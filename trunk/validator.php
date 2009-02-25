<?php
/****************************************************************
 * Description:		Configuration file			*
 * Author: 		Mai Haohui				*
 * CreationDate:	2005-11-09				*
 * Lastupdate:		2006-07-02				*
 * License:		GPL					*
 * Version:		0.11alpha				*
 * 								*
 * This program comes with ABSOLUTE NO WARRANTY. 		*
 * Use at YOUR OWN RISK!					*
 ****************************************************************
 */

include_once 'config.inc.php';
include_once 'common.inc.php';

class proxy_class {
	private $proxy;
	private $tries;

	public function get_proxy_str() { return $this->proxy;}
	public function get_tries() { return $this->tries;}
	public function dec_tries() { if($this->tries >0) $this->tries--;}
	public function __construct($proxy) {
		global $config;
		$this->proxy = $proxy;
		$this->tries = $config['verify_tries'];
	}
	
}

class validator {
	private $mh;
	private $proxy_queue;
	private $proxy_result;

	// tool functions
	private function get_next_proxy() {return count($this->proxy_queue) ? array_shift($this->proxy_queue) : false; }
	public function __construct($proxies) {
		$this->mh = curl_multi_init(); 
		$this->proxy_queue = $proxies;
	}
	public function get_proxy_result() { return $this->proxy_result;}
	private function new_curl_handle($proxy) {
		global $config;
		if(is_null($proxy)) return false;
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $config['verify_url']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXY, "http://$proxy");
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $config['connection_timeout']);
		curl_setopt($ch, CURLOPT_TIMEOUT, $config['overall_timeout']);
		
		return $ch;
	}
	
	public function validate() {
		global $config;
		while(count($this->proxy_queue)) {
			$i = 0;	unset($conn);
			while ($i < $config['parellel_sockets'] && $p = $this->get_next_proxy()){
				$conn[$i] = array($this->new_curl_handle($p->get_proxy_str()), $p);
				curl_multi_add_handle ($this->mh, $conn[$i][0]);
				$i++;
			}

			// start performing the request
			do {
				$mrc = curl_multi_exec($this->mh, $active);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);

			while ($active && $mrc == CURLM_OK) {
				// wait for network
				if (curl_multi_select($this->mh) != -1) {
					// pull in any new data, or at least handle timeouts
					do {
						$mrc = curl_multi_exec($this->mh, $active);
					} while ($mrc == CURLM_CALL_MULTI_PERFORM);
				}
			}

			// retrieve data & check
			for($i=0;$i<count($conn);$i++) {
				$ch = $conn[$i][0];
				$proxy = $conn[$i][1];
				$verify_result = curl_multi_getcontent($ch);
				if(strpos($verify_result, $config['verify_keyword'])) {
					$this->proxy_result[] = array("proxy"=>$proxy->get_proxy_str(),
					"speed"=> curl_getinfo($ch, CURLINFO_SPEED_DOWNLOAD),
					"status" => "GOOD");
				} else if($proxy->get_tries() >0 ){
					$proxy->dec_tries();
					$this->proxy_queue[] = $proxy;
				}
				curl_multi_remove_handle($this->mh, $ch);
			}
		} // end of main-while
	}
	function __destruct() {	curl_multi_close($this->mh);}
}

$proxies = get_proxy_from_string(file_get_contents($config['proxy_file']));

$q[] = '';
foreach($proxies as $p) $q[] = new proxy_class($p);
array_shift($q);

$v = new validator($q);
$v->validate();

$res = $v->get_proxy_result();
$avail_proxies[] = '';
if(count($res))
	foreach ($res as $p) if($p["status"] == "GOOD") $avail_proxies[] = $p["proxy"];

array_shift($avail_proxies);

echo "available proxys are:<br/>";
echo implode("<br/>", $avail_proxies);
echo "<br/>";

$fproxy = fopen($config['proxy_checked_file'],'w');
fputs ($fproxy,implode("\n", $avail_proxies));
fputs ($fproxy, "\n");
fclose($fproxy);
?>
