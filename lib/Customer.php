<?php

namespace App;

class Customer
{
	const CUSTOMER_REQUIRED_FIELD = 'This is a required field.';
	const CUSTOMER_PASSWORD_CONFIRM_FAILED = 'Your password confirmation do not match your password.';
	const CUSTOMER_NAME_MALFORMED = 'Name contains deprecated characters. Allowed only alpha characters.';
	const CUSTOMER_EMAIL_NOT_VALID = 'Please, enter valid Email';

	/**
	 * Identifier (from the db)
	 *
	 * @var int
	 **/
	private $id;

	/**
	 * Name
	 *
	 * @var string
	 **/
	private $name;

	/**
	 * Email
	 *
	 * @var string
	 **/
	private $email;

	/**
	 * Password
	 *
	 * @var string
	 **/
	private $password;

	/**
	 * Confirm password (for registration only)
	 *
	 * @var string
	 **/
	private $password_confirm;

	/**
	 * Errors
	 *
	 * @var array
	 **/
	private $errors;


	function __construct($id = null) {
		$this->id = $id;

		# load data from db if $id is not null
	}

	/**
	 * Return id
	 *
	 * @return int
	 * @author Mykola Martynov
	 **/
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Return name
	 *
	 * @return string
	 * @author Mykola Martynov
	 **/
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set name
	 *
	 * @param  string  $name
	 * @return self
	 * @author Mykola Martynov
	 **/
	public function setName($name)
	{
		# remove extra/trailing spaces
		$name = trim(preg_replace('#\s+#', ' ', $name));

		$this->name = $name;

		return $this;
	}

	/**
	 * Return true if current name has a valid form and not empty
	 *
	 * @return void
	 * @author Mykola Martynov
	 **/
	private function validateName()
	{
		unset($this->errors['name']);

		# check if name is not empty
		if (empty($this->name)) {
			$this->errors['name'] = self::CUSTOMER_REQUIRED_FIELD;
			return ;
		}

		# check if a name has only allowed characters (alpha only)
		if (!preg_match('#^[a-z]+(\s[a-z]+)?$#i', $this->name)) {
			$this->errors['name'] = self::CUSTOMER_NAME_MALFORMED;
			return ;
		}
	}

	/**
	 * Return email
	 *
	 * @return string
	 * @author Mykola Martynov
	 **/
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set email
	 *
	 * @param  string  $email
	 * @return self
	 * @author Mykola Martynov
	 **/
	public function setEmail($email)
	{
		# remove trailing spaces
		$email = trim($email);

		$this->email = $email;

		return $this;
	}

	/**
	 * Return true if current email has a valid form and not empty
	 *
	 * @return void
	 * @author Mykola Martynov
	 **/
	private function validateEmail()
	{
		// !!! stub
		unset($this->errors['email']);

		if (empty($this->email)) {
			$this->errors['email'] = self::CUSTOMER_REQUIRED_FIELD;
			return ;
		}

		# check if an email has a valid form
		if (!isEmailValid($this->email)) {
			$this->errors['email'] = self::CUSTOMER_EMAIL_NOT_VALID;
			return ;
		}

		# check if customer with given email already exists
		$this->isRegistered($this->email);
	}

	/**
	 * Return password
	 *
	 * @return string
	 * @author Mykola Martynov
	 **/
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Set password
	 *
	 * @param  string  $password
	 * @return self
	 * @author Mykola Martynov
	 **/
	public function setPassword($password)
	{
		if (!empty($password)) {
			$this->password = md5($password);
		}

		return $this;
	}

	/**
	 * Set confirm password
	 *
	 * @param  string  $password
	 * @return self
	 * @author Mykola Martynov
	 **/
	public function setConfirmPassword($password)
	{
		if (!empty($password)) {
			$this->password_confirm = md5($password);
		}
		
		return $this;
	}

	/**
	 * Return true if current password not empty and equals to confirm password
	 *
	 * @return void
	 * @author Mykola Martynov
	 **/
	private function validatePassword()
	{
		unset($this->errors['password']);
		unset($this->errors['password_confirm']);

		if (empty($this->password)) {
			$this->errors['password'] = self::CUSTOMER_REQUIRED_FIELD;
		}

		if (empty($this->password_confirm)) {
			$this->errors['password_confirm'] = self::CUSTOMER_REQUIRED_FIELD;
			return ;
		}

		if ($this->password != $this->password_confirm) {
			$this->errors['password_confirm'] = self::CUSTOMER_PASSWORD_CONFIRM_FAILED;
			return ;
		}
	}

