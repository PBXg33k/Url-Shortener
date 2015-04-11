<?php

/**
 * ControllerBase class
 * 
 * This controller contains shared logic which can be used by all descendants of this class.
 * See this class as a half assed abstract class
 * 
 * @author Oguzhan Uysal <development.php@oguzhanuysal.eu>
 * @package g33kSoft\Shortlinker
 * @version 1.0.1
 * 
 * @since 1.0.1 CloudFlare support added. When using CLoudFlare real user IP will be returned.
 */
class ControllerBase extends \Phalcon\Mvc\Controller {

    public function getUserIP() {
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

}