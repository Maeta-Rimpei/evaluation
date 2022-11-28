<?php

namespace App\Consts;

class StaffPositionConsts
{
    // 職位別コード
    // 園長、副園長、主任
    public const CHIEF = 0;
    // 保育士、看護師、保育補助員
    public const CHILD_MINDER = 1;
    // 事務員、調理師
    public const CLERK = 2;
    // 管理者
    public const ADMINISTER = 3;

    public const STAFF_LIST = [
        '園長、副園長、主任' => self::CHIEF,
        '保育士、看護師、保育補助員' => self::CHILD_MINDER,
        '事務員、調理師' => self::CLERK,
        '管理者' => self::ADMINISTER,
    ];
}