<?php
/**
 * @file   CcomErr.php
 * @brief  common error exception
 * @author simpart
 * @note   MIT License 
 */
namespace error;
require_once(__DIR__ . '/define.php');

/**
 * @class CcomErr
 * @brief common error class
 */
class CcomErr extends \Exception {
    private $header   = "";
    private $summary  = null;
    private $contents = null;
    
    /**
     * set error string
     * 
     * @param $err : (string) error summary
     * @param $cnt : (string) contents
     */
    function __construct($err, $cnt ) {
        try {
            $this->summary  = $err;
            $this->contents = $cnt;
        } catch( \Exception $e ) {
            DERR_EXCPCNT_METHOD;
        }
    }
    
    /**
     * show error contents
     */
    public function showConts() {
        try {
            echo $this->err_hdr . 'Error   : ' . $this->err_conts . PHP_EOL;
            $cnt  = strlen($this->err_hdr);
            $pad  = "";
            $loop = 0;
            for($loop=0;$loop < $cnt;$loop++) {
                $pad .= ' ';
            }
            echo 'Support '. $pad .': ' . $this->sup_str . PHP_EOL;
        } catch ( \Exception $e ) {
            DERR_EXCPCNT_METHOD;
        }
    }
    
    protected function setHeader($hdr) {
        try {
            $this->err_hdr = $hdr;
        } catch (\Exception $e) {
            DERR_EXCPCNT_METHOD;
        }
    }
}
/* end of file */
