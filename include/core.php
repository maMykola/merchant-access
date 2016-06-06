<?php

require_once __DIR__ . '/constants.php';
require_once ROOT_DIR . 'vendor/autoload.php';



$loader = new \Twig_Loader_Filesystem(TWIG_TEMPLATES_DIR);
$twig = new \Twig_Environment($loader);
