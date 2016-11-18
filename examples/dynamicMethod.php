<?php
/**
 * Created by PhpStorm.
 * User: ibalasov <igorhome5@yandex.ru>
 * Date: 18.11.16
 * Time: 12:27
 */

$SmartisAPI = new Smartis_API();

$SmartisAPI->apiRequest('getDomains', []);

echo '
    <h4>Параметры запроса:</h4>
    <pre>'.print_r($SmartisAPI->REQUEST_PARAMS, true).'</pre>
    <hr>
    <h4>Результат выполнения:</h4>
    <pre>'.print_r($SmartisAPI->RESULT, true).'</pre>
';