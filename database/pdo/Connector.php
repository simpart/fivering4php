<?php
/**
 * @file   Connector.php
 * @brief  connect to RDMS
 * @author simpart
 */
namespace ttr\database\pdo;

class Connector {
    private $conn = null;
    
    /**
     * get pdo object
     */
    function __construct($host, $dbnm, $user, $pass) {
        try {
            $pdo = new \PDO(
                'mysql:host=' . $host . ';dbname=' . $dbnm . ';charset=utf8',
                $user ,
                $pass ,
                array(
                    \PDO::ATTR_EMULATE_PREPARES        => false,
                    \PDO::MYSQL_ATTR_READ_DEFAULT_FILE => '/etc/my.cnf'
                )
            );
            if(true === is_null($pdo)) {
                throw new \Exception('pdo connect failure');
            }
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn = $pdo;
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
    
    public function select($tbl, $fil) {
        try {
            $sql = 'select * from ' . $tbl;
            if (null !== $fil) {
                $sql   .= ' where ';
                $first  = true;
                foreach ($fil as $fil_key => $fil_val) {
                    if (true === $first) {
                        $first = false;
                    } else {
                        $sql .= ' and ';
                    }
                    $sql .= $fil_key . ' = ' . $fil_val;
                }
            }
            return $this->manual($sql);
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
    
    public function insert ($tbl, $conts) {
        try {
            $sql = 'insert into ' . $tbl;
            if (null === $conts) {
                throw new \Exception('invalid paramter');
            }
            $col_str = '(';
            $val_str = '(';
            $first = true;
            foreach ($conts as $key => $val) {
                if (true === $first) {
                    $first = false;
                } else {
                    $col_str .= ',';
                    $val_str .= ',';
                }
                $col_str .= $key;
                $val_str .= $val;
            }
            $col_str .= ')';
            $val_str .= ')';
            $sql .= ' ' . $col_str . ' values ' . $val_str;
            $stmt    = $this->conn->prepare($sql);
            $stmt->execute();
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
    
    public function delete($tbl, $fil) {
        try {
            $sql = 'delete from ' . $tbl;
            if (null !== $fil) {
                $sql   .= ' where ';
                $first  = true;
                foreach ($fil as $fil_key => $fil_val) {
                    if (true === $first) {
                        $first = false;
                    } else {
                        $sql .= ' and ';
                    }
                    $sql .= $fil_key . ' = ' . $fil_val;
                }
            }
            $stmt    = $this->conn->prepare($sql);
            $stmt->execute();
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
    
    public function update($tbl, $val, $fil) {
        try {
             $sql = 'update ' . $tbl;
             if (null !== $val) {
                $sql   .= ' set ';
                $first  = true;
                foreach ($val as $val_key => $val_val) {
                    if (true === $first) {
                        $first = false;
                    } else {
                        $sql .= ' and ';
                    }
                    $sql .= $val_key . ' = ' . $val_val;
                }
            }
            if (null !== $fil) {
                $sql   .= ' where ';
                $first  = true;
                foreach ($fil as $fil_key => $fil_val) {
                    if (true === $first) {
                        $first = false;
                    } else {
                        $sql .= ' and ';
                    }
                    $sql .= $fil_key . ' = ' . $fil_val;
                }
            }
            $stmt    = $this->conn->prepare($sql);
            $stmt->execute();
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
    
    public function maxIndex($tbl, $idx_nm) {
        try {
            $sql     = 'select max('. $idx_nm .') from ' . $tbl;
            $stmt    = $this->conn->prepare($sql);
            $stmt->execute();
            $row     = $stmt->fetch(\PDO::FETCH_ASSOC);
            $ret_val = intval($row['max('. $idx_nm .')']);
            if (0 === $ret_val) {
                throw new Exception('could not get index');
            }
            return $ret_val;
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
    
    public function manual ($sql) {
        try {
            $stmt    = $this->conn->prepare($sql);
            $stmt->execute();
            $ret_val = null;
            while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $ret_val[] = $row;
            }
            return $ret_val;
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
