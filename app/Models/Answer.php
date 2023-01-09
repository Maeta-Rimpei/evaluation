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
        'staff_id',
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

    
    
    public function saveAnswer()
    {
        return $this->saveOrFail();
    }
    
    /**
     * staff_idに紐づいたanswerを取得
     * @param int $staff_id staffs.id
     * @return void
     */
    public function selectAnswerByStaffId($staff_id)
    {
        return $this->where('staff_id', $staff_id)->get();
    }
    
    /**
     * 回答削除
     * @return bool|null
     */
    public function deleteAnswer()
    {
        return $this->delete();
    }

    /**
     * 職員の回答を全て削除
     * @param mixed $user_answers
     * @return void
     */
    public function deleteAllstaffAnswer($user_answers)
    {
        foreach ($user_answers as $user_answer) {
            $user_answer->deleteAnswer();
        }
    }
    
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
