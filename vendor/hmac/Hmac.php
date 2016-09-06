<?php

/**
 * Rest Api Proxy Library
 *
 * @author Zeynel Dağlı
 * @version 0.2
 * @todo Nonce parameter will be encrypted and decrypted in http request 'X-NONCE' parameter
 */
namespace Hmac;

class Hmac {
    
    protected $hash;
    
    protected $publicKey;
    
    protected $privateKey;
    
    protected $requestParams = array();
    
    protected $nonce;
    
    protected $timeStamp;
    
    public function __construct() {
        
    }
    
    public function setHash($hash = null) {
        $this->hash = $hash;
    }
    
    public function getHash() {
        return $this->hash;
    }
    
    /**
     * to make every request hash , random variables
     * are inserted into hash cretae mechanism, this function
     * sets random parameter
     * @param string | null $nonce
     * @author Mustafa Zeynel Dağlı
     */
    public function setNonce($nonce = null) {
        if($nonce == null) {
            $this->nonce = md5(time().rand());
        } else {
            $this->nonce = $nonce;
        }        
        //print_r('!!!!'.$this->nonce.'!!!!');
    }
    
    /**
     * get random parameter for hash mechanism
     * @return string | null
     * @author Mustafa Zeynel Dağlı
     */
    public function getNonce() {
        //if($this->nonce==null) $this->setNonce();
        //print_r('// get nonce()--'.$this->nonce.'//');
        return $this->nonce;
    }
    
     /**
     * set timestamp 
     * framework
     * @param string $timeStamp
     * @author Okan Cıran
     * @version 0.0.1
     */
      public function setTimeStamp($timeStamp = null) {
        if($timeStamp == null) {
            $this->timeStamp = time();
         } else {
            $this->timeStamp = $timeStamp;
        }  
        return $this->timeStamp;
    }
    
     /**
     * get timestamp 
     * framework
     * 
     * @author Okan Cıran
     * @version 0.0.1
     */
    public function getTimeStamp() {
        return $this->timeStamp;
    }   
    
     /**
     * difference timestamp 
     * framework
     * @param string $timeStamp
     * @author Okan Cıran
     * @version 0.0.1
     */
      public function differenceTimeStamp() {
        if($this->timeStamp != null) {
            return time() - $this->timeStamp;
         } else {
            return null;
        } 
        // print_r('// differenceTimeStamp()--'.$this->differenceTimeStamp().'//');
    } 
       
    public function makeHmac() {
        $this->setNonce();
        $this->hash = hash_hmac('sha256', hash_hmac('sha256', json_encode($this->requestParams),  $this->getNonce()), $this->privateKey);
        //print_r('--'.$this->hash.'--');
        //$this->hash = hash_hmac('sha256', json_encode($this->requestParams), $this->privateKey);
    }
    
    public function setPublicKey($publicKey = null) {
        $this->publicKey = $publicKey;
    } 
    
    public function getPublicKey() {
        return $this->publicKey;
    }
    
    public function setPrivateKey($privateKey = null) {
        $this->privateKey = $privateKey;
    }
    
    public function getPrivateKey() {
        return $this->privateKey;
    }
    
    public function setRequestParams($requestParams = null) {
        $this->requestParams = $requestParams;
    }
    
    public function getRequestParams() {
        return $this->requestParams;
    }
}
