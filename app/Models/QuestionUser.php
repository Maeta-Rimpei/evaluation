<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionUser extends Model
{
    use HasFactory;
    // 可変項目設定
    protected $fillable = [
        'id',
        'role_id',
        'question_id',
    ];
}
