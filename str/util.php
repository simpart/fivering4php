<?php
/**
 * @file util.php
 */
namespace ttr\str;

function rem_ctrl_char ($str) {
    try {
        $sp_str  = str_split($str);
        $isctrl  = false;
        $rep_hex = '';
        foreach ($sp_str as $str_elm) {
            if ('1b' === dechex(ord($str_elm))) {
                $isctrl = true;
            }
            if ( (true === $isctrl) && ('6d' === dechex(ord($str_elm))) ) {
                $isctrl = false;
                continue;
            }
            if (false === $isctrl) {
                $hex = dechex(ord($str_elm));
                if (1 === strlen($hex)) {
                    $hex = '0' . $hex;
                }
                $rep_hex .= (1 === strlen($hex)) ? '0'.$hex : $hex;
            }
        }
        $ret_str = hex2bin($rep_hex);
        return preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $ret_str);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
