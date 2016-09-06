<?php

namespace Encrypt;

class EncryptManual extends \Encrypt\AbstractEncrypt {
    private $_mcrypt_algorithms=array();
    private $_mcrypt_algorithm=MCRYPT_RIJNDAEL_256;
    private $_mcrypt_algorithms_dir;
    private $_mcrypt_modes=array();
    private $_mcrypt_mode=MCRYPT_MODE_ECB;
    private $_mcrypt_modes_dir;
    
    public function __construct()
    {

    }

    public static function static_encrypt($value,$key,$crypt_mode=MCRYPT_MODE_ECB,$crypt_algorithm=MCRYPT_RIJNDAEL_256)
    {
        if(extension_loaded("mcrypt"))
        {
        $iv_size = mcrypt_get_iv_size($crypt_algorithm,$crypt_mode);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
        $crypttext = mcrypt_encrypt($crypt_algorithm,$key,$value,$crypt_mode, $iv);
        return trim(self::base64_url_encode($crypttext));
        }
        return false;
    }

    public static function static_decrypt($value,$key,$crypt_mode=MCRYPT_MODE_ECB,$crypt_algorithm=MCRYPT_RIJNDAEL_256)
    {
        $crypttext = self::base64_url_decode($value); 
        $iv_size = mcrypt_get_iv_size($this->_mcrypt_algorithm, $this->_mcrypt_mode);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
        $decrypttext = mcrypt_decrypt($this->_mcrypt_algorithm, $this->_key, $crypttext,$this->_mcrypt_mode, $iv);
        return trim($decrypttext);
    }

    public function encrypt($value="",$key="")
    {
        if (extension_loaded("mcrypt"))  
        {
            //$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv_size = mcrypt_get_iv_size($this->_mcrypt_algorithm,$this->_mcrypt_mode);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
            $crypttext = mcrypt_encrypt($this->_mcrypt_algorithm, $this->_key, $text,$this->_mcrypt_mode, $iv);
            return trim(self::base64_url_encode($crypttext));
        }
        return false;
    }

    public function decrypt($value="",$key="")
    {
        $crypttext = self::base64_url_decode($value); 
        $iv_size = mcrypt_get_iv_size($this->_mcrypt_algorithm, $this->_mcrypt_mode);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
        $decrypttext = mcrypt_decrypt($this->_mcrypt_algorithm, $this->_key, $crypttext,$this->_mcrypt_mode, $iv);
        return trim($decrypttext);
    }

    public function set_mcrypt_mode($mcrypt_mode)
    {
        if(empty($this->_mcrypt_modes))
        {
                $this->set_mcrypt_modes();
                if(in_array("".$mcrypt_mode."",$this->_mcrypt_modes))
                {
                        $this->_mcrypt_mode=$mcrypt_mode;
                        return true;
                }
                return false;
        }
        else 
        {
                if(in_array("".$mcrypt_mode."",$this->_mcrypt_modes))
                {
                        $this->_mcrypt_mode=$mcrypt_mode;
                        return true;
                }
                return false;
        }
    }

    public function set_mcrypt_modes()
    {
        $this->_mcrypt_modes=mcrypt_list_modes($this->_mcrypt_modes_dir);
    }

    public function set_mcrypt_algorithm($mcrypt_algorithm)
    {
        if(empty($this->_mcrypt_algorithms))
        {
                $this->set_mcrypt_algoritms();
                if(in_array("".$mcrypt_algorithm."",$this->_mcrypt_algorithms))
                {
                        $this->_mcrypt_algorithm=$mcrypt_algorithm;
                        return true;
                }
        }
        else 
        {
                if(in_array("".$mcrypt_algorithm."",$this->_mcrypt_algorithms))
                {
                        $this->_mcrypt_algorithm=$mcrypt_algorithm;
                        return true;
                }
        }
        return false;
    }


    private function set_mcrypt_algoritms()
    {
        $this->_mcrypt_algorithms=mcrypt_list_algorithms($this->_mcrypt_algorithms_dir);
    }

    public function set_mcrypt_modes_dir($dir)
    {
        $this->_mcrypt_modes_dir=$dir;
    }

    public function get_mcrypt_modes_dir()
    {
        return $this->_mcrypt_modes_dir;
    }

    public function set_mcrypt_algorith_dir($dir)
    {
        $this->_mcrypt_algorithms_dir=$dir;
    }

    public function get_mcrypt_algorith_dir()
    {
        return $this->_mcrypt_algorithms_dir;
    } 

}
