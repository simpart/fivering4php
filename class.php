<?php
/**
 * @file   class.php
 * @brief  class loader
 * @author simpart
 * @note   MIT license
 */
namespace tetraring\cls;
require_once(__DIR__ . '/directory.php');
$Gtrp_appPath = __DIR__ . '/../';

/*** function ***/
/**
 * search and require class
 * 
 * @param $cname : (string) class name
 */
function load($cname) {
    try {
        global $Gtrp_appPath;
        
        if (null === $Gtrp_appPath) {
            throw new \Exception('app path is null');
        }
        
        $lnpos = strripos($cname, '\\'); // last namespace position
        if (false === $lnpos) {
            throw new \Exception('invalid class name');
        }
        $nspace = substr($cname, 0, $lnpos);
        $cname  = substr($cname, $lnpos+1);
        $fname  = $Gtrp_appPath .
                  str_replace('\\',
                      DIRECTORY_SEPARATOR,
                      $nspace
                  ) .
                  DIRECTORY_SEPARATOR . $cname . '.php';
        if (true === file_exists($fname)) {
            require $fname;
        } else {
            throw new \Exception('could not find : ' . $fname);
        }
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * set application path
 * 
 * @param $path : (string) path to application path 
 */
function setAppPath($path) {
    try {
        global $Gtrp_appPath;
        
        if (false === \tetraring\dir\isExists($path)) {
            throw new \Exception('parameter is null');
        }
        $Gtrp_appPath = $path;
    } catch (\Exception $e) {
        throw $e;
    }
}

spl_autoload_register('\tetraring\cls\load');
/* end of file */
