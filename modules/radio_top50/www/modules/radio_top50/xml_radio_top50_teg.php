<?php
error_reporting(0);
header('Content-type: text/plain');
header('Pragma: no-cache');
header('Expires: 0');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0');
$WIN1251=0;


function xml_radio_top50_teg_content()
{
global $mos;    
    if( isset( $_REQUEST['link'] ))
	{
		$url = $_REQUEST['link'];
	} else return;

		$station=Station($url);
        file_put_contents( './teg1.dat', var_export( $station, true ) );        
		if ($station['icy-br']!=""){
			$streambitrate = intval($station['icy-br']);
		}
		if ($station['icy-name']==""){
			$icy_name = "";	
		} else {
			$icy_name = toUTF(Replacer($station['icy-name']));
            $stream_tip = toUTF(Replacer($station['http/1_0_200_okcontent-type']));
		}

		$song = Song($url);
$xml = null;		
$xml = '<?xml version="1.0" encoding="UTF-8"?><channel><item>';
$xml .= '<icy-br>'.$streambitrate.'</icy-br>';
$xml .= '<icy-name>'.$icy_name.'</icy-name>';
$xml .= '<stream_tip>'.$stream_tip.'</stream_tip>';
$xml .= '<song>'.$song.'</song>';
$xml .= '</item>';
$xml .= '</channel>';

	if( isset( $_REQUEST['debug']))
	{
		echo $xml;
	}
	else
	{
		file_put_contents( '/tmp/teg.dat', $xml );
		echo "/tmp/teg.dat";
	}
		
}

function Station($sURL) {
	$aPathInfo = parse_url($sURL);
	$sHost = $aPathInfo['host'];
	$sPort = empty($aPathInfo['port']) ? 80 : $sPort = $aPathInfo['port'];
	$sPath = empty($aPathInfo['path']) ? '/' : $sPath = $aPathInfo['path'];
	$fp = fsockopen($sHost, $sPort, $errno, $errstr, 2);
	if (!$fp):
		return "";
	else: 
		fputs($fp, "GET $sPath HTTP/1.0\r\n");
		fputs($fp, "Host: $sHost\r\n");
		fputs($fp, "Accept: */*\r\n");
		fputs($fp, "Icy-MetaData:1\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		$char = "";
		$info = "";
		while ($char != Chr(255)){	//END OF MPEG-HEADER
			if (@feof($fp) || @ftell($fp)>14096){  //Spezial, da my-Mojo am Anfang leere Zeichen hat
			    exit;
			}
			$char = @fread($fp,1);
			$info .= $char;
		}
		fclose($fp);
		$info = str_replace("\n", "",$info);
		$info = str_replace("\r", "",$info);
		$info = str_replace("\n\r", "",$info);
		$info = str_replace("<BR>", "",$info);
		$info = str_replace(":", "=",$info);
		$info = str_replace("icy", "&icy",$info);
		$info = strtolower($info);
		parse_str($info, $output);

		if ($output['icy-name']==""){
			return "";	
		} else {
			return $output;
		}
	endif;
}

function Song($sURL) {
	$aPathInfo = parse_url($sURL);
	$sHost = $aPathInfo['host'];
	$sPort = empty($aPathInfo['port']) ? 80 : $sPort = $aPathInfo['port'];
	$sPath = empty($aPathInfo['path']) ? '/' : $sPath = $aPathInfo['path'];
	$fp = fsockopen($sHost, $sPort, $errno, $errstr, "1");
	
	if (!$fp):
		fclose($fp);
		return StreamTitle($sURL);
	else: 
		fputs($fp, "GET /7.html HTTP/1.0\r\nUser-Agent: Mozilla\r\n\r\n");
		while (!feof($fp)):
			$info = fgets($fp);
		endwhile;
		$info = str_replace('<HTML><meta http-equiv="Pragma" content="no-cache"></head><body>', "", $info);
		$info = str_replace('</body></html>', "", $info);
		$stats = explode(',', $info);
		if (empty($stats[1]) ):
			fclose($fp);
			return StreamTitle($sURL);
		else:
			if ($stats[1] == "1"):
				$song = $stats[6];
				$listeners = $stats[0];
				$max =  $stats[3];
				$bitrate = $stats[5];
				$peak = $stats[2];
				return toUTF($song);
			else:
				fclose($fp);
				return StreamTitle($sURL);
			endif;
		endif;
	endif;
}
function StreamTitle($sURL) {
	$aPathInfo = parse_url($sURL);
	$sHost = $aPathInfo['host'];
	$sPort = empty($aPathInfo['port']) ? 80 : $sPort = $aPathInfo['port'];
	$sPath = empty($aPathInfo['path']) ? '/' : $sPath = $aPathInfo['path'];
	$fp = fsockopen($sHost, $sPort, $errno, $errstr, 2);
	if (!$fp):
		return "";
	else: 
		fputs($fp, "GET $sPath  HTTP/1.0\r\n");
		fputs($fp, "Host: $sHost\r\n");
		fputs($fp, "Accept: */*\r\n");
		fputs($fp, "Icy-MetaData:1\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		$char = "";
		$info = "";
		while (!strpos($input, "StreamTitle")){
			if (@feof($fp) || @ftell($fp)>300000){ //max 366kb
//					exit;
               return;     
				}	
			$char = @fread($fp, 16);
			$input .= $char;
		}
		$input .=@fread($fp, 255);
		$startstr = "StreamTitle='";
		$endstr = "';";
		$start = strpos($input, $startstr);
		$subinput = substr($input, $start + strlen($startstr));
		$end = strpos($subinput, $endstr);
		fclose($fp);
		$output = substr($subinput, 0, $end);
		$output = Replacer($output);
		return toUTF($output);
	endif;
}

function toUTF($str){
	global $WIN1251;
	return $WIN1251==1?iconv("WINDOWS-1251", "UTF-8",$str):$str;
}
function Replacer($str){
	$str = str_replace("- 0:00", "", $str);
	$str = str_replace("101.ru= ", "", $str);
	return $str;
}

?>