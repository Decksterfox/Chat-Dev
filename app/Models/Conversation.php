<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id'];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function pdfFiles(): HasMany
    {
        return $this->hasMany(PdfFile::class);
    }

    public function getLastMessageTimeAttribute()
    {
        return $this->messages()->latest()->first()->created_at ?? $this->created_at;
    }
}
