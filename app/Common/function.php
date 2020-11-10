<?php
// 公共函数文件
if (! function_exists('curl_request'))
{
    function curl_request($api, $params = array(), $method = 'GET', $headers = array())
    {
        $curl = curl_init();

        switch (strtoupper($method))
		{
            case 'GET' :
                if (!empty($params))
				{
                    $api .= (strpos($api, '?') ? '&' : '?') . http_build_query($params);
                }
                curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
                break;
            case 'POST' :
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case 'PUT' :
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case 'DELETE' :
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
        }
        
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($curl);
        
        if ($response === FALSE)
		{
            $error = curl_error($curl);
            curl_close($curl);
            return FALSE;
        }
		else
		{
            // 解决windows 服务器 BOM 问题
            $response = trim($response,chr(239).chr(187).chr(191));
            $response = json_decode($response, true);
        }
        
        curl_close($curl);
        
        return $response;
    }
}

//获取数据
function dataList($modelname, $where = [], $size = 15, $page = 1)
{
	$model = \DB::table($modelname);
	
	$page = 1;$skip = 0;
	if(isset($where['limit'])){$limit=explode(',',$where['limit']); $skip = $limit[0]; $size = $limit[1];}else{if(isset($where['row'])){$size = $where['row'];}} // 参数格式：$where['limit'] = '2,10';$where['row'] = 10;

    //原生sql
	if(isset($where['sql']))
	{
		$model = $model->whereRaw($where['sql']);
	}

    //排序
	if(isset($where['orderby']))
	{
		$orderby = $where['orderby'];
		
		if($orderby == 'rand()')
		{
			$model = $model->orderBy(\DB::raw('rand()'));
		}
		else
		{
			if(count($orderby) == count($orderby, 1))
			{
				$model = $model->orderBy($orderby[0], $orderby[1]);
			}
			else
			{
				foreach($orderby as $row)
				{
					$model = $model->orderBy($row[0], $row[1]);
				}
			}
		}
	}
	else
	{
		$model = $model->orderBy('id', 'desc');
	}
	
	//要返回的字段
	if(isset($where['field'])){$model = $model->select(\DB::raw($where['field']));}

	//查询条件
	$where = function ($query) use ($where) {
		if(isset($where['expression']))
		{
			foreach($where['expression'] as $row)
			{
				$query->where($row[0], $row[1], $row[2]);
			}
		}
    };

    if(!empty($where)){$model = $model->where($where);}
    
	if($skip==0){$skip = ($page-1)*$size;}
	
	return object_to_array($model->skip($skip)->take($size)->get());
}

//pc前台栏目、标签、内容页面地址生成
function get_front_url($param='')
{
	$url = '';
	
    if($param['type'] == 'list')
    {
        //列表页
        $url .= '/cat'.$param['catid'];
    }
    else if($param['type'] == 'content')
    {
        //内容页
        $url .= '/p/'.$param['id'];
    }
    else if($param['type'] == 'tags')
    {
        //tags页面
        $url .= '/tag'.$param['tagid'];
    }
    else if($param['type'] == 'page')
    {
        //单页面
        $url .= '/page/'.$param['pagename'];
    }
    else if($param['type'] == 'search')
    {
        //搜索关键词页面
        $url .= '/s'.$param['searchid'];
    }
	else if($param['type'] == 'goodslist')
    {
        //商品列表页
        $url .= '/product'.$param['catid'];
    }
    else if($param['type'] == 'goodsdetail')
    {
        //商品内容页
        $url .= '/goods/'.$param['id'];
    }
	
    return $url;
}

//wap前台栏目、标签、内容页面地址生成
function get_wap_front_url(array $param)
{
    $url = '';
	
    if($param['type'] == 'list')
    {
        //列表页
        $url .= '/cat'.$param['catid'];
    }
    else if($param['type'] == 'content')
    {
        //内容页
        $url .= '/p/'.$param['id'];
    }
    else if($param['type'] == 'tags')
    {
        //tags页面
        $url .= '/tag'.$param['tagid'];
    }
    else if($param['type'] == 'page')
    {
        //单页面
        $url .= '/page/'.$param['pagename'];
    }
    else if($param['type'] == 'search')
    {
        //tags页面
        $url .= '/s'.$param['searchid'];
    }
	else if($param['type'] == 'goodslist')
    {
        //商品列表页
        $url .= '/product'.$param['catid'];
    }
    else if($param['type'] == 'goodsdetail')
    {
        //商品内容页
        $url .= '/goods/'.$param['id'];
    }
	
    return $url;
}

