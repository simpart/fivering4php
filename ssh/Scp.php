<?php
namespace ttr\ssh;

class Scp
{
    private $connection = null;
    private $tgt_addr   = null;
    private $port       = 22;
    private $usernm     = null;
    private $passwd     = null;
    private $pubkey     = null;
    private $srcpath    = null;
    private $dstpath    = null;
    
    public function __construct ($dst, $opt)
    {
        try {
            $this->tgt_addr = $dst;
            foreach ($opt as $opt_idx => $opt_val) {
                $this->setOption($opt_idx, $opt_val);
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
    
    public function setOption ($key, $val)
    {
        try {
            if (0 === strcmp($key, 'port')) {
                $this->port    = $val;
            } else if (0 === strcmp($key, 'username')) {
                $this->usernm  = $val;
            } else if (0 === strcmp($key, 'password')) {
                $this->passwd  = $val;
            } else if (0 === strcmp($key, 'pubkey')) {
                $this->pubkey  = $val;
            } else if (0 === strcmp($key, 'prikey')) {
                $this->prikey  = $val;
            } else if (0 === strcmp($key, 'srcpath')) {
                $this->srcpath = $val;
            } else if (0 === strcmp($key, 'dstpath')) {
                $this->dstpath = $val;
            } else {
                throw new \Exception(
                              PHP_EOL  .
                              'File:' . __FILE__ . ',' .
                              'Line:' . __line__ . ',' .
                              'Message: invalid key -> ' . $key
                          );
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
    
    public function getOption ($key)
    {
        try {
            $ret_val = null;
            if (0 === strcmp($key, 'port')) {
                $ret_val = $this->port;
            } else if (0 === strcmp($key, 'username')) {
                $ret_val = $this->usernm;
            } else if (0 === strcmp($key, 'password')) {
                $ret_val = $this->passwd;
            } else if (0 === strcmp($key, 'pubkey')) {
                $ret_val = $this->pubkey;
            } else if (0 === strcmp($key, 'prikey')) {
                $ret_val = $this->prikey;
            } else if (0 === strcmp($key, 'srcpath')) {
                $ret_val = $this->srcpath;
            } else if (0 === strcmp($key, 'dstpath')) {
                $ret_val = $this->dstpath;
            } else {
                throw new \Exception(
                              PHP_EOL  .
                              'File:' . __FILE__ . ',' .
                              'Line:' . __line__ . ',' .
                              'Message: invalid key -> ' . $key
                          );
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
    
    private function connect ()
    {
        try {
            if (null !== $this->connection) {
                return;
            }
            $this->connection = ssh2_connect(
                                    $this->tgt_addr,
                                    $this->port
                                );
            if (false === $this->connection) {
                throw new \Exception(
                              PHP_EOL  .
                              'File:' . __FILE__ . ',' .
                              'Line:' . __line__ . ',' .
                              'Message: failed ssh connect'
                          );
            }
            if ( (null !== $this->usernm) &&
                 (null !== $this->passwd) &&
                 (null === $this->pubkey) ) {
                /* connect via username/password */
                $auth_ret = ssh2_auth_password($this->connection, $this->usernm, $this->passwd);
            } else if ( (null !== $this->usernm) &&
                        (null !== $this->pubkey) &&
                        (null !== $this->prikey) ) {
                /* connect via public key */
                $auth_ret = ssh2_auth_pubkey_file(
                                $this->connection,
                                $this->usernm,
                                $this->pubkey,
                                $this->prikey,
                                $this->passwd
                            );
            } else {
                throw new \Exception(
                              PHP_EOL  .
                              'File:' . __FILE__ . ',' .
                              'Line:' . __line__ . ',' .
                              'Message: invalid parameter'
                          );
            }
            
            if (false === $auth_ret) {
                throw new \Exception(
                              PHP_EOL  .
                              'File:' . __FILE__ . ',' .
                              'Line:' . __line__ . ',' .
                              'Message: failed authentication'
                          );
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
    
    public function upload ($local_src, $remote_dst)
    {
        try {
            $this->connect();
            if(false === ssh2_scp_send(
                              $this->connection,
                              $local_src,
                              $remote_dst)) {
                throw new Exception(
                          PHP_EOL  .
                          'File:' . __FILE__ . ',' .
                          'Line:' . __line__ . ',' .
                          'Message: failed upload'
                      );
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
    
    public function download ($remote_src, $local_dst)
    {
        try {
            $this->connect();
            if(false === ssh2_scp_recv(
                             $this->connection ,
                             $remote_src,
                             $local_dst)) {
                throw new \Exception(
                              PHP_EOL  .
                              'File:' . __FILE__ . ',' .
                              'Line:' . __line__ . ',' .
                              'Message: failed download'
                          );
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
    
    function __destruct() {
        try {
            $this->stream = null;
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
