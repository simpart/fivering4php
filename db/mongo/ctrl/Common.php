<?php
/**
 * @file Common.php
 * @brief mongodb common controller
 * @author simpart
 */
namespace ttr\db\mongo\ctrl;

require_once(__DIR__ . '/../../../class.php');
require_once(__DIR__ . '/../func.php');

class Common {
    private $host     = null;
    private $db_name  = null;
    private $col_name = null;
    private $mng      = null;
    
    function __construct($hst=null, $db=null, $cl=null) {
        try {
            if ((null === $hst) || (null === $db) || (null === $cl)) {
                throw new \Exception('invalid parameter');
            }
            $this->mng      = \ttr\db\mongo\getManager($hst);
            $this->db_name  = $db;
            $this->col_name = $cl;
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
    
    public function add ($key_vals) {
        try {
            $bulk = new \MongoDB\Driver\BulkWrite;
            if (array_values($key_vals) === $key_vals) {
                foreach ($key_vals as $elm) {
                    $bulk->insert($elm);
                }
            } else {
                $bulk->insert($key_vals);
            }
            return $this->mng->executeBulkWrite(
                       $this->db_name . '.' . $this->col_name,
                       $bulk
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
    
    public function delete ($kvs) {
        try {
            $bulk = new \MongoDB\Driver\BulkWrite;
            if (array_values($kvs) === $kvs) {
                foreach ($kvs as $elm) {
                    $bulk->delete($elm);
                }
            } else {
                $bulk->delete($kvs);
            }
            return $this->mng->executeBulkWrite(
                       $this->db_name . '.' . $this->col_name,
                       $bulk
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
    
    public function update ($fil, $upd) {
        try {
            $bulk = new \MongoDB\Driver\BulkWrite;
            $bulk->update($fil, $upd);
            return $this->mng->executeBulkWrite(
                       $this->db_name . '.' . $this->col_name,
                       $bulk
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
    
    public function find ($fil, $opt=[]) {
        try {
            $query = new \MongoDB\Driver\Query(
                             $fil,
                             $opt
                         );
            return $this->mng->executeQuery(
                       $this->db_name . '.' . $this->col_name,
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
