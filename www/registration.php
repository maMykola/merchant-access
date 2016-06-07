<?php
require_once __DIR__  . '/../include/core.php';
require_once INCLUDE_DIR  . 'customers.php';


# get customers registration data	
$reg_data = customerFetchRegistration($_POST);
$errors = [];

if (isset ($_POST['buttonSubmit'])){

	# check input values

	$errors = customerValidateRegistration($reg_data);


	if (empty($errors)) {
		
		#check if customer with given email already exists
		$merchant_exists = customerExists($reg_data);
		if (empty($merchant_exists)) {
			# if customer does not exist

			# save customer registration data into db
		 	$customer = customerSaveRegistration($reg_data);
		 	if ($customer['id']!==0) {
		 		# if registration data saved in db successfully
		 		
		 		# send email to confirm registration
		 		customerEmailConfirmation($customer);
		 		
		 		# display success registration page
				echo $twig->render('Signup/success.html.twig', [
					'customer'=>$reg_data
					]); 
			}
			else{
				# if registration data not saved in db
				# display error registration page
				echo $twig->render('Signup/error.html.twig', [
					'customer'=>$reg_data, 
					'reg_status'=> 'query_error',
					]); 
			}
		}

		else {
			# if customer already exists
			# display page with alert 
			echo $twig->render('Signup/error.html.twig', [
				'customer'=>$reg_data,
				'reg_status'=> 'customer_exists',
				]); 
		}
	exit;
	}
}
# display registration page with errors if any exist
echo $twig->render('Signup/registration.html.twig', [
	'customer'=>$reg_data,
	'errors'=>$errors, 
	'sitekey'=>$captcha_keys['sitekey'],
	]);