<?php
/**
 * @file   routing/util.php
 * @brief  url checker class
 * @author simpart
 */
namespace ttr\routing;

/**
 * @class URL
 * @brief util function for url
 */
class URL {
    private $url    = null;
    private $offset = 0;
    
    function __construct($u) {
        try {
            $this->setUrl($u);
        } catch (\Exception $e) {
            throw new \Exception(
                PHP_EOL   .
                'File:'   . __FILE__         . ',' .
                'Line:'   . __line__         . ',' .
                'Class:'  . get_class($this) . ',' .
                'Method:' . __FUNCTION__     . ',' .
                $e->getMessage()
            );
        }
    }
    
    private function setUrl ($url) {
        try {
            $ex_url = explode('/', $url);
            
            // check path
            foreach ($ex_url as $elm) {
                if (0 === strcmp($elm, '..')) {
                    throw new \Exception('invalid format');
                }
            }
            
            // remove empty element
            while (true) {
                $is_empty = false;
                foreach ($ex_url as $uidx => $uval) {
                    if (0 === strcmp($uval, '')) {
                        $is_empty = true;
                        array_splice($ex_url, $uidx, 1);
                        break;
                    }
                }
                if (false === $is_empty) {
                    break;
                }
            }
            
            $this->url = $ex_url;
        } catch (\Exception $e) {
            throw new \Exception(
                PHP_EOL   .
                'File:'   . __FILE__         . ',' .
                'Line:'   . __line__         . ',' .
                'Class:'  . get_class($this) . ',' .
                'Method:' . __FUNCTION__     . ',' .
                $e->getMessage()
            );
        }
    }
    
    public function setOffset ($off) {
        try {
            if (0 !== strcmp(gettype($off), 'integer')) {
                throw new \Exception('invalid parameter');
            }
            
            if ((0 > $off) || (count($this->url) < $off)) {
                throw new \Exception('invalid parameter');
            }
            $this->offset = $off;
        } catch (\Exception $e) {
            throw new \Exception(
                PHP_EOL   .
                'File:'   . __FILE__         . ',' .
                'Line:'   . __line__         . ',' .
                'Class:'  . get_class($this) . ',' .
                'Method:' . __FUNCTION__     . ',' .
                $e->getMessage()
            );
        }
    }
    
    public function getUrl ($idx=null) {
        try {
            $ret_url = $this->url;
            
            if (null === $idx) {
                for ($loop=0; $loop < $this->offset ;$loop++) {
                    array_splice($ret_url, 0, 1);
                }
                return $ret_url;
            } else if ( (0 !== strcmp(gettype($idx), 'integer')) ||
                        (0 > $idx) ||
                        (count($ret_url) <= $idx) ) {
                throw new \Exception('invalid parameter');
            } else {
                return $ret_url[$idx];
            }
        } catch (\Exception $e) {
            throw new \Exception(
                PHP_EOL   .
                'File:'   . __FILE__         . ',' .
                'Line:'   . __line__         . ',' .
                'Class:'  . get_class($this) . ',' .
                'Method:' . __FUNCTION__     . ',' .
                $e->getMessage()
            );
        }
    }
    
    public function getUrlString ($off=null) {
        try {
            $ret = '';
            $cnt = 0;
            $url = $this->url;
            if (null === $off) {
                $off = $this->offset;
            }
            foreach ($url as $uelm) {
                if ($cnt < $off) {
                    $cnt++;
                    continue;
                }
                $ret .= DIRECTORY_SEPARATOR . $uelm;
                $cnt++;
            }
            return $ret;
        } catch (\Exception $e) {
            throw new \Exception(
                PHP_EOL   .
                'File:'   . __FILE__         . ',' .
                'Line:'   . __line__         . ',' .
                'Class:'  . get_class($this) . ',' .
                'Method:' . __FUNCTION__     . ',' .
                $e->getMessage()
            );
        }
    }
}
/* end of file */
