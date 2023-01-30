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
     * 質問作成
     * @return App\Models\Question
     */
    public function saveQuestion()
    {
        return $this->saveOrFail();
    }

    /**
     * 質問削除(中間テーブルのレコードを削除し、そのレコードに紐づいたquestionを削除)
     * @return void
     */
    public function destroyQuestion()
    {
        return $this->staffs()->detach();
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
            ->where('question_staff.role_id', "=", $role_id)
            ->select(
                'questions.id as question_id',
                'questions.content',
                'questions.category',
                'question_staff.role_id'
            )
            ->leftJoin('question_staff', 'questions.id', '=', 'question_id')
            ->get();
    }

    /**
     * $question_idに紐づいた質問を取得
     * @param int $question_id
     *
     * @return App\Models\Question
     */
    public function getQuestionByQuestionId(int $question_id)
    {
        return DB::table('questions')
            ->where('question_staff.question_id', "=", $question_id)
            ->select(
                'questions.id as question_id',
                'questions.content',
                'questions.category',
                'question_staff.role_id',
            )
            ->leftJoin('question_staff', 'questions.id', '=', 'question_id')
            ->first();
    }

    /**
     * $question_idに紐づいた$role_idを取得
     * @param int $question_id
     *
     * @return $role_id App\Models\QuestionStaff
     */
    public function getRoleIdByQuestionId(int $question_id)
    {
        return DB::table('questions')
            ->where('questions.id', '=', $question_id)
            ->select('question_staff.role_id')
            ->join('question_staff', 'questions.id', '=', 'question_staff.question_id')
            ->first();
    }

    /**
     * 最後に生成したquestionのidを取得
     * @return int id
     */
    public function getLastQuestionId()
    {
        return $this->latest('id')->first()->id;
    }

    /**
     * 中間テーブルにレコードを挿入
     * @param int $related_pivot_key
     *
     * @return void
     */
    public function insertPivotTable(int $related_pivot_key)
    {
        return $this->staffs()->attach($related_pivot_key);
    }
    /**
     * Summary of spaceConversionAndPushArray
     * @param mixed $str
     *
     * @return array
     */
    public function spaceConversionAndPushArray($str)
    {
        $space_conversion = mb_convert_kana($str, 's');

        return preg_split('/[\s,]+/', $space_conversion, -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function escape($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }

    /**
     * questionsテーブルとquestion_staffテーブル結合
     */
    public function joinQuestionsAndQuestionStaff()
    {
        $query = $this->query()->join('question_staff', 'questions.id', '=', 'question_staff.question_id')
            ->select(
                'questions.id',
                'questions.content',
                'questions.category',
                'question_staff.role_id'
            );

        return $query;
    }

    /**
     * 質問検索
     * @param $keyword
     * @param $category
     * @param int $role_id
     */
    public function getSearchParameterOfQuestion($keyword, $category, $role_id)
    {
        $query = $this->joinQuestionsAndQuestionStaff();

        if (isset($keyword)) {
            $keyword_push_array = $this->spaceConversionAndPushArray($keyword);
            foreach ($keyword_push_array as $word) {
                $query->where('content', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($category)) {
            $query->where('category', $category);
        }

        if (isset($role_id)) {
            $query->where('role_id', $role_id);
        }

        $search_results = $query->orderBy('questions.content', 'desc');

        return $search_results;
    }

    // Staff Modelとのリレーション(多対多)
    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'question_staff', 'question_id', 'role_id',)
            ->withPivot('role_id', 'question_id')
            ->withTimestamps();
    }

    // questionStaff Modelとのリレーション
    public function questionStaff()
    {
        return $this->belongsTo(questionStaff::class);
    }
}
