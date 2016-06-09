<?php

namespace App;

class Customer
{

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
	 * @return boolean
	 * @author Mykola Martynov
	 **/
	public function isValidName()
	{
		// !!! stub
		return false;
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
	 * @return boolean
	 * @author Mykola Martynov
	 **/
	public function isValidEmail()
	{
		// !!! stub
		return false;
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
		$this->password = md5($password);

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
		$this->password_confirm = md5($password);
		
		return $this;
	}

	/**
	 * Return true if current password not empty and equals to confirm password
	 *
	 * @return boolean
	 * @author Mykola Martynov
	 **/
	public function isValidPassword()
	{
		// !!! stub
		return false;
	}

	/**
	 * Return customer information gathered from the given $form_Data. 
 	 * Keep non-existing fields empty.
	 *
	 * @param  array  $post
	 * @return self
	 * @author Mykola Martynov
	 **/
	public function fetchInfo($post)
	{
		// !!! stub
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
		// !!! stub
		return false;
	}
}