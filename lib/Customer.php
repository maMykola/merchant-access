<?php

namespace App;

class Customer
{

	/**
	 * Return name
	 *
	 * @return string
	 * @author Mykola Martynov
	 **/
	public function getName()
	{
		// !!! stub
		return '';
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
		// !!! stub
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
		// !!! stub
		return '';
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
		// !!! stub
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
		// !!! stub
		return '';
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
		// !!! stub
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
		// !!! stub
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