<?php

require_once __DIR__  . '/../../include/core.php';
require_once INCLUDE_DIR  . 'customers.php';

if (isset($_POST['buttonSubmit'])) {    
    # steps to do when form was submitted
    $error = null;
    $email = strtolower(trim(filter_input(INPUT_POST, 'email')));
    $password = filter_input(INPUT_POST, 'password');

    if (empty($email) || empty($password)) {
        echo $twig->render('Panel/login.html.twig', [
            'error' => 'Invalid Email and/or password. Please try again.'
        ]);
        exit;
    }

    $customer = new App\Customer();
    $customer->findByEmail($email);

    if (!($customer->exists() && $customer->isPasswordMatch($password))) {
        echo $twig->render('Panel/login.html.twig', [
            'error' => 'Invalid Email and(or) password. Please try again.'
        ]);
        exit;
    }

    if (!$customer->isActive()) {
        echo $twig->render('Panel/login.html.twig', [
            'error' => 'Your account is not validated. Please, use link from validation mail.'
        ]);
        exit;
    }



    #show panel main page
    header("Location: http://".$_SERVER['HTTP_HOST']."/accounts/main.php");
    exit;

}

echo $twig->render('Panel/login.html.twig', []);
