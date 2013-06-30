<?php

// sorting callback functions
// sort by domain name
function compare_domain($a, $b)
{
	return strnatcmp($a['domain'], $b['domain']);
}

// sort by expiration
function compare_expiration($a, $b)
{
	return strnatcmp($a['expiration'], $b['expiration']);
}

// sort by creation
function compare_creation($a, $b)
{
	return strnatcmp($a['creation'], $b['creation']);
}

// Check cache if it needs an update
function run_cache()
{
	global $config;
	if(file_exists("./inc/cache.txt") && (@filemtime("./inc/cache.txt") + $config["cache_time"] - 1) < time()) {
		refresh();
	}
}

// Update cache and pull the domains from the API of OVH
function refresh()
{
	global $config;
	$cache = null;
	try {
		$soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.52.wsdl");
		$session = $soap->login($config["user"], $config["pass"], "de", false);
		$domains = $soap->domainList($session);
		$cache["domains"] = $domains;
		foreach($domains as $domain)
		{
			$info = $soap->domainInfo($session, $domain);
			$cache["dom_".$domain] = $info;
		}
		$soap->logout($session);
		$cache = json_encode($cache);
		file_put_contents("./inc/cache.txt", $cache);
	 } catch(SoapFault $fault) {
		echo $fault;
	}
}

// Read cache and build an array for easier using in the index.php file
function load_domains()
{
	$i = 0;
	$result = null;
	$cache = file_get_contents("./inc/cache.txt");
	$cache = json_decode($cache, true);
	$domains = $cache["domains"];

	foreach($domains as $domain) {
		$i++;
		$dns = array();
		$dn = "dom_".$domain;
		$info = $cache["$dn"];
		foreach($info["dns"] as $dnsname) {
			$dns[] = $dnsname["name"];
		}
		unset($info["dns"]);
		$info["dns"] = $dns;
		$info["id"] = $i;
		$result[$domain] = $info;
	}
	return $result;
}

// Calculate the time two unix timestamps in readable 1y 1m 1h 1s format.
function time2str($time, $anz=9) {
	$str = "";
	if($time > (60 * 60 * 24 * 30.5) && $anz > 0) {
		$anz--;
		$months = floor($time/(60 * 60 * 24 * 30.5));
		if(strlen($months) == 1) { 
			$months = "0".$months; 
		}
		if($months == 1) {
			$str .= $months." month ";
		 }else{
			$str .= $months." months ";
		}
		$time = $time-((60 * 60 * 24 * 30.5)*$months);
	}
	if($time > (60 * 60 * 24) && $anz > 0) {
		$anz--;
		$days = floor($time/(60*60*24));
		if(strlen($days) == 1) { 
			$days = "0".$days; 
		}
		if($days == 1) {
			$str .= $days." day ";
		 }else{
			$str .= $days." days ";
		}
		$time = $time-((60 * 60 * 24)*$days);
	}
	if($time > (60 * 60) && $anz > 0) {
		$anz--;
		$stunden = floor($time/(60*60));
		if(strlen($stunden) == 1) { 
			$stunden = "0".$stunden; 
		}
		if($stunden == 1) {
			$str .= $stunden." hour ";
		 }else{
			$str .= $stunden." hours ";
		}
		$time = $time-((60 * 60)*$stunden);
	}
	$str = substr($str, 0, strlen($str)-1);
	return $str;
}

?>