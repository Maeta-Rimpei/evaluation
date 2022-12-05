<?php

namespace App\Consts;

class CategoryConsts
{
    // カテゴリー別コード
    // 選択式
    public const OPTION = 0;
    // 記述式
    public const DESCRIPTION = 1;

    public const CATEGORY_LIST = [
        self::OPTION => '選択式',
        self::DESCRIPTION => '記述式' 
    ];
}