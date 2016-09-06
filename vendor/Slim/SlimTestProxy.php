<?php

namespace Slim;

class SlimTestProxy extends \Proxy {
    
     /**
     * a mapping array for related functions and proxy calls
     * to be executed
     * @var array()
     */
    protected $redirectMap = array('getReports_test' => 'restApiDefaultCall');
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function redirect() {
        $execFunction = $this->resolveRedirectMap();
        $this->setEndPointByClosure();  
        echo $this->$execFunction();
    }
    
    public function setEndPointByClosure(Array $EndPointClosure=null) {
        $endPointFunction = $this->getRestApiEndPointFunction();
        if (substr($endPointFunction, -5) == '_test') {
            //$this->setEndPointUrl("http://localhost/slim2_test/index.php/");
            $this->setRestApiFullPathUrl($this->restApiBaseUrl.$this->restApiEndPoint.$this->restApiEndPointFunction);
        }else {
            //$this->setEndPointUrl("http://localhost/slim2_test/".$this->getInvalidCallUrl()."/");
            //$this->setEndPointUrl("".$this->getRestApiBaseUrl()."/".$this->getInvalidCallUrl()."/");
            //$this->setEndPointFunction($this->getInvalidCallFunc());
        }
        
        
    }
    
}

