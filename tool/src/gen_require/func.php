<?php
/**
 * @file gen_require/func.php
 */


define('D_GEN_HEAD', '<?php' . PHP_EOL);


function getTgtList($tgt_key) {
    try {
        global $g_tgt_lst;
        global $g_tgt_yml;
        global $g_deep_cnt;
        
        $g_deep_cnt++;
        if (1000 < $g_deep_cnt) {
            throw new Exception('detect require loop');
        }
        
        $ret_val = array();
        foreach ($g_tgt_yml as $elm) {
            foreach ($elm as $elm_key => $elm_val) {
                if (0 !== strcmp($elm_key, $tgt_key)) {
                    continue;
                }
                
                if ( (false === array_key_exists('require', $elm_val)) ||
                     (false === array_key_exists('enable' , $elm_val)) ) {
                    throw new Exception('invalid config file');
                }
                
                if (false === $elm_val['enable']) {
                    return null;
                }
                
                if (true === array_key_exists($tgt_key, $g_tgt_lst)) {
                    return null;
                }
                
                $req_lst = $elm_val['require'];
                if (null !== $req_lst) {
                    foreach ($req_lst as $req_elm) {
                        $req_ret = getTgtList($req_elm);
                        if (null !== $req_ret) {
                            foreach ($req_ret as $req_ret_elm) {
                                $ret_val[] = $req_ret_elm;
                            }
                        }
                    }
                }
                $ret_val[] = $tgt_key;
            }
        }
        return $ret_val;
    } catch (Exception $e) {
        throw $e;
    }
}

function genReqsrc($tgt_name) {
    try {
        $set_str = "    require_once(__DIR__.'/$tgt_name/require.php');" . PHP_EOL;
        file_put_contents(__DIR__.'/../../../require.php', $set_str, FILE_APPEND);
    } catch (Exception $e) {
        throw $e;
    }
}



/* end of file */
