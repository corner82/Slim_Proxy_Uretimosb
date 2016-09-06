<?php

/**
 * Rest Api Proxy Library
 *
 * @author Zeynel Dağlı
 * @version 0.2
 * @todo Nonce parameter will be encrypted and decrypted in http request 'X-NONCE' parameter
 */
namespace Dal;

class Dal {
    public function __construct() {
        
    }
    
    /**
     * create PDO object and connect to database
     * @return boolean|\PDO
     * @author Mustafa Zeynel Dağlı
     * @since 05/01/2016
     */
    private function getPdo() {
        try {
            $pdo = new \PDO('pgsql:dbname=ostim_development;host=localhost;',
                            'postgres',
                            '1Qaaal123');
            return $pdo;
        } catch (PDOException $e) {
            return false;
        } 
    }
    
    /**
     * get company public key due to user public key
     * @param type $publicKey
     * @return type
     * @throws \PDOException
     * @author Mustafa Zeynel Dağlı
     * @since 09/06/2016
     */
    public function isUserBelongToCompany($userPublicKey, $companyPublicKey) {
        try {
            $resultSet = $this->getPrivateKey($userPublicKey);
            //print_r($resultSet);
            
            $pdo = $this->getPdo();
            
            $sql = "              
                    SELECT firm_id AS firm_id, 1=1 AS control FROM (
                            SELECT a.firm_id ,
                             CRYPT(sf_private_key_value,CONCAT('_J9..',REPLACE('".$companyPublicKey."','*','/'))) = CONCAT('_J9..',REPLACE('".$companyPublicKey."','*','/')) as cpk 
                            FROM info_firm_keys a                                                        
                INNER JOIN info_firm_profile ifp ON ifp.active =0 AND ifp.deleted =0 AND ifp.language_parent_id =0 AND a.firm_id = ifp.act_parent_id     
                INNER JOIN info_firm_users ifu ON ifu.user_id = " . intval($resultSet['resultSet'][0]['id']) . " AND ifu.language_parent_id =0 AND a.firm_id = ifu.firm_id
                ) AS xtable WHERE cpk = TRUE  limit 1
                    "; 
            
           // print_r($sql);
            
            $statement = $pdo->prepare($sql);  
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
           // print_r($result);

            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            return array("found" => true, "errorInfo" => $errorInfo, "resultSet" => $result);
        } catch (\PDOException $e /* Exception $e */) {
            $pdo->rollback();
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }
    
    
    /**
     * get private key due to public key
     * @param string $publicKey
     * @return type
     * @throws \PDOException
     * @author Mustafa Zeynel Dağlı
     * @since 05/01/2016
     */
    public function getPrivateKey($publicKey) {
        try {
            $pdo = $this->getPdo();
            
            $sql = "              
                    SELECT id,pkey,sf_private_key_value FROM (
                            SELECT id, 	
                                CRYPT(sf_private_key_value,CONCAT('_J9..',REPLACE('".$publicKey."','*','/'))) = CONCAT('_J9..',REPLACE('".$publicKey."','*','/')) as pkey,	                                
                                sf_private_key_value
                            FROM info_users WHERE active=0 AND deleted =0) AS logintable
                        WHERE pkey = TRUE

                    "; 
            
            //print_r($sql);
            
            $statement = $pdo->prepare($sql);  
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            //print_r($result);

            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            return array("found" => true, "errorInfo" => $errorInfo, "resultSet" => $result);
        } catch (\PDOException $e /* Exception $e */) {
            $pdo->rollback();
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }
    
    
     /**
     * is public key present for the request
     * @author Okan CIRAN
     * @ public key varsa True değeri döndürür.  !!
     * @version v 1.0  06.01.2016
     * @param array | null $args
     * @return array
     * @throws \PDOException
     */
    public function pkIsThere($params = array()) {
        
        try {
            $pdo = $this->getPdo();          
            $sql = "              
                    SELECT a.public_key =  '".$params['pk']."'
                    FROM act_session a                  
                    WHERE a.public_key =   '".$params['pk']."'
                    ";           
            
            $statement = $pdo->prepare($sql);            
            //echo debugPDO($sql, $params);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            return array("found" => true, "errorInfo" => $errorInfo, "resultSet" => $result);
        } catch (\PDOException $e /* Exception $e */) {
            $pdo->rollback();
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }
    
    /**
     * get private key temp due to public key temp
     * @param string $publicKey
     * @return type
     * @throws \PDOException
     * @author Mustafa Zeynel Dağlı
     * @since 27/01/2016
     */
    public function getPrivateKeyTemp($publicKeyTemp) {
        try {
            $pdo = $this->getPdo();
            
            $sql = "              
                    SELECT id,pkey,sf_private_key_value_temp FROM (
                            SELECT id, 	
                                CRYPT(sf_private_key_value_temp,CONCAT('_J9..',REPLACE('".$publicKeyTemp."','*','/'))) = CONCAT('_J9..',REPLACE('".$publicKeyTemp."','*','/')) as pkey,	                                
                                sf_private_key_value_temp
                            FROM info_users WHERE active=0 AND deleted =0) AS logintable
                        WHERE pkey = TRUE

                    "; 
            
            //print_r($sql);
            
            $statement = $pdo->prepare($sql);  
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            //print_r($result);

            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            return array("found" => true, "errorInfo" => $errorInfo, "resultSet" => $result);
        } catch (\PDOException $e /* Exception $e */) {
            $pdo->rollback();
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }
    
}
