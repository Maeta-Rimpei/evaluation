<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

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
        return $this->belongsToMany(User::class,'question_user','question_id','role_id')
        ->withPivot('role_id', 'user_id')
        ->withTimestamps();
    }
}
