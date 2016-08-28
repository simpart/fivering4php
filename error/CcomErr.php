<?php
/**
 * @file   CcomErr.php
 * @brief  common error exception
 * @author simpart
 * @note   MIT License 
 */
namespace tetraring\error;
require_once(__DIR__ . '/define.php');

/**
 * @class CcomErr
 * @brief common error class
 */
class CcomErr extends \Exception {
    private $header  = "";
    private $summary = null;
    private $conts   = null;
    
    /**
     * set error string
     * 
     * @param $err : (string) error summary
     * @param $cnt : (string) contents
     */
    function __construct($err, $cnt ) {
        try {
            $this->summary  = $err;
            $this->conts    = $cnt;
        } catch( \Exception $e ) {
            DERR_EXCPCNT_METHOD;
        }
    }
    
    /**
     * show error contents
     */
    public function showConts() {
        try {
            echo $this->header . 'Error   : ' . $this->summary . PHP_EOL;
            $pad  = "";
            $loop = 0;
            for($loop=0;$loop < strlen($this->header);$loop++) {
                $pad .= ' ';
            }
            echo 'Support ' . $pad . ': ' . $this->conts . PHP_EOL;
        } catch ( \Exception $e ) {
            DERR_EXCPCNT_METHOD;
        }
    }
    
    protected function setHeader($hdr) {
        try {
            $this->header = $hdr;
        } catch (\Exception $e) {
            DERR_EXCPCNT_METHOD;
        }
    }
}
/* end of file */
