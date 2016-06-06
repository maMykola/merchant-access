<?php

define('CUSTOMER_REQUIRED_FIELD', 'This is a required field.');
define('CUSTOMER_NAME_MALFORMED', 'Name contains deprecated characters. Allowed only alpha characters.');

/**
 * Return customer information gathered from the given $form_Data. 
 * Keep not existing fields empty.
 *
 * @param array $form_data
 * @return array
 * @author Michael Strohyi
 **/
function customerFetchRegistration ($form_data)
{
	// !!! stub
	/*$customer_info=[
		'name' => 'John Doe',
		'email' => 'John.Doe@example.com',
		'password' => 'JohnPassword',
		'confirm_password' => 'JohnPassword',
		'captcha' => [],
		];*/

	$customer_info = [
		'name'=>$_POST['inputName'],
		'email'=>$_POST['inputEmail'],
		'password'=>$_POST['inputPassword'],
		'confirm_password'=>$_POST['inputConfirmPassword'],
		'captcha'=>$_POST['g-recaptcha-response'],
	];
	return $customer_info;
		
}

/**
 * Return empty list if no errors in customer registration data.
 * Otherwise return list of errors (where keys are field names).
 *
 * @param array $customer_info
 * @return array
 * @author Michael Strohyi
 **/
function customerValidateRegistration($customer_info)
{
	// !!! stub
	/*
	$errors = [
		'name'=>'Name Error', 
		'email'=>'eEmail Error', 
		'password'=>'Password Error', 
		'confir_password'=>'Confirmation Error', 
		'captcha'=>'Captcha Error',
		];
	*/
	# initialize empty errors
	$errors = [];
	
		# check if name is not empty
	if (empty($customer_info['name'])) {
		$errors['name'] = CUSTOMER_REQUIRED_FIELD;
	}
	# check if a name has only allowed characters (alpha only)
	elseif (!preg_match('#^[a-z]+(\s[a-z]+)?$#i', $customer_info['name'])) {
		$errors['name'] = CUSTOMER_NAME_MALFORMED;
	}
	# check if an email is not empty
	if (empty($customer_info['email'])) {
		$errors['email'] = CUSTOMER_REQUIRED_FIELD;
	}
	# check if an email has a valid form
	if (!isEmailValid($customer_info['email'])) {
		$errors['email'] = 'Please, enter valid Email';
	}
	# check if a password is not empty
	if (empty($customer_info['password'])) {
		$errors['password'] = CUSTOMER_REQUIRED_FIELD;
	}
	# check if a confirm_password is not empty
	if (empty($customer_info['confirm_password'])) {
		$errors['confirm_password'] = CUSTOMER_REQUIRED_FIELD;
	}

	# check if a password is equal to confirmed password
	if ($customer_info['password'] != $customer_info['confirm_password']) {
		$errors['confirm_password'] = 'Your password confirmation do not match your password';
	}
	# check if a google captcha is valid
	if (!isGoogleCaptchaValid($customer_info['captha'])) {
		$errors['captcha'] = 'Captha is not valid.';
	}
	return $errors;

}


/**
 * Return true if Google Captcha is valid. Otherwise return false.
 *
 * @param $captcha
 * @return boolean
 * @author Michael Strohyi
 **/
function isGoogleCaptchaValid($captcha)
{
	// !!! stub
	return true;
}


/**
 * Return true if Email is valid. Otherwise return false.
 *
 * @param $email
 * @return boolean
 * @author Michael Strohyi
 **/
function isEmailValid($email)
{
	// !!! stub
	return true;
}

/**
 * Save customer registration data into db. Return customer info.
 *
 * @param $form_data
 * @return array
 * @author Michael Strohyi
 **/
function customerSaveRegistration($form_data)
{
	// !!! stub
	return [];
}

/**
 * Send the confirmation link to customer's email
 *
 * @param $customer
 * @return void
 * @author Michael Strohyi
 **/
function customerEmailConfirmation($customer)
{
	// !!! stub
	
}