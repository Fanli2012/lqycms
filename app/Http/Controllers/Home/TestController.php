<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\DB;

class TestController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //首页
    public function index()
    {
        //Excel文件导出功能，如果出现文件名中文乱码，iconv('UTF-8', 'GBK', '学生成绩')
        /* $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        \Excel::create('学生成绩',function($excel) use ($cellData){
            //第一个工作簿，score是工作簿的名称
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });

            //第二个工作簿
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');

        //Excel文件导入功能
        $filePath = 'storage/'.iconv('UTF-8', 'GBK', '学生成绩').'.xls';
        \Excel::load($filePath, function($reader) {
            $reader = $reader->getSheet(0);
            $res = $reader->toArray();
            dd($res);
        }); */
    }

    // 队列测试
    public function queue()
    {
        // php artisan queue:work
        dispatch(new \App\Jobs\Example());
    }

    // 事件测试
    public function event()
    {
        $order = \App\Http\Model\Order::where(['id' => 1])->first();
        $order_id = 1;
        event(new \App\Events\OrderShipped($order_id));
    }

}