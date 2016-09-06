<?php

/**
 * Rest Api Proxy Library
 *
 * @author Zeynel Dağlı
 * @version 0.1
 */

namespace Proxy;

 class Proxy extends \Proxy\AbstractProxy implements PublicKeyRequiredInterface,
                                                                    PublicKeyTempRequiredInterface,
                                                                    PublicKeyNotFoundInterface,
                                                                    PublicKeyTempNotFoundInterface,
                                                                    PrivateKeyNotFoundInterface,
                                                                    PrivateTempKeyNotFoundInterface,
                                                                    UserNotRegisteredInterface
{
    
    

/**
     * invalid url format redirect url
     * @var string
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected $invalidCallUrl = "invalid.php";
    
    /**
     * invalid url format redirect url function
     * @var string
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected $invalidCallFunc = "invalid";
    
    /**
     * encrypt class obj
     * @var \vendor\Encrypt\AbstractEncrypt
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected $encryptClass;
    
    /**
     * encrypt class key
     * @var string
     * @author Mustafa Zeynel Dağlı
     * @since version 0.2
     */
    protected $encryptKey = 'testKey';
    
    
    /**
     * service pk required or not
     * @var mixed boolean | null
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    protected $isServicePkRequired = null;
    
    /**
     * service pk temp required or not
     * @var mixed boolean | null
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 27/01/2016
     */
    protected $isServicePkTempRequired = null;
    
    /**
     * service cpk (company private key) required or not
     * @var mixed boolean | null
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 09/06/2016
     */
    protected $isServiceCpkRequired = null;
    
    /**
     * determine if public key not found redirect closure
     * @var boolean | null
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    protected $isPublicKeyNotFoundRedirect = true;
    
    /**
     * determine if public key not found redirect closure
     * @var boolean | null
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 27/01/2016
     */
    protected $isPublicTempKeyNotFoundRedirect = true;
    
    /**
     * determine if company public key not found redirect closure
     * @var boolean | null
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 09/06/2016
     */
    protected $isPublicCompanyKeyNotFoundRedirect = true;
    
    /**
     * determine if private key not found
     * @var boolean | null
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    protected $isPrivateKeyNotFoundRedirect = true;
    
    /**
     * determines what will be done if private temp key not found
     * @author Mustafa Zeynel Dağlı
     * @var boolean
     */
     protected $privateKeyTempNotFoundRedirect = true;
    
    /**
     * determine if user not registered
     * @var boolean | null
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    protected $isUserNotRegisteredRedirect = true;
    
    /**
     * determine if insert operations logged
     * @var mixed boolean
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 21/03/2016
     */
    protected $isInsertOperationLogged = true;
    
    /**
     * determine if update operations logged
     * @var mixed boolean
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 21/03/2016
     */
    protected $isUpdateOperationLogged = true;
    
    /**
     * determine if delete operations logged
     * @var mixed boolean
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 21/03/2016
     */
    protected $isDeleteOperationLogged = true;


    public function __construct() {
        //parent::__construct();
    }
    
    /**
     * user not registered process function, will be overridden by
     * inherit classes
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function userNotRegisteredRedirect() {
        if($this->isServicePkRequired && $this->isUserNotRegisteredRedirect) {
            $forwarder = new \Utill\Forwarder\UserNotRegisteredForwarder();
            $forwarder->redirect();
        } else {
            return true;
        }
    }
    
    /**
     * get if to redirect due to user not registered  process
     * @return boolean
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function getUserNotRegisteredRedirect() {
        return $this->isUserNotRegisteredRedirect;
    }
    
    /**
     * set if to redirect due to user not registered  process
     * @param boolean $boolean
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function setUserNotRegisteredRedirect($boolean = null) {
        $this->isUserNotRegisteredRedirect = $boolean;
    }
    
    /**
     * private key not found process function, will be overridden by
     * inherit classes
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function privateKeyNotFoundRedirect() {
        if($this->isServicePkRequired && $this->isPrivateKeyNotFoundRedirect) {
            $forwarder = new \Utill\Forwarder\PrivateNotFoundForwarder();
            $forwarder->redirect();
        } else {
            return true;
        }
    }
    
    /**
     * if user id and company id does not match , rest api forwarded here
     * inherit classes
     * @author Mustafa Zeynel Dağlı
     * @since version 0.4 09/06/2016
     */
    public function userNotBelongCompany() {
        $forwarder = new \Utill\Forwarder\UserNotBelongCompanyForwarder;
        $forwarder->redirect();
    }

    /**
     * get if to redirect due to private key not found process
     * @return type
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function getPrivateKeyNotFoundRedirect() {
        return $this->isPrivateKeyNotFoundRedirect;
    }
    
    /**
     * set if to redirect due to private key not found process
     * @param boolean $boolean
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function setPrivateKeyNotFoundRedirect($boolean = null) {
        $this->isPrivateKeyNotFoundRedirect = $boolean;
    }
    
    
    /**
     * public key not found process function, will be overridden by
     * inherit classes
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function publicKeyNotFoundRedirect() {
         if($this->isServicePkRequired && $this->isPublicKeyNotFoundRedirect) {
             $forwarder = new \Utill\Forwarder\PublicNotFoundForwarder();
             $forwarder->redirect();  
         } else {
             return true;
         }
    }
    
    /**
     * get if to redirect due to public key not found process
     * @return boolean 
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function getPublicKeyNotFoundRedirect() {
        return $this->isPublicKeyNotFoundRedirect;
    }
    
    /**
     * set if to redirect due to public key not found process
     * @param boolean | null $boolean 
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function setPublicKeyNotFoundRedirect($boolean = null) {
        $this->isPublicKeyNotFoundRedirect = $boolean;
    }
    
    
    /**
     * determine if service needs private and public key
     * interragation
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
     public function servicePkRequired() {
         
     }
     
     /**
     * determine if service needs private key temp and public key temp
     * interragation
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
     public function servicePkTempRequired() {
         if($this->isServicePkTempRequired==null) {
             $params = $this->getRequestParams();
             if(substr(trim($params['url']),0,6) == 'pktemp') {
                $this->isServicePkTempRequired = true;
                return $this->isServicePkTempRequired ;
             }
             $this->isServicePkTempRequired = false;
             return $this->isServicePkTempRequired;
         } else {
             return $this->isServicePkTempRequired;
         }
     }
     
     /**
     * determine if service needs company private key interragation
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 09/06/2016
     */
     public function serviceCpkRequired() {
         if($this->isServiceCpkRequired==null) {
             $params = $this->getRequestParams();
             if(substr(trim($params['url']),0,5) == 'pkcpk') {
                $this->isServiceCpkRequired= true;
                return $this->isServiceCpkRequired ;
             }
             $this->isServiceCpkRequired= false;
             return $this->isServiceCpkRequired;
         } else {
             return $this->isServiceCpkRequired;
         }
     }
     
    /**
     * public key temp not found process function, will be overridden by
     * inherit classes
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 27/01/2016
     */
    public function privateKeyTempNotFoundRedirect() {
        if($this->isServicePkTempRequired && $this->privateKeyTempNotFoundRedirect) {
            $forwarder = new \Utill\Forwarder\PrivateTempNotFoundForwarder();
            $forwarder->redirect();
        } else {
            return true;
        }
    }
    
    /**
     * get variable for private key temp not found strategy
     * @return boolean
     * @author Mustafa Zeynel Dağlı
     * @since 27/01/2016
     */
    public function getPrivateKeyTempNotFoundRedirect() {
        return $this->privateKeyTempNotFoundRedirect;
    }
    
    /**
     * set variable for private key temp not found strategy
     * @param type $boolean
     * @author Mustafa Zeynel Dağlı
     * @since 27/01/2016  
     */
    public function setPrivateKeyTempNotFoundRedirect($boolean = null) {
        $this->privateKeyNotFoundRedirection = $boolean;
    }
    
    /**
     * set invalid call format redirect function
     * @param type $invalidCallFunc
     * @return string
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected function setInvalidCallFunc($invalidCallFunc) {
        return $this->invalidCallFunc = $invalidCallFunc;
    }
    
    /**
     * get invalid call format redirect function
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected function getInvalidCallFunc() {
        return $this->invalidCallFunc;
    }
    
    /**
     * set invalid call format redirect url
     * @param type $invalidCallUrl
     * @return string
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected function setInvalidCallUrl($invalidCallUrl) {
        return $this->invalidCallUrl = $invalidCallUrl;
    }
    
    /**
     * set encrytion class obj
     * @param \vendor\Encrypt\AbstractEncrypt $encrypyClass
     * @author Mustafa Zeynel Dağlı
     */
    public function setEncryptClass(\vendor\Encrypt\AbstractEncrypt $encryptClass = null) {
        try {
            if($encryptClass == null) {
                $this->encryptClass = new \Encrypt\EncryptManual($this->encryptKey);
                //print_r($this->encryptClass);
            } else {
                $this->encryptClass = $encryptClass;
            }
            return $this->encryptClass;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    /**
     * get encrytion class obj
     * @return \vendor\Encrypt\AbstractEncrypt
     * @author Mustafa Zeynel Dağlı
     */
    public function getEncryptClass() {
        if($this->encryptClass == null){
            $this->setEncryptClass();
        }else {
            return $this->encryptClass;
        }
    }
    
    /**
     * get invalid call format redirect url
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected function getInvalidCallUrl() {
        return $this->invalidCallUrl;
    }

    protected function prepareGetParams(array $paramsArray = null,
            array $ignoreParamList = null) {
        $params = null;
        if($this->isServicePkRequired) { 
            $paramsArray = $this->getRequestParamsWithoutPublicKey();
        } else if($this->isServicePkTempRequired) {
            $paramsArray = $this->getRequestParamsWithoutPublicKeyTemp();
        } else {
            $paramsArray = $this->getRequestParamsWithoutPublicKey();
        }
        if(!empty($ignoreParamList)) {
            foreach($paramsArray as $key=>$value) {
               if(!in_array ($key, $ignoreParamList)) {
                    $params .= $key.'='.urlencode (trim($value)).'&';
                }  
            }         
        } else {
             foreach($paramsArray as $key=>$value) {
                 $params .= $key.'='.urlencode (trim($value)).'&';
            }
        }
        $params = trim($params, '&');
        return $params;
        
    }
    
    /**
     * set full path url for rest api
     * framework
     * @param string $endpointFunction
     * @author Zeynel Dağlı
     * @version 0.0.1
     */
    protected function setRestApiFullPathUrl($restApiFullPathUrl) {
        $this->restApiFullPathUrl = $restApiFullPathUrl;
    }
    
    /**
     * get full path url for rest api
     * @return string
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected function getRestApiFullPathUrl() {
        return $this->restApiFullPathUrl;
    }
    
    
    /**
     * set end point function for rest api
     * framework
     * @param string $endpointFunction
     * @author Zeynel Dağlı
     * @version 0.0.1
     */
    protected function setRestApiEndPointFunction($restApiEndpointFunction = '') {
        $requestParams = $this->getRequestParams();
        //print_r($requestParams);
        if(isset($requestParams['url'])) {
            $this->restApiEndPointFunction = $requestParams['url'];
        }
    }
    
    /**
     * get rest api end point function
     * @return string
     * @author Mustafa Zeynel Dağlı
     * @since 0.2
     */
    protected function getRestApiEndPointFunction() {
        $this->restApiEndPointFunction == null ? $this->setRestApiEndPointFunction() : true ;
        return $this->restApiEndPointFunction;
    }
    
    /**
     * get proxy helper function name form redirect map array
     * @return string proxy helper function
     * @author Zeynel Dağlı 
     * @since 0.1
     */
    protected function resolveRedirectMap() {
        $this->getRestApiEndPointFunction();
        if(isset($this->redirectMap[$this->restApiEndPointFunction])) {
            return $this->redirectMap[$this->restApiEndPointFunction];
        } else {
            try {
                throw new \Exception('redirect map mapper bulunamadı');
            } catch (\Exception $exc) {
                //echo $exc->getTraceAsString();
                echo $exc->getMessage();
                exit();
                //return false;
            }

            
        }
        
    }
    
    /**
     *  will be implemented
     * in next versions
     * @param array
     * @author Zeynel Dağlı
     * @version 0.2
     */
    public function addRedirectMapFunction(array $redirectFunctionMapping = null) {
        
    }
    
    /**
     * setting redirection process for rest api
     * will be implemented on extended classes
     * @author Zeynel Dağlı
     * @version 0.2
     */
    public function redirect() {
        
    }
    
    /**
     * setting end point for rest api
     * this end point strategy may vary according to
     * rest service implementation
     * will be implemented on extended classes
     * @author Zeynel Dağlı
     * @version 0.2
     */
    public function setEndPointByClosure(array $EndPointClosure = null) {
        
    }
    
    /**
     * Rest api default call (Curl lib)
     * @author Mustafa Zeynel Dağlı
     * @version 0.2
     */
    public function restApiDefaultCall() {
        $params = null;
        $params = $this->getRequestParams();
        $preparedParams = $this->prepareGetParams();
        if (($ch = @curl_init()) == false) {
            header("HTTP/1.1 500", true, 500);
            die("Cannot initialize CURL session. Is CURL enabled for your PHP installation?");
        }
        //print_r($this->restApiFullPathUrl.'?'.$preparedParams);
        //print_r($this->restApiBaseUrl.$this->restApiEndPoint.$this->restApiEndPointFunction.'?'.$preparedParams);
        curl_setopt($ch, CURLOPT_URL, $this->restApiFullPathUrl.'?'.$preparedParams ); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , $this->getCallTimeOut()); //Timeout (Default 7 seconds)
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Public: 0',
            'X-Hash: 143444,12'
        ));
        curl_setopt($ch, CURLOPT_HEADER, 0); // we don’t want also to get the header information that we receive.
 
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
        if ($response == false) {
            die("curl_exec() failed. Error: " . curl_error($ch));
        }
 
        return $response;
    }
    
    /**
     * Rest api 'GET' call (Curl lib)
     * @author Mustafa Zeynel Dağlı
     * @version 0.2
     */
    public function restApiGetCall() {
        $params = null;
        $params = $this->getRequestParams();
        $preparedParams = $this->prepareGetParams();
        if (($ch = @curl_init()) == false) {
            header("HTTP/1.1 500", true, 500);
            die("Cannot initialize CURL session. Is CURL enabled for your PHP installation?");
        }
        //print_r($this->restApiFullPathUrl.'?'.$preparedParams);
        //print_r($this->endPointUrl.$this->getEndPointFunction().'?'.$preparedParams);
        curl_setopt($ch, CURLOPT_URL, $this->restApiFullPathUrl.'?'.$preparedParams ); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , $this->getCallTimeOut()); //Timeout (Default 7 seconds)
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Public: 0',
            'X-Hash: 143444,12'
        ));
        curl_setopt($ch, CURLOPT_HEADER, 0); // we don’t want also to get the header information that we receive.
 
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
        if ($response == false) {
            die("curl_exec() failed. Error: " . curl_error($ch));
        }
 
        return $response;
    }
    
    /**
     * Rest api 'POST' call (Curl lib)
     * @author Mustafa Zeynel Dağlı  
     * @version 0.2
     */
    public function restApiPostCall() {
        $params = null;
        $params = $this->getRequestParams();
        $preparedParams = $this->prepareGetParams();
        if (($ch = @curl_init()) == false) {
            header("HTTP/1.1 500", true, 500);
            die("Cannot initialize CURL session. Is CURL enabled for your PHP installation?");
        }
        //print_r($this->restApiFullPathUrl.'?'.$preparedParams);
        //print_r($this->endPointUrl.$this->getEndPointFunction().'?'.$preparedParams);
        curl_setopt($ch, CURLOPT_URL, $this->restApiFullPathUrl ); //Url together with parameters
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , $this->getCallTimeOut()); //Timeout (Default 7 seconds)
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Public: 0',
            'X-Hash: 143444,12'
        ));
        curl_setopt($ch, CURLOPT_HEADER, 0); // we don’t want also to get the header information that we receive.

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
        if ($response == false) {
            
            die("curl_exec() failed. Error: " . curl_error($ch));
        }
 
        return $response;
    }
    
    /**
     * public key temp not found process is being evaluated here
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3
     */
    public function publicKeyTempNotFoundRedirect() {
        if($this->isServicePkTempRequired && $this->isPublicTempKeyNotFoundRedirect) {
             $forwarder = new \Utill\Forwarder\PublicTempNotFoundForwarder();
             $forwarder->redirect();  
         } else {
             return true;
         }
    }
    
    /**
     * public key temp not found process is being evaluated here
     * @author Mustafa Zeynel Dağlı
     * @since version 0.3 09/06/2016
     */
    public function publicKeyCompanyNotFoundRedirect() {
        if($this->isServiceCpkRequired && $this->isPublicCompanyKeyNotFoundRedirect) {
             $forwarder = new \Utill\Forwarder\PublicCompanyNotFoundForwarder();
             $forwarder->redirect();  
         } else {
             return true;
         }
    }
    
    /**
     * set variable for public key temp not found strategy
     * @param type $boolean
     * @author Mustafa Zeynel Dağlı
     * @since 27/01/2016  
     */
    public function getPublicKeyTempNotFoundRedirect() {
        return $this->isPublicTempKeyNotFoundRedirect;
    }

    /**
     * get variable for public key temp not found strategy
     * @return boolean
     * @author Mustafa Zeynel Dağlı
     * @since 27/01/2016
     */
    public function setPublicKeyTempNotFoundRedirect($boolean = null) {
        $this->isPublicTempKeyNotFoundRedirect = $boolean;
    }

}

