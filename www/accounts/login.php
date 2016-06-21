<?php

define('LOGIN_CHECK', false);

require_once __DIR__  . '/../../include/core.php';

$error = null;

if (isset($_POST['buttonSubmit'])) {    
    # steps to do when form was submitted
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    $customer = App\Customer::findByEmail($email);

    if (!($customer->exists() && $customer->isPasswordMatch($password))) {
        $error = 'Invalid email or password. Please try again.';
    } elseif (!$customer->isActive()) {
        $error = 'Your account is not validated. Please, use link from validation mail.';
    } else {
        session_start();
        $_SESSION['customer_id'] = $customer->getId();
        $_SESSION['customer_name'] = $customer->getName();
       
        redirectToPage('main');
        exit;
    }
}

echo $twig->render('Panel/login.html.twig', [
    'error' => $error
    ]);
