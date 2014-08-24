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
    private $roomId = '';

    public function __construct($token, $roomId) {
        $this->token = $token;
        $this->roomId = $roomId;
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
    }

    private function requestWithRe($messageId) {
        die('reply function is not implemented yet');
//        $this->request($this->getPostURL('messages'), 'POST', $this->getGaxtu(''));
    }

    private function requestWithTo($userId) {
//        $body = $this->getGaxtu('[To:' . $userId . ']' . $this->getUserNameFromId($userId));
        $body = $this->getGaxtu('[To:' . $userId . ']');
        $this->request($this->getPostURL('messages'), 'POST', $body);
    }

    private function getPostURL($type) {
        $url = '';
        switch ($type) {
            case 'messages':
                $url = $this->baseURL . $this->roomId . '/messages';
                break;
            case 'members':
                $url = $this->baseURL . $this->roomId . '/members';
                break;
        }
        return $url;
    }

    private function getGaxtu($anchor) {
        $list = getGatxuList($anchor);
        return $list[array_rand($list)];
    }

    private function request($url, $method, $body = '') {
        try {
            $request = new HTTP_Request2();

            $request->setConfig('ssl_verify_peer', false);
            $request->setConfig('ssl_verify_host', false);

            $request->setUrl($url);

            if (strtolower($method) == 'post') {
                $request->setMethod(HTTP_Request2::METHOD_POST);
            } elseif (strtolower($method) == 'get') {
                $request->setMethod(HTTP_Request2::METHOD_GET);
            }

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

    private function getUserNameFromId($Id) {
        $response = json_decode($this->request($this->getPostURL('members'), 'GET'));
        echo "\n\n ${response['name']} \n\n";
        die('');
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


//$pr = new PostRequest(getToken(), '23818946');
//$pr->load('641867');
