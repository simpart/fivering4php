<?php
/**
 * @file   file.php
 * @brief  file util functions
 * @author simpart
 * @note   MIT license
 */
namespace tetraring\file;

/**
 * check exists file
 * 
 * @param $path : (string) path to target file
 */
function isExists($path) {
    try {
        if (true !== file_exists($path)) {
            return false;
        }
        $ftype = filetype($path);
        if (0 !== strcmp($ftype, 'file')) {
            return false;
        }
        return true;
    } catch (\Exception $e) {
        throw $e;
    }
}
/* end of file */
