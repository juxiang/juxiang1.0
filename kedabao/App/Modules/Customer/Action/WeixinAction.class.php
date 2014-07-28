<?php

class WeixinAction extends Action 
{
	public $uid;
	public function index() 
	{
		import('@.Common.Wechat');
		$where=array(
				'uid'=>I('uid'),
		);
		$this->uid=I('uid');
		$wxconf=M('wxconf');
		$wxinfo=$wxconf->where($where)->select();
		$_SESSION["wxtoken"]=trim($wxinfo[0]["wxtoken"]);
		$_SESSION["wx_aid"]=trim($wxinfo[0]["wx_aid"]);
		$_SESSION["wx_secret"]=trim($wxinfo[0]["wx_secret"]);
		//dump($_SESSION["wxtoken"]);die;
		if (!isset($_GET['echostr'])) {
			return $this->responseMsg();
		}else{
			$weixin = new Wechat();
			$data = $this->valid();
			echo $data;
		}
	}
	public function valid(){
        $echoStr = $_GET['echostr'];
        if($this->checkSignature($_SESSION["wxtoken"])){
        	return $echoStr;
			exit;
        }else{
			echo $token;
		}
    	}
	private function checkSignature($to){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = $to;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
	}
	//信息回复
    private function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
			
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $result;
			//p($this->uid);
        }else {
            echo "";
            exit;
        }
    }
	
	private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                $content = "欢迎关注我们。";
                $content .= (!empty($object->EventKey))?("\n来自二维码场景 ".str_replace("qrscene_","",$object->EventKey)):"";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "SCAN":
                $content = "扫描场景 ".$object->EventKey;
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    default:
                        $content = "点击菜单:".$object->EventKey;
                        break;
                }
                break;
            case "LOCATION":
                $content = "上传位置:纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                break;
            default:
                $content = "receive a new event: ".$object->Event;
                break;
        }
        $result = $this->transmitText($object, $content);
        return $result;
    }
    public function receiveText($object)
    {
        $keyword = trim($object->Content);
        switch ($keyword)
        {
            default:
                $content = '谢谢您的留言，我们会尽快回复您！';
                break;
        }
        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
			//保存用户信息数据
			$d=D('WxuserMessage');
			$fromuser=trim($object->FromUserName);
			$touser=trim($object->ToUserName);
			$d->addMessage($fromuser,$touser,$keyword,$this->uid);
            $result = $this->transmitText($object, $content);
        }
		//将用户发送的信息保存数据库
		
        return $result;
    }
	private function receiveImage($object)
    {
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    private function receiveLocation($object)
    {
        $content = "你发送的是位置，纬度为:".$object->Location_X."；经度为:".$object->Location_Y."；缩放级别为:".$object->Scale."；位置为:".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    private function receiveVoice($object)
    {
        if (empty($object->Recognition)){
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }else{
            $content = "你刚才说的是:".$object->Recognition;
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }

    private function receiveVideo($object)
    {
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为:".$object->Title."；内容为:".$object->Description."；链接地址为:".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }
	
	private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
    <MediaId><![CDATA[%s]]></MediaId>
</Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
    <MediaId><![CDATA[%s]]></MediaId>
</Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
    <MediaId><![CDATA[%s]]></MediaId>
    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
</Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

	/**
     *  获取access token
     */
    private function getAccessToken(){
		$url=
		"https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->secret";
        $atjson=file_get_contents($url);
        $result=json_decode($atjson,true);//json解析成数组

		return $result["access_token"];
    }
	//获取第一次关注公众账号用户的信息:openid,nickname,sex,language,city,province,country,headingurl,subscribe_time
	public function getUserinfo($fromuserid){
		$access_token=$this->getAccessToken();
		$openid=$fromuserid;
		$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
		$output=$this->https_request($url);
		$jsoninfo=json_decode($output,true);
		return $jsoninfo;
	}
	//客户绑定调用url
	private function https_request($url){
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$data=curl_exec($curl);
		if(curl_errno($curl)){
			return 'ERROR'.curl_error($curl);
		}
		curl_close($curl);
		return $data;
	}

	
}

?>