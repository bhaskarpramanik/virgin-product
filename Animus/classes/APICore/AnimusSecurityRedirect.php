<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimusSecurityRedirect
 *
 * @author bbhask1x
 */
require_once "AnimusUnconditionalRedirect.php";
class AnimusSecurityRedirect extends AnimusUnconditionalRedirect {
    public function setRedirectType($_redirectType = "SECURITY_REDIRECT") {
        parent::setRedirectType($_redirectType);
    }
    public function setRedirectCause($_redirectCause="Access Forbidden.") {
        parent::setRedirectCause($_redirectCause);
    }
    public function setRedirectHeaderCode($_redirectHeaderCode=403) {
        parent::setRedirectHeaderCode($_redirectHeaderCode);
    }
}
