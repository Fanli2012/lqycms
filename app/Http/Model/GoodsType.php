<?php
namespace App\Http\Model;

use App\Common\Token;

class GoodsType extends BaseModel
{
	//产品分类模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'goods_type';
	public $timestamps = false;
	
	/**
	 * 获取分类对应的产品
	 */
	public function goods()
	{
		return $this->hasMany(GoodsType::class, 'typeid', 'id');
	}
	
}
