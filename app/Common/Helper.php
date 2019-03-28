<?php
namespace App\Common;

class Helper
{
	//保留两位小数，最后一位会四舍五入
    public static function formatPrice($price)
    {
        return sprintf("%.2f",$price);
    }
	
    //验证是否是合法的手机号码
    public static function isValidMobile($mobile)
    {
        return preg_match('/^(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])\d{8}$/', $mobile);
    }
	
    //验证是否是合法中文
    public static function isValidChinese($word, $length = 16)
    {
        $pattern = "/(^[\x{4e00}-\x{9fa5}]+)/u";

        preg_match($pattern, $word, $match);

        if (!$match)
		{
            return false;
        }

        if (mb_strlen($match[1]) > $length)
		{
            return false;
        }
		
        return $match[1];
    }
	
    //验证是否是合法的身份证号，简单验证
    public static function isValidIdCardNo($idcard)
    {
        $length = strlen($idcard);

        //15位老身份证
        if ($length == 15)
		{
            if (checkdate(substr($idcard, 8, 2), substr($idcard, 10, 2), '19' . substr($idcard, 6, 2)))
			{
                return true;
            }
        }
		
        //18位二代身份证号
        if ($length == 18)
		{
            if (!checkdate(substr($idcard, 10, 2), substr($idcard, 12, 2), substr($idcard, 6, 4)))
			{
                return false;
            }
			
            $idcard = str_split($idcard);
            if (strtolower($idcard[17]) == 'x')
			{
                $idcard[17] = '10';
            }
			
            //加权求和
            $sum = 0;
            //加权因子
            $wi = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1];
            for ($i = 0; $i < 17; $i++)
			{
                $sum += $wi[$i] * $idcard[$i];
            }

            //得到验证码所位置
            $position = $sum % 11;

            //身份证验证位值 10代表X
            $code = [1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2];
            if ($idcard[17] == $code[$position])
			{
                return true;
            }
        }

