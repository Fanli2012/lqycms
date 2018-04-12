<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    //获取某一表的所有字段
    public static function getColumnListing($table)
    {
        return Schema::getColumnListing($table);
    }
    
    //过滤不是某一表的字段
    public static function filterTableColumn($data, $table)
    {
        $table_column = Schema::getColumnListing($table);
        
        if(!$table_column)
        {
            return $data;
        }
        
        foreach($data as $k=>$v)
        {
            if (!in_array($k,$table_column))
            {
                unset($data[$k]);
            }
        }
        
        return $data;
    }
}