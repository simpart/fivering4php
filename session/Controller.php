<?php
/**
 * @file   Controller.php
 * @brief  Session Controller
 * @author simpart
 */
namespace ttr\session;

class Controller {
    private $limit = null;
    
    function __construct($app, $lmt=null) {
        try {
            if (0 !== strcmp('string', gettype($app))) {
                throw new \Exception('invalid parameter : ' . __FILE__ . '->' . __LINE__ );
            }
            ini_set('session.cokkie_httponly', true);
            session_name($app);
            session_set_cookie_params(0, '/' . $app . '/');
            session_start();
            header('X-Control-Type-Options: nosniff');
            
            /* set limit */
            if (null !== $lmt) {
                ini_set('session.cookie_lifetime', $lmt);
                ini_set('session.gc_maxlifetime' , $lmt); 
                $this->limit = lmt;
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

    
    public function set ($key, $val) {
        try {
            session_regenerate_id(true);
            //session.cookie_lifetime
            $_SESSION[$key] = $val;
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
    
    public function get ($key) {
        try {
            /* set session value */
            if (false === array_key_exists($key, $_SESSION)) {
                return null;
            }
            return $_SESSION[$key];
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
    
    public function destroy () {
        try {
            $nm = session_name();
            setcookie($nm, '', 0, '/' . $nm . '/');
            session_destroy();
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
