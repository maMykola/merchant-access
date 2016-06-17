<?php

/**
 * Send the confirmation link to customer's email
 *
 * @param App\Customer $customer
 * @return void
 * @author Michael Strohyi
 **/
function customerEmailConfirmation($customer)
{
    // !!! stub
    $subject = 'Verify your registration at ' . SIGNUP_SERVER;
    $message = getEmailMessage('account_verification', $customer);
    if (!(defined('ENVIRONMENT') && ENVIRONMENT == 'development')) { 
    	 mail($customer->getEmail(), $subject, $message);
   	} else {
   	// stub echo
		echo "Subject: $subject <br> Message:<br> $message";
	//end of stub echo
   	}

}

/**
 * Return text of email according to set $template
 *
 * @param string $template
 * @param App\Customer $customer
 * @return string
 * @author Michael Strohyi
 **/
function getEmailMessage($template, $customer)
{
  	// !!! stub
  	return getTwig()->render("Email/${template}.html.twig", [
    		'customer' => $customer, 
    		'server' => SIGNUP_SERVER,
    		]);
}

/**
 * Return customer's info if link is valid, otherwise return empty array.
 *
 * @param array $get
 * @return array
 * @author Michael Strohyi
 **/
function isLinkValid($get)
{
    if (!isset($get['id']) || !isset($get['hash'])) {
        return [];
    }

    $query = "SELECT `email`, `name`, `status` FROM `merchants` WHERE `id` = ${get['id']}";
    _QExec($query);
    $res_element = _QElem();

    if(empty($res_element)) {
        return [];
    }
    
    if ($get['hash'] != md5($res_element['email'] . $get['id']) || $res_element['status'] != 'added') {
        return [];
    }

    return ['id' => $get['id'],
        'name' => $res_element['email'],
        ];
}

/**
 * Change status to 'active' in db for customer with given $id and return true.
 * Return false if some error happens
 *
 * @param int $id
 * @return boolean
 * @author Michael Strohyi
 **/
function activateCustomer($id)
{
    // !!! stub
    return true;
    //end of stub
    $query = "UPDATE `merchants` SET `status` = 'active' WHERE `id` = $id";
    return  _QExec($query) != false && mysql_affected_rows() >0;
}