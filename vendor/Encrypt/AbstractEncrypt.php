<?php

namespace Encrypt;

abstract class AbstractEncrypt {
    
    protected $_key;
    protected $_base64=true;
    protected $_base32=false;
    protected $_base16=false;
    protected $_salt;
    protected function __construct()
    {

    }

    public function set_salt($salt="")
    {

    }
    public function get_salt()
    {

    }

    public function hash_value($value)
    {

    }

    //abstract public function encrypt($value="",$key="");
    //abstract public function decrypt($value="",$key="");

    /**
    * URL ve COOKIE elemanları Şifrelerken dikkat edilmesi gereken karakterleri düzenler
    *
    * @param string $value
    * @return string
    */
    public static  function base64_url_encode($value="")
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '='); 
    }

    /**
    * URL ve COOKIE elemanlarını Şifrelerken dikkat edilmesi gereken karakterleri düzenler
    *
    * @param string $value
    * @return string
    */
    public static  function base64_url_decode($value="")
    {
        return base64_decode(str_pad(strtr($value, '-_', '+/'), strlen($value) % 4, '=', STR_PAD_RIGHT)); 	
    }

    /**
    * Şifreleme işleminde kullanılacak anahtar elemanı yerleştirir
    *
    * @param string $key
    * @return void
    */
    public function set_key($key="")
    {
        $this->_key=$key;
    }

    /**
    * Şifreleme işleminde kullanılacak anahtar elemanı döndürür
    *
    * @return string 
    */
    public function get_key()
    {
        return $this->_key;
    }

    protected function set_base64($boolean)
    {
        $this->_base64=$boolean;
    }

    protected function get_base64($boolean)
    {
        return $this->_base64;
    }

    protected function set_base32($boolean)
    {
        $this->_base32=$boolean;
    }

    protected function get_base32($boolean)
    {
        return $this->_base32;
    }

    protected function set_base16($boolean)
    {
        $this->_base16=$boolean;
    }

    protected function get_base16($boolean)
    {
        return $this->_base16;
    }
    
}
