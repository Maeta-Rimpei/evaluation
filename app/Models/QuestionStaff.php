<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionStaff extends Model
{
    use HasFactory;

    protected $table = 'question_user';

    // 可変項目設定
    protected $fillable = [
        'id',
        'role_id',
        'question_id',
    ];

    public function staffs()
    {
        return $this->belongsTo(Staff::class);
    }

    public function questions()
    {
        return $this->belongsTo(Question::class);
    }
}
