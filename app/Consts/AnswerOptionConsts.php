<?php

namespace App\Consts;

class AnswerOptionConsts
{
    // 回答選択肢
    public const GOOD = 0;

    public const NORMAL = 1;

    public const BAD = 2;

    public const WORST = 3;

    public const ANSWER_OPTION = [
        'A' => self::GOOD,
        'B' => self::NORMAL,
        'C' => self::BAD,
        'D' => self::WORST,
    ];
}