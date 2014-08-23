<?php

require_once '../token.php';
//require_once 'composer/vendor/autoload.php';
//require_once __DIR__ . '/composer/vendor/pear/http_request2/HTTP/Request2.php';
require_once __DIR__ . '/composer/vendor/autoload.php';
require_once 'HTTP/Request2.php';


class PostRequest {
    private $token;
    private $tokenHeaderKey = 'X-ChatWorkToken';
    private $baseURL = 'https://api.chatwork.com/v1/rooms/';
    private $roomId = '23818946';

    public function __construct($token) {
        $this->token = $token;
    }

    public function load($userId, $messageId = null) {
        if (!isset($userId)) { die('user id is not set'); }

        if (isset($messageId)) {
            $this->requestWithRe($messageId);
        } elseif (isset($userId)) {
            $this->requestWithTo($userId);
        } else {
            die('error occurred');
        }

//        $this->request($userId, $messageId);
    }

    private function requestWithRe($messageId) {
        die('reply function is not implemented yet');
//        $this->request($this->getPostURL(), $this->getGaxtu(''));
    }

    private function requestWithTo($userId) {
        $this->request($this->getPostURL(), $this->getGaxtu('[To:' . $userId . ']'));
    }

    private function getPostURL() {
        return $this->baseURL . $this->roomId . '/messages';
    }

    private function getGaxtu($anchor) {
        $list = getGatxuList($anchor);
        return $list[array_rand($list)];
//        return $list[0];
    }

    private function request($url, $body) {
        try {
            $request = new HTTP_Request2();

            $request->setConfig('ssl_verify_peer', false);
            $request->setConfig('ssl_verify_host', false);

            $request->setUrl($url);

//            $request->setMethod(HTTP_Request2::METHOD_GET);
            $request->setMethod(HTTP_Request2::METHOD_POST);
            $request->setHeader($this->tokenHeaderKey, $this->token);

            $request->addPostParameter('body', $body);

            $result = $request->send();
            echo $result->getBody();

        } catch (HTTP_Request2_Exception $e) {
            die($e->getMessage());
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}

function getGatxuList($anchor) {
    return array(
        '　　 （　・∀・）　　　|　|　ｶﾞｯ' . "\n" .
        '　　と　　　　）　 　 |　|\n'. "\n" .
        '　　　 Ｙ　/ノ　　　 人\n' . "\n" .
        '　　　　 /　）　 　 < 　>__Λ∩\n' . "\n" .
        '　　 ＿/し\'　／／. Ｖ｀Д´）/ ←' . $anchor . "\n" .
        '　　（＿フ彡　　　　　 　　/',
        $anchor . "\n" . 'ガッ！',
        $anchor . "\n" . '・・・・・・・・ガッ！',
    );
}


$pr = new PostRequest(getToken());
$pr->load('641867');
