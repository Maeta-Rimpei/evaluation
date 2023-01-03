<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

     // 可変項目設定
    protected $fillable = [
        'id',
        'staff_id',
        'name',
        'affiliation',
        'role_id',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * adminsテーブルから全ての情報を取得
     *
     * @return collection
     */
    public function getAllAdmins()
    {
        return $this->get();
    }

    /**
     * 特定のadminを取得
     * @param int $id
     *
     * @return App\Models\Admin
     */
    public function getAdmin(int $id)
    {
        return $this->findOrFail($id);
    }
}