/**
 * 获取文章列表
 * @param int $tuijian=0 推荐等级
 * @param int $typeid=0 分类
 * @param int $image=1 是否存在图片
 * @param int $row=10 需要返回的数量
 * @param string $orderby='id desc' 排序，默认id降序，随机rand()
 * @param string $limit='0,10' 如果存在$row，$limit就无效
 * @return string
 */
function arclist(array $param)
{
	$modelname = 'article';
	if(isset($param['table'])){$modelname = $param['table'];}

	$model = \DB::table($modelname);
	
	$size = sysconfig('CMS_PAGESIZE');$page = 1;$skip = 0;
	if(isset($param['limit'])){$limit=explode(',',$param['limit']); $skip = $limit[0]; $size = $limit[1];}else{if(isset($param['row'])){$size = $param['row'];}} // 参数格式：$param['limit'] = '2,10';$param['row'] = 10;

	//查询条件
	$where = function ($query) use ($param) {
		if(isset($param['tuijian']))
		{
			if(is_array($param['tuijian']))
			{
				$query->where('tuijian', $param['tuijian'][0], $param['tuijian'][1]);
			}
			else
			{
				$query->where('tuijian', $param['tuijian']);
			}
		}
		
		if(isset($param['expression']))
		{
			foreach($param['expression'] as $row)
			{
				$query->where($row[0], $row[1], $row[2]);
			}
		}
		
		if(isset($param['typeid']))
		{
			$query->where('typeid', $param["typeid"]);
		}
		
		if(isset($param['image']))
		{
			$query->where('litpic', '<>', '');
		}
    };

    if(!empty($where)){$model = $model->where($where);}

    //原生sql
	if(isset($param['sql']))
	{
		$model = $model->whereRaw($param['sql']);
	}

    //排序
	if(isset($param['orderby']))
	{
		$orderby = $param['orderby'];
		
		if($orderby == 'rand()')
		{
			$model = $model->orderBy(\DB::raw('rand()'));
		}
		else
		{
			if(count($orderby) == count($orderby, 1))
			{
				$model = $model->orderBy($orderby[0], $orderby[1]);
			}
			else
			{
				foreach($orderby as $row)
				{
					$model = $model->orderBy($row[0], $row[1]);
				}
			}
		}
	}
	else
	{
		$model = $model->orderBy('id', 'desc');
	}
	
	//要返回的字段
	if(isset($param['field'])){$model = $model->select(\DB::raw($param['field']));}

	if($skip==0){$skip = ($page-1)*$size;}
	
	return object_to_array($model->skip($skip)->take($size)->get());
}

/**
 * 获取tag标签列表
 * @param int $row=10 需要返回的数量，如果存在$limit,$row就无效
 * @param string $orderby='id desc' 排序，默认id降序，随机rand()
 * @param string $limit='0,10'
 * @return string
 */
function tagslist($param="")
{
	$tagindex = \DB::table("tagindex");
    $orderby=$limit="";
	if(isset($param['row'])){$tagindex = $tagindex->take($param['row']);}
	if(isset($param['orderby'])){if($param['orderby']=='rand()'){$tagindex = $tagindex->orderBy(\DB::Raw('rand()'));}else{$tagindex = $tagindex->orderBy($param['orderby'][0],$param['orderby'][1]);}}else{$tagindex = $tagindex->orderBy('id','desc');}
	
	return object_to_array($tagindex->get());
}

/**
 * 获取友情链接
 * @param string $orderby='id desc' 排序，默认id降序，随机rand()
 * @param int||string $limit='0,10'
 * @return string
 */
function flinklist($param="")
{
	return \DB::table("friendlink")->orderBy('rank','desc')->take($param['row'])->get();
}

/**
 * 获取文章上一篇，下一篇id
 * @param $param['aid'] 当前文章id
 * @param $param['typeid'] 当前文章typeid
 * @param string $type 获取类型
 *       pre:上一篇 next:下一篇
 * @return array
 */