	/**
	 * Return customer information gathered from the given $form_Data. 
 	 * Keep non-existing fields empty.
	 *
	 * @param  array  $info
	 * @return self
	 * @author Mykola Martynov
	 **/
	public function fetchInfo($info)
	{

		if (!empty($info['name'])) {
			$this->setName($info['name']);
		}

		if (!empty($info['email'])) {
			$this->setEmail($info['email']);
		}
		
		if (!empty($info['password'])) {
			$this->setPassword($info['password']);
		}
		

		if (!empty($info['password_confirm'])) {
			$this->setConfirmPassword($info['password_confirm']);
		}
		
		return $this;
	}

	/**
	 * Return true if all fields has valid data, false otherwise.
	 *
	 * @return boolean
	 * @author Mykola Martynov
	 **/
	public function isValid()
	{
		return empty($this->errors);			
	}

	/**
	 * Return error string for given field $name
	 *
	 * @param string $name
	 * @return string
	 * @author Michael Strohyi
	 **/
	public function getErrorString($name)
	{
		return $this->errors[$name];
	}

	/**
	 * Return true if field with $name has error
	 *
	 * @param string $name
	 * @return boolean
	 * @author Michael Strohyi
	 **/
	public function hasError($name)
	{
		return isset($this->errors[$name]);
	}

	/**
	 * Save customer's registration data into db and return true. If error happens return false.
	 *
	 * @return boolean
	 * @author Michael Strohyi
	 **/
	public function save()
	{
		// !!! stub
		/*$merchant_account = [
			'email' => strtolower($this->email),
			'password' => $this->password,
			'name' => $this->name,
			'status' => 'added',
			'reg_date' => date("Y-m-d H:i:s"),
		];
		$query = "INSERT INTO `merchants` "._QInsert($merchant_account);
		$res = _QExec($query);
		if ($res === false) {
			return false;
		}*/

// temp code without db_func use
		$merchant_account = [
			'email' => "'" . mysql_real_escape_string(strtolower($this->email)) . "'",
			'password' => "'" . $this->password . "'",
			'name' => "'" . mysql_real_escape_string($this->name) . "'",
			'status' => "'added'",
			'reg_date' => "'" . date("Y-m-d H:i:s") . "'",
		];
		$keys = '';
		$vals = '';
		foreach ($merchant_account as $key => $val) {
			if ($keys != '') {
		    	$keys .= ', ';
		    	$vals .= ', ';
		    }
		    $keys .= "`{$key}`";
		    $vals .= $val;
		  }

		$query = "INSERT INTO `merchants` "."({$keys}) VALUES ({$vals})";
		$res  = mysql_query($query);
		if ($res === false) {
			return false;
		}
// end of temp code without db_func use

		return true;
	}

	/**
	 * Validate user-submitted data.
	 *
	 * @return self
	 * @author Michael Strohyi
	 **/
	public function validate()
	{
		$this->validateName();
		$this->validateEmail();
		$this->validatePassword();

		return $this;
	}

	/**
	 * Check if customer with given $email is already registered in db
	 *
	 * @param string $email
	 * @return void
	 * @author Michael Strohyi
	 **/
	private function isRegistered($email)
	{
		// !!! stub
	/*	$query = "SELECT `id`, `status` FROM `merchants` WHERE `email` = "._QData($email);
    	_QExec($query);
	    $res_element = _QElem();
	    if (!empty($res_element)) {
	    	$this->errors['email'] = 'Customer with this email is already registered. Please visit login page to enter your account.';
	    }*/

// temp code without db_func use
	    $query = "SELECT `id`, `status` FROM `merchants` WHERE `email` = '". mysql_real_escape_string($this->email) ."'";
	    $res  = mysql_query($query) or trigger_error(mysql_error().$query);
  		$rows = mysql_num_rows($res);
  		if ($rows != 0) {
	    	$this->errors['email'] = 'Customer with this email is already registered. Please visit login page to enter your account.';
	    }
// end of temp code without db_func use
	}
}
