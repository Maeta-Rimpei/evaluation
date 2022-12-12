<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\TextUI\CliArguments\Builder;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $dates = [ 'deleted_at' ];
    protected $softCascade = ['questionUser'];

    // 可変項目設定
    protected $fillable = [
        'id',
        'content',
        'category'
    ];

    // User Modelとのリレーション(多対多)
    public function users()
    {
        return $this->belongsToMany(User::class,'question_user', 'question_id', 'role_id')
        ->using(QuestionUser::class)
        ->withPivot('role_id', 'user_id')
        ->withTimestamps();
    }

    public function questionUser()
    {
        return $this->belongsTo(questionUser::class);
    }
}
