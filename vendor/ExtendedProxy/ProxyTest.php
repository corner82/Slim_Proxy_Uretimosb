<?php

namespace vendor\ExtendedProxy;

class Proxy extends vendor\Proxy\Proxy {
    
public function __construct() {
    parent::__construct();
}

protected function getEndPointFunction() {
        
    }

   
    
    /**
     * setting redirection process for rest api
     * will be implemented on extended classes
     * @author Zeynel Dağlı
     * @version 0.2
     */
    public function redirect() {
        $execFunction = $this->resolveRedirectMap();
        $this->setEndPointByClosure();  
        echo $this->$execFunction();
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
        $endPointFunction = $this->getEndPointFunction();
        if (stripos($endPointFunction, "test")>0) {
            $this->setEndPointUrl("http://localhost/slim_test/index.php/");
        }
    }

}

