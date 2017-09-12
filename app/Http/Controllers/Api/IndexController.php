<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;

class IndexController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //安卓升级信息
	public function andriodUpgrade()
	{
		$res = array(
			'appname'       => 'lqycms', //app名字
			'serverVersion' => 2, //服务器版本号
            'serverFlag'    => 1, //服务器标志
			'lastForce'     => 0, //是否强制更新，0不强制，1强制
            'updateurl'     => 'http://api.52danchuang.com/wap/app-release.apk', //apk下载地址
			'upgradeinfo'   => '描述：3.0.0' //版本更新的描述
		);

		return ReturnData::create(ReturnData::SUCCESS, $res);
	}
    
	//关于
    public function about(Request $request)
    {
        return ReturnData::create(ReturnData::SUCCESS,array('url'=>'http://www.baidu.com'));
    }
	
    //文章列表页
    public function listarc()
	{
        $res["code"] = 0;
        $res["msg"] = "success";
		$res["data"] = "";
		
        $where = array();
        $result = "";
		
        $PageIndex = request('PageIndex',1);
    	$PageSize = request('PageSize', sysconfig('CMS_PAGESIZE'));
        $skip = ($PageIndex-1)*$PageSize;
        
        $typeid = request('typeid');if(!empty($typeid)){ $where['typeid']=$typeid; }
        $tuijian = request('tuijian');if(!empty($tuijian)){ $where['tuijian']=$tuijian; }
		$field = array('field','id,typeid,click,title,writer,litpic,pubdate');
        $orderby = request('orderby',['pubdate','desc']);
        $mname = request('mname','article');
        
		$model = \DB::table($mname);
		if($where){$model = $model->where($where);}
		if($orderby == 'rand()'){$model = $model->orderBy(\DB::raw('rand()'));}else{$model = $model->orderBy($orderby[0], $orderby[1]);}
		
		$count = $model->count();
        $list = object_to_array($model->skip($skip)->take($PageSize)->get());
        
		if(!empty($list) && $PageIndex<=10)
		{
			/* foreach($list as $key=>$row)
			{
				//$list[$key]["pubdate"] = date("Y-m-d", $list[$key]["pubdate"]);
				$result .= '<div class="list">';
				
				if(!empty($row['litpic']) && file_exists($_SERVER['DOCUMENT_ROOT'].$row['litpic']))
				{
					$result .= '<a class="';
					//判断图片长宽
					if(getimagesize($row['litpic'])[0]>getimagesize($row['litpic'])[1])
					{
						$result .= 'limg';
					}
					else
					{
						$result .= 'simg';
					}
					
					$result .= '" href="'.WEBHOST.'/p/'.$row['id'].'"><img alt="'.$row['title'].'" src="'.$row['litpic'].'"></a>';
				}
				
				$result .= '<strong class="tit"><a href="'.WEBHOST.'/p/'.$row['id'].'">'.$row['title'].'</a></strong><p>'.mb_strcut(strip_tags($row['description']),0,126,'UTF-8').'..<a href="'.WEBHOST.'/p/'.$row['id'].'" class="more">[详情]</a></p>';
				$result .= '<div class="info"><span class="fl"><i class="pub-v"></i><em>'.date("Y-m-d H:i",$row['pubdate']).'</em></span><span class="fr"><em>'.$row['click'].'</em>人阅读</span></div><div class="cl"></div></div>';
			} */
			
            foreach($list as $key=>$row)
			{
                $list[$key]["url"] = get_front_url(array("id"=>$row['id'],"type"=>'content'));
				$list[$key]["pubdate"] = date("Y-m-d", $list[$key]["pubdate"]);
            }
            
			$res["data"] = $list;
		}
		/* $result['List']=$list;
		$result['Count']=$count>0?$count:0; */
		
        //return $res;
        exit(json_encode($res));
	}
}
