<?php
require_once __DIR__  . '/../include/core.php';
require_once INCLUDE_DIR  . 'customers.php';




if (isset ($_POST['buttonSubmit'])){

	# get customers registration data	
	$reg_data = customerFetchRegistration($_POST);

	# check input values

	$errors = customerValidateRegistration($reg_data);


	if (empty($errors) && (isset($_POST['buttonSubmit']))) {
		
		# save customer registration data into db
	 	$customer = customerSaveRegistration($reg_data);
	 
	 	# send email to confirm registration
	 	customerEmailConfirmation($customer);
	 	
	 	# display success registration page
		echo $twig->render('Signup/success.html.twig', [
			'customer'=>$reg_data
			]); 
	} 
	else {

		# display registration page with errors if any exist
		echo $twig->render('Signup/registration.html.twig', [
			'customer'=>$reg_data,
			'errors'=>$errors, 
			]);
	}

}
else {
	echo $twig->render('Signup/registration.html.twig', []);
}
