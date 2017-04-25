<?php
namespace ttr\ssh;
define('TTR_SSHCLI_PORT',   'port');
define('TTR_SSHCLI_USER',   'username');
define('TTR_SSHCLI_PASS',   'password');
define('TTR_SSHCLI_PUBKEY', 'pubkey');
define('TTR_SSHCLI_PRIKEY', 'prikey');

class Command
{
    private $stream   = null;
    private $tgt_addr = null;
    private $port     = 22;
    private $usernm   = null;
    private $passwd   = null;
    private $pubkey   = null;
    
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
            if (0 === strcmp($key, TTR_SSHCLI_PORT)) {
                $this->port   = $val;
            } else if (0 === strcmp($key, TTR_SSHCLI_USER)) {
                $this->usernm = $val;
            } else if (0 === strcmp($key, TTR_SSHCLI_PASS)) {
                $this->passwd = $val;
            } else if (0 === strcmp($key, TTR_SSHCLI_PUBKEY)) {
                $this->pubkey = $val;
            } else if (0 === strcmp($key, TTR_SSHCLI_PRIKEY)) {
                $this->prikey = $val;
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
            if (0 === strcmp($key, TTR_SSHCLI_PORT)) {
                $ret_val = $this->port;
            } else if (0 === strcmp($key, TTR_SSHCLI_USER)) {
                $ret_val = $this->usernm;
            } else if (0 === strcmp($key, TTR_SSHCLI_PASS)) {
                $ret_val = $this->passwd;
            } else if (0 === strcmp($key, TTR_SSHCLI_PUBKEY)) {
                $ret_val = $this->pubkey;
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
            if (null !== $this->stream) {
                return;
            }
            $con = ssh2_connect(
                       $this->tgt_addr,
                       $this->port
                   );
            if (false === $con) {
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
                $auth_ret = ssh2_auth_password($con, $this->usernm, $this->passwd);
            } else if ( (null !== $this->usernm) &&
                        (null !== $this->pubkey) &&
                        (null !== $this->prikey) ) {
                /* connect via public key */
                $auth_ret = ssh2_auth_pubkey_file(
                                $con,
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
            $this->stream = ssh2_shell($con, "xterm");
            $this->responce();
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
    
    public function execute ($cmd)
    {
        try {
            if( (null  === $cmd)            ||
                (false === is_string($cmd)) ) {
                throw new Exception(
                              PHP_EOL  .
                              'File:' . __FILE__ . ',' .
                              'Line:' . __line__ . ',' .
                              'Message: invalid parameter'
                          );
            }
            $this->connect();
            fwrite($this->stream, $cmd.PHP_EOL);
            fflush($this->stream);
            return $this->responce();
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
    
    private function responce ()
    {
        try {
            $count    = 0;
            $ret_val  = "";
            $res_str  = "";
            $res_part = "";
            while(true) {
                $res_str  = stream_get_contents($this->stream);
                $ret_val .= $res_str;
                if(0 === strcmp($res_str, "")) {
                    $count++;
                    $res_part = substr( $ret_val , -1 );
                    if( ( 0 === strcmp( $res_part , "#" ) ) ||
                        ( 0 === strcmp( $res_part , ">" ) ) ||
                        ( 0 === strcmp( $res_part , "$" ) ) ||
                        ( 0 === strcmp( $res_part , ":" ) ) ) {
                        break;
                    }
                    $res_part = substr( $ret_val , -2 );
                    if ( ( 0 === strcmp( $res_part , "# " ) ) ||
                         ( 0 === strcmp( $res_part , "> " ) ) ||
                         ( 0 === strcmp( $res_part , "$ " ) ) ||
                         ( 0 === strcmp( $res_part , ": " ) ) ) {
                        break;
                    }
                    if ( 100 < $count ) {
                        break;
                    }
                    usleep(100000);
                }
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
