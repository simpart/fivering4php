<?php
/**
 * @file   responce.php
 * @brief  rest responce function
 * @author simpart
 * @note   MIT license
 */
namespace ttr\rest;

function resp($msg) {
    try {
       header("Content-Type: application/json; charset=utf-8");
       $ret_val = array(
           'result'  => true,
           'message' => $msg
       );
       echo json_encode($ret_val); 
    } catch (Exception $e) {
        throw $e;
    }
}

function errResp($msg) {
    try {
       header("Content-Type: application/json; charset=utf-8");
       $ret_val = array(
           'result'  => false,
           'message' => $msg
       );
       echo json_encode($ret_val);
    } catch (Exception $e) {
        throw $e;
    }
}
/* end of file */
