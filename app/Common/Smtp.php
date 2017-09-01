<?php
/******************************************************************************\
 * SMTP邮件类
 * 
 * 注：本邮件类经测试是成功了的，如果大家发送邮件的时候遇到了失败的问题，请从以下几点排查：
 * 1. 用户名和密码是否正确；
 * 2. 检查邮箱设置是否启用了smtp服务；
 * 3. 是否是php环境的问题导致；
 * 4. 将22行的$smtp->debug = false改为true，可以显示错误信息，然后可以复制报错信息到网上搜一下错误的原因；
 * 
 * -----------------------------------------------------------------------------
 * 
 * ******************************* 配置信息 ************************************
 * $smtpserver = 'smtp.163.com';//SMTP服务器
 * $smtpserverport = 25;//SMTP服务器端口
 * $smtpusermail = '1feng.2008@163.com';//SMTP服务器的用户邮箱
 * $smtpemailto = '277023115@qq.com';//发送给谁
 * $smtpuser = "1feng.2008@163.com";//SMTP服务器的用户帐号
 * $smtppass = "";//SMTP服务器的用户密码
 * $mailtitle = '邮件标题';//邮件主题
 * $mailcontent = '';//邮件内容
 * $mailtype = 'HTML';//邮件格式（HTML/TXT）,TXT为文本邮件
 * $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
 * $smtp->debug = false;//是否显示发送的调试信息
 * $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
 * if($state==""){echo '对不起，邮件发送失败！请检查邮箱填写是否有误。';exit();}else{echo '邮件发送成功';}
\******************************************************************************/
namespace App\Common;

class Smtp
{
    /* Public Variables */
    var $smtp_port;//SMTP服务器端口
    var $time_out;//
    var $host_name;//
    var $log_file;
    var $relay_host;//SMTP服务器
    var $debug;//是否显示发送的调试信息
    var $auth;//true是表示使用身份验证,否则不使用身份验证
    var $user;//SMTP服务器的用户帐号
    var $pass;//SMTP服务器的用户密码

    /* Private Variables */ 
    var $sock;

    /* Constractor */

    function __construct($relay_host = '', $smtp_port = 25,$auth = false,$user,$pass)
    {
        $this->debug = FALSE;
        $this->smtp_port = $smtp_port;
        $this->relay_host = $relay_host;
        $this->time_out = 30; //is used in fsockopen() 
        $this->auth = $auth;//auth
        $this->user = $user;
        $this->pass = $pass;
        $this->host_name = 'localhost'; //is used in HELO command 
        $this->log_file = '';
        $this->sock = FALSE;
    }

    /*获取要抓取的列表的URL地址
     *
     * @param $to 发送给谁
     * @param $from SMTP服务器的用户邮箱
     * @param $subject 邮件主题
     * @param $body 邮件内容
     * @param $mailtype 邮件格式(HTML/TXT),TXT为文本邮件
     *
     * @return array 返回列表URL
     */
    function sendmail($to, $from, $subject = '', $body = '', $mailtype, $cc = '', $bcc = '', $additional_headers = '')
    {
        $mail_from = $this->get_address($this->strip_comment($from));
        $body = preg_replace("/(^|(\r\n))(\.)/", "\1.\3", $body);
        $header = "MIME-Version:1.0\r\n";

        if($mailtype=="HTML")
        {
            $header .= "Content-Type:text/html\r\n";
        }

        $header .= "To: ".$to."\r\n";

        if ($cc != "")
        {
            $header .= "Cc: ".$cc."\r\n";
        }

        $header .= "From: $from<".$from.">\r\n";
        $header .= "Subject: ".$subject."\r\n";
        $header .= $additional_headers;
        $header .= "Date: ".date("r")."\r\n";
        $header .= "X-Mailer:By Redhat (PHP/".phpversion().")\r\n";

        list($msec, $sec) = explode(" ", microtime());

        $header .= "Message-ID: <".date("YmdHis", $sec).".".($msec*1000000).".".$mail_from.">\r\n";

        $TO = explode(",", $this->strip_comment($to));

        if ($cc != "")
        {
            $TO = array_merge($TO, explode(",", $this->strip_comment($cc)));
        }

        if ($bcc != "")
        {
            $TO = array_merge($TO, explode(",", $this->strip_comment($bcc)));
        }

        $sent = TRUE;

        foreach ($TO as $rcpt_to)
        {
            $rcpt_to = $this->get_address($rcpt_to);

            if (!$this->smtp_sockopen($rcpt_to))
            {
                $this->log_write("Error: Cannot send email to ".$rcpt_to."\n");
                $sent = FALSE;
                continue;
            }

        if ($this->smtp_send($this->host_name, $mail_from, $rcpt_to, $header, $body))
        {
            $this->log_write("E-mail has been sent to <".$rcpt_to.">\n");
        }
        else
        {
            $this->log_write("Error: Cannot send email to <".$rcpt_to.">\n");
            $sent = FALSE;
        }

        fclose($this->sock);
        $this->log_write("Disconnected from remote host\n");
        }

        return $sent;
    }

