<?php
/**
 * @file   network.php
 * @brief  format check for network
 * @author simpart
 * @note   MIT license
 */
namespace tetraring\format\network;
require_once(__DIR__ . '/integer.php');
/**
 * check ipaddress
 *
 * @param $chk : (string) check target
 * @return true : (bool) paramter is ipaddress
 * @return false : (bool) parameter is not ipaddress
 */
function isIpv4addr($chk) {
    try {
        $exp_chk = explode('.', $chk);
        if (4 !== $exp_chk) {
            return false;
        }
        // check integer
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * check host name
 * 
 * @param $host : (string) 
 */
function isHostName($host) {
    try {
        /* check enable charactor */
        $chk = preg_match('/[0-9a-zA-Z_.¥-]*/', $host, $m);
        if (1 !== $chk) {
            return false;
        }
        if (strlen($m[0]) !== strlen($host)) {
            return false;
        }
        /* check dot using (only use split domain) */
        if (false !== strpos('..',$host)) {
            return false;
        }
        
        /* check string length */
        $host_len = strlen($host);
        if (24 < $host_len) {
            return false;
        }
        
        /* check first charactor */
        $chk = preg_match('/[a-zA-Z0-9]/', $host[0], $m);
        if (1 !== $chk) {
            return false;
        }
        
        /* check last charactor */
        if ( ('-' === $host[$host_len-1]) ||
             ('.' === $host[$host_len-1])) {
            return false;
        }
        
        /* check integer */
        $chk = true;
        for($loop=0; $loop < $host_len ;$loop++) {
            if (false === \tetraring\format\integer\isDecimal($host[$loop])) {
                $chk = false;
                break;
            }
        }
        if (true === $chk) {
            return false;
        }
        
        return true;
    } catch (\Exception $e) {
        throw $e;
    }
}
/* end of file */
