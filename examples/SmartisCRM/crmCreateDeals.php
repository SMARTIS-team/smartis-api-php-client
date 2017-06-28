<?php
/**
 * Created by PhpStorm.
 * User: ibalashov <igorhome5@yandex.ru>
 * Date: 01.06.17
 * Time: 20:27
 */

require_once("../../SmartisAPI.php");

$POST = Array(
    "action" => "crmCreateDeals",
    "token"  => Smartis_API::CRM_TOKEN,

    "items" => [
        [
            "external_id"   => 123,
            "lead_id"       => 1,
            "price"         => 8990,
            "pipeline_id"   => 34535,
            "pipeline_status_id" => 87687686,
        ],
    ]
);


$SmartisAPI = new Smartis_API($POST);

echo '
    <h4>Параметры запроса:</h4>
    <pre>'.print_r($SmartisAPI->REQUEST_PARAMS, true).'</pre>
    <hr>
    <h4>Результат выполнения:</h4>
    <pre>'.print_r($SmartisAPI->RESULT, true).'</pre>
';

echo '<pre>'.print_r(json_decode($SmartisAPI->RESULT, true), true).'</pre>';