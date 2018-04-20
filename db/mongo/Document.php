<?php
/**
 * @file Document.php
 * @brief common document interface
 * @author simpart
 */
namespace ttr\db\mongo;

class Document {
    private $id      = null;
    private $conts   = null;
    private $require = null;
    
    function __construct($key=null, $req=null) {
        try {
            if (null !== $key) {
                $conts = null;
                foreach ($key as $k_elm) {
                    $conts[$k_elm] = null;
                }
                $this->contents($conts);
            }
            
            if (null !== $req) {
                $this->setRequire($req);
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
    
    public function id ($prm=null) {
        try {
            if (null === $prm) {
                /* getter */
                if (true === array_key_exists('_id', $this->contents())) {
                    return $this->contents()['_id'];
                } else {
                    return null;
                }
            }
            /* setter */
            $this->contents(array('_id' => $prm));
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
    
    public function setRequire ($lst) {
        try {
            $conts = $this->contents();
            $hit   = false;
            foreach ($lst as $l_elm) {
                $hit = false;
                foreach ($conts as $c_key => $c_val) {
                    if (0 === strcmp($c_key, $l_elm)) {
                        $hit = true;
                        break;
                    }
                }
                if (false === $hit) {
                    throw new \Exception('could not find contents');
                }
            }
            $this->require = $lst;
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
    
    public function chkRequire() {
        try {
            $conts = $this->contents();
            $this->require;
            foreach ($conts as $c_key => $c_val) {
                foreach ($this->require as $r_elm) {
                    if ( (0 === strcmp($r_elm, $c_key)) &&
                         (null === $c_val) ) {
                        throw new \Exception($c_key . ' is not set');
                    }
                }
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
    
    public function contents ($kvs=null) {
        try {
            if (null === $kvs) {
                /* getter */
                return $this->conts;
            }
            /* setter */
            foreach ($kvs as $key => $val) {
                $this->conts[$key] = $val;
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
}
/* end of file */
