<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $dates = [ 'deleted_at' ];

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
     * ユーザーのログインチェック
     * 
     * @return mixed
     */
    // public static function checkExistAuthUser()
    // {
    //     $auth_user = User::();
    //     if ($auth_user == null) {
    //         return view('login')->with('timeOutMessage', '一定時間が経過したためログアウトしました。再度ログインしてください。');
    //     }
    // }

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
