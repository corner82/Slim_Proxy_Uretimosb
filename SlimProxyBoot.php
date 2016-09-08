<?php
/**
 * ECOMAN Rest Api Proxy Library
 *
 * @link      https://github.com/Leadera/ecoman_slim/tree/ecoman_proxy for the canonical source repository
 * @copyright Copyright (c) 2014 - 2015 
 * @license   https://github.com/Leadera/ecoman_slim/blob/slim2/LICENSE
 * @author Zeynel Dağlı
 * @version 0.0.1
 */

/**
 * "Cross-origin resource sharing" özelliğinin farklı domainlerden 
 * proxy içine istek yaparken engel ve kısıtlarından kaçınılması
 * için koyulmuştur.
 * @author Mustafa Zeynel Dağlı
 * @since 2.10.2015
 */
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

/**
 * composer auto load class
 * @author Mustafa Zeynel Dağlı
 * @since version 0.4 09/06/2016
 */
require 'vendor/autoload.php';

//require_once 'vendor\SPR0\AutoLoad\spr0Loader.php';

/*$classLoader = new \SPR0\AutoLoad\spr0Loader("vendor", '');
$classLoader->register();*/

/*
require_once 'vendor\Proxy\AbstractProxy.php';
require_once 'vendor\Proxy\Proxy.php';   
require_once 'vendor\Slim\SlimTestProxy.php';*/


//$proxyClass = new \vendor\Slim\SlimTestProxy();
$proxyClass = new \Slim\SlimHmacProxy();
// $proxyClass->setRestApiBaseUrl("http://localhost/Slim_SanalFabrika/");
/**
 * bazı browser larda crossdomain hataları oluştuğu için yapısal değişiklik yapıldı.  
 * @since 23.12.2015
 * @author Okan CIRAN
 * 
 */ 
  $proxyClass->setRestApiBaseUrl("http://slim.uretimosb.com:9990/");
  //$proxyClass->setRestApiBaseUrl("http://sanalfabrika.slim.com:9990/");
//$proxyClass->setRestApiBaseUrl("https://slim.uretimosb.com/");
$proxyClass->setRestApiEndPoint("index.php/");
//$proxyClass->setEndPointUrl('http://88.249.18.205:8090/slim2_ecoman/index.php/');
//$ecoman->setEndPointUrl('http://88.249.18.205:8090/slim2_ecoman/index.php/');
echo $proxyClass->redirect();
