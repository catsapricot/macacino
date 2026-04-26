<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documents extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'documents';
    const UPDATED_AT = 'last_read_at';
    protected $fillable = [
        'user_id',
        'title',
        'filename',
        'last_page',
        'last_read_at'
    ];

    protected $appends = [
        'file_url'
    ];

    public function getFileUrlAttribute(): string
    {
        return "/static/uploads/{$this->filename}";
        
        // Catatan: Jika Anda ingin URL lengkap termasuk domain (http://...), 
        // Anda bisa menggunakan helper asset() bawaan Laravel seperti ini:
        // return asset("static/uploads/{$this->filename}");
    }

    protected function casts(): array 
    {
        return [
            'created_at' => 'datetime',
            'last_read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
