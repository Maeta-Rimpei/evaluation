<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\TextUI\CliArguments\Builder;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    use HasFactory;
    // 可変項目設定
    protected $fillable = [
        'id',
        'content',
        'category'
    ];

    /**
     * questionsテーブルの全ての情報を取得
     *
     * @return //collection
     */
    public function getAllQuestions()
    {
        return $this->get();
    }

    /**
     * questionsテーブルから特定のレコードを取得
     *
     * @return App\Models\Question
     */
    public function getQuestion($question_id)
    {
        return $this->findOrFail($question_id);
    }

    /**
     * $role_idに紐づいた全ての質問情報を取得
     * @param int $role_id
     *
     * @return // collection
     */
    public function getQuestionsByRoleId(int $role_id)
    {
        return DB::table('questions')
            ->where('question_user.role_id', "=", $role_id)
            ->select(
                'questions.id as question_id',
                'questions.content',
                'questions.category',
                'question_user.role_id'
            )
            ->leftJoin('question_user', 'questions.id', '=', 'question_id')
            ->get();
    }

    /**
     * $question_idに紐づいた質問を取得
     * @param int $question_id
     *
     * @return App\Models\Question;
     */
    public function getQuestionByQuestionId(int $question_id)
    {
        return DB::table('questions')
            ->where('question_user.question_id', "=", $question_id)
            ->select(
                'questions.id as question_id',
                'questions.content',
                'questions.category',
                'question_user.role_id',
            )
            ->leftJoin('question_user', 'questions.id', '=', 'question_id')
            ->first();
    }

    /**
     * $question_idに紐づいた$role_idを取得
     * @param int $question_id
     *
     * @return $role_id App\Models\QuestionUser
     */
    public function getRoleIdByQuestionId(int $question_id)
    {
        return DB::table('questions')
            ->where('questions.id', '=', $question_id)
            ->select('question_user.role_id')
            ->join('question_user', 'questions.id', '=', 'question_user.question_id')
            ->first();
    }

    // User Modelとのリレーション(多対多)
    public function users()
    {
        return $this->belongsToMany(User::class, 'question_user', 'question_id', 'role_id')
            ->withPivot('role_id', 'question_id')
            ->withTimestamps();
    }

    public function questionUser()
    {
        return $this->belongsTo(questionUser::class);
    }
}
