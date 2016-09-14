<?php
/**
 * @file   define.php
 * @brief  error define
 * @author simpart
 * @note   MIT License
 */

/**
 * @define DERR_EXCPCNT_METHOD
 * @brief  common exception function at method
 * @attention Exception value name is '$e'
 */
define(
    'DERR_EXCPCNT_METHOD',
    'throw new \Exception(
                   PHP_EOL   .
                   \'File:\'   . __FILE__         . \',\' .
                   \'Line:\'   . __line__         . \',\' .
                   \'Class:\'  . get_class($this) . \',\' .
                   \'Method:\' . __FUNCTION__     . \',\' .
                   $e->getMessage()
               )'
);

/**
 * @define DERR_EXCPCNT_FUNC
 * @brief  common exception function define
 * @attention Exception value name is '$e'
 */
define(
    'DERR_EXCPCNT_FUNC',
    'throw new \Exception(
                   PHP_EOL   .
                   \'File:\'   . __FILE__   . \',\' .
                   \'Line:\'   . __line__   . \',\' .
                   \'Func:\' . __FUNCTION__ . \',\' .
                   $e->getMessage()
               )'
);
/* end of file */
