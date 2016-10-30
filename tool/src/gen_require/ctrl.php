<?php
try {
    require_once(__DIR__ . '/func.php');
    $g_deep_cnt = 0;
    $g_tgt_lst  = array();
    /* load module target */
    $g_tgt_yml  = yaml_parse_file(__DIR__ . '/../../target.yml');
    if (false === $g_tgt_yml) {
        throw new Exception('failed load target');
    }
    
    foreach ($g_tgt_yml as $tgt_elm) {
        foreach ($tgt_elm as $tgt_key => $tgt_val) {
        
            $tgt_ret = getTgtList($tgt_key);
            if (null === $tgt_ret) {
                continue;
            }
            
            foreach ($tgt_ret as $tgt_ret_elm) {
                $g_tgt_lst[$tgt_ret_elm] = true;
            }
        }
    }
    
    file_put_contents(__DIR__ . '/../../../require.php', D_GEN_HEAD);
    
    foreach ($g_tgt_lst as $tgt_name => $tgt_val) {
        genReqsrc($tgt_name);
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
/* end of file */
