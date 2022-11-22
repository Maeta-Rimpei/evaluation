<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer_User extends Model
{
    use HasFactory;

    // 可変項目設定
    protected $fillable = [
        'id',
        'user_id',
        'answer_id',
    ];
}
