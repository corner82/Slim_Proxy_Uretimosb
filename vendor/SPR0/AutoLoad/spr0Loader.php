<?php

/**
 * SplClassLoader implementation that implements the technical interoperability
 * standards for PHP 5.3 namespaces and class names.
 *
 * http://groups.google.com/group/php-standards/web/final-proposal
 *
 *     // Example which loads classes for the Doctrine Common package in the
 *     // Doctrine\Common namespace.
 *     $classLoader = new SplClassLoader('Doctrine\Common', '/path/to/doctrine');
 *     $classLoader->register();
 *
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Roman S. Borschel <roman@code-factory.org>
 * @author Matthew Weier O'Phinney <matthew@zend.com>
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 * @author Fabien Potencier <fabien.potencier@symfony-project.org>
 */
namespace SPR0\AutoLoad;

class spr0Loader
{
    private $_fileExtension = '.php';
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = '\\';
    private $_class_name_replace=false;

    /**
     * class ismindeki '_' karakterlerinin replace edilerek
     * directory name içerisine eklenip eklenmeyeceğini kontrol eden 
     * değişken değeri set ediliyor
     * @param boolean $class_name_replace_boolean
     */
    public function set_class_name_replace($class_name_replace_boolean)
    {
        $this->_class_name_replace=$class_name_replace_boolean;
    }
    
    /**
     * class ismindeki '_' karakterlerinin replace edilerek
     * directory name içerisine eklenip eklenmeyeceğini kontrol eden 
     * değişken değeri çağırılıyor
     * @return boolean
     */
    public function get_class_name_replace()
    {
        return $this->_class_name_replace;
    }

        /**
     * Creates a new <tt>SplClassLoader</tt> that loads classes of the
     * specified namespace.
     * 
     * @param string $ns The namespace to use.
     */
    public function __construct($ns = null, $includePath = null)
    {
        $this->_namespace = $ns;
        $this->_includePath = $includePath;
    }

    /**
     * Sets the namespace separator used by classes in the namespace of this class loader.
     * 
     * @param string $sep The separator to use.
     */
    public function setNamespaceSeparator($sep)
    {
        $this->_namespaceSeparator = $sep;
    }

    /**
     * Gets the namespace seperator used by classes in the namespace of this class loader.
     *
     * @return void
     */
    public function getNamespaceSeparator()
    {
        return $this->_namespaceSeparator;
    }

    /**
     * Sets the base include path for all class files in the namespace of this class loader.
     * 
     * @param string $includePath
     */
    public function setIncludePath($includePath)
    {
        $this->_includePath = $includePath;
    }

    /**
     * Gets the base include path for all class files in the namespace of this class loader.
     *
     * @return string $includePath
     */
    public function getIncludePath()
    {
        return $this->_includePath;
    }

    /**
     * Sets the file extension of class files in the namespace of this class loader.
     * 
     * @param string $fileExtension
     */
    public function setFileExtension($fileExtension)
    {
        $this->_fileExtension = $fileExtension;
    }

    /**
     * Gets the file extension of class files in the namespace of this class loader.
     *
     * @return string $fileExtension
     */
    public function getFileExtension()
    {
        return $this->_fileExtension;
    }

    /**
     * Installs this class loader on the SPL autoload stack.
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Uninstalls this class loader from the SPL autoloader stack.
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Loads the given class or interface.
     *
     * @param string $className The name of the class to load.
     * @return void
     */
    public function loadClass($className)
    {
        /*
        echo "</br>loadclass SplClassLoader-->class-->".$className;
        echo "</br>loadclass SplClassLoader-->namespace-->".$this->_namespace;
        echo "</br>loadclass SplClassLoader-->_namespaceSeparator-->".$this->_namespaceSeparator;
        echo "</br>loadclass substr-->".substr($className, 0, strlen($this->_namespace.$this->_namespaceSeparator));
        echo "</br>loadclass namespace+namespace_seperator-->".$this->_namespace.$this->_namespaceSeparator;
        */ 
        
        if (null === $this->_namespace || $this->_namespace.$this->_namespaceSeparator === substr($className, 0, strlen($this->_namespace.$this->_namespaceSeparator))) {
            //echo "</br>testttt";
            $fileName = '';
            $namespace = '';
            if (false !== ($lastNsPos = strripos($className, $this->_namespaceSeparator))) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
                /*
                echo "</br>SplClassLoader filename-->".str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
                echo "</br>SplClassLoader classname-->".$className;
                 */
            }
            /**
             * 05-11-2013 Mustafa Zeynel Dağlı
             * class ismindeki '_' karakterlerinin dizin olarak tanımlanıp tanımlanmayacağı
             * kriterine göre aşağıdaki kontrol bloğu eklenmiştir.
             */
            if($this->_class_name_replace)
            {
                $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . $this->_fileExtension;
            }
            else {
                $fileName .= $className. $this->_fileExtension;
            }
            /*
            echo "</br>required file--->".$this->_includePath . DIRECTORY_SEPARATOR.$fileName;
            echo "</br>namespace--->".__NAMESPACE__;
            */
            include ($this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : '') . $fileName;  
        }
    }
}