function get_article_prenext(array $param)
{
    $typeid = $res = '';
    
    if(!empty($param["typeid"]))
    {
        $typeid = $param["typeid"];
    }
    else
    {
        $Article = DB::table("article")->select('typeid')->where('id', $param["aid"])->first();
        $typeid = $Article["typeid"];
    }
    
	$res = DB::table("article")->select('id','typeid','title')->where('typeid', $typeid);
    if($param["type"]=='pre')
    {
        $res = $res->where('id', '<', $param["aid"])->orderBy('id', 'desc');
    }
    elseif($param["type"]=='next')
    {
        $res = $res->where('id', '>', $param["aid"])->orderBy('id', 'asc');
    }
    
    return object_to_array($res->first(), 1);
}

/**
 * 获取列表分页
 * @param $param['pagenow'] 当前第几页
 * @param $param['counts'] 总条数
 * @param $param['pagesize'] 每页显示数量
 * @param $param['catid'] 栏目id
 * @param $param['offset'] 偏移量
 * @return array
 */
function get_listnav(array $param)
{
	$catid       = $param["catid"];
	$pagenow     = $param["pagenow"];
	$prepage     = $nextpage = '';
    $prepagenum  = $pagenow-1;
    $nextpagenum = $pagenow+1;
	
	$counts=$param["counts"];
	$totalpage=get_totalpage(array("counts"=>$counts,"pagesize"=>$param["pagesize"]));
	
	if($totalpage<=1 && $counts>0)
	{
		return "<li><span class=\"pageinfo\">共1页/".$counts."条记录</span></li>";
	}
	if($counts == 0)
	{
		return "<li><span class=\"pageinfo\">共0页/".$counts."条记录</span></li>";
	}
	$maininfo = "<li><span class=\"pageinfo\">共".$totalpage."页".$counts."条</span></li>";
    
	if(!empty($param["urltype"]))
    {
        $urltype = $param["urltype"];
    }
	else
	{
		$urltype = 'cat';
	}
	
	//获得上一页和下一页的链接
	if($pagenow != 1)
	{
		if($pagenow == 2)
		{
			$prepage.="<li><a href='/".$urltype.$catid."'>上一页</a></li>";
		}
		else
		{
			$prepage.="<li><a href='/".$urltype.$catid."/$prepagenum'>上一页</a></li>";
		}
		
		$indexpage="<li><a href='/".$urltype.$catid."'>首页</a></li>";
	}
	else
	{
		$indexpage="<li><a>首页</a></li>";
	}
	if($pagenow!=$totalpage && $totalpage>1)
	{
		$nextpage.="<li><a href='/".$urltype.$catid."/$nextpagenum'>下一页</a></li>";
		$endpage="<li><a href='/".$urltype.$catid."/$totalpage'>末页</a></li>";
	}
	else
	{
		$endpage="<li><a>末页</a></li>";
	}
	
	//获得数字链接
	$listdd="";
	if(!empty($param["offset"])){$offset=$param["offset"];}else{$offset=2;}
	
	$minnum=$pagenow-$offset;
	$maxnum=$pagenow+$offset;
	
	if($minnum<1){$minnum=1;}
	if($maxnum>$totalpage){$maxnum=$totalpage;}
	
	for($minnum;$minnum<=$maxnum;$minnum++)
	{
		if($minnum==$pagenow)
		{
			$listdd.= "<li class=\"thisclass\"><a>$minnum</a></li>";
		}
		else
		{
			if($minnum==1)
			{
				$listdd.="<li><a href='/".$urltype.$catid."'>$minnum</a></li>";
			}
			else
			{
				$listdd.="<li><a href='/".$urltype.$catid."/$minnum'>$minnum</a></li>";
			}
		}
	}
    
    $plist = '';
	$plist .= $indexpage; //首页链接
	$plist .= $prepage; //上一页链接
	$plist .= $listdd; //数字链接
	$plist .= $nextpage; //下一页链接
	$plist .= $endpage; //末页链接
	$plist .= $maininfo;
	
	return $plist;
}

/**
 * 获取列表上一页、下一页
 * @param $param['pagenow'] 当前第几页
 * @param $param['counts'] 总条数
 * @param $param['pagesize'] 每页显示数量
 * @param $param['catid'] 栏目id
 * @return array
 */
