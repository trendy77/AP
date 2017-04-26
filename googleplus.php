<?php
function curloptposandget($ch)
{
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "");
	curl_setopt($ch, CURLOPT_HTTPGET, true);	
}
//This function check domain
function checkdomaingp($servicegpurl,$wpapadvsettings)
{
		$servicegpurl = "https://accounts.google.com/ServiceLogin?service=oz&continue=https://plus.google.com/?gpsrc%3Dogpy0%26tab%3DwX%26gpcaz%3Dc7578f19&hl=en-US";	
	
	$hdcheck = getcurlpagex($servicegpurl, "", true, "", $wpapadvsettings);
	return $hdcheck;
}
	
//this function used for random generate string	
function GeraHash($qtd){
//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
$Caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVXWYZ';
$QuantidadeCaracteres = strlen($Caracteres);
$QuantidadeCaracteres--;
$Hash=NULL;
    for($x=1;$x<=$qtd;$x++){
        $Posicao = rand(0,$QuantidadeCaracteres);
        $Hash .= substr($Caracteres,$Posicao,1);
    }
return $Hash;
} 
//This function check header	
function headersofssl()
{
	$headers = array();
	$headers[] = "Accept: text/html, application/xhtml+xml, */*";
	$headers[] = "Cache-Control: no-cache";
	$headers[] = "Connection: Keep-Alive";
	$headers[] = "Accept-Language: en-us";	
	return $headers;
}
//This function check curl ssl verifyhost
function curlsllver($ch)
{
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
}
//This funtion check cookies in header 
function curloptcokhead($ch,$cookies,$headers)
{
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIE, $cookies);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
}
function curlhostcheck($prhost,$prport,$prup){
	    
		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		curl_setopt($ch, CURLOPT_PROXY, $prhost);
		curl_setopt($ch, CURLOPT_PROXYPORT, $prport);
		if (isset($prup) && $prup != "")
		{
			curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $prup);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
}
		
