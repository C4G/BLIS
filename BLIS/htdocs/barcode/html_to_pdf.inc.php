<?php

	/**
	 * Genereate PDF from HTML
	 * @author Harish Chauhan
	 * @version 1.0.0
	 * @name HTML_TO_PDF
	 */
	
	define ("HKC_USE_ABC",1);
	define ("HKC_USE_EASYW",2);

	class HTML_TO_PDF
	{
		var $html 	= "";
		var $htmlurl= "";
		var $error 	= "";
		var $host	= "";
		var $port	= 80;
		var $url	= "";
		var $_useurl  = "";
		
		var $saveFile = "";
		var $downloadFile = "";	
		var $_cookie = "";
		
		function HTML_TO_PDF($html="",$useurl = HKC_USE_ABC)
		{
			$this->html = $html;
			$this->_useurl=$useurl;
		}
		
		function useURL($useurl)
		{
			$this->_useurl = $useurl;
		}
		
		function saveFile($file="")
		{
			if(empty($file))
				$this->saveFile = time().".pdf";
			else 
				$this->saveFile =$file;
		}
		
		function downloadFile($file="")
		{
			if(empty($file))
				$this->downloadFile = time().".pdf";
			else 
				$this->downloadFile =$file;
		}
		
		function error()
		{
			return  $this->error;
		}
		
		function convertHTML($html="")
		{
			if(!empty($html))
				$this->html=$html;
			$htmlfile = time().".html";
			$url = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/".$htmlfile;
			
			$this->write_file($htmlfile,$this->html);

			$return = $this->convertURL($url);
			if(is_file($htmlfile))
				@unlink($htmlfile);
			return $return;
		}
		
		function convertURL($url)
		{
			$this->htmlurl = $url;
			if($this->_useurl == HKC_USE_ABC)
				return $this->_convertABC();
			elseif ($this->_useurl == HKC_USE_EASYW)
				return $this->_convertEASYW();
		}
		
		function _convertABC()
		{
			$this->host = "64.39.14.230";

			$this->url = "/pdf-net/cleardoc.aspx";
			$this->_sendRequest($s_POST_DATA);
			$s_POST_DATA = "url=".urlencode($this->htmlurl);
			$s_POST_DATA.= "&PagedOutput=on";
			$s_POST_DATA.= "&AddLinks=on";
			$s_POST_DATA.= "&x=30";
			$s_POST_DATA.= "&y=30";
			$s_POST_DATA.= "&w=550";
			$s_POST_DATA.= "&h=704";
			$s_POST_DATA.= "&UserName=";
			$s_POST_DATA.= "&Password=";
			$s_POST_DATA.= "&Timeout=15550";
			$s_POST_DATA.= "&Submit=Add URL";

			$this->url = "/pdf-net/addurl.aspx";
			$this->_sendRequest($s_POST_DATA);
			$this->url = "/pdf-net/showdoc.aspx";
			$s_POST_DATA = "";
			
			$pdfdata = $this->_sendRequest($s_POST_DATA);
			if($pdfdata===false) return false;

			if(!empty($this->saveFile))		
				$this->write_file($this->saveFile,$pdfdata);
			if(!empty($this->downloadFile))
				$this->download_file($pdfdata);
			return $pdfdata;
		}
		
		function _convertEASYW()
		{
			//http://www.easysw.com/htmldoc/pdf-o-matic.php
			$this->url= "/htmldoc/pdf-o-matic.php";
			$this->host="www.easysw.com";
			$s_POST_DATA = "URL=".urlencode($this->htmlurl);
			$s_POST_DATA .= "&FORMAT=.pdf";
			$pdfdata = @file_get_contents("http://".$this->host.$this->url."?".$s_POST_DATA);
			if(!empty($pdfdata))
			{
				if(!empty($this->saveFile))		
					$this->write_file($this->saveFile,$pdfdata);
				if(!empty($this->downloadFile))
					$this->download_file($pdfdata);
				return true;
			}
			
			$pdfdata = $this->_sendRequest($s_POST_DATA);
			if($pdfdata===false) return false;
			
			if(!empty($this->saveFile))		
				$this->write_file($this->saveFile,$pdfdata);
			if(!empty($this->downloadFile))
				$this->download_file($pdfdata);

			return $pdfdata;			
		}
		
		function _sendRequest($s_POST_DATA)
		{
			if(function_exists("curl_init"))
				return $this->_sendCRequest($s_POST_DATA);
			else
				return $this->_sendSRequest($s_POST_DATA);
		}

		function _sendSRequest($s_POST_DATA)
		{
			$s_Request = "POST ".$this->url." HTTP/1.0\n";
			$s_Request .="Host: ".$this->host.":".$this->port."\n";
			$s_Request .="Content-Type: application/x-www-form-urlencoded\n";
			$s_Request .="Content-Length: ".strlen($s_POST_DATA)."\n";
			if($this->_useurl == HKC_USE_ABC && !empty($this->_cookie))
				$s_Request .="Cookie: ".$this->_cookie."\n";
			$s_Request .="\n".$s_POST_DATA."\n\n";
			
			$fp = fsockopen ($this->host, $this->port, $errno, $errstr, 30);
			if(!$fp)
			{
				$this->error = "ERROR: $errno - $errstr<br />\n";
				return false;
			}
			fputs ($fp, $s_Request);
			while (!feof($fp)) {
				$this->GatewayResponse .= fgets ($fp, 128);
			}
			fclose ($fp);

			if(empty($this->_cookie))
			{
				@preg_match("/ASP.NET_SessionId[^;]*/s", $this->GatewayResponse, $match);
				$this->_cookie = $match[0];
			}

			@preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $this->GatewayResponse, $match);
			if($this->_useurl == HKC_USE_ABC)
				@preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $match[2], $match);
			$this->GatewayResponse =$match[2];

			return $this->GatewayResponse;
		}
		
		function _sendCRequest($s_POST_DATA)
		{
			$ch = curl_init();
			//"http://".$this->host.":".$this->port.$this->url;
			curl_setopt( $ch, CURLOPT_URL, "http://".$this->host.":".$this->port.$this->url );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS,$s_POST_DATA);
			if($this->_useurl == HKC_USE_ABC && !empty($this->_cookie))
				curl_setopt( $ch, CURLOPT_COOKIE,$this->_cookie);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_TIMEOUT,30 );
			curl_setopt($ch, CURLOPT_HEADER, 1);
			$this->GatewayResponse=curl_exec( $ch );
			if(curl_error($ch)!="")
			{
				$this->error = "ERROR: ".curl_error($ch)."<br />\n";
				return false;
			}
			curl_close($ch);
			
			if(empty($this->_cookie))
			{
				@preg_match("/ASP.NET_SessionId[^;]*/s", $this->GatewayResponse, $match);
				$this->_cookie = $match[0];
			}

			@preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $this->GatewayResponse, $match);
			if($this->_useurl == HKC_USE_ABC)
				@preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $match[2], $match);
			$this->GatewayResponse =$match[2];

			return $this->GatewayResponse;
		}

		function write_file($file,$content,$mode="w")
		{
			$fp=@fopen($file,$mode);
			if(!is_resource($fp))
				return false;
			fwrite($fp,$content);
			fclose($fp);
			return true;
		}

		function download_file($pdfdata)
		{
			@header("Cache-Control: ");// leave blank to avoid IE errors
			@header("Pragma: ");// leave blank to avoid IE errors
			@header("Content-type: application/octet-stream");
			@header("Content-Disposition: attachment; filename=".$this->downloadFile);
			echo $pdfdata;
		}

	}
?>