    /* Private Functions */

    function smtp_send($helo, $from, $to, $header, $body = "")
    {
        if (!$this->smtp_putcmd("HELO", $helo))
        {
            return $this->smtp_error("sending HELO command");
        }

        //auth

        if($this->auth)
        {
            if (!$this->smtp_putcmd("AUTH LOGIN", base64_encode($this->user)))
            {
                return $this->smtp_error("sending HELO command");
            }

            if (!$this->smtp_putcmd("", base64_encode($this->pass)))
            {
                return $this->smtp_error("sending HELO command");
            }
        }

        if (!$this->smtp_putcmd("MAIL", "FROM:<".$from.">"))
        {
            return $this->smtp_error("sending MAIL FROM command");
        }

        if (!$this->smtp_putcmd("RCPT", "TO:<".$to.">"))
        {
            return $this->smtp_error("sending RCPT TO command");
        }

        if (!$this->smtp_putcmd("DATA"))
        {
            return $this->smtp_error("sending DATA command");
        }

        if (!$this->smtp_message($header, $body))
        {
            return $this->smtp_error("sending message");
        }

        if (!$this->smtp_eom())
        {
            return $this->smtp_error("sending <CR><LF>.<CR><LF> [EOM]");
        }

        if (!$this->smtp_putcmd("QUIT"))
        {
            return $this->smtp_error("sending QUIT command");
        }

        return TRUE;
    }

    function smtp_sockopen($address)
    {
        if ($this->relay_host == "")
        {
            return $this->smtp_sockopen_mx($address);
        }
        else
        {
            return $this->smtp_sockopen_relay();
        }
    }

    function smtp_sockopen_relay()
    {
        $this->log_write("Trying to ".$this->relay_host.":".$this->smtp_port."\n");
        $this->sock = @fsockopen($this->relay_host, $this->smtp_port, $errno, $errstr, $this->time_out);

        if (!($this->sock && $this->smtp_ok()))
        {
            $this->log_write("Error: Cannot connenct to relay host ".$this->relay_host."\n");
            $this->log_write("Error: ".$errstr." (".$errno.")\n");

            return FALSE;
        }
        
        $this->log_write("Connected to relay host ".$this->relay_host."\n");
        return TRUE;;
    }

    function smtp_sockopen_mx($address)
    {
        $domain = preg_replace("/^.+@([^@]+)$/", "\1", $address);

        if (!@getmxrr($domain, $MXHOSTS))
        {
            $this->log_write("Error: Cannot resolve MX \"".$domain."\"\n");
            return FALSE;
        }

        foreach ($MXHOSTS as $host)
        {
            $this->log_write("Trying to ".$host.":".$this->smtp_port."\n");
            $this->sock = @fsockopen($host, $this->smtp_port, $errno, $errstr, $this->time_out);

            if (!($this->sock && $this->smtp_ok()))
            {
                $this->log_write("Warning: Cannot connect to mx host ".$host."\n");
                $this->log_write("Error: ".$errstr." (".$errno.")\n");
                continue;
            }

            $this->log_write("Connected to mx host ".$host."\n");
            return TRUE;
        }

        $this->log_write("Error: Cannot connect to any mx hosts (".implode(", ", $MXHOSTS).")\n");
        return FALSE;
    }

