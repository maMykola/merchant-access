<?php

require_once __DIR__  . '/../../include/core.php';
require_once INCLUDE_DIR  . 'customers.php';

$customer = new App\Customer();

if (isset($_POST['buttonSubmit'])) {    
   # steps to do when form was submitted
}

echo $twig->render('Panel/login.html.twig', [
    'customer' => $customer
    ]);
