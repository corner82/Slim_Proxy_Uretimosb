<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Proxy;

interface PrivateKeyNotFoundInterface {
    public function setPrivateKeyNotFoundRedirect($boolean = null);
    public function getPrivateKeyNotFoundRedirect();
    public function privateKeyNotFoundRedirect();
}