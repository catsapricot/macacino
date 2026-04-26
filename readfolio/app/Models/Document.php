<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
// use Illuminate\Database\Eloquent\Factories\HasFactory
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasUuids;
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

    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => "/static/uploads/{$this->filename}",
        );
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

    public function highlights(): HasMany
    {
        return $this->hasMany(Highlight::class);
    }

}
