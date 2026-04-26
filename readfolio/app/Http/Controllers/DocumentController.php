<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends BaseController
{
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
}
