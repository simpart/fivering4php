<?php
/**
 * @file Mongo.php
 * @brief mongo db controller
 * @author simpart
 */
namespace ttr\db\mongo;

require_once(__DIR__ . '/../../class.php');
require_once(__DIR__ . '/func.php');

class Ctrl {
    private $host    = null;
    private $dbname  = null;
    private $colname = null;
    private $mng     = null;
    
    function __construct($hst=null, $db=null) {
        try {
            if ((null === $hst) || (null === $db)) {
                throw new \Exception('invalid parameter');
            }
            $this->mng    = getManager($hst);
            $this->dbname = $db;
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
    
    public function add ($col, $key_vals) {
        try {
            $bulk = new \MongoDB\Driver\BulkWrite;
            if (array_values($key_vals) === $key_vals) {
                foreach ($key_vals as $elm) {
                    $bulk->insert($elm);
                }
            } else {
                $bulk->insert($key_vals);
            }
            return $this->mng->executeBulkWrite($this->dbname . '.' . $col, $bulk);
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
    
    public function delete ($col, $tgt) {
        try {
            $bulk = new \MongoDB\Driver\BulkWrite;
            if (array_values($tgt) === $tgt) {
                foreach ($tgt as $elm) {
                    $bulk->delete($elm);
                }
            } else {
                $bulk->delete($tgt);
            }
            return $this->mng->executeBulkWrite($this->dbname . '.' . $col, $bulk);
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
    
    public function update ($col, $fil, $upd) {
        try {
            $bulk = new \MongoDB\Driver\BulkWrite;
            $bulk->update($fil, $upd);
            return $this->mng->executeBulkWrite($this->dbname . '.' . $col, $bulk);
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
    
    public function find ($col, $fil, $opt=[]) {
        try {
            $query = new \MongoDB\Driver\Query(
                             $fil,
                             $opt
                         );
            return $this->mng->executeQuery(
                       $this->dbname . '.' . $col,
                       $query
                   );
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
