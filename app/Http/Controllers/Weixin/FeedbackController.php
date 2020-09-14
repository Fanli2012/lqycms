<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnCode;

class FeedbackController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    //意见反馈添加
    public function userFeedbackAdd(Request $request)
    {
        return view('weixin.feedback.userFeedbackAdd');
    }
}