<?php

define('CUSTOMER_REQUIRED_FIELD', 'This is a required field.');
define('CUSTOMER_NAME_MALFORMED', 'Name contains deprecated characters. Allowed only alpha characters.');
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
	if (!isGoogleCaptchaValid($customer_info['captcha'])) {
		$errors['captcha'] = 'Captha is not valid.';
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
	// !!! stub

	$reCAPTCHA = new reCAPTCHA('6LdkhwITAAAAAESYoe0uBsVTji1VlqTdRjBqiiv6', '6LdkhwITAAAAAGbzE8f6dOpAfXtXiMVjGZd9lWUV');
	return $reCAPTCHA->isValid($captcha);
}


/**
 * Return true if given $email has a valid form.
 *
 * @param  string  $email
 * @return boolean
 */
function isEmailValid($email)
{
  // First, we check that there's one @ symbol,
  // and that the lengths are right.
  if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
    // Email invalid because wrong number of characters
    // in one section or wrong number of @ symbols.
    return false;
  }

  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/",
            $local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not,
  // it should be valid domain name
  if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
      return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/",
              $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
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
	// !!! stub
	return [];
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