function get_prenext(array $param)
{
	$counts=$param['counts'];
	$pagenow=$param["pagenow"];
	$prepage = $nextpage = '';
	$prepagenum = $pagenow-1;
    $nextpagenum = $pagenow+1;
	$cat=$param['catid'];
    
	if(!empty($param["urltype"]))
    {
        $urltype = $param["urltype"];
    }
	else
	{
		$urltype = 'cat';
	}
    
	$totalpage=get_totalpage(array("counts"=>$counts,"pagesize"=>$param["pagesize"]));
	
	//获取上一页
	if($pagenow == 1)
	{
		
	}
	elseif($pagenow==2)
	{
		$prepage='<a class="prep" href="/'.$urltype.$cat.'">上一页</a> &nbsp; ';
	}
	else
	{
		$prepage='<a class="prep" href="/'.$urltype.$cat.'/'.$prepagenum.'">上一页</a> &nbsp; ';
	}
	
	//获取下一页
	if($pagenow<$totalpage && $totalpage>1)
	{
		$nextpage='<a class="nextp" href="/'.$urltype.$cat.'/'.$nextpagenum.'">下一页</a>';
	}
	
	$plist = '';
	$plist .= $indexpage; //首页链接
	$plist .= $prepage; //上一页链接
	$plist .= $nextpage; //下一页链接
	
	return $plist;
}

/**
 * 获取分页列表
 * @access    public
 * @param     string  $list_len  列表宽度
 * @param     string  $list_len  列表样式
 * @return    string
 */
function pagenav(array $param)
{
    $prepage = $nextpage = '';
    $prepagenum = $param["pagenow"]-1;
    $nextpagenum = $param["pagenow"]+1;
    
	if(!empty($param['tuijian'])){$map['tuijian']=$param['tuijian'];}
	if(!empty($param['typeid'])){$map['typeid']=$param['typeid'];}
	if(!empty($param['image'])){$map['litpic']=array('NEQ','');}
	if(!empty($param['row'])){$limit="0,".$param['row'];}else{if(!empty($param['limit'])){$limit=$param['limit'];}else{$limit='0,8';}}
	if(!empty($param['orderby'])){$orderby=$param['orderby'];}else{$orderby='id desc';}
	
    return db("article")->field('body',true)->where($map)->order($orderby)->limit($limit)->select();
}

//根据总数与每页条数，获取总页数
function get_totalpage(array $param)
{
	if(!empty($param['pagesize'] || $param['pagesize']==0)){$pagesize=$param["pagesize"];}else{$pagesize=CMS_PAGESIZE;}
	$counts=$param["counts"];
	
	//取总数据量除以每页数的余数
    if($counts % $pagesize)
	{
		$totalpage = intval($counts/$pagesize) + 1; //如果有余数，则页数等于总数据量除以每页数的结果取整再加一,如果没有余数，则页数等于总数据量除以每页数的结果
	}
	else
	{
		$totalpage = $counts/$pagesize;
	}
	
	return $totalpage;
}

/**
 * 获得当前的页面文件的url
 * @access public
 * @return string
 */
function GetCurUrl()
{
    if(!empty($_SERVER['REQUEST_URI']))
    {
        $nowurl = $_SERVER['REQUEST_URI'];
        $nowurls = explode('?', $nowurl);
        $nowurl = $nowurls[0];
    }
    else
    {
        $nowurl = $_SERVER['PHP_SELF'];
    }
    return $nowurl;
}

/**
 * 获取单页列表
 * @param int $row=8 需要返回的数量
 * @param string $orderby='id desc' 排序，默认id降序，随机rand()
 * @param string $limit='0,8' 如果存在$row，$limit就无效
 * @return string
 */
function pagelist($param="")
{
	if(!empty($param['row'])){$limit="0,".$param['row'];}else{if(!empty($param['limit'])){$limit=$param['limit'];}else{$limit='0,8';}}
	if(!empty($param['orderby'])){$orderby=$param['orderby'];}else{$orderby='id desc';}
	
    return db("page")->field('body',true)->order($orderby)->limit($limit)->select();
}

/**
 * 截取中文字符串
 * @param string $string 中文字符串
 * @param int $sublen 截取长度
 * @param int $start 开始长度 默认0
 * @param string $code 编码方式 默认UTF-8
 * @param string $omitted 末尾省略符 默认...
 * @return string
 */
