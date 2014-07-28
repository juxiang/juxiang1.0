<?php
class Wechat extends Action{

	//签名
    private $token;

    //消息类型
    private $msgtype;

    //消息内容
    private $msgobj;

    //事件类型
    private $eventtype;

    //事件key值
    private $eventkey;

	#{服务号才可得到
    //AppId
    private $appid;
    //AppSecret
    private $secret;
	#}
	
	private $_isvalid = false;
	
	public function __construct(){
		$this->token=$_SESSION["wxtoken"];
		$this->appid=$_SESSION["wx_aid"];
		$this->secret=$_SESSION["wx_secret"];
	}
	
	/**
	 *	执行程序入口
	 */
	public function index($menu='',$buttons){
		if($menu=='menu'){
			return $this->createMenu($buttons);
		}
		if (!isset($_GET['echostr'])) {
			return $this->responseMsg();
		}else{
			return $this->valid();
		}
	}

	/**
     *  初次校验
     */
	public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature($this->token)){
        	echo $echoStr;
			exit;
        }else{
			echo $token;
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
        }else {
            echo "";
            exit;
        }
    }
//获取第一次关注公众账号用户的信息:openid,nickname,sex,language,city,province,country,headingurl,subscribe_time
	public function getUserinfo(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $object = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		}	
		$access_token=$this->getAccessToken();
		$openid=$object->FromUserName;
		$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
		$output=$this->https_request($url);
		$jsoninfo=json_decode($output,true);
		return $jsoninfo;
	}
     private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                $content = "欢迎".$output['nickname']."关注我们。";
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
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        switch ($keyword)
        {
            case "文本":
                $content = "这是个文本消息";
                break;
            case "图文":
				break;
            case "单图文":
                break;
            case "多图文":
                break;
            case "音乐":
                break;
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
            $result = $this->transmitText($object, $content);
        }
		//将用户发送的信息保存数据库
		
        return $result;
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
     *  校验签名
     */
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

    /**
     *  获取access token
     */
    private function getAccessToken(){
		$url=
		"https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->secret;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $atjson = curl_exec($ch);
        $result=json_decode($atjson,true);//json解析成数组
		return $result["access_token"];
    }
	/**
     *  创建自定义菜单
     */
    public function createMenu($wx_buttons){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->getAccessToken();
			//根据设置生成微信菜单，菜单信息数组$buttons
			foreach($wx_buttons as $k=>$button){
			if($button['grade']==1){
				$arr[$k][]="{'name':'".$button['name1']."',";
				if($button['type']=='click'){
					$arr[$k][]="'type':'click',
							'key':'".$button['key']."'},";
				}else{
					$arr[$k][]="'type':'view',
							'url':'".$button['url']."'},";
				}
			}else{
				$ar=array();
				$arr[$k][]="{'name':'".$button['name1']."',
						'sub_button':[";
				foreach($button['button2'] as $j=>$v){
					$ar[$j][]="{'name':'".$v['name2']."'";
					if($v['type']=='click'){
						$ar[$j][]="'type':'click',
								'key':'".$v['key']."'}";
					}else{
						$ar[$j][]="'type':'view',
								'url':'".$v['url']."'}";
					}
						$ar[$j]=implode(",",$ar[$j]);
				}
				$arr[$k][]=implode(",",$ar);
				$arr[$k][]="]},";
			}
			$arr[$k]=implode($arr[$k]);
			}
			$arr=implode($arr);
			$arr=str_replace("'",'"',$arr);
		$menujson="{\"button\":[".$arr."]}";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$menujson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $info = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);
        }

        curl_close($ch);

       echo $info;
	   
    }

    /**
     *  删除自定义菜单
     */
    private function deleteMenu(){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->getAccessToken();

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

        $info = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);
        }

        curl_close($ch);


    }

}

?>