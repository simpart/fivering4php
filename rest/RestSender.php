<?php
/**
 * @file   RestSender.php
 * @brief  rest send function
 * @author simpart
 * @note   MIT license
 */

/**
 * @class RestSender
 * @brief rest sender class
 * @note curl wrapper
 */
class RestSender
{
    private $uri = null;

    public function __construct ($uri)
    {
        try {
            if (null === $uri) {
                throw new \Exception('invalid parameter');
            }
        } catch (\Exception $e) {

        }
    }
    
    
    public function sendGet ($prm)
    {
        try {
#            $curl = null;
#            if( count($prm) > 0 ) {
#                $uri  .= '?';
#                $query = '';
#                foreach ($prm as $key => $value) {
#                    if( strlen(trim($key)) > 0 ) {
#                        $query .= (rawurlencode($key).'='.rawurlencode($value).'&');
#                    }
#                }
#                $uri .= $query;
#            }
#            $curl = curl_init($this->uri);
#            curl_setopt($curl, CURLOPT_URL           , $this->uri);
#            curl_setopt($curl, CURLOPT_CUSTOMREQUEST , 'GET');
#            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
#            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
#            $ret_val = curl_exec($curl);
#            curl_close($curl);
#
#            return $ret_val;
        } catch (\Exception $e) {

        }
    }
    
    /** 
     * send post
     *
     * @param $prm : (array) post parameter
     */
    public function sendPost ($prm)
    {
        try {
            $curl = curl_init($uri);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($prm));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_MAXREDIRS     , 5);
            $ret_val = curl_exec($curl);
            curl_close($curl);

            return $ret_val;
        } catch (\Exception $e) {

        }
    }
}
/* end of file */