//This funtion check ssl url with return transfer header
function wpapCheckSSLCurl($url) 
{
	$ch = curl_init($url);
	$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; compatible; MSIE 9.0; WOW64; Trident/5.0; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
	$headers = headersofssl();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	$content = curl_exec($ch);
	if (curl_errno($ch))
	{
		$errNo = curl_errno($ch);
		$errMsg = curl_error($ch);
		return array("errNo" => $errNo, "errMsg" => $errMsg);
	}
	return false;
}
//this funtion check for cookies to string
function cookArrToStr($cookiesarray) 
{
	foreach ($cookiesarray as $key => $val)
	{
		$ctos .= $key . "=" . $val . "; ";
	}
	return $ctos;
}
function linkwithmsgnew($msg,$new,$wpappostlinktitle,$wpappostlinktext,$wpappostlinkdomain,$wpappostlinkimg,$wpappostlinklink,$wpappostlinkimgType,$wpapownerid,$proOrCommTxt,$wpapbigcd,$gpatvalue)
{
	$rnds = GeraHash(13);
	return $wpapsprvl = "f.req=%5B%22" . $msg . "%22%2C%22oz%3A" . $new . "." . $rnds . ".1%22%2Cnull%2Cnull%2Cnull%2Cnull%2C%22%5B%5C%22%5Bnull%2Cnull%2Cnull%2C%5C%5C%5C%22" . str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $wpappostlinktitle) . "%5C%5C%5C%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22" . $wpappostlinklink . $wpapownerid . "%5C%5C%5C%22%2C%5C%5C%5C%22owner%5C%5C%5C%22%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5C%5C%5C%22" . str_replace("%5C", "%5C%5C%5C%5C%5C%5C%5C", $wpappostlinktext) . "%5C%5C%5C%22%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $wpappostlinklink . "%5C%5C%5C%22%2Cnull%2C%5C%5C%5C%22text%2Fhtml%5C%5C%5C%22%2C%5C%5C%5C%22document%5C%5C%5C%22%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $wpappostlinkdomain . "%5C%5C%5C%22%2Cnull%2Cnull%5D%2C%5Bnull%2C%5C%5C%5C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $wpappostlinkdomain . "%5C%5C%5C%22%2Cnull%2Cnull%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fprovider%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%2C%5Bnull%2C%5C%5C%5C%22" . $wpappostlinklink . "%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fcanonical_id%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%5D%5D%5C%22%2C%5C%22%5Bnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $wpappostlinkimg . "%5C%5C%5C%22%5D%2Cnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5Bnull%2C%5C%5C%5C%22" . $wpappostlinklink . "%5C%5C%5C%22%2Cnull%2C%5C%5C%5C%22" . $wpappostlinkimgType . "%5C%5C%5C%22%2C%5C%5C%5C%22photo%5C%5C%5C%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C250%2C178%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22" . $wpappostlinkimg . "%5C%5C%5C%22%2Cnull%2Cnull%5D%2C%5Bnull%2C%5C%5C%5C%22" . $wpappostlinkimg . "%5C%5C%5C%22%2Cnull%2Cnull%5D%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5Bnull%2C%5C%5C%5C%22images%5C%5C%5C%22%2C%5C%5C%5C%22http%3A%2F%2Fgoogle.com%2Fprofiles%2Fmedia%2Fprovider%5C%5C%5C%22%2C%5C%5C%5C%22%5C%5C%5C%22%5D%5D%5D%5C%22%5D%22%2Cnull%2Cnull%2Ctrue%2C%5B%5D%2Cfalse%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cfalse%2Cfalse%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5B35%2C1%2C0%5D%2C%22" . $wpappostlinklink . "%22%2Cnull%2Cnull%2Cnull%2C%7B%2229646191%22%3A%5B%22" . $wpappostlinklink . "%22%2C%22" . $wpappostlinkimg . "%22%2C%22" . $wpappostlinktitle . "%22%2C%22" . $txttxt . "%22%2Cnull%2C%5B%22%2F%2Fimages1-focus-opensocial.googleusercontent.com%2Fgadgets%2Fproxy%3Furl%3D" . $wpappostlinkimg . "%26container%3Dfocus%26gadget%3Da%26rewriteMime%3Dimage%2F*%26refresh%3D31536000%26resize_h%3D150%26resize_w%3D150%26no_expand%3D1%22%2C150%2C150%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B3%2C%22https%3A%2F%2Fimages2-focus-opensocial.googleusercontent.com%2Fgadgets%2Fproxy%3Furl%3D" . $wpappostlinkimg . "%26container%3Dfocus%26gadget%3Dhttps%3A%2F%2Fplus.google.com%26rewriteMime%3Dimage%2F*%26resize_h%3D800%26resize_w%3D800%26no_expand%3D1%22%5D%5D%2C%22%2F%2Fs2.googleusercontent.com%2Fs2%2Ffavicons%3Fdomain%3Dwww." . $wpappostlinkdomain . "%22%2C%5B%5B%5B5%2C0%5D%2Cnull%2Cnull%2Cnull%2Cnull%2C%7B%2227219582%22%3A%5Bnull%2Cnull%2Cnull%2C%22" . $wpappostlinklink . $wpapownerid . "%22%5D%7D%5D%5D%2Cnull%2C%5B%5D%2C%22" . $wpappostlinkdomain . "%22%2Cnull%2C%5B%5D%2C%5B%5D%2C%5B%5D%2C%5B%5D%5D%7D%5D%2Cnull%2C%5B" . $proOrCommTxt . "%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%22!" . $wpapbigcd . "%22%5D&at=" . $gpatvalue . "&";
}
function curlpagemanage($ch, $reference = "", $wpapcontentonly = false, $wpapfieldsgp = "", $wpapadvsettings = "") 
{
	global $wpap_gpsession;
	global $wpap_arraysession;
	global $wpap_gpckarray;
	global $wpap_cookiesarrayBD;
	
	$headers = array();
	$headers[] = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
	$headers[] = "Cache-Control: no-cache";
	$headers[] = "Connection: Keep-Alive";
	$headers[] = "Accept-Language: en-US,en;q=0.8";
	$headers[] = "X-Requested-With: XMLHttpRequest";
	$headers[] = "Origin: " . $wpapadvsettings["Origin"];
	
	$cookies = cookarrtostr($wpap_gpckarray);
	
	//Check Ssl
	if ($wpapfieldsgp != "")
	{
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $wpapfieldsgp);
	}
	else 
	{
		curloptposandget($ch);
	}
	curloptcokhead($ch,$cookies,$headers);
	if($reference != "")
	{
		curl_setopt($ch, CURLOPT_REFERER, $reference);
	}
	//curl_setopt($ch,CURLOPT_USERAGENT,$agents[array_rand($agents)]);
	curl_setopt($ch, CURLOPT_USERAGENT, (isset($wpapadvsettings["UA"])) && ($wpapadvsettings["UA"] != "") ? $wpapadvsettings["UA"] : "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.44 Safari/537.36");
	
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	$content = curl_exec($ch);
	$valwpsss = stripos($content, "http-equiv=\"refresh\" content=\"0; url=&#39;");
	$wpapnewrnew = "\r\n\r\n" ;
	list($header, $content) = explode($wpapnewrnew, $content, 2);
	$nsheader = curl_getinfo($ch);
	$err = curl_errno($ch);
	$errmsg = curl_error($ch);
	$nsheader["errno"] = $err;
	$nsheader["errmsg"] = $errmsg;
	$nsheader["headers"] = $header;
	$nsheader["content"] = $content;
	
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$headers = curl_getinfo($ch);
	
	//Cookies set
	$results = array();
	preg_match_all("|Host: (.*)\\n|U", $headers["request_header"], $results);
	$ckDomain = str_replace(".", "_", $results[1][0]);
	$ckDomain = str_replace("\r", "", $ckDomain);
	$ckDomain = str_replace("\n", "", $ckDomain);
	
	$results = array();
	$cookies = "";
	preg_match_all("|Set-Cookie: (.*);|U", $header, $results);
	$wpapcktmpvl = $results[1];
	preg_match_all("/Set-Cookie: (.*)\\b/", $header, $xck);
	$xck = $xck[1];
	
	foreach ($wpapcktmpvl as $wpapdomainval)
	{
		$wpapcktotal = explode("=", $wpapdomainval, 2);
		$wpap_cookiesarrayBD[$ckDomain][$wpapcktotal[0]] = $wpapcktotal[1];
		continue;
	}
	
	if (isset($wpapadvsettings["cdomain"]) && $wpapadvsettings["cdomain"] != "")
	{
		foreach ($wpapcktmpvl as $wpapdomainkey => $wpapdomainval)
		{
			$cookick = stripos($xck[$wpapdomainkey], "Domain=." . $wpapadvsettings["cdomain"] . ";");
			$xckvl = stripos($xck[$wpapdomainkey], "Domain=");
			if (!($xckvl === false || $cookick !== false))
			{
				continue;
			}
			$wpapcktotal = explode("=", $wpapdomainval, 2);
			$wpap_gpckarray[$wpapcktotal[0]] = $wpapcktotal[1];
			continue;
		}
	}
	else 
	{
		
		foreach ($wpapcktmpvl as $wpapdomainval)
		{
			$wpapcktotal = explode("=", $wpapdomainval, 2);
			$wpap_gpckarray[$wpapcktotal[0]] = $wpapcktotal[1];
			continue;
		}
	}
	
	$rURL = "";
	$wpapcurlloops = 0;
	if ($valwpsss !== false && $http_code == 200 || $http_code == 301 || $http_code == 302 || $http_code == 303)
	{
		if($valwpsss !== false && $http_code == 200)
		{
		$http_code = 301;
		$wpapfstart = stripos($content, "http-equiv=\"refresh\" content=\"0; url=&#39;");
		$wpapftmp = substr($content, $wpapfstart + strlen("http-equiv=\"refresh\" content=\"0; url=&#39;"));
		$wpapflen = stripos($wpapftmp, "&#39;\"");
		$rURL = substr($wpapftmp, 0, $wpapflen);
		if (stripos($rURL, "blogger.com") === false)
		{
			$wpap_gpckarray = array();
		}
		}
		else
		{
			if ($rURL != "")
		{
			$rURL = str_replace("\\x3d", "=", $rURL);
			$rURL = str_replace("\\x26", "&", $rURL);
			$url = @parse_url($rURL);
		}
		else 
		{
			$matches = array();
			preg_match("/Location:(.*?)\\n/", $header, $matches);
			$url = @parse_url(trim(array_pop($matches)));
		}
		$rURL = "";
		if (!$url)
		{
			$wpapcurlloops = 0;
			return $pmp_ocheck === true ? $content : $nsheader;
		}
		$wpap_last_urlx = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		$wpap_lasturl = @parse_url($wpap_last_urlx);
		
		
		if (!(isset($url["scheme"])))
		{
			$url["scheme"] = $wpap_lasturl["scheme"];
		}
		if (!(isset($url["host"])))
		{
			$url["host"] = $wpap_lasturl["host"];
		}
		if (!$url["path"])
		{
			$url["path"] = $wpap_lasturl["path"];
		}
		if (!(isset($url["query"])))
		{
			$url["query"] = "";
		}
		$new_url = $url["scheme"] . "://" . $url["host"] . $url["path"] . ($url["query"] ? "?" . $url["query"] : "");
		curl_setopt($ch, CURLOPT_URL, $new_url);
		return curlpagemanage($ch, $wpap_last_urlx, false ,"", $wpapadvsettings);
		}
	}
	
	if($wpapcontentonly === true)
	{ 
		return $content;
	}
	else
	{ 
		return $nsheader;
	}
	
	$checkw="new";
}
function getcurlpagex($url, $reference = "", $wpapfieldsgp = "", $wpapadvsettings = "") 
{
	$ch = curl_init($url);
	$contents = curlpagemanage($ch, $reference, $wpapfieldsgp, $wpapadvsettings);
	curl_close($ch);
	return $contents;
}
function urlcheckongp($contenturl,$contentcnt)
{
	$googlesclink = "https://accounts.google.com/ServiceLoginAuth";
	$googlechspan = "<span color=\"red\">";
	$googlesecondvr = "google.com/SecondFactor";
	$googlesecondvr2 = "google.com/SmsAuth";
	$googlepolicy = "NewPrivacyPolicy";
	$googleserviceauto = "ServiceLoginAuth";
	$googlecaptcha = "CaptchaChallengeOptionContent";
	$googlecaptcha2 = "captcha-box";
	
	if ((stripos($contenturl, "https://accounts.google.com/ServiceLoginAuth") !== false) && (stripos($contentcnt, "<span color=\"red\">") !== false))
	{
		$wpapfstart4 = stripos($contentcnt, "<span color=\"red\">");
		$wpapftmp4 = substr($contentcnt, $wpapfstart4 + strlen("<span color=\"red\">"));
		$wpapflen4 = stripos($wpapftmp4, "</span>");
		return substr($wpapftmp4, 0, $wpapflen4);
	}
	if (stripos($contenturl, "google.com/SecondFactor") !== false || stripos($contenturl, "google.com/SmsAuth") !== false)
	{
		return "2-step verification in on so not ready for autopost.";	
	}
	if (stripos($contenturl, "NewPrivacyPolicy") !== false)
	{
		return "Please login to your account and accept New Privacy Policy";
	}
	if (stripos($contenturl, "ServiceLoginAuth") !== false)
	{
		return "The username or password you entered is incorrect" . $contents["errmsg"];
	}
	if (stripos($contentcnt, "CaptchaChallengeOptionContent") !== false || stripos($contentcnt, "captcha-box") !== false)
	{
		return "Captcha is \"On\" for your account. Please click here <a href=\"https://www.google.com/accounts/DisplayUnlockCaptcha\" target=\"_blank\">Click Here</a>";
	}
	
}
		
