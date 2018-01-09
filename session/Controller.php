<?php
/**
 * @file   Controller.php
 * @brief  Session Controller
 * @author simpart
 */
namespace ttr\session;

class Controller {

    function __construct($app) {
        try {
            if (0 !== strcmp('string', gettype($app))) {
                throw new \Exception('invalid parameter : ' . __FILE__ . '->' . __LINE__ );
            }
            ini_set('session.cokkie_httponly', true);
            session_name($app);
            session_set_cookie_params(0, '/' . $app . '/');
            session_start();
            header('X-Control-Type-Options: nosniff');
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

//    public function isStarted () {
//        try {
//            if ( php_sapi_name() !== 'cli' ) {
//                if ( version_compare(phpversion(), '5.4.0', '>=') ) {
//                    return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
//                } else {
//                    return session_id() === '' ? FALSE : TRUE;
//                }
//            }
//        } catch (\Exception $e) {
//            throw new \Exception(
//                PHP_EOL   .
//                'File:'   . __FILE__         . ',' .
//                'Line:'   . __line__         . ',' .
//                'Class:'  . get_class($this) . ',' .
//                'Method:' . __FUNCTION__     . ',' .
//                $e->getMessage()
//            );
//        }
//    }
    
    public function set ($key, $val) {
        try {
            session_regenerate_id(true);
            $_SESSION[$key] = $val;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function get ($key) {
        try {
            if (false === array_key_exists($key, $_SESSION)) {
                return null;
            }
            return $_SESSION[$key];
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function destroy () {
        try {
            $nm = session_name();
            setcookie($nm, '', 0, '/' . $nm . '/');
            session_destroy();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
/* end of file */
