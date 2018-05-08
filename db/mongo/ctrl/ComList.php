<?php
/**
 * @file Common.php
 * @brief mongodb common controller
 * @author simpart
 */
namespace ttr\db\mongo\ctrl;

require_once(__DIR__ . '/../../../class.php');
require_once(__DIR__ . '/../func.php');

class ComList extends Common {
    
    public function add ($lst) {
        try {
            foreach ($lst as $elm) {
                parent::add($elm);
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
    
    public function delete ($lst) {
        try {
            foreach ($lst as $elm) {
                parent::delete($elm);
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
}
/* end of file */
