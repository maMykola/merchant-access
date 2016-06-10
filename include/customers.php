<?php

define('CUSTOMER_REQUIRED_FIELD', 'This is a required field.');
define('CUSTOMER_NAME_MALFORMED', 'Name contains deprecated characters. Allowed only alpha characters.');
define('CAPTCHA_SITEKEY', $captcha_keys['sitekey']);
define('CAPTCHA_SECRETEKEY', $captcha_keys['secretkey']);
use Phelium\Component\reCAPTCHA;

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
	$customer_info =[];
	if (isset ($_POST['buttonSubmit'])){
		$customer_info = [
			'name'=>$_POST['inputName'],
			'email'=>$_POST['inputEmail'],
			'password'=>$_POST['inputPassword'],
			'confirm_password'=>$_POST['inputConfirmPassword'],
		];
		if (ENVIRONMENT!='development') {
			$customer_info['captcha']=$_POST['g-recaptcha-response'];
		}
	}
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
	elseif (!isEmailValid($customer_info['email'])) {
			$errors['email'] = 'Please, enter valid Email';
	}
		#check if customer with given email already exists
	//else $merchant_exists = customerExists($reg_data);
	# check if a password is not empty
	if (empty($customer_info['password'])) {
		$errors['password'] = CUSTOMER_REQUIRED_FIELD;
	}
	# check if a confirm_password is not empty
	if (empty($customer_info['confirm_password'])) {
		$errors['confirm_password'] = CUSTOMER_REQUIRED_FIELD;
	}

	# check if a password is equal to confirmed password
	if ((!empty($customer_info['password'])) && ($customer_info['password'] != $customer_info['confirm_password'])) {
		$errors['confirm_password'] = 'Your password confirmation do not match your password';
	}
	# check if a google captcha is valid
	if (ENVIRONMENT != 'development') {
		if (!isGoogleCaptchaValid($customer_info['captcha'])) {
			$errors['captcha'] = 'Captha is not valid.';
		}
	}
	return $errors;

}


/**
 * Return true if Google Captcha is valid. Otherwise return false.
 *
 * @param string $captcha
 * @return boolean
 * @author Michael Strohyi
 **/
function isGoogleCaptchaValid($captcha)
{
	
	$reCAPTCHA = new reCAPTCHA(CAPTCHA_SITEKEY, CAPTCHA_SECRETEKEY);
	return $reCAPTCHA->isValid($captcha);
}




/**
 * Save customer registration data into db. Return customer info.
 *
 * @param array $form_data
 * @return array
 * @author Michael Strohyi
 **/
function customerSaveRegistration($form_data)
{
	$merchant_account = [
		'email' => strtolower($form_data['email']),
		'password' => md5($form_data['password']),
		'name' => $form_data['name'],
		'status' => 'added',
		'reg_date' => date("Y-m-d H:i:s"),
	];
	$query = "INSERT INTO `merchants` "._QInsert($merchant_account);
	$res = _QExec($query);
	if ($res !== false) {
		$merchant_account['id'] = _QID();
	}
	else {
		$merchant_account['id'] = 0;
	}
	
  	return $merchant_account;
}

/**
 * Send the confirmation link to customer's email
 *
 * @param array $customer
 * @return void
 * @author Michael Strohyi
 **/
function customerEmailConfirmation($customer)
{
	// !!! stub

}

/**
 * Check if customer with entered email already exists. Return customer info from db 
 * or empty array if does not exist
 *
 * @param array $merchant_account
 * @return array
 * @author Michael Strohyi
 **/
function customerExists($form_data)
{
	$query = "SELECT `id`, `status` FROM `merchants` WHERE `email` = "._QData($form_data['email']);
    _QExec($query);
	return  _QElem();
}