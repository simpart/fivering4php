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
            if (null === $this->find($doc)) {
                /* this doc is already deleted */
                return;
            }
            /* set target */
            $del_tgt = null;
            if (null === $doc->id()) {
                $del_tgt = $doc->contents();
            } else {
                $del_tgt = array(
                               '_id' => new \MongoDB\BSON\ObjectId($doc->id())
                           );
            }
            /* delete */
            $this->ctrl->delete($del_tgt);
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
                if (null !== $doc->id()) {
                    /* find by _id */
                    $rows = $this->ctrl->find(
                        array(
                            '_id' => new \MongoDB\BSON\ObjectId($doc->id())
                        )
                    );
                } else {
                    /* find by contents */
                    $rows = $this->ctrl->find($doc->contents());
                }
            } else {
                /* get all document */
                $rows = $this->ctrl->find([]);
            }
            
            $ret = null;
            foreach ($rows as $d_elm) {
                $ret[] = $d_elm;
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