function cut_str($string, $sublen=250, $omitted = '', $start=0, $code='UTF-8')
{
	$string = strip_tags($string);
	$string = str_replace("　","",$string);
	$string = mb_strcut($string,$start,$sublen,$code);
	$string.= $omitted;
	return $string;
}

//PhpAnalysis获取中文分词
function get_keywords($keyword)
{
	require_once(resource_path('org/phpAnalysis/phpAnalysis.php'));
	//import("Vendor.phpAnalysis.phpAnalysis");
	//初始化类
	PhpAnalysis::$loadInit = false;
    $pa = new PhpAnalysis('utf-8', 'utf-8', false);
	//载入词典
	$pa->LoadDict();
	//执行分词
    $pa->SetSource($keyword);
    $pa->StartAnalysis( false );
    $keywords = $pa->GetFinallyResult(',');
	
    return ltrim($keywords, ",");
}

//获取二维码
function get_erweima($url='',$size=150)
{
    return 'data:image/png;base64,'.base64_encode(\QrCode::format('png')->encoding('UTF-8')->size($size)->margin(0)->errorCorrection('H')->generate($url));
}

//根据栏目id获取栏目信息
function typeinfo($typeid)
{
    return db("arctype")->where("id=$typeid")->find();
}

//根据栏目id获取该栏目下文章/商品的数量
function catarcnum($typeid, $modelname='article')
{
    $map['typeid']=$typeid;
    return \DB::table($modelname)->where($map)->count('id');
}

//根据Tag id获取该Tag标签下文章的数量
function tagarcnum($tagid)
{
	$taglist = \DB::table("taglist");
    if(!empty($tagid)){$map['tid']=$tagid; $taglist = $taglist->where($map);}
    return $taglist->count();
}

