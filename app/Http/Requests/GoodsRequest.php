<?php
namespace App\Http\Requests;

class GoodsRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'title' => 'required|max:150',
        'typeid' => 'required|integer',
        'click' => 'integer',
        'tuijian' => 'integer',
        'sn' => 'max:60',
        'price' => ['required','regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'litpic' => 'required|max:100',
        'pubdate' => 'integer',
        'add_time' => 'required|integer',
        'keywords' => 'max:60',
        'seotitle' => 'max:150',
        'description' => 'max:250',
        'status' => 'integer|between:0,5',
        'shipping_fee' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'market_price' => ['required','regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'goods_number' => 'required|integer|between:1,99999',
        'user_id' => 'integer',
        'sale' => 'integer|between:1,99999',
        'cost_price' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'goods_weight' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'point' => 'integer|between:1,99999',
        'comments' => 'integer|between:1,99999',
        'promote_start_date' => 'integer',
        'promote_end_date' => 'integer',
        'promote_price' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'goods_img' => 'max:250',
        'warn_number' => 'integer|between:1,99',
        'listorder' => 'integer|between:1,9999',
        'brand_id' => 'integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'title.required' => '标题必填',
        'title.max' => '标题不能超过150个字符',
        'typeid.required' => '栏目ID必填',
        'typeid.integer' => '栏目ID必须为数字',
        'click.integer' => '点击量必须为数字',
        'tuijian.integer' => '推荐等级必须是数字',
        'sn.max' => '货号不能超过60个字符',
        'price.required' => '产品价格必填',
        'price.regex' => '产品价格只能带2位小数的数字',
        'litpic.required' => '缩略图必须上传',
        'litpic.max' => '缩略图不能超过100个字符',
        'pubdate.integer' => '更新时间格式不正确',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
        'keywords.max' => '关键词不能超过60个字符',
        'seotitle.max' => 'seo标题不能超过150个字符',
        'description.max' => '描述不能超过250个字符',
        'status.integer' => '商品状态必须是数字',
        'status.between' => '商品状态 0正常 1已删除 2下架 3申请上架',
        'shipping_fee.regex' => '运费格式不正确，运费只能带2位小数的数字',
        'market_price.required' => '市场价格必填',
        'market_price.regex' => '市场价格格式不正确，市场价格只能带2位小数的数字',
        'goods_number.required' => '库存必填',
        'goods_number.integer' => '库存必须是数字',
        'goods_number.between' => '库存只能1-99999',
        'user_id.integer' => '发布者ID必须是数字',
        'sale.integer' => '销量必须是数字',
        'sale.between' => '销量只能1-99999',
        'cost_price.regex' => '成本价格格式不正确，成本价格只能带2位小数的数字',
        'goods_weight.regex' => '重量格式不正确，重量只能带2位小数的数字',
        'point.integer' => '购买该商品时每笔成功交易赠送的积分数量必须是数字',
        'point.between' => '购买该商品时每笔成功交易赠送的积分数量只能1-99999',
        'comments.integer' => '评论次数必须是数字',
        'comments.between' => '评论次数只能1-9999999',
        'promote_start_date.integer' => '促销价格开始日期必须是数字',
        'promote_end_date.integer' => '促销价格结束日期必须是数字',
        'promote_price.regex' => '促销价格格式不正确，促销价格只能带2位小数的数字',
        'goods_img.max' => '商品的实际大小图片不能超过250个字符',
        'warn_number.integer' => '商品报警数量必须是数字',
        'warn_number.between' => '商品报警数量只能1-99',
        'listorder.integer' => '排序必须是数字',
        'listorder.between' => '排序只能1-9999',
        'brand_id.integer' => '商品品牌ID必须是数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['typeid', 'title', 'tuijian', 'click', 'sn', 'price', 'litpic', 'pubdate', 'add_time', 'keywords', 'seotitle', 'description', 'status', 'shipping_fee', 'market_price', 'goods_number', 'user_id', 'sale', 'cost_price', 'goods_weight', 'point', 'comments', 'promote_start_date', 'promote_price', 'promote_end_date', 'goods_img', 'warn_number', 'listorder', 'brand_id'],
        'edit' => ['typeid', 'title', 'tuijian', 'click', 'sn', 'price', 'litpic', 'pubdate', 'add_time', 'keywords', 'seotitle', 'description', 'status', 'shipping_fee', 'market_price', 'goods_number', 'user_id', 'sale', 'cost_price', 'goods_weight', 'point', 'comments', 'promote_start_date', 'promote_price', 'promote_end_date', 'goods_img', 'warn_number', 'listorder', 'brand_id'],
        'del'  => ['id'],
    ];
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //修改为true
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }
    
    /**
     * 获取被定义验证规则的错误消息.
     *
     * @return array
     */
    public function messages()
    {
        return $this->messages;
    }
    
    //获取场景验证规则
    public function getSceneRules($name, $fields = null)
    {
        $res = array();
        
        if(!isset($this->scene[$name]))
        {
            return false;
        }
        
        $scene = $this->scene[$name];
        if($fields != null && is_array($fields))
        {
            $scene = $fields;
        }
        
        foreach($scene as $k=>$v)
        {
            if(isset($this->rules[$v])){$res[$v] = $this->rules[$v];}
        }
        
        return $res;
    }
    
    //获取场景验证规则自定义错误信息
    public function getSceneRulesMessages()
    {
        return $this->messages;
    }
}