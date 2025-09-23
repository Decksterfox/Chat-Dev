<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfFile extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'filename', 'original_name', 'content', 'page_count'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
