<?php

namespace App\Http\Controllers;

use Str, File, Log;
use App\Http\Controllers\API\BaseController;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends BaseController
{
    /**
     * GET /api/documents/
     */
    public function index(Request $request)
    {
        try {
            // $doc = Document::where('user_id', $userId)->latest('created_at')->get();
            $doc = $request->user()->documents()->latest('created_at')->get();

            return $this->sendResponse($doc);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
    /**
     * GET /api/documents/{id}
     */
    public function show(Request $request, string $id)
    {
        try {
            $doc = $request->user()->documents()->find($id);
            if (!$doc) {
                return $this->sendError("Document not found or access denied", 404);
            }

            return $this->sendResponse($doc, "Document retrieved successfully");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),404);
        }
    }
    /**
     * POST /api/documents/upload
     */
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:pdf',
                'title' => 'nullable|string'
            ]);

            $file = $request->file('file');
            $title = $request->input('title');
            if (empty(trim($title))) {
                $title = $file->getClientOriginalName();
            }

            $fileId = Str::uuid()->toString();
            $safeName = $fileId . "_" . str_replace(' ', '_', $file->getClientOriginalName());
            $uploadPath = public_path('uploads');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            $file->move($uploadPath, $safeName);

            $doc = $request->user()->documents()->create([
                'id' => $fileId,
                'title' => trim($title),
                'filename' => $safeName,
                'last_page' => 1,
            ]);

            return $this->sendResponse($doc,"File uploaded successfully", 201);
        } catch (\Exception $e) {
            Log::error("ERROR SAAT UPLOAD: " . $e->getMessage());
            return $this->sendError($e->getMessage());
        }
    }
    /**
     * PUT /api/documents/{id}/last-page
     */
    public function updateLastPage(Request $request, string $id) 
    {
        try {
            $page = (int) $request->input('page', 1);
            $doc = $request->user()->documents()->find($id);

            if ($doc) {
                $doc->update([
                    'last_page' => $page,
                    'last_read_at' => now(),
                ]);
            }

            return $this->sendResponse(['page' => $page], "Last page updated successfully");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
    /**
     * PUT /api/documents/{id}/total-pages
     */
    public function updateTotalPage(Request $request, string $id)
    {
        try {
            $totalPage = (int) $request->input('total_pages', 0);
            $doc = $request->user()->documents()->find($id);

            if ($doc) {
                $doc->update([
                    'total_pages' => $totalPage
                ]);
            }

            return $this->sendResponse(['total_pages' => $totalPage], "Total page updated successfully");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
    /**
     * DELETE /api/documents/{id}
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $doc = $request->user()->documents()->find($id);

            if ($doc) {
                $filePath = public_path('uploads/' . $doc->filename);

                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                $doc->destroy();
            }
            
            return $this->sendResponse(null, "Document deleted successfully");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
    /**
     * POST /api/documents/bulk-delete
     */
    public function bulkDelete(Request $request)
    {
        try {
            $docIds = $request->input('ids', []);

            if (!$docIds) {
                return $this->sendError("No Documents selected", 400);
            }

            $docs = $request->user()->documents()->whereIn('id', $docIds)->get();
            $count = $docs->count();

            foreach ($docs as $doc) {
                $filePath = public_path('uploads/' . $doc->filename);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                $doc->destroy();
            }

            return $this->sendResponse(null, "{$count} documents deleted successfully.");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}