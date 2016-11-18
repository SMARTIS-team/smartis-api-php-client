<?php
/**
 * Created by PhpStorm.
 * User: ibalashov <igorhome5@yandex.ru>
 * Date: 18.11.16
 * Time: 12:25
 */

require_once("../SmartisAPI.php");

$POST = Array(
    "action"        => "batchSetTag",

    "items" => Array(
        Array(
            "itemId"    => 20164092700,
            "itemType"  => "comagic",
            "newTag"    => "не клиент",
            "dateOfUpdate" => time(),
        ),
        Array(
            "itemId"    => 376354000,
            "itemType"  => "scb",
            "newTag"    => "В работе",
            "dateOfUpdate" => time(),
        ),
    ),
);


$SmartisAPI = new Smartis_API($POST);


echo '
    <h4>Параметры запроса:</h4>
    <pre>'.print_r($SmartisAPI->REQUEST_PARAMS, true).'</pre>
    <hr>
    <h4>Результат выполнения:</h4>
    <pre>'.print_r($SmartisAPI->RESULT, true).'</pre>
';