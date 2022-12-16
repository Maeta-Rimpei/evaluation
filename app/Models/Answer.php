<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // 可変項目設定
    protected $fillable = [
        'id',
        'user_id',
        'question_id',
        'answer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
