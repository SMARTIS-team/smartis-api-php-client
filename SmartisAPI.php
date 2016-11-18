<?php
/**
 * Created by PhpStorm.
 * User: ibalashov <igorhome5@yandex.ru>
 * Date: 17.11.16
 * Time: 12:35
 */
class Smartis_API {

    //const API_URL       = 'https://stat.smart-is.ru/api/';
    const API_URL       = 'http://localhost:8888/id108dev/api/';
    const API_TOKEN     = 'wYKvWFkfz4JvFUNkUR0A';
    const API_SIGNATURE = 'gO3Em6wq9MWlr3Zo';

    public static $CLIENT_ID    = '9';
    public static $CLIENT_TOKEN = 'htRotk53rn3kW5n3k5U63m2fh5';

    const HTTP_INTERFACE = 'auto'; //'auto': autodetect, 'curl' or 'fopen'

    function __construct($POST = Array()){

        if(!empty($POST['action']) && preg_match("/[$#&?><\'\"]/" , $POST['action'])==NULL){

            if(method_exists(__CLASS__, $POST['action'])){
                echo '<pre>'.print_r(json_decode($this->$POST['action']($POST), true), true).'</pre>';
            }
        }
    }

    function apiRequest($method, $POST = Array()){

        if(empty($method)) RETURN false;

        $POST['apiToken'] = self::API_TOKEN;
        $POST = $this->_signRequest($POST);

        if (self::HTTP_INTERFACE == 'auto')
            $interface = function_exists('curl_exec') ? 'curl' : 'fopen';
        else
            $interface = self::HTTP_INTERFACE;

        switch ($interface) {
            case 'curl':
                RETURN $this->_curlRequest($method, $POST);
            case 'fopen':
                RETURN $this->_fopenRequest($method, $POST);
            default:
                throw new Exception('Invalid http interface defined. No such interface "' . self::HTTP_INTERFACE . '"');
        }
    }

    private function _signRequest($POST = Array()){
        $all = "";
        foreach($POST as $v){
            $all .= $v;
        }
        $POST["apiSignature"] = md5($all.self::API_SIGNATURE);
        $all = null;

        RETURN $POST;
    }

    /**
     * HTTP request using native PHP fopen function
     * Requires PHP openSSL
     *
     * @param $method
     * @param null $post_variables
     * @param null $get_variables
     * @param null $headers
     * @return array
     */
    private function _fopenRequest($method, $post_variables = null, $get_variables = null, $headers = null) {

        $http_options = Array('method' => 'GET', 'timeout' => 3);

        $string_headers = '';
        if (is_array($headers)) {
            foreach ($headers as $key => $value) {
                $string_headers .= "$key: $value\r\n";
            }
        }

        if (is_array($get_variables)) {
            $get_variables = '?' . str_replace('&amp;', '&', urldecode(http_build_query($get_variables, '', '&')));
        }
        else {
            $get_variables = null;
        }

        if (is_array($post_variables)) {
            $post_variables = str_replace('&amp;', '&', urldecode(http_build_query($post_variables, '', '&')));
            $http_options['method'] = 'POST';
            $string_headers = "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($post_variables) . "\r\n" . $string_headers;
            $http_options['header'] = $string_headers;
            $http_options['content'] = $post_variables;
        }
        else {
            $post_variables = '';
            $http_options['header'] = $string_headers;
        }

        $context = stream_context_create(array('http' => $http_options));

        RETURN @file_get_contents(self::API_URL . $method. '/' . $get_variables, null, $context);
    }

    /**
     * @param string $method
     * @param array $POST
     * @return mixed
     */
    private function _curlRequest($method, $POST = Array()){
        echo '<h1>123</h1>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
        curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51");
        curl_setopt($ch, CURLOPT_URL, self::API_URL . $method. '/');

        //добавляем POST параметры если они были переданы в функцию
        if (is_array($POST)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($POST, '', '&'));
        }
        echo '<hr>POST:<pre>'.print_r($POST, true).'</pre>';
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $html = curl_exec($ch);
        echo '<hr>Пришел ответ:'.$html;
        curl_close($ch);

        RETURN $html;
    }


    function getDomainsList($POST = Array()){

        $method = 'getDomains';
        $POST = Array(
            "client_id"     => (!empty($POST['client_id'])) ? $POST['client_id'] : self::$CLIENT_ID,
        );

        RETURN $this->apiRequest($method, $POST);

    }

    function setTag($POST = Array()){

        $method = 'setTag';
        $POST = Array(
            "itemId"    => 201640927,
            "itemType"  => "comagic",
            "newTag"    => "не клиент",
            "dateOfUpdate" => GF::getTimeFromShort("02.10.16"),
        );

        RETURN $this->apiRequest($method, $POST);

    }

    function batchSetTag($POST = Array()){

        $method = 'batchSetTag';
        $POST = Array(
            "items" => Array(
                Array(
                    "itemId"    => 20164092700,
                    "itemType"  => "comagic",
                    "newTag"    => "не клиент",
                    "dateOfUpdate" => GF::getTimeFromShort("02.10.16")+3650,
                ),
                Array(
                    "itemId"    => 376354000,
                    "itemType"  => "scb",
                    "newTag"    => "В работе",
                    "dateOfUpdate" => GF::getTimeFromShort("02.10.16"),
                ),
            ),
        );

        RETURN $this->apiRequest($method, $POST);

    }
    function referrerQuality($POST = Array()){

        $method = 'referrerQuality';
        $POST = Array(
            "referrer" => "move.ru"
        );

        RETURN $this->apiRequest($method, $POST);

    }

}