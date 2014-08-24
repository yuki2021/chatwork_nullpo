<?php

header('Access-Control-Allow-Origin: *');

/**
 * Created by PhpStorm.
 * User: nagata
 * Date: 14/08/23
 * Time: 16:37
 */

require_once '../token.php';
require_once __DIR__ .'/PostRequest.php';

require_once(__DIR__ .'/composer/vendor/autoload.php');
require_once(__DIR__ .'/composer/vendor/sunra/php-simple-html-dom-parser/Src/Sunra/PhpSimple/simplehtmldom_1_5/simple_html_dom.php');

class loadHTML {

    public $html;

    public function __construct() {

        $this->html = $this->getHTMLStr();
    }

    public function pearceHTML() {

        $nullpo_obj = new PostRequest(getToken(), '23818946');

        $pearceObj = \simplehtmldom_1_5\str_get_html($this->html);
        //foreach($pearceObj->find('div[class=_chatTimeLineMessageBox chatTimeLineMessageInner]') as $loop1) {
            $i = 0;
            foreach($pearceObj->find('div[class=chatTimeLineMessageArea clearfix]') as $loop2) {
            //foreach($pearceObj->find('div',0) as $loop2) {
                //$time_str = $loop1->find('div', 1)->plaintext;
                $nullpo_str = $loop2->find('pre', 0)->plaintext;
                //echo $nullpo_str;
                //if(preg_match('/ぬるぽ/', $nullpo_str) !== false) {
                if(strstr($nullpo_str, 'ぬるぽ') !== false) {
                    if($i <= 1) {
                       echo 'false';
                       //$nullpo_obj->load('641867');
                       @$nullpo_obj->load('641867');
                       $i++;
                    }
                }

            }
        //}
    }

    public function getHTMLStr() {

        $return_str = '';

        if(!empty($_POST['timeLine'])) {
            $return_str = $_POST['timeLine'];
            $return_str = html_entity_decode($return_str);
        } else {

            $fp = @fopen('./timeLine.html', 'r');
            while(!feof($fp)) {
                $return_str .= fgets($fp);
            }
            fclose($fp);
        }

        return $return_str;
    }
}

$con = new loadHTML();
$con->pearceHTML();


