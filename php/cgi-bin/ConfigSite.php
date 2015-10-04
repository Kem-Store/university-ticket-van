<?php
// Author: Kenanek Thongkam
class ini
{
	public static function SettingArray($path)
	{
		$tmpConfig = NULL;
		$loadConfig = parse_ini_file($path, true);
		foreach($loadConfig as $isGroupConfig)
		{
			foreach($isGroupConfig as $name=>$value)
			{
				$tmpConfig[$name] = $value;
			}
		}
		return $tmpConfig;
	}	
}

class alert
{
	public static function Warning($text)
	{
		$tmpString = '<center><div class="alert-warning">';
		$tmpString .= $text.'</div></center>';
		return $tmpString;
	}	
	public static function Info($text)
	{
		$tmpString = '<center><div class="alert-info">';
		$tmpString .= $text.'</div></center>';
		return $tmpString;
	}	
}

class site
{
	public static function Module($folder, $name)
	{
		if(file_exists('module/'.$folder.'/'.$name.'.php')) {
			include_once('module/'.$folder.'/'.$name.'.php');
			return true;
		} else {
			include_once('plugins/default.php');
			return false;
		}
	}
	
	public static function Content($file, $value = array())
	{
		$urlInfo = pathinfo($_SERVER['REQUEST_URI']);
		$urlfile = 'http://'.$_SERVER['SERVER_NAME'].'/'.$urlInfo['dirname'].'/index.php/?html='.$file;
		$getContent = file_get_contents($urlfile);
		$data = array();
		if(ereg('\[', $getContent)) {
			$contents = explode('[',$getContent);
			$tmpString = $contents[0];
			for($loop=1;$loop<count($contents);$loop++) {
				if(ereg('\]', $contents[$loop])) {
					$vars = explode(']', $contents[$loop]);
					$found = false;
					foreach($value as $key=>$val) {
						if($vars[0]==$key) {
							$found = true;
							$tmpString .= $value[$vars[0]];					 
						}
					}
					if(!$found) { $tmpString .= '<strong>['.$vars[0].']</strong>'; }
					$tmpString .= $vars[1];
				} else {
					$tmpString .= $contents[$loop];
				}
			}
		} else {
			$tmpString = $data;
		}
		return $tmpString;
	}
}

class ThaiDate
{
	public static function TimeStamp($isHour, $isMinute, $isDay, $isMonth, $isYear)
	{
		return mktime($isHour, $isMinute, 0, $isMonth, $isDay, $isYear);
	}
	
	public static function Full($timestamp)
	{
		$fullMonth = array(0,_January, _February, _March, _April, _Mays, _June, _July, _August, _September, _October, _November, _December);
		
		$isDay = getdate($timestamp);		
		return $isDay['mday'].' '.$fullMonth[$isDay['mon']].' '.($isDay['year']+543);
	}	
	
	public static function Mid($timestamp)
	{
		$fullMonth = array(0,_January, _February, _March, _April, _Mays, _June, _July, _August, _September, _October, _November, _December);
		$isDay = getdate($timestamp);		
		if(strlen($isDay['hours'])<2) $isDay['hours'] = '0'.$isDay['hours'];
		if(strlen($isDay['minutes'])<2) $isDay['minutes'] = '0'.$isDay['minutes'];
		
		return $isDay['mday'].' '.$fullMonth[$isDay['mon']].' '.($isDay['year']+543).' '._TIME.' '.$isDay['hours'].':'.$isDay['minutes'];
	}
}
?>
