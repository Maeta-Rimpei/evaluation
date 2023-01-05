<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = users;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'staff_id',
        'name',
        'affiliation',
        'role_id',
        'password',
        'evaluation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * usersテーブルのデータを全件取得
     *
     * @return // collection
     */
    public function getAllUsers()
    {
        return $this->all();
    }

    /**
     * 特定のユーザーを取得
     * @param int $id user_id
     *
     * @return App\Models\User
     */
    public function getUser(int $id)
    {
        return $this->find($id);
    }

    /**
     * ユーザーに関係する質問と回答を取得
     * @param int $id
     *
     * @return collection
     */
    public function getQuestionsAndAnswers(int $id)
    {
        $user = $this->find($id);
        return DB::table('users')
            ->where('users.id', '=', $id)
            ->where('answers.user_id', '=', $id)
            ->select(
                'users.id as user_id',
                'questions.id as question_id',
                'questions.content',
                'questions.category',
                'answers.id as answer_id',
                'answers.answer',
            )
            ->leftJoin('answers', 'users.id', '=', 'answers.user_id')
            ->leftJoin('questions', 'questions.id', '=', 'answers.question_id')
            ->get();
    }

    /**
     * StdClassオブジェクトを配列に変換
     * @param // ex. collection
     *
     * @return array
     */
    public function conversionToArray($array)
    {
        return json_decode(json_encode($array), true);
    }

    // Question Modelとのリレーション
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_user', 'role_id', 'question_id', 'role_id');
    }

    // Answer Modelとのリレーション
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
