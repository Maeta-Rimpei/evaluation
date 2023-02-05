<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Admin extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    // 可変項目設定
    protected $fillable = [
        'id',
        'staff_code',
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
     * ログイン中の管理者情報を取得
     */
    public function getAuthAdmin()
    {
        return Auth::user();
    }

    /**
     * 管理者データ保存
     * @return void
     */
    public function saveAdmin()
    {
        $this->saveOrFail();
    }

    /**
     * あいまい検索
     * @param string $str
     *
     * @return
     */
    public function getSearchParameterOfAdmin($name, $staff_code, $affiliation, $role_id)
    {
        $query = $this->query();

        if (isset($name)) {
            $name_push_array = $this->spaceConversionAndPushArray($name);
            foreach ($name_push_array as $word) {
                $query->where('name', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($staff_code)) {
            $staff_code_push_array = $this->spaceConversionAndPushArray($staff_code);
            foreach ($staff_code_push_array as $word) {
                $query->where('staff_code', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($affiliation)) {
            $affiliation_push_array = $this->spaceConversionAndPushArray($affiliation);
            foreach ($affiliation_push_array as $word) {
                $query->where('affiliation', 'LIKE', '%' . self::escape($word) . '%');
            }
        }

        if (isset($role_id)) {
            $query->where('role_id', $role_id);
        }

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

    /**
     * 管理者残り人数確認
     * @return bool
     */
    public function checkNumberOfAdmin()
    {
        $all_admins = $this->getAllAdmins()->toArray();

        if (count($all_admins) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 管理者物理削除
     */
    public function deleteAdmin()
    {
        return $this->delete();
    }

    /**
     * 論理削除済管理者取得
     */
    public function getSoftDeletedAdmins()
    {
        return $this->onlyTrashed()->whereNotNull('id')->get();
    }

    /**
     * 論理削除済管理者復元
     * @param int $admin_id admins.id
     */
    public function exeRestoreSoftDeletedAdmin($admin_id)
    {
        $admin = $this->onlyTrashed()->whereId($admin_id);
        return $admin->restore();
    }
}
