<?php
/**
 * @file Collection.php
 * @brief collection controller for mongo
 * @author simpart
 */
namespace ttr\db\mongo\ctrl;

class Collection {
    private $ctrl = null;
    
    function __construct($hst, $dbn, $cln) {
        try {
            $this->ctrl = new Common($hst, $dbn, $cln);
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
    
    public function add ($doc) {
        try {
            /* check document */
            $doc->chkRequire();
            /* check redundant */
            if (null !== $this->find($doc)) {
                throw new \Exception('this document is already exists');
            }
            /* execute add */
            $this->ctrl->add($doc->contents());
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
    
    public function delete ($doc) {
        try {
            /* check target exists */
            $chk_find = (null === $doc->id()) ? $doc->contents() : array('_id' => $doc->id());
            if (null === $this->find($chk_find)) {
                /* this doc is already deleted */
                return;
            }
            /* delete */
            $this->ctrl->delete($doc->contents());
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

    public function update ($doc) {
        try {
            /* check document */
            $doc->chkRequire();
            if (null === $doc->id()) {
                throw new \Exception('could not find document id');
            }
            
            $this->ctrl->update($doc->id(), $doc->contents());
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

    public function find ($doc=null) {
        try {
            $find_cnt = null;
            if (null !== $doc) {
                $conts = $doc->contents();
                foreach ($conts as $c_key => $c_val) {
                    if (null !== $c_val) {
                        $find_cnt[$c_key] = $c_val;
                    }
                }
            }
            
            if ( (1 === count($find_cnt)) &&
                 (true === array_key_exists('_id', $find_cnt())) ) {
                $rows =  $this->ctrl->find(
                              array(
                                  '_id' => new \MongoDB\BSON\ObjectId($find_cnt['_id'])
                              )
                          );
            } else {
                $rows = $this->ctrl->find((null == $find_cnt) ? [] : $find_cnt);
            }
            
            $ret = null;
            foreach ($rows as $doc) {
                $ret[] = $doc;
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
