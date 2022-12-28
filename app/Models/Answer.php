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

    /**
     * answersテーブルから全ての情報を取得
     *
     * @return collection
     */
    public function getAllAnswers()
    {
        return $this->get();
    }

    /**
     * answersテーブルから特定の情報を取得
     * @param int $id
     *
     * @return App\Models\Answer
     */
    public function getAnswer($id)
    {
        return $this->findOrFail($id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
