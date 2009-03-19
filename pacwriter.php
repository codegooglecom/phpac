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

$proxies = get_proxy_from_string(file_get_contents($config['proxy_checked_file']));
$freeips = get_free_ip_from_string(file_get_contents($config['free_ip_url']));
$pac_file = file_get_contents($config['pac_template_file']);
$freeip_file = file($config['freeip_file']);

/*echo ($freeip_file[0]);
$keywords = preg_split ("/[\s,]+/", trim("$freeip_file[0]"));
foreach($keywords as $test) echo("$test\n");
echo("$keywords[0]\n");
echo("$keywords[1]\n");
echo("$keywords[2]\n");*/



$freeip[] = '';
foreach($freeips as $l) $freeip[] = preg_split('/[\s,]+/', trim("$l"));
array_shift($freeip);

//print_r ($freeip);


$inst_p = '';		// template instance of proxy
foreach($proxies as $proxy) $inst_p .= "\"PROXY $proxy;\"+\n";
$inst_p .= "\"DIRECT\";\n";

$inst_f = '';		// template instance of free ip
//foreach($freeip as $f) echo ("$f[0]\r\n");
foreach($freeip as $f) 
//$inst_f .= "f.push(Array(\"{$f[0]}\",\"{$f[1]}\"));\n";
$inst_f .= "if (isInNetEx(host,\"$f[0]\",\"$f[2]\")) {return \"DIRECT\";}\n";

$pac_file = str_replace('$TMPL_PROXY$', $inst_p, $pac_file);
$pac_file = str_replace('$TMPL_FREEIP$', $inst_f, $pac_file);

$fproxy = fopen($config['proxypac_file'],'w');
fputs ($fproxy,$pac_file);
fclose($fproxy);

echo "Done. pac at <a href='http://roar.net9.org/proxy/proxy.pac' target='_blank'>http://roar.net9.org/proxy/proxy.pac</a><br/>";

?>
