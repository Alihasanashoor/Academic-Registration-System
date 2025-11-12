<?php       
/**
 * Keep secrets OUT of public HTML. This is included by server PHP only.
 */
return[
// Base URL of Payment API (your PHP -S server or Apache vhost)
'base_url' => 'http://localhost:8000',
//API key
'api_key'=> 'CHANGE_ME_SECRET_KEY',
];
?>