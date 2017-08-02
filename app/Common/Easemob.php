<?php
namespace App\Common;

//环信即时云通信
class Easemob
{
	//const APP_KEY = 'b82cd9fcd0cbb92866d6d726';
	//const APP_SECRET = 'ac92d336f90842051dc12f49';
	
	private $client_id     = 'YXA6fLiQwHNeEee1cGVk2WW3qw';
	private $client_secret = 'YXA6Re59-iEqGB2aohfoaeeAgEtRYiw';
	private $org_name      = '1194170724115734';
	private $app_name      = 'cuobian';
	private $url;
	
	/**
	 * 初始化参数
	 *
	 * @param array $options 
	 * @param $options['client_id'] 
	 * @param $options['client_secret'] 
	 * @param $options['org_name'] 
	 * @param $options['app_name'] 
	*/
	public function __construct($options='')
	{
		/* $this->client_id = isset ( $options ['client_id'] ) ? $options ['client_id'] : '';
		$this->client_secret = isset ( $options ['client_secret'] ) ? $options ['client_secret'] : '';
		$this->org_name = isset ( $options ['org_name'] ) ? $options ['org_name'] : '';
		$this->app_name = isset ( $options ['app_name'] ) ? $options ['app_name'] : ''; */
		
		if (! empty ( $this->org_name ) && ! empty ( $this->app_name ))
		{
			$this->url = 'https://a1.easemob.com/' . $this->org_name . '/' . $this->app_name . '/';
		}
	}
	
	/** 
	 * 获取app管理员token
	 * Path: /{org_name}/{app_name}/token
     * HTTP Method: POST
     * URL Params: 无
     * Request Headers: {“Content-Type”:”application/json”}
     * Request Body: {“grant_type”: “client_credentials”,”client_id”: “{APP的client_id}”,”client_secret”: “{APP的client_secret}”}
	 */  
	public function getToken()
	{
		$url = $this->url . "token";
		$body=array(
		"grant_type"=> "client_credentials",
		"client_id"=> $this->client_id,
		"client_secret"=> $this->client_secret
		);
		
		$res = $this->postCurl($url,$body);
		$tokenResult = array();
		
		$tokenResult =  json_decode($res, true);
		//var_dump($tokenResult);
		//return "Authorization:Bearer ". $tokenResult["access_token"];
		
		return $tokenResult["access_token"];
	}
	
	/**
	 * 开放注册模式
	 *
	 * @param $options['username'] 用户名
	 * @param $options['password'] 密码
	 */
	public function openRegister($options)
	{
		$url = $this->url . "users";
		$result = $this->postCurl ( $url, $options, $head = 0 );
		
		return $result;
	}
	
	/**
	 * 授权注册模式 || 批量注册
	 *
	 * @param $options['username'] 用户名
	 * @param $options['password'] 密码
	 * 批量注册传二维数组
	 */
	public function imRegister($options)
	{
		$url = $this->url . "users";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, $options, $header );
		
