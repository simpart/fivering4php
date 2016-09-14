<?php
/**
 * @file   Connector.php
 * @brief  connect to RDMS
 * @author simpart
 */
namespace tetraring\database\pdo;

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
