<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'question_user';

    /**
     * IDの自動増分を指定する
     *
     * @var bool
     */
    public $incrementing = true;

    // 可変項目設定
    protected $fillable = [
        'id',
        'role_id',
        'question_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->belongsTo(Question::class);
    }
}