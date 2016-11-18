<?php
/**
 * Created by PhpStorm.
 * User: ibalashov <igorhome5@yandex.ru>
 * Date: 18.11.16
 * Time: 12:21
 */

require_once("../SmartisAPI.php");

$POST = Array(
    "action"        => "setTag",

    "itemId"        => 201640927,
    "itemType"      => "comagic",
    "newTag"        => "не клиент",
    "dateOfUpdate"  => time(),
);

$SmartisAPI = new Smartis_API($POST);

echo '
    <h4>Параметры запроса:</h4>
    <pre>'.print_r($SmartisAPI->REQUEST_PARAMS, true).'</pre>
    <hr>
    <h4>Результат выполнения:</h4>
    <pre>'.print_r($SmartisAPI->RESULT, true).'</pre>
';