//判断是否是图片格式，是返回true
function imgmatch($url)
{
    $info = pathinfo($url);
    if (isset($info['extension']))
    {
        if (($info['extension'] == 'jpg') || ($info['extension'] == 'jpeg') || ($info['extension'] == 'gif') || ($info['extension'] == 'png'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

//将栏目列表生成数组
function get_category($modelname, $parent_id=0, $pad=0)
{
    $arr = array();
	
	$temp = \DB::table($modelname)->where('pid', $parent_id);
    if(get_table_columns($modelname, 'listorder'))
	{
		$temp = $temp->orderBy('listorder', 'asc');
	}
	else
	{
		$temp = $temp->orderBy('id', 'asc');
	}
	
	$temp = $temp->get();
    
    $cats = object_to_array($temp);
	
    if($cats)
    {
        foreach($cats as $row)//循环数组
        {
            $row['deep'] = $pad;
			
            if($child = get_category($modelname, $row["id"], $pad+1))//如果子级不为空
            {
                $row['child'] = $child;
            }
			
            $arr[] = $row;
        }
		
        return $arr;
    }
}

function category_tree($list,$pid=0)
{
    global $temp;
	
    if(!empty($list))
    {
        foreach($list as $v)
        {
            $temp[] = array("id"=>$v['id'],"deep"=>$v['deep'],"name"=>$v['name'],"pid"=>$v['pid']);
            //echo $v['id'];
            if(array_key_exists("child",$v))
            {
                category_tree($v['child'],$v['pid']);
            }
        }
    }
	
    return $temp;
}

//递归获取面包屑导航
function get_cat_path($cat,$table='arctype',$type='list')
{
    global $temp;
    
    $row = \DB::table($table)->select('name','pid','id')->where('id',$cat)->first();
    
    $temp = '<a href="'.get_front_url(array("catid"=>$row->id,"type"=>$type)).'">'.$row->name."</a> > ".$temp;
    
    if($row->pid<>0)
    {
        get_cat_path($row->pid, $table, $type);
    }
    
    return $temp;
}

//根据文章id获得tag，$id表示文章id，$tagid表示要排除的标签id
function taglist($id,$tagid=0)
{
    $tags="";
    if($tagid!=0)
    {
        $Taglist = \DB::table("taglist")->where('aid',$id)->where('tid', '<>', $tagid)->get();
    }
    else
    {
        $Taglist = \DB::table("taglist")->where('aid',$id)->get();
    }
    
    foreach($Taglist as $row)
    {
        if($tags==""){$tags='id='.$row->tid;}else{$tags=$tags.' or id='.$row->tid;}
    }
	
    if($tags!=""){return object_to_array(\DB::table("tagindex")->whereRaw(\DB::raw($tags))->get());}
}

//读取动态配置
function sysconfig($varname='')
{
	$sysconfig = cache('sysconfig');
	$res = '';
	
	if(empty($sysconfig))
	{
		cache()->forget('sysconfig');
		
		$sysconfig = \App\Http\Model\Sysconfig::orderBy('id')->select('varname', 'value')->get()->toArray();
		
		cache(['sysconfig' => $sysconfig], \Carbon\Carbon::now()->addMinutes(86400));
	}
	
	if($varname != '')
	{
		foreach($sysconfig as $row)
		{
			if($varname == $row['varname'])
			{
				$res = $row['value'];
			}
		}
	}
	else
	{
		$res = $sysconfig;
	}
	
	return $res;
}

//获取https的get请求结果
function curl_post($c_url,$data='')
{
	$curl = curl_init(); // 启动一个CURL会话
	curl_setopt($curl, CURLOPT_URL, $c_url); // 要访问的地址
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
	
	if($data)
	{
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
	}
	
	curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	
	$tmpInfo = curl_exec($curl); // 执行操作
	
	if (curl_errno($curl))
	{
		echo 'Errno'.curl_error($curl);//捕抓异常
	}
	
	curl_close($curl); // 关闭CURL会话
	
	return $tmpInfo; // 返回数据
}

//通过file_get_content获取远程数据
function http_request_post($url,$data,$type='POST')
{
	$content = http_build_query($data);
	$content_length = strlen($content);
	$options = array(
		'http' => array(
			'method' => $type,
			'header' => "Content-type: application/x-www-form-urlencoded\r\n" .	"Content-length: $content_length\r\n",
			'content' => $content
		)
	);
	
	$result = file_get_contents($url,false,stream_context_create($options));
	
	return $result;
}

function json_to_array($json)
{
	return json_decode($json,true);
}

function imageResize($url, $width, $height)
{
	header('Content-type: image/jpeg');
	
	list($width_orig, $height_orig) = getimagesize($url);
	$ratio_orig = $width_orig/$height_orig;
	
	if($width/$height > $ratio_orig)
	{
		$width = $height*$ratio_orig;
	}
	else
	{
		$height = $width/$ratio_orig;
	}
	
	// This resamples the image
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($url);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	// Output the image
	imagejpeg($image_p, null, 100);
}

/**
 * 为文章内容添加内敛, 排除alt title <a></a>直接的字符替换
 *
 * @param string $body
 * @return string
 */
function ReplaceKeyword($body)
{
	$karr = $kaarr = array();
    
	//暂时屏蔽超链接
	$body = preg_replace("#(<a(.*))(>)(.*)(<)(\/a>)#isU", '\\1-]-\\4-[-\\6', $body);
	
	if(cache("keywordlist")){$posts=cache("keywordlist");}else{$posts = object_to_array(DB::table("keyword")->get());cache(["keywordlist"=>$posts], \Carbon\Carbon::now()->addMinutes(2592000));}
    
	foreach($posts as $row)
	{
		$keyword = trim($row['keyword']);
		$key_url=trim($row['rpurl']);
		$karr[] = $keyword;
		$kaarr[] = "<a href='$key_url' target='_blank'><u>$keyword</u></a>";
	}
	
	asort($karr);
    
    $body = str_replace('\"', '"', $body);
    
	foreach ($karr as $key => $word)
	{
		$body = preg_replace("#".preg_quote($word)."#isU", $kaarr[$key], $body, 1);
	}
    
	//恢复超链接
	return preg_replace("#(<a(.*))-\]-(.*)-\[-(\/a>)#isU", '\\1>\\3<\\4', $body);
}

/**
 * 删除非站内链接
 *
 * @access    public
 * @param     string  $body  内容
 * @param     array  $allow_urls  允许的超链接
 * @return    string
 */
function replacelinks($body, $allow_urls=array())
{
    $host_rule = join('|', $allow_urls);
    $host_rule = preg_replace("#[\n\r]#", '', $host_rule);
    $host_rule = str_replace('.', "\\.", $host_rule);
    $host_rule = str_replace('/', "\\/", $host_rule);
    $arr = '';
	
    preg_match_all("#<a([^>]*)>(.*)<\/a>#iU", $body, $arr);
	
    if( is_array($arr[0]) )
    {
        $rparr = array();
        $tgarr = array();
		
        foreach($arr[0] as $i=>$v)
        {
            if( $host_rule != '' && preg_match('#'.$host_rule.'#i', $arr[1][$i]) )
            {
                continue;
            }
			else
			{
                $rparr[] = $v;
                $tgarr[] = $arr[2][$i];
            }
        }
		
        if( !empty($rparr) )
        {
            $body = str_replace($rparr, $tgarr, $body);
        }
    }
    $arr = $rparr = $tgarr = '';
    return $body;
}

/**
 * 获取文本中首张图片地址
 * @param  [type] $content
 * @return [type]
 */
function getfirstpic($content)
{
    if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches))
	{
        $file=$_SERVER['DOCUMENT_ROOT'].$matches[3][0];
		
		if(file_exists($file))
		{
			return $matches[3][0];
		}
    }
	else
	{
		return false;
	}
}

/**
 * 更新配置文件 / 更新系统缓存
 */
function updateconfig()
{
	$str_tmp="<?php\r\n"; //得到php的起始符。$str_tmp将累加
    $str_end="?>"; //php结束符
    $str_tmp.="//全站配置文件\r\n";
    
	$param = db("sysconfig")->select();
    foreach($param as $row)
    {
        $str_tmp .= 'define("'.$row['varname'].'","'.$row['value'].'"); // '.$row['info']."\r\n";
    }
	
    $str_tmp .= $str_end; //加入结束符
    //保存文件
    $sf = APP_PATH."common.inc.php"; //文件名
    $fp = fopen($sf,"w"); //写方式打开文件
    fwrite($fp,$str_tmp); //存入内容
    fclose($fp); //关闭文件
}

//清空文件夹
function dir_delete($dir)
{
    //$dir = dir_path($dir);
    if (!is_dir($dir)) return FALSE; 
    $handle = opendir($dir); //打开目录
    
    while(($file = readdir($handle)) !== false)
    {
        if($file == '.' || $file == '..')continue;
        $d = $dir.DIRECTORY_SEPARATOR.$file;
        is_dir($d) ? dir_delete($d) : @unlink($d);
    }
    
    closedir($handle);
    return @rmdir($dir);
}

//对象转数组
function object_to_array($object, $get=0)
{
	$res = [];
	if(empty($object)) {
		return $res;
	}

	if ($get==0) {
		foreach ($object as $key=>$value) {
			$res[$key] = (array)$value;
		}
	}
	elseif ($get==1) {
		$res = (array)$object;
	}

    return $res;
}

/**
 * 操作错误跳转的快捷方法
 * @access protected
 * @param string $msg 错误信息
 * @param string $url 页面跳转地址
 * @param mixed $time 当数字时指定跳转时间
 * @return void
 */
function error_jump($msg='', $url='', $time=3)
{
	if ($url=='' && isset($_SERVER["HTTP_REFERER"]))
	{
		$url = $_SERVER["HTTP_REFERER"];
	}
	
	if(!headers_sent())
    {
        header("Location:".route('admin_jump')."?error=$msg&url=$url&time=$time");
        exit();
    }
    else
    {
        $str = "<meta http-equiv='Refresh' content='URL=".route('admin_jump')."?error=$msg&url=$url&time=$time"."'>";
        exit($str);
    }
}

/**
 * 操作成功跳转的快捷方法
 * @access protected
 * @param string $msg 提示信息
 * @param string $url 页面跳转地址
 * @param mixed $time 当数字时指定跳转时间
 * @return void
 */
function success_jump($msg='', $url='', $time=1)
{
	if ($url=='' && isset($_SERVER["HTTP_REFERER"]))
	{
		$url = $_SERVER["HTTP_REFERER"];
	}
	
	if(!headers_sent())
    {
		header("Location:".route('admin_jump')."?message=$msg&url=$url&time=$time");
        exit();
    }
    else
    {
        $str = "<meta http-equiv='Refresh' content='URL=".route('admin_jump')."?message=$msg&url=$url&time=$time"."'>";
        exit($str);
    }
}

//获取表所有字段
function get_table_columns($table, $field='')
{
	$res = \Illuminate\Support\Facades\Schema::getColumnListing($table);
	
	if($field != '')
	{
		//判断字段是否在表里面
		if(in_array($field, $res))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	return $res;
}

//获取http(s)://+域名
function http_host($flag=true)
{
    $res = '';
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    if($flag)
    {
        $res = "$protocol$_SERVER[HTTP_HOST]";
    }
    else
    {
        $res = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //完整网址
    }
    
    return $res;
}

/**
 * 获取数据属性
 * @param $dataModel 数据模型
 * @param $data 数据
 * @return array
 */
function getDataAttr($dataModel,$data = [])
{
    if(empty($dataModel) || empty($data))
    {
        return false;
    }
    
    foreach($data as $k=>$v)
    {
        $_method_str=ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {
            return strtoupper($match[1]);
        }, $k));
        
        $_method = 'get' . $_method_str . 'Attr';
        
        if(method_exists($dataModel, $_method))
        {
			$tmp = $k.'_text';
            $data->$tmp = $dataModel->$_method($data);
        }
    }
    
    return $data;
}

/**
 * 调用服务接口
 * @param $name 服务类名称
 * @param array $config 配置
 * @return object
 */
function service($name = '', $config = [])
{
    static $instance = [];
    $guid = $name . 'Service';
    if (!isset($instance[$guid]))
    {
        $class = 'App\\Http\\Service\\' . ucfirst($name);
        if (class_exists($class))
        {
            $service = new $class($config);
            $instance[$guid] = $service;
        }
        else
        {
            throw new Exception('class not exists:' . $class);
        }
    }
    
    return $instance[$guid];
}

/**
 * 调用逻辑接口
 * @param $name 逻辑类名称
 * @param array $config 配置
 * @return object
 */
function logic($name = '', $config = [])
{
    static $instance = [];
    $guid = $name . 'Logic';
    if (!isset($instance[$guid]))
    {
        $class = 'App\\Http\\Logic\\' . ucfirst($name) . 'Logic';
        
        if (class_exists($class))
        {
            $logic = new $class($config);
            $instance[$guid] = $logic;
        }
        else
        {
            throw new Exception('class not exists:' . $class);
        }
    }
    
    return $instance[$guid];
}

/**
 * 实例化（分层）模型
 * @param $name 模型类名称
 * @param array $config 配置
 * @return object
 */
function model($name = '', $config = [])
{
    static $instance = [];
    $guid = $name . 'Model';
    if (!isset($instance[$guid]))
    {
        $class = '\\App\\Http\\Model\\' . ucfirst($name);
        if (class_exists($class))
        {
            $model = new $class($config);
            $instance[$guid] = $model;
        }
        else
        {
            throw new Exception('class not exists:' . $class);
        }
    }
    
    return $instance[$guid];
}

//判断是否为数字
function checkIsNumber($data)
{
	if($data == '' || $data == null)
	{
		return false;
	}
	
    if(preg_match("/^\d*$/",$data))
	{
		return true;
	}
    
	return false;
}

// 车牌号校验
function isCarLicense($license)
{
    if (empty($license)) {
        return false;
    }
    $regular = "/^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领A-Z]{1}[A-Z]{1}[A-Z0-9]{4}[A-Z0-9挂学警港澳]{1}$/u";
    preg_match($regular, $license, $match);
    if (isset($match[0])) {
        return true;
    }
    
    return false;
}

/**
 * 格式化文件大小显示
 *
 * @param int $size
 * @return string
 */
function format_bytes($size)
{
    $prec = 3;
    $size = round(abs($size));
    $units = array(
        0 => " B ",
        1 => " KB",
        2 => " MB",
        3 => " GB",
        4 => " TB"
    );
    if ($size == 0)
    {
        return str_repeat(" ", $prec) . "0$units[0]";
    }
    $unit = min(4, floor(log($size) / log(2) / 10));
    $size = $size * pow(2, -10 * $unit);
    $digi = $prec - 1 - floor(log($size) / log(10));
    $size = round($size * pow(10, $digi)) * pow(10, -$digi);
 
    return $size . $units[$unit];
}
