<?php
/**
 * @file   header/util.php
 * @brief  util function for http header
 * @author simpart
 */
namespace ttr\header;

function setContsType ($cnt_pth) {
    try {
        $ex_path = explode('.', $cnt_pth);
        $file_tp = $ex_path[count($ex_path)-1];
        $type    = null;
        if (0 === strcmp($file_tp, 'csv')) {
            $type = 'text/csv';
        } else if (0 === strcmp($file_tp, 'html')) {
            $type = 'text/html';
        } else if (0 === strcmp($file_tp, 'css')) {
            $type = 'text/css';
        } else if (0 === strcmp($file_tp, 'javascript')) {
            $type = 'text/javascript';
        } else if (0 === strcmp($file_tp, 'exe')) {
            $type = 'application/octet-stream';
        } else if (0 === strcmp($file_tp, 'pdf')) {
            $type = 'application/pdf';
        } else if ( (0 === strcmp($file_tp, 'xsl'))  ||
                    (0 === strcmp($file_tp, 'xslx')) ||
                    (0 === strcmp($file_tp, 'xslm')) ) {
            $type = 'application/vnd.ms-excel';
        } else if (0 === strcmp($file_tp, 'ppt')) {
            $type = 'application/vnd.ms-powerpoint';
        } else if ( (0 === strcmp($file_tp, 'doc'))  ||
                    (0 === strcmp($file_tp, 'docx')) ) {
            $type = 'application/msword';
        } else if ( (0 === strcmp($file_tp, 'jpg'))  ||
                    (0 === strcmp($file_tp, 'jpeg')) ) {
            $type = 'image/jpeg';
        } else if (0 === strcmp($file_tp, 'png')) {
            $type = 'image/png';
        } else if (0 === strcmp($file_tp, 'gif')) {
            $type = 'image/gif';
        } else if (0 === strcmp($file_tp, 'bmp')) {
            $type = 'image/bmp';
        } else if (0 === strcmp($file_tp, 'zip')) {
            $type = 'application/zip';
        } else if (0 === strcmp($file_tp, 'lzh')) {
            $type = 'application/zip';
        } else if ( (0 === strcmp($file_tp, 'tar')) ||
                    (0 === strcmp($file_tp, 'gzip')) ) {
            $type = 'application/x-tar';
        } else if (0 === strcmp($file_tp, 'mp3')) {
            $type = 'audio/mpeg';
        } else if (0 === strcmp($file_tp, 'mp4')) {
            $type = 'audio/mp4';
        } else if (0 === strcmp($file_tp, 'mpeg')) {
            $type = 'video/mpeg';
        } else if (0 === strcmp($file_tp, 'php')) {
            $type = 'application/json; charset=utf-8';
        } else {
            $type = 'text/plain';
        }
        header("Content-Type: " . $type);
    } catch (\Exception $e) {
        throw new \Exception(
                   PHP_EOL .
                   'File:' . __FILE__     . ',' .
                   'Line:' . __line__     . ',' .
                   'Func:' . __FUNCTION__ . ',' .
                   $e->getMessage()
              );
    }
}
/* end of file */
