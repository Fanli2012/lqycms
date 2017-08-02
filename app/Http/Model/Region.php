<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Token;

class Region extends BaseModel
{
    //地区
    
    protected $table      = 'region';
    public    $timestamps = false;
    
    public static function getRegionName($id)
    {
        $res = self::where('id', $id)->value('name');
        if (!empty($res))
        {
            return $res;
        }

        return false;
    }
    
    public static function getList($parent_id=86)
    {
        $key = 'region';
        
        if (!$model = Cache::get($key))
        {
            $model = self::where('parent_id', $parent_id)->get()->toArray();
            Cache::put($key, $model, 10);
        }

        return $model;
    }
    
    public static function getOne($id)
    {
        $res = self::where('id', $id)->first()->toArray();
        if (!empty($res))
        {
            return $res;
        }
        
        return false;
    }
}
