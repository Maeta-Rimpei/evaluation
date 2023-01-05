<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

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

    /**
     * あいまい検索
     * @param string $str
     * 
     * @return 
     */
    public function searchAdmin($name, $staff_id, $affiliation, $role_id)
    {
        $query = $this->query();

        // $this->admin->likeSearchAdmin($name);
        $name_push_array = $this->spaceConversionAndPushArray($name);
        $staff_id_push_array = $this->spaceConversionAndPushArray($staff_id);
        $affiliation_push_array = $this->spaceConversionAndPushArray($affiliation);

        foreach ($name_push_array as $word) {
            $query->where('name', 'LIKE', '%' . self::escape($word) . '%');
        }

        foreach ($staff_id_push_array as $word) {
            $query->where('staff_id', 'LIKE', '%' . self::escape($word) . '%');
        }

        foreach ($affiliation_push_array as $word) {
            $query->where('affiliation', 'LIKE', '%' . self::escape($word) . '%');
        }

        $query->when($role_id, function ($query, $role_id) {
            return $query->where('role_id', '=', $role_id);
        });

        $search_results = $query->orderBy('admins.created_at', 'desc');

        return $search_results;
    }

    /**
     * Summary of spaceConversionAndPushArray
     * @param mixed $str
     * @return array 
     */
    public function spaceConversionAndPushArray($str)
    {
        $space_conversion = mb_convert_kana($str, 's');

        return preg_split('/[\s,]+/', $space_conversion, -1, PREG_SPLIT_NO_EMPTY);

    }

    public static function escape($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }
}