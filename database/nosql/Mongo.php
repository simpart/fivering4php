<?php
/**
 * @file Mongo.php
 * @brief mongo db controller
 * @author simpart
 */
namespace db;
require_once(__DIR__ . '/../ttr/class.php');
require_once(__DIR__ . '/func/mongo.php');

class Mongo implements NoSqlCtrl {
    private $host    = null;
    private $dbname  = null;
    private $colname = null;
    private $mng     = null;
    
    function __construct($hst=null, $db=null) {
        try {
            if ((null === $hst) || (null === $db)) {
                throw new \Exception('invalid parameter');
            }
            $mng    = db\mongo\getManager($hst);
            $dbname = $db;
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
            if (array_values($keyvals) === $key_vals) {
                foreach ($key_vals as $elm) {
                    $bulk->insert($elm);
                }
            } else {
                $bulk->insert($key_vals);
            }
            return $mongo->executeBulkWrite($this->dbname . '.' . $col, $bulk);
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
            return $mongo->executeBulkWrite($this->dbname . '.' . $col, $bulk);
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
            return $mongo->executeBulkWrite($this->dbname . '.' . $col, $bulk);
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
            $query = new \MongoDB\Driver\Query($fil, $opt);
            $rows  = $mongo->executeQuery( $this->dbname . '.' . $col, $query);
            $ret   = null;
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
