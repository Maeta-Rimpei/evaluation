<?php

namespace App\Consts;

class AnswerOptionConsts
{
    // 回答選択肢
    public const GOOD = 'A';

    public const NORMAL = 'B';

    public const BAD = 'C';

    public const WORST = 'D';

    public const ANSWER_OPTION = [
        self::GOOD,
        self::NORMAL,
        self::BAD,
        self::WORST,
    ];
}