<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    // 可変項目設定
    protected $fillable = [
        'id',
        'role_id',
        'question_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
