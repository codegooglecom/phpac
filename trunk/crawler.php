<?php
/****************************************************************
 * Description:		Configuration file			*
 * Author: 			Mai Haohui			*
 * CreationDate:	2005-11-09				*
 * Lastupdate:		2006-07-02				*
 * License:			GPL				*
 * Version:			0.11alpha			*
 * 								*
 * This program comes with ABSOLUTE NO WARRANTY. 		*
 * Use at YOUR OWN RISK!					*
 ****************************************************************
 */

include_once "config.inc.php";
include_once "common.inc.php";

unset($proxies);
$proxies[] = '';

$files = $config['proxy_lists_url'];
$files[] = $config['proxy_checked_file'];

foreach ($files as $list_url) {
	if($html = file_get_contents($list_url))
		$proxies = array_merge($proxies, get_proxy_from_string($html));
}

array_shift($proxies);
$proxies = array_unique($proxies);

echo implode("<br/>", $proxies);
echo "<br/>";

$fproxy = fopen($config['proxy_file'],'w');
fputs ($fproxy,implode("\n", $proxies));
fputs ($fproxy, "\n");
fclose($fproxy);

?>
