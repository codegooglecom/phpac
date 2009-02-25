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

function get_proxy_from_string($s) {
	preg_match_all('/(\w)+(\.(\w)+)+:(\d)+/', $s, $found_proxy);
	return $found_proxy[0];	
}

function get_free_ip_from_string($s){
    preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\s+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\s+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\s+/', $s, $freeips);
    return $freeips[0];
}

?>
