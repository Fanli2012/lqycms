<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
	//产品分类模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'product_type';
	public $timestamps = false;
	
	/**
	 * 获取分类对应的产品
	 */
	public function product()
	{
		return $this->hasMany(ProductType::class, 'typeid', 'id');
	}
	
}
