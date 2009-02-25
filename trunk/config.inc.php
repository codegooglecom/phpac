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

// proxy list to validate, generate .pac, etc.
$config['proxy_file'] = "proxy.txt";
$config['proxy_checked_file'] = "plcheck.txt";
$config['proxypac_file'] = "proxy.pac";

// where to get the proxy lists from internet
$config['proxy_lists_url'][] = "http://proxy.ipcn.org/proxylist.html";
//$config['proxy_lists_url'][] = "http://www.proxycn.com/cnallproxy/page1.htm";
//$config['proxy_lists_url'][] = "http://www.xjtushare.com";
//$config['proxy_lists_url'][] = "http://www.cnproxy.com/proxyedu1.html";
//$config['proxy_lists_url'][] = "http://www.cnproxy.com/proxyedu2.html";

$config['free_ip_url'] = 'http://netsupport.tsinghua.edu.cn/mfdzb/freeip.htm';

// pac template
$config['pac_template_file'] = 'proxy_pac_template.txt';

// free ip list
$config['freeip_file'] = 'freeip.txt';

// verification data
$config['verify_url'] = 'http://www.battle.net/';
$config['verify_keyword'] = 'Blizzard';
$config['verify_tries'] = 2;

// time settings
$config['connection_timeout'] = 5;
$config['overall_timeout'] = 30;
$config['parellel_sockets'] = 20;
?>
