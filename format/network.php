<?php
/**
 * @file   network.php
 * @brief  format check for network
 * @author simpart
 * @note   MIT license
 */
namespace tetraring\format\network;

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

/* end of file */
