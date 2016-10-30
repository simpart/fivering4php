<?php
/**
 * @file   directory.php
 * @brief  directory util functions
 * @author simpart
 * @note   MIT license
 */
namespace tetraring\dir;

/**
 * delete directory
 * 
 * @param $dir : (string) path to target directory
 */
function delete($dir) {
    try {
        $odir = scandir( $dir );
        if (2 < count($odir)) {
            foreach( $odir as $elm ) {
                if ((0 === strcmp($elm,'.')) ||
                    (0 === strcmp($elm,'..')) ) {
                    continue;
                }
                $ftype = filetype( $dir . DIRECTORY_SEPARATOR . $elm );
                if (0 === strcmp($ftype, 'dir')) {
                    delete($dir . DIRECTORY_SEPARATOR . $elm);
                } else {
                    $ret = unlink($dir . DIRECTORY_SEPARATOR . $elm);
                    if (false === $ret) {
                        throw new \Exception('could not delete : ' . $dir . DIRECTORY_SEPARATOR . $elm);
                    }
                }
            }
            $ret = rmdir($dir); 
            if (false === $ret) {
                throw new \Exception('could not delete : ' . $dir);
            }
        } else if (2 === count($odir) ) {
            $ret = rmdir($dir);
            if (false === $ret) {
                throw new \Exception();
            }
        }
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * delete directory contents
 * it does not delete target directory
 * 
 * @param $dir : (string) path to target directory
 */
function delConts( $dir ) {
    try {
        if( strlen($dir)-1 === strrpos($dir, DIRECTORY_SEPARATOR) ) {
            $dir = substr($dir, 0, strlen($dir)-1);
        }
        $odir = scandir( $dir );
        foreach( $odir as $elm ) {
            if ((0 === strcmp($elm,'.')) ||
                (0 === strcmp($elm,'..')) ) {
                continue;
            }
            $ftype = filetype( $dir . DIRECTORY_SEPARATOR . $elm );
            if (0 === strcmp($ftype, 'dir')) {
                delete($dir . DIRECTORY_SEPARATOR . $elm);
            } else {
                $ret = unlink($dir . DIRECTORY_SEPARATOR . $elm);
                if (false === $ret) {
                    throw new \Exception('could not delete : ' . $dir . DIRECTORY_SEPARATOR . $elm);
                }
            }
        } 
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * check whether the directory exists
 * 
 * @param $dir : (string) path to target directory
 * @return true : (bool) exists
 * @return false : (bool) not exists or $dir is not directory
 */
function isExists($dir) {
    try {
        if (true !== file_exists($dir)) {
            return false;
        }
        $ftype = filetype($dir);
        if (0 !== strcmp($ftype, 'dir')) {
            return false;
        }
        return true;
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * copy directory
 * 
 * @param $src : (string) path to source directory
 * @param $dst : (string) path to destination directory
 */
function copy($src, $dst) {
    try {
        /* check source directory */
        if (false === isExists($src)) {
            throw new \Exception('could not find source directory');
        }
        /* check destination directory */
        if (false === isExists($dst)) {
            if( false === mkdir($dst) ) {
                throw new \Exception('could not create destination directory');
            }
        }
        
        $scan = scandir( $src );
        foreach ($scan as $elm) {
            if ((0 === strcmp($elm,'.')) || 
                (0 === strcmp($elm,'..')) ) {
                continue;
            }
            $ftype = filetype($src . DIRECTORY_SEPARATOR . $elm);
            if (0 === strcmp($ftype, 'dir')) {
                copy(
                    $src . DIRECTORY_SEPARATOR . $elm,
                    $dst . DIRECTORY_SEPARATOR . $elm
                );
            } else {
                if (false === \copy(
                                  $src . DIRECTORY_SEPARATOR . $elm,
                                  $dst . DIRECTORY_SEPARATOR . $elm
                              )) {
                    throw new \Exception(
                        'could not copy \'' . $src . DIRECTORY_SEPARATOR . $elm . '\'' .
                        ' to \'' . $dst . DIRECTORY_SEPARATOR . $elm . '\''
                    );
                }
            }
        }
    } catch (\Exception $e) {
        throw $e;
    }
}
/* end of file */