		return $result;
	}
	
	/**
	 * 获取指定用户详情
	 *
	 * @param $username 用户名 
	 */
	public function userDetails($username)
	{
		$url = $this->url . "users/" . $username;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = 'GET' );
		
		return $result;
	}

	/**
	 * 重置用户密码
	 *
	 * @param $options['username'] 用户名 
	 * @param $options['password'] 密码 
	 * @param $options['newpassword'] 新密码 
	 */
	public function editPassword($options)
	{
		$url = $this->url . "users/" . $options['username'] . "/password";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, $options, $header, $type = 'PUT');
		
		return $result;
	}
	
	/**
	 * 删除用户
	 *
	 * @param $username 用户名 
	 */
	public function deleteUser($username)
	{
		$url = $this->url . "users/" . $username;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = 'DELETE' );
	}

	/**
	 * 批量删除用户
	 * 描述：删除某个app下指定数量的环信账号。上述url可一次删除300个用户,数值可以修改 建议这个数值在100-500之间，不要过大
	 *
	 * @param $limit="300" 默认为300条 
	 * @param $ql 删除条件
	 * 如ql=order+by+created+desc 按照创建时间来排序(降序)
	 */
	public function batchDeleteUser($limit = "300", $ql = '')
	{
		$url = $this->url . "users?limit=" . $limit;
		
		if (! empty ( $ql ))
		{
			$url = $this->url . "users?ql=" . $ql . "&limit=" . $limit;
		}
		
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = 'DELETE' );
	}
	
	/**
	 * 给一个用户添加一个好友
	 *
	 * @param
	 * $owner_username
	 * @param
	 * $friend_username
	 */
	public function addFriend($owner_username, $friend_username)
	{
		$url = $this->url . "users/" . $owner_username . "/contacts/users/" . $friend_username;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header );
	}
	
	/**
	 * 删除好友
	 *
	 * @param
	 * $owner_username
	 * @param
	 * $friend_username
	 */
	public function deleteFriend($owner_username, $friend_username)
	{
		$url = $this->url . "users/" . $owner_username . "/contacts/users/" . $friend_username;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "DELETE" );
	}
	
	/**
	 * 查看用户的好友
	 *
	 * @param
	 * $owner_username
	 */
	public function showFriend($owner_username)
	{
		$url = $this->url . "users/" . $owner_username . "/contacts/users/";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "GET" );
	}
	
	// +----------------------------------------------------------------------
	// | 聊天相关的方法
	// +----------------------------------------------------------------------
	/**
	 * 查看用户是否在线
	 *
	 * @param
	 * $username
	 */
	public function isOnline($username)
	{
		$url = $this->url . "users/" . $username . "/status";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "GET" );
		
		return $result;
	}
	
	/**
	 * 发送消息
	 *
	 * @param string $from_user
	 * 发送方用户名
	 * @param array $usernames
	 * array('1','2')
	 * @param string $target_type
	 * 默认为：users 描述：给一个或者多个用户(users)或者群组发送消息(chatgroups)
	 * @param string $msg_content
	 * @param array $ext
	 * 自定义参数
	 */
	public function sendMessage($from_user = "admin", $usernames, $msg_type='txt', $msg_content='', $target_type = "users", $ext=[])
	{
		$option ['target_type'] = $target_type;
		$option ['target'] = $usernames;
		$params ['type'] = $msg_type;
		
		if($msg_type == 'txt')
		{
			$params ['msg'] = $msg_content;
		}
		elseif($msg_type == 'cmd')
		{
			$params ['action'] = $msg_content;
		}

		$option ['msg'] = $params;
		$option ['from'] = $from_user;
		
		if($ext)
		{
			$option ['ext'] = $ext;
		}
		
		$url = $this->url . "messages";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, $option, $header );
		
		return $result;
	}
	
	//--------------------------------------------------------上传下载
	/**
	 * 上传图片或文件
	 */
	public function uploadFile($filePath)
	{
		$url=$this->url.'chatfiles';
		$file=file_get_contents($filePath);
		$body['file']=$file;
		$header=array('Content-type: multipart/form-data','Authorization: Bearer ' . $this->getToken(),"restrict-access:true");
		$result=$this->postCurl($url,$body,$header,'XXX');
		
		return $result;
	}
	
	/**
	 * 下载文件或图片
	 */
	public function downloadFile($uuid,$shareSecret,$ext)
	{
		$url = $this->url . 'chatfiles/' . $uuid;
		$header = array("share-secret:" . $shareSecret, "Accept:application/octet-stream", 'Authorization: Bearer ' . $this->getToken(),);
		
		if ($ext=="png")
		{
			$result = $this->postCurl($url,'',$header,'GET');
		}
		else
		{
			$result = $this->getFile($url);
		}
		
		$filename = md5(time().mt_rand(10, 99)).".".$ext; //新图片名称
		if(!file_exists("resource/down"))
		{
			mkdir("resource/down/");
		}
		
		$file = @fopen("resource/down/".$filename,"w+");//打开文件准备写入
		@fwrite($file,$result);//写入
		fclose($file);//关闭
		
		return $filename;
	}
	
	public function getFile($url)
	{
		set_time_limit(0); // unlimited max execution time
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 600); //max 10 minutes
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
	
	/**
	 * 下载图片缩略图
	 */
	public function downloadThumbnail($uuid,$shareSecret)
	{
		$url=$this->url.'chatfiles/'.$uuid;
		$header = array("share-secret:".$shareSecret,"Accept:application/octet-stream",'Authorization: Bearer ' . $this->getToken(),"thumbnail:true");
		$result=$this->postCurl($url,'',$header,'GET');
		$filename = md5(time().mt_rand(10, 99))."th.png"; //新图片名称
		
		if(!file_exists("resource/down"))
		{
			//mkdir("../image/down");
			mkdirs("resource/down/");
		}
		
		$file = @fopen("resource/down/".$filename,"w+");//打开文件准备写入
		@fwrite($file,$result);//写入
		fclose($file);//关闭
		
		return $filename;
	}
	 
	
	
	//--------------------------------------------------------发送消息
	/**
	 * 发送文本消息
	 */
	public function sendText($from="admin",$target_type,$target,$content,$ext)
	{
		$url=$this->url.'messages';
		$body['target_type']=$target_type;
		$body['target']=$target;
		$options['type']="txt";
		$options['msg']=$content;
		$body['msg']=$options;
		$body['from']=$from;
		$body['ext']=$ext;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result=$this->postCurl($url,$body,$header);
		
		return $result;
	}
	
	/**
	 * 发送透传消息
	 */
	public function sendCmd($from="admin",$target_type,$target,$action,$ext)
	{
		$url=$this->url.'messages';
		$body['target_type']=$target_type;
		$body['target']=$target;
		$options['type']="cmd";
		$options['action']=$action;
		$body['msg']=$options;
		$body['from']=$from;
		$body['ext']=$ext;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result=$this->postCurl($url,$body,$header);
		
		return $result;
	}
	
	/**
	 * 发图片消息
	 */ 
	public function sendImage($filePath,$from="admin",$target_type,$target,$filename,$ext)
	{
		$result=$this->uploadFile($filePath);
		$uri=$result['uri'];
		$uuid=$result['entities'][0]['uuid'];
		$shareSecret=$result['entities'][0]['share-secret'];
		$url=$this->url.'messages';
		$body['target_type']=$target_type;
		$body['target']=$target;
		$options['type']="img";
		$options['url']=$uri.'/'.$uuid;
		$options['filename']=$filename;
		$options['secret']=$shareSecret;
		$options['size']=array(
			"width"=>480,
			"height"=>720
		);
		$body['msg']=$options;
		$body['from']=$from;
		$body['ext']=$ext;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result=$this->postCurl($url,$body,$header);
		
		return $result;
	}
	
	/**
	 * 发语音消息
	 */
	public function sendAudio($filePath,$from="admin",$target_type,$target,$filename,$length,$ext)
	{
		$result=$this->uploadFile($filePath);
		$uri=$result['uri'];
		$uuid=$result['entities'][0]['uuid'];
		$shareSecret=$result['entities'][0]['share-secret'];
		$url=$this->url.'messages';
		$body['target_type']=$target_type;
		$body['target']=$target;
		$options['type']="audio";
		$options['url']=$uri.'/'.$uuid;
		$options['filename']=$filename;
		$options['length']=$length;
		$options['secret']=$shareSecret;
		$body['msg']=$options;
		$body['from']=$from;
		$body['ext']=$ext;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result=$this->postCurl($url,$body,$header);
		
		return $result;
	}
	
	/**
	 * 发视频消息
	 */
	public function sendVedio($filePath,$from="admin",$target_type,$target,$filename,$length,$thumb,$thumb_secret,$ext)
	{
		$result=$this->uploadFile($filePath);
		$uri=$result['uri'];
		$uuid=$result['entities'][0]['uuid'];
		$shareSecret=$result['entities'][0]['share-secret'];
		$url=$this->url.'messages';
		$body['target_type']=$target_type;
		$body['target']=$target;
		$options['type']="video";
		$options['url']=$uri.'/'.$uuid;
		$options['filename']=$filename;
		$options['thumb']=$thumb;
		$options['length']=$length;
		$options['secret']=$shareSecret;
		$options['thumb_secret']=$thumb_secret;
		$body['msg']=$options;
		$body['from']=$from;
		$body['ext']=$ext;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result=$this->postCurl($url,$body,$header);
		
		return $result;
	}
	
	/**
	 * 发文件消息
	 */
	public function sendFile($filePath,$from="admin",$target_type,$target,$filename,$length,$ext)
	{
		$result=$this->uploadFile($filePath);
		$uri=$result['uri'];
		$uuid=$result['entities'][0]['uuid'];
		$shareSecret=$result['entities'][0]['share-secret'];
		$url=$GLOBALS['base_url'].'messages';
		$body['target_type']=$target_type;
		$body['target']=$target;
		$options['type']="file";
		$options['url']=$uri.'/'.$uuid;
		$options['filename']=$filename;
		$options['length']=$length;
		$options['secret']=$shareSecret;
		$body['msg']=$options;
		$body['from']=$from;
		$body['ext']=$ext;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result=postCurl($url,$body,$header);
		
		return $result;
	}
	
	/**
	 * 获取app中所有的群组
	 */
	public function chatGroups()
	{
		$url = $this->url . "chatgroups";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "GET" );
		
		return $result;
	}
	
	/**
	 * 创建群组
	 *
	 * @param $option['groupname'] //群组名称,
	 * 此属性为必须的
	 * @param $option['desc'] //群组描述,
	 * 此属性为必须的
	 * @param $option['public'] //是否是公开群,
	 * 此属性为必须的 true or false
	 * @param $option['approval'] //加入公开群是否需要批准,
	 * 没有这个属性的话默认是true, 此属性为可选的
	 * @param $option['owner'] //群组的管理员,
	 * 此属性为必须的
	 * @param $option['members'] //群组成员,此属性为可选的 
	 */
	public function createGroups($option)
	{
		$url = $this->url . "chatgroups";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, $option, $header );
		
		return $result;
	}

	/**
	 * 修改群组
	 *
	 * @param $option['groupname']   //群组名称
	 * @param $option['description'] //群组描述
	 * @param $option['maxusers']    //群组成员最大数
	 */
	public function updateGroups($group_id,$option)
	{
		$url = $this->url . "chatgroups/". $group_id;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, $option, $header, $type = 'PUT' );
		
		return $result;
	}

	/**
	 * 获取群组详情
	 *
	 * @param
	 * $group_id
	 */
	public function chatGroupsDetails($group_id)
	{
		$url = $this->url . "chatgroups/" . $group_id;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "GET" );
		
		return $result;
	}
	
	/**
	 * 删除群组
	 *
	 * @param
	 * $group_id
	 */
	public function deleteGroups($group_id)
	{
		$url = $this->url . "chatgroups/" . $group_id;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "DELETE" );
		
		return $result;
	}
	
	/**
	 * 获取群组成员
	 *
	 * @param
	 * $group_id
	 */
	public function groupsUser($group_id)
	{
		$url = $this->url . "chatgroups/" . $group_id . "/users";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "GET" );
		
		return $result;
	}
	
	/**
	 * 群组添加成员
	 *
	 * @param
	 * $group_id
	 * @param
	 * $username
	 */
	public function addGroupsUser($group_id, $username)
	{
		$url = $this->url . "chatgroups/" . $group_id . "/users/" . $username;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "POST" );
		
		return $result;
	}

	/**
	 * 群组批量添加成员
	 *
	 * @param
	 * $group_id
	 * @param
	 * $username
	 */
	public function addGroupsUsers($group_id, $usernames)
	{
		$usernames = ['usernames' => $usernames];

		$url = $this->url . "chatgroups/" . $group_id . "/users";
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, $usernames, $header, $type = "POST" );
		
		return $result;
	}

	/**
	 * 群组删除成员
	 *
	 * @param
	 * $group_id
	 * @param
	 * $username
	 */
	public function delGroupsUser($group_id, $username)
	{
		$url = $this->url . "chatgroups/" . $group_id . "/users/" . $username;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "DELETE" );
		
		return $result;
	}
	
	/**
	 * 聊天消息记录
	 *
	 * @param $ql 查询条件如：$ql
	 * = "select+*+where+from='" . $uid . "'+or+to='". $uid ."'+order+by+timestamp+desc&limit=" . $limit . $cursor;
	 * 默认为order by timestamp desc
	 * @param $cursor 分页参数
	 * 默认为空
	 * @param $limit 条数
	 * 默认20
	 */
	public function chatRecord($ql = '', $cursor = '', $limit = 20)
	{
		$ql = ! empty ( $ql ) ? "ql=" . $ql : "order+by+timestamp+desc";
		$cursor = ! empty ( $cursor ) ? "&cursor=" . $cursor : '';
		$url = $this->url . "chatmessages?" . $ql . "&limit=" . $limit . $cursor;
		$access_token = $this->getToken();
		$header [] = 'Authorization: Bearer ' . $access_token;
		$result = $this->postCurl ( $url, '', $header, $type = "GET " );
		
		return $result;
	}
	
	/**
	 * 获取Token
	 */
	/* public function getToken()
	{
		$option ['grant_type'] = "client_credentials";
		$option ['client_id'] = $this->client_id;
		$option ['client_secret'] = $this->client_secret;
		$url = $this->url . "token";
		$fp = @fopen ( "easemob.txt", 'r' );
		
		if ($fp)
		{
			$arr = unserialize ( fgets ( $fp ) );
			
			if ($arr ['expires_in'] < time ())
			{
				$result = $this->postCurl ( $url, $option, $head = 0 );
				$result = json_decode($result);
				$result ['expires_in'] = $result ['expires_in'] + time ();
				@fwrite ( $fp, serialize ( $result ) );
				return $result ['access_token'];
				fclose ( $fp );
				exit ();
			}
			
			return $arr ['access_token'];
			fclose ( $fp );
			
			exit ();
		}
		
		$result = $this->postCurl ( $url, $option, $head = 0 );
		$result = json_decode($result,true);
		$result ['expires_in'] = $result ['expires_in'] + time ();
		$fp = @fopen ( "easemob.txt", 'w' );
		@fwrite ( $fp, serialize ( $result ) );
		
		return $result ['access_token'];
		
		fclose ( $fp );
	} */
	
	private function postCurl($url, $option, $header = 0, $type = 'POST')
	{
		$curl = curl_init (); // 启动一个CURL会话
		curl_setopt ( $curl, CURLOPT_URL, $url ); // 要访问的地址
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE ); // 对认证证书来源的检查
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE ); // 从证书中检查SSL加密算法是否存在
		curl_setopt ( $curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)' ); // 模拟用户使用的浏览器
		
		if (! empty ( $option ))
		{
			$options = json_encode ( $option );
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $options ); // Post提交的数据包
		}
		
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 30 ); // 设置超时限制防止死循环
		
		if(is_object($header) || is_array($header))
		{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // 设置HTTP头
		}
		
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 ); // 获取的信息以文件流的形式返回
		curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, $type );
		$result = curl_exec ( $curl ); // 执行操作
		//$res = object_array ( json_decode ( $result ) );
		//$res ['status'] = curl_getinfo ( $curl, CURLINFO_HTTP_CODE );
		//pre ( $res );
		curl_close ( $curl ); // 关闭CURL会话
		
		return $result;
	}
	
	//postCurl方法
	public function curl($url, $body, $header = array(), $method = "POST")
	{
		array_push($header, 'Accept:application/json');
		array_push($header, 'Content-Type:application/json');
		//array_push($header, 'http:multipart/form-data');
		
		$ch = curl_init();//启动一个curl会话
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, $method, 1);
		
		switch ($method)
		{
			case "GET" :
				curl_setopt($ch, CURLOPT_HTTPGET, true);
			break;
			case "POST":
				curl_setopt($ch, CURLOPT_POST,true);
			break;
			case "PUT" :
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			break;
			case "DELETE":
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			break;
		}
		
		curl_setopt($ch, CURLOPT_USERAGENT, 'SSTS Browser/1.0');
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//原先是FALSE，可改为2
		
		if (isset($body{3}) > 0)
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}
		
		if (count($header) > 0)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		
		$ret = curl_exec($ch);
		$err = curl_error($ch);
		
		curl_close($ch);
		//clear_object($ch);
		//clear_object($body);
		//clear_object($header);
		
		if ($err)
		{
			return $err;
		}
		
		return $ret;
	}
}