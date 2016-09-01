<?php
/**
 * @file   integer.php
 * @brief  format check for integer
 * @author simpart
 * @note   MIT license
 */
namespace tetraring\format\integer;



function isDecimal($chk) {
    try {
        if (1 === preg_match('/^(-?([1234567890])+)/', $chk, $mat)) {
            return true;
        }
        return false;
    } catch (Exception $e) {
        throw $e;
    }
}

function isHexa($chk) {
    try {
        if (1 === preg_match('/^(-?(0x)?([1234567890]|[abcdef]|[ABCDEF])+)/', $chk, $mat)) {
            return true;
        }
        return false;
    } catch (Exception $e) {
        throw $e;
    }
}


function isRanged($chk, $start, $end) {
    try {
        
    } catch (Exception $e) {
        throw $e;
    }
}
/* end of file */
