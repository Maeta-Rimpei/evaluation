<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    private $question;
    /**
     * Summary of __construct
     * @return void
     */
    public function __construct()
    {
        $this->question = new question();
    }

    public function showQuestionEdit()
    {
        return view('admin.show_question_edit');
    }

}