function conncetwithgoogleplus($email, $pass)
{
	global $wpap_gpckarray;
	global $wpap_gpckarrayBD;
	$wpap_gpckarray = array();
	$wpapadvsettings = array();
	$md = array();
	$mids = "";
	$wpapgpflds = array();
	
	
	$err = wpapCheckSSLCurl("https://accounts.google.com/ServiceLogin");
	if ($err !== false && $err["errNo"] == "60")
	{
		$wpapadvsettings["noSSLSec"] = true;
	}
	$contents = checkdomaingp($servicegpurl,$wpapadvsettings);
	$inputfld = "<input";
	$inputname = "name=\"";
	$inputvalue = "value=\"";
	$signin = "Sign%20in";
	$hidden = "\"hidden\"";
	$googleaclink = "https://accounts.google.com/ServiceLoginAuth";
	$wpapgpflds["Email"] = $email;
	$wpapgpflds["Passwd"] = $pass;
	$wpapgpflds["signIn"] = $signin;
	while (stripos($contents, $inputfld) !== false)
	{
		$wpapfstart = stripos($contents, $inputfld);
		$wpapftmp = substr($contents, $wpapfstart + strlen($inputfld));
		$wpapflen = stripos($wpapftmp, ">");
		$tffch = substr($wpapftmp, 0, $wpapflen);
		$inpField = trim($tffch);
		
		$wpapfstart1 = stripos($inpField, $inputname);
		$wpapftmp1 = substr($inpField, $wpapfstart1 + strlen($inputname));
		$wpapflen1 = stripos($wpapftmp1, "\"");
		$tffch1 =  substr($wpapftmp1, 0, $wpapflen1);
		$name = trim($tffch1);
		if ((stripos($inpField, $hidden) !== false) && ($name != "") && !(in_array($name, $md)))
		{
			$md[] = $name;
			$wpapfstart2 = stripos($inpField, $inputvalue);
			$wpapftmp2 = substr($inpField, $wpapfstart2 + strlen($inputvalue));
			$wpapflen2 = stripos($wpapftmp2, "\"");
			$tffch2 =  substr($wpapftmp2, 0, $wpapflen2);
			$val = trim($tffch2);
			$wpapgpflds[$name] = $val;
			$mids .= "&" . $name . "=" . $val;
		}
		$contents = substr($contents, stripos($contents, $inputfld) + 8);
		continue;
	}
	
	$wpapquery_array = array();
	foreach ($wpapgpflds as $key => $value)
	{
		$wpapquery_array[] = $key . "=" . urlencode($value);
		continue;
	}
	$wpapgpfldsTxt = implode("&", $wpapquery_array);
	$wpapadvsettings["cdomain"] = "google.com";
	$contents = getcurlpagex($googleaclink, "", false, $wpapgpfldsTxt, $wpapadvsettings);
	
	return urlcheckongp($contents['url'],$contents['content']);
	return false;
}



