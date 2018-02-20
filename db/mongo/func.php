<?php
/**
 * @file func.php
 * @brief util function for mongodb
 * @author simpart
 */
namespace ttr\db\mongo;
$g_mongo = null;

function getManager ($host) {
    try {
        global $g_mongo;
        if (null !== $g_mongo) {
            /* find manager */
            foreach ($g_mongo as $elm) {
                if (0 === strcmp($elm['host'], $host)) {
                    return $elm['manager'];
                }
            }
        }
        /* get manager */
        $mng = new \MongoDB\Driver\Manager("mongodb://" . $host);
        $g_mongo[] = array(
            'host'    => $host,
            'manager' => $mng
        );
        return $mng;
    } catch (\Exception $e) {
        throw new \Exception(
            PHP_EOL   .
            'File:'   . __FILE__   . ',' .
            'Line:'   . __line__   . ',' .
            'Func:' . __FUNCTION__ . ',' .
            $e->getMessage()
        );
    }
}
/* end of file */