    function smtp_message($header, $body)
    {
        fputs($this->sock, $header."\r\n".$body);
        $this->smtp_debug("> ".str_replace("\r\n", "\n"."> ", $header."\n> ".$body."\n> "));
        return TRUE;
    }

    function smtp_eom()
    {
        fputs($this->sock, "\r\n.\r\n");
        $this->smtp_debug(". [EOM]\n");
        return $this->smtp_ok();
    }

    function smtp_ok()
    {
        $response = str_replace("\r\n", "", fgets($this->sock, 512));
        $this->smtp_debug($response."\n");

        if (!preg_match("/^[23]/", $response))
        {
            fputs($this->sock, "QUIT\r\n");
            fgets($this->sock, 512);
            $this->log_write("Error: Remote host returned \"".$response."\"\n");
            return FALSE;
        }

        return TRUE;
    }

    function smtp_putcmd($cmd, $arg = "")
    {
        if ($arg != "")
        {
            if($cmd=="") $cmd = $arg;
            else $cmd = $cmd." ".$arg;
        }

        fputs($this->sock, $cmd."\r\n");
        $this->smtp_debug("> ".$cmd."\n");
        return $this->smtp_ok();
    }

    function smtp_error($string)
    {
        $this->log_write("Error: Error occurred while ".$string.".\n");
        return FALSE;
    }

    function log_write($message)
    {
        $this->smtp_debug($message);

        if ($this->log_file == "")
        {
            return TRUE;
        }

        $message = date("M d H:i:s ").get_current_user()."[".getmypid()."]: ".$message;

        if (!@file_exists($this->log_file) || !($fp = @fopen($this->log_file, "a")))
        {
            $this->smtp_debug("Warning: Cannot open log file \"".$this->log_file."\"\n");
            return FALSE;;
        }

        flock($fp, LOCK_EX);
        fputs($fp, $message);
        fclose($fp);

        return TRUE;
    }

    function strip_comment($address)
    {
        $comment = "/\([^()]*\)/";

        while (preg_match($comment, $address))
        {
            $address = preg_replace($comment, "", $address);
        }

        return $address;
    }

    function get_address($address)
    {
        $address = preg_replace("/([ \t\r\n])+/", "", $address);
        $address = preg_replace("/^.*<(.+)>.*$/", "\1", $address);

        return $address;
    }

    function smtp_debug($message)
    {
        if ($this->debug)
        {
            echo $message;
        }
    }
}

//~ $smtpserver = 'smtp.exmail.qq.com';//SMTP服务器
//~ $smtpserverport = 25;//SMTP服务器端口
//~ $smtpusermail = 'smtp@micw.com';//SMTP服务器的用户邮箱
//~ $smtpemailto = '277023115@qq.com';//发送给谁
//~ $smtpuser = "smtp@micw.com";//SMTP服务器的用户帐号
//~ $smtppass = "XbdNew168!";//SMTP服务器的用户密码
//~ $mailtitle = '三国演义ssl222';//邮件主题
//~ $mailcontent = '《三国演义》是中国古典四大名著之一，是中国第一部长篇章回体历史演义小说，全名为《三国志通俗演义》，作者是元末明初的小说家罗贯中。';//邮件内容
//~ $mailtype = 'HTML';//邮件格式(HTML/TXT),TXT为文本邮件
//~ $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
//~ $smtp->debug = false;//是否显示发送的调试信息
//~ $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
//~ if($state==""){echo '对不起，邮件发送失败！请检查邮箱填写是否有误。';exit();}else{echo '邮件发送成功';}
?>