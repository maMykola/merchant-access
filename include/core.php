<?php

require_once __DIR__ . '/constants.php';
require_once ROOT_DIR . 'vendor/autoload.php';
require_once INCLUDE_DIR . 'config.php';
require_once INCLUDE_DIR . 'helper_func.php';
require_once INCLUDE_DIR . 'db_func.php';
require_once INCLUDE_DIR . 'routes.php';

$loader = new \Twig_Loader_Filesystem(TWIG_TEMPLATES_DIR);
$twig = new \Twig_Environment($loader, [
 'debug' => ENVIRONMENT == DEVELOPMENT_MODE,
 ]);
$twig->addExtension(new \Twig_Extension_Debug());
$twig->addGlobal('app_environment', ENVIRONMENT);

$db_conn = mysql_connect(DB_CONFIG_HOST, DB_CONFIG_LOGIN, DB_CONFIG_PASSWORD);
mysql_select_db(DB_CONFIG_NAME, $db_conn);

if (!defined('LOGIN_CHECK') || LOGIN_CHECK == true) {
    # get user data from session
    if (!isset($_SESSION)) {
        session_start();
    }

    if (empty($_SESSION['customer_id'])) {
        redirectToPage('login');
    } else {
        $customer_id = $_SESSION['customer_id'];
        $customer_name = $_SESSION['customer_name'];
    }
}
