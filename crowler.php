<?php
/**
 * Created by PhpStorm.
 * User: nagata
 * Date: 14/08/23
 * Time: 13:31
 */

require_once __DIR__ .'/composer/vendor/autoload.php';
//require_once __DIR__ .'/composer/vendor/pear/http_request2/HTTP/Request2.php';
//require_once '/var/www/html/chatwork_nullpo/composer/vendor/pear/http_request2/HTTP/Request2.php';
require_once 'HTTP/Request2.php';

class crowler {

    public $httpRequestObj;
    public $response;
    public $cookie;

    public function __construct() {

        $this->httpRequestObj =& new HTTP_Request2();
        $this->cookie = array();
    }

    public function loginChatWork() {

        $httpRequestObj =& new HTTP_Request2();

        $url = 'https://www.chatwork.com/login.php?lang=ja&args=#!rid16545008';
        $httpRequestObj->setUrl($url);
        $httpRequestObj->setConfig(array('ssl_verify_peer'=>false));

        $httpRequestObj->setHeader('User-Agent', 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ja; rv:1.9.1.1) Gecko/20090715 Firefox/3.5.1 (.NET CLR 3.5.30729)');
        $httpRequestObj->setHeader('Keep-Alive', 115);
        $httpRequestObj->setHeader('Connection', 'keep-alive');
        $httpRequestObj->setHeader('Referer', $url);

        $httpRequestObj->addPostParameter('email', 'nagata@ryukyu-i.co.jp');
        $httpRequestObj->addPostParameter('password', 'yuki5752');

        $response = $httpRequestObj->send();
        $cookie = $response->getCookies();

        return($cookie);
    }

    public function getHTMLParam($cookie) {

        $url = 'https://www.chatwork.com/';
        $httpRequestObj = new HTTP_Request2($url);

        $httpRequestObj->setConfig(array('ssl_verify_peer'=>false));

        $httpRequestObj->setHeader('User-Agent', 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ja; rv:1.9.1.1) Gecko/20090715 Firefox/3.5.1 (.NET CLR 3.5.30729)');
        $httpRequestObj->setHeader('Keep-Alive', 115);
        $httpRequestObj->setHeader('Connection', 'keep-alive');
        $httpRequestObj->setHeader('Referer', $url);

        foreach($cookie as $loop) {
            $httpRequestObj->addCookie($loop['name'], $loop['value']);
        }
        $response = $httpRequestObj->send();
        var_dump($response);
        return $response->getBody();
    }

    public function parseHTMLString() {


    }
}

$con = new crowler();
$con->getMessageList();
//$cookie = $con->loginChatWork();
//$body = $con->getHTMLParam($cookie);
//var_dump($body);
