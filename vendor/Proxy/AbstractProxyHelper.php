<?php
/**
 * ECOMAN Rest Api Proxy Library
 *
 * @link      https://github.com/Leadera/ecoman_slim/tree/ecoman_proxy for the canonical source repository
 * @copyright Copyright (c) 2014 - 2015 
 * @license   https://github.com/Leadera/ecoman_slim/blob/slim2/LICENSE
 * @author Zeynel Dağlı
 * @version 0.0.1
 * @deprecated since version 0.2
 */

namespace Proxy;

/**
 * base abstract class for proxy helpers
 */
abstract class AbstractProxyHelper {
    protected $proxyClass;
    
    
    


    /**
     * set proxy class
     * @param \OAuth2\SlimProxyClass $proxyClass
     * @author Zeynel Dağlı 
     * @since 0.0.1
     */
    public function setProxyClass(\Proxy\Proxy\AbstractProxy $proxyClass) {
        $this->proxyClass = $proxyClass;
    }
    
    /**
     * return proxy class
     * @return \Proxy\Prox\AbstractProxy
     * @author Zeynel Dağlı 
     * @since 0.0.1
     */
    public function getProxyClass() {
        return $this->proxyClass;
    }
  
}