        return false;
    }
	
    //验证是否是合法的银行卡，不包含信用卡
    public static function isValidBankCard($card)
    {
        if (!is_numeric($card))
		{
            return false;
        }

        if (strlen($card) < 16 || strlen($card) > 19)
		{
            return false;
        }

        $cardHeader = [10, 18, 30, 35, 37, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 58, 60, 62, 65, 68, 69, 84, 87, 88, 94, 95, 98, 99];
        if (!in_array(substr($card, 0, 2), $cardHeader))
		{
            return false;
        }

        $numShouldCheck = str_split(substr($card, 0, -1));
        krsort($numShouldCheck);

        $odd = $odd['gt9'] = $odd['gt9']['tens'] = $odd['gt9']['unit'] = $odd['lt9'] = $even = [];
        array_walk($numShouldCheck, function ($item, $key) use (&$odd, &$even, $card){

            if ((strlen($card) == 16) && (substr($card, 0, 2) == '62'))
			{
                $key += 1;
            }

            if (($key & 1))
			{
                $t = $item * 2;
                if ($t > 9)
				{
                    $odd['gt9']['unit'][] = intval($t % 10);
                    $odd['gt9']['tens'][] = intval($t / 10);
                }
				else
				{
                    $odd['lt9'][] = $t;
                }
            }
			else
			{
                $even[] = $item;
            }
        });
		
        $total = array_sum($even);
        array_walk_recursive($odd, function ($item, $key) use (&$total) {
            $total += $item;
        });

        $luhm = 10 - ($total % 10 == 0 ? 10 : $total % 10);

        $lastNumOfCard = substr($card, -1, 1);
        if ($luhm != $lastNumOfCard)
		{
            return false;
        }
		
        return true;
    }
	
	//随机字母
    public static function randLetter($len)
    {
        $letter = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $result = '';
		
        for ($i = 0; $i < $len; $i++)
		{
            $result .= $letter[array_rand($letter, 1)];
        }
		
        return $result;
    }
    
    /**
     * 取得随机字符串
     * 
     * @param int $length 生成随机数的长度
     * @param int $numeric 是否只产生数字随机数 1是0否
     * @return string
     */
    public static function getRandomString($length, $numeric = 0)
    {
        $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
        $hash = '';
        $max = strlen($seed) - 1;
        
        for($i = 0; $i < $length; $i++)
        {
            $hash .= $seed{mt_rand(0, $max)};
        }
        
        return $hash;
    }
    
    //生成二维码
    public static function qrcode($url,$size=150)
    {
        return 'data:image/png;base64,'.base64_encode(\QrCode::format('png')->encoding('UTF-8')->size($size)->margin(0)->errorCorrection('H')->generate($url));
    }
	
    //获取浏览器信息
    public static function getBrowser()
    {
        $browser = array('name'=>'unknown', 'version'=>'unknown');

        if(empty($_SERVER['HTTP_USER_AGENT'])) return $browser;

        $agent = $_SERVER["HTTP_USER_AGENT"];

        // Chrome should checked before safari
        if(strpos($agent, 'Firefox') !== false) $browser['name'] = "firefox";
        if(strpos($agent, 'Opera') !== false)   $browser['name'] = 'opera';
        if(strpos($agent, 'Safari') !== false)  $browser['name'] = 'safari';
        if(strpos($agent, 'Chrome') !== false)  $browser['name'] = "chrome";

        // Check the name of browser
        if(strpos($agent, 'MSIE') !== false || strpos($agent, 'rv:11.0')) $browser['name'] = 'ie';
        if(strpos($agent, 'Edge') !== false) $browser['name'] = 'edge';

        // Check the version of browser
        if(preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))       $browser['version'] = $regs[1];
        if(preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))    $browser['version'] = $regs[1];
        if(preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs)) $browser['version'] = $regs[1];
        if(preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))     $browser['version'] = $regs[1];

        if((strpos($agent, 'Chrome') == false) && preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs)) $browser['version'] = $regs[1];
        if(preg_match('/rv:(\d+)\..*/i', $agent, $regs)) $browser['version'] = $regs[1];
        if(preg_match('/Edge\/(\d+)\..*/i', $agent, $regs)) $browser['version'] = $regs[1];

        return $browser;
    }
    
    /**
     * 检查是否是AJAX请求。
     * Check is ajax request.
     * 
     * @static
     * @access public
     * @return bool
     */
    public static function isAjaxRequest()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') return true;
        if(isset($_GET['HTTP_X_REQUESTED_WITH'])    && $_GET['HTTP_X_REQUESTED_WITH']    == 'XMLHttpRequest') return true;
        
        return false;
    }
    
    /**
     * 检查是否是POST请求
     */
    public static function isPostRequest()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') return true;
        if($_POST) return true;
        
        return false;
    }
    
    /**
     * 是否是GET提交的
     */
    public static function isGetRequest()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
    }
    
    /**
     * 301跳转。
     * Header 301 Moved Permanently.
     * 
     * @param  string    $locate 
     * @access public
     * @return void
     */
    public static function header301($locate)
    {
        header('HTTP/1.1 301 Moved Permanently');
        die(header('Location:' . $locate));
    }
    
    /** 
     * 获取远程IP。
     * Get remote ip. 
     * 
     * @access public
     * @return string
     */
    public static function getRemoteIp()
    {
        $ip = '';
        if(!empty($_SERVER["REMOTE_ADDR"]))          $ip = $_SERVER["REMOTE_ADDR"];
        if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        if(!empty($_SERVER['HTTP_CLIENT_IP']))       $ip = $_SERVER['HTTP_CLIENT_IP'];

        return $ip;
    }
    
    /**
     * 建立文件夹
     *
     * @param string $aimUrl
     * @return viod
     */
    public static function createDir($aimUrl)
    {
        $aimUrl = str_replace('', '/', $aimUrl);
        $aimDir = '';
        $arr = explode('/', $aimUrl);
        $result = true;
        
        foreach ($arr as $str)
        {
            $aimDir .= $str . '/';
            
            if (!file_exists($aimDir))
            {
                $result = mkdir($aimDir);
            }
        }
        
        return $result;
    }
    
    //判断访问终端是否是微信浏览器
    public static function isWechatBrowser()
    { 
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
        { 
            return true; 
        }
        
        return false; 
    }
    
    //判断是不是https
    public static function isHttpsRequest()
    {
        if((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) return true;
        
        if($_SERVER['SERVER_PORT'] == 443) return true;
        
        return false;
   }
   
    /**
     * @name php获取中文字符拼音首字母
     * @param $str
     * @return null|string
     */
    public function getFirstCharter($str)
    {
        if (empty($str))
        {
            return '';
        }
        
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        
        return '';
    }
    
    /**
	* 图片转base64
	* @param image_file String 图片路径
	* @return 转为base64的图片
	*/
    public static function Base64EncodeImage($image_file)
    {
        if(file_exists($image_file) || is_file($image_file))
        {
            $base64_image = '';
            $image_info = getimagesize($image_file);
            $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
            $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
            return $base64_image;
        }
        
        return false;
    }
    
    //提取数字
    public static function findNum($str='')
    {
        $str=trim($str);
        if(empty($str)){return '';}
        $reg='/(\d{3}(\.\d+)?)/is';//匹配数字的正则表达式
        preg_match_all($reg,$str,$result);
        if(is_array($result)&&!empty($result)&&!empty($result[1])&&!empty($result[1][0])){
            return $result[1][0];
        }
        
        return ''; 
    }
    
    /**
	 * 过滤emoji
	 */
	public static function filterEmoji($str)
	{
        // preg_replace_callback执行一个正则表达式搜索并且使用一个回调进行替换
		$str = preg_replace_callback('/./u', function (array $match) {
                    return strlen($match[0]) >= 4 ? '' : $match[0];
                }, $str);
        
		return $str;
	}
}