function wpapgetlinkandtitle($url,$msg) 
{
	$url = urlencode($url);
	$contents = getcurlpagex("https://plus.google.com/", "", false);
	$wpapfstart7 = stripos($contents["content"], "csi.gstatic.com/csi\",\"");
	$wpapftmp7 = substr($contents["content"], $wpapfstart7 + strlen("csi.gstatic.com/csi\",\""));
	$wpapflen7 = stripos($wpapftmp7, "\",");
	$gpatvalue = substr($wpapftmp7, 0, $wpapflen7);
	$gurl = "https://plus.google.com/u/1/_/sharebox/linkpreview/?c=" . $url . "&t=1&slpf=0&ml=1&_reqid=1608303&rt=j";
	$wpapsprvl = "susp=false&at=" . $gpatvalue . "&";
	$contents = getcurlpagex($gurl, "", false, $wpapsprvl);
	$titlejson1 = substr($contents["content"], 5);
	$titlejson1 = str_replace(",{", ",{\"", $titlejson1);
	$titlejson1 = str_replace(":[", "\":[", $titlejson1);
	$titlejson1 = str_replace(",{\"\"", ",{\"", $titlejson1);
	$titlejson1 = str_replace("\"\":[", "\":[", $titlejson1);
	$titlejson1 = str_replace("[,", "[\"\",", $titlejson1);
	$titlejson1 = str_replace(",,", ",\"\",", $titlejson1);
	$titlejson1 = str_replace(",,", ",\"\",", $titlejson1);
	
	$json = $titlejson1;
	return posttitledisplaylist($json,$msg);
}
function postmsgcheck($msg)
{
	$msg = str_replace("<br>", "_wpapvlformsg", $msg);
	$msg = str_replace("<br/>", "_wpapvlformsg", $msg);
	$msg = str_replace("<br />", "_wpapvlformsg", $msg);
	$msg = str_replace("\r\n", "\n", $msg);
	$msg = str_replace("
\r", "\n", $msg);
	$msg = str_replace("\r", "\n", $msg);
	$msg = str_replace("\n", "_wpapvlformsg", $msg);
	$msg = str_replace("\"", "\\\"", $msg);
	$msg = urlencode(strip_tags($msg));
	$msg = str_replace("_wpapvlformsg", "%5Cn", $msg);
	$msg = str_replace("+", "%20", $msg);
	$msg = str_replace("%0A%0A", "%20", $msg);
	$msg = str_replace("%0A", "", $msg);
	$msg = str_replace("%0D", "%5C", $msg);
	return $msg;
}	





function posttitledisplaylist($vljsn,$msg)
{
	
	$array = json_decode($vljsn, true);
	$lnkvl["link"]= $array[0][1][4][0][1];
	$lnkvl["fav"] = $array[0][1][4][0][2];
	$lnkvl["title"] = $array[0][1][4][0][3];
	$lnkvl["domain"] = $array[0][1][4][0][4];
	$lnkvl["txt"] = $array[0][1][4][0][5];
	list(, list(, , , , list(list(, , , , , , list(list(, , , , , , , , $lnkvl["img"])))))) = $array[0];
	list(, list(, , , , list(list(, , , , , , list(list(, $lnkvl["imgType"])))))) = $array[0];
	$lnkvl["title"] = str_replace("&#39;", "'", $lnkvl["title"]);
	$lnkvl["txt"] = str_replace("&#39;", "'", $lnkvl["txt"]);
	$lnkvl["txt"] = html_entity_decode($lnkvl["txt"]);
	$lnkvl["title"] = html_entity_decode($lnkvl["title"]);
	
	$title = $lnkvl["title"];
	$link =$lnkvl["link"];
	$domain =$lnkvl["domain"];
	$txt = $lnkvl["txt"];
	return googlepluspostfromwpap($msg,$images,$link,$domain,$title,$txt);
	//return $out;	
	
}