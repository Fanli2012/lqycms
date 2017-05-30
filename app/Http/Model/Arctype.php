<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Arctype extends Model
{
	//文章分类模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'arctype';
	public $timestamps = false;
	
	/**
     * 表明模型是否应该被打上时间戳
     * 默认情况下，Eloquent 期望 created_at 和updated_at 已经存在于数据表中，如果你不想要这些 Laravel 自动管理的数据列，在模型类中设置 $timestamps 属性为 false
	 * 
     * @var bool
     */
    public $timestamps = false;
	
	/**
     * The connection name for the model.
     * 默认情况下，所有的 Eloquent 模型使用应用配置中的默认数据库连接，如果你想要为模型指定不同的连接，可以通过 $connection 属性来设置
     * @var string
     */
    //protected $connection = 'connection-name';
	
	/**
	 * 获取分类对应的文章
	 */
	public function article()
	{
		return $this->hasMany(Article::class, 'typeid', 'id');
	}
	
}
