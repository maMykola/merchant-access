<?php

require_once __DIR__  . '/../../include/core.php';
require_once INCLUDE_DIR  . 'customers.php';

# verify link
$customer = isLinkValid($_GET);

if (empty($customer)) {
    #show error validation page
    echo $twig->render('Signup/link-error.html.twig');
    exit;
}

# change customer's status in db
if (!activateCustomer($customer['id'])) {
    echo $twig->render('Signup/db-access-error.html.twig', [
        'message' => 'Some arror happens. Please, try to verify your account later.'
        ]); 
    exit;
}

# show success validation page
echo $twig->render('Signup/success.html.twig', [
    'action' => 'verified'
    ]);
