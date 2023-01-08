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
    protected $table = 'staffs';

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

    // Question Modelとのリレーション
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_staff', 'role_id', 'question_id', 'role_id');
    }

    // Answer Modelとのリレーション
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

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
     * @return
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

    /**
     * 2次元以上の配列$arrayからそれぞれの$keyを抽後、カウントして結果を連想配列で返す
     * @param array $array
     * @param mixed $key
     *
     * @return array
     * $key => $value(カウントの結果)
     */
    public function conversionAndArrayCountValues(array $array, $key)
    {
        return array_count_values(array_column($array, $key));
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
     * @param mixed $name
     * @param mixed $staff_id
     * @param mixed $affiliation
     * @param int $role_id
     * @return void
     */
    public function getSearchParameterOfStaff($name, $staff_id, $affiliation, $role_id)
    {
        $query = $this->query();

        if (isset($name)) {
            $name_push_array = $this->spaceConversionAndPushArray($name);
            foreach ($name_push_array as $word) {
                $query->where('name', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($staff_id)) {
            $staff_id_push_array = $this->spaceConversionAndPushArray($staff_id);
            foreach ($staff_id_push_array as $word) {
                $query->where('staff_id', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($affiliation)) {
            $affiliation_id_push_array = $this->spaceConversionAndPushArray($affiliation);
            foreach ($affiliation_id_push_array as $word) {
                $query->where('affiliation', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($role_id)) {
            $query->where('role_id', $role_id);
        }

        $search_results = $query->orderBy('users.created_at', 'desc');

        return $search_results;
    }

    /**
     * 職員削除
     * @return bool|null
     */
    public function deleteStaff()
    {
        return $this->delete();
    }

    /**
     * evaluationとtotal_evaluationの削除を実行
     * @return void
     */
    public function exeDeleteStaffEvaluation()
    {
        $users = $this->getAllUsers();

        foreach ($users as $user) {
            $user->evaluation = null;
            $user->total_evaluation = null;
            $user->save();
        }
    }

    /**
     * 論理削除済職員取得
     */
    public function getSoftDeletedStaffs()
    {
        return $this->onlyTrashed()->whereNotNull('id')->get();
    }

    /**
     * 論理削除済職員復元
     * @param int $user_id users.id
     */
    public function exeRestoreSoftDeletedStaff($user_id)
    {
        $user = $this->onlyTrashed()->whereId($user_id);
        return $user->restore();
    }

    /**
     * evaluationとtotal_evaluationが空かどうかのチェック
     * @return bool
     */
    public function checkEmptyEvaluation()
    {
        $users = $this->getAllUsers()->toArray();
        $user_evaluation = array_filter(array_column($users, 'evaluation'));
        $user_total_evaluation = array_filter(array_column($users, 'total_evaluation'));

        if (empty($user_evaluation) && empty($user_total_evaluation)) {
            return true;
        } else {
            return false;
        }
    }
}
