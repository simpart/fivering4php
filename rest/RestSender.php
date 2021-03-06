<?php
/**
 * @file   RestSender.php
 * @brief  rest send function
 * @author simpart
 * @note   MIT license
 */
namespace ttr\rest;

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
            $this->uri = $uri;
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
    
    
    public function sendGet ($opt=null)
    {
        try {
            $curl = \curl_init($this->uri);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST , 'GET');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_MAXREDIRS     , 5);

            if (null !== $opt) {
                foreach ($opt as $key => $val) {
                    \curl_setopt($curl, $key, $val);
                }
            }

            $ret_val = \curl_exec($curl);
            if (false === $ret_val) {
		 throw new \Exception(\curl_getinfo($curl));
            }
            curl_close($curl);
            
            return $ret_val;
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
    
    /** 
     * send post
     *
     * @param $prm : (array) post parameter
     */
    public function sendPost ($prm, $opt=null)
    {
        try {
            $curl = curl_init($this->uri);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_MAXREDIRS     , 5);
            
            $json = false;
            if (null !== $opt) {
                foreach ($opt as $key => $val) {
                    if ($key === CURLOPT_HTTPHEADER) {
                        foreach ($val as $hdr_elm) {
                            if ( (false !== strpos($hdr_elm, 'Content-Type:')) &&
                                 (false !== strpos($hdr_elm, 'application/json')) ) {
                                $json = true;
                            }
                        }
                    }
                    curl_setopt($curl, $key, $val);
                }
            } 
            
            if (true === $json) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($prm));
            } else {
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($prm));
            }
            
            $ret_val = curl_exec($curl);
            if (false === $ret_val) {
                 var_dump(curl_getinfo($curl));
                 var_dump(curl_errno($curl));
            }
            curl_close($curl);

            return $ret_val;
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
