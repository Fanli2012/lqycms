<?php
namespace App\Http\Model;

class Region extends BaseModel
{
    //地区
    
    protected $table      = 'region';
    public    $timestamps = false;
    
    public static function getRegionName($id)
    {
        if(empty($id) || $id==0){return '';}
        
        return self::where('id', $id)->value('name');
    }
    
    public static function getList($parent_id=86)
    {
        return self::where('parent_id', $parent_id)->get();
    }
    
    public static function getOne($id)
    {
        return self::where('id', $id)->first();
    }
}