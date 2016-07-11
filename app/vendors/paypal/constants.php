<?php
$sandbox = FALSE;

if ($sandbox == TRUE)
{
    define('API_USERNAME', 'sandbox_username');
    define('API_PASSWORD', 'sandbox_password');
    define('API_SIGNATURE', 'sandbox_signature');
    define('API_ENDPOINT', 'https://api.sandbox.paypal.com/nvp');
    define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');
}
else
{
    define('API_USERNAME', 'live_username');
    define('API_PASSWORD', 'live_password');
    define('API_SIGNATURE', 'live_signature');
    define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
    define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');
}

define('USE_PROXY',FALSE);
define('PROXY_HOST', '127.0.0.1');
define('PROXY_PORT', '808');
define('VERSION', '3.0');
?> 