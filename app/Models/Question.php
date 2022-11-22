<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // 可変項目設定
    protected $fillable = [
        'id',
        'content',
        'category'
    ];

    // User Modelとのリレーション(多対多)
    public function users()
    {
        return $this->belongsToMany(User::class,'question_user','question_id','role_id');
    }
}
