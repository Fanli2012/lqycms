<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
	protected $table = 'user_role';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];
	
	/**
	 * 获取角色对应的用户
	 */
	public function user()
	{
		return $this->hasMany(User::class, 'role_id', 'id');
	}
}
