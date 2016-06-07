\<?php

use App\Customer;


class CustomerValidationTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->customer = new Customer;
	}

	public function testCustomerClassHaveMethods()
	{
		$customer = $this->customer;

		$this->assertTrue(method_exists($customer, 'getName'), 'getter name');
		$this->assertTrue(method_exists($customer, 'setName'), 'setter name');
		$this->assertTrue(method_exists($customer, 'isValidName'), 'validation name');

		$this->assertTrue(method_exists($customer, 'getEmail'), 'getter email');
		$this->assertTrue(method_exists($customer, 'setEmail'), 'setter email');
		$this->assertTrue(method_exists($customer, 'isValidEmail'), 'validation email');

		$this->assertTrue(method_exists($customer, 'getPassword'), 'getter password');
		$this->assertTrue(method_exists($customer, 'setPassword'), 'setter password');
		$this->assertTrue(method_exists($customer, 'setConfirmPassword'), 'setter confirm password');
		$this->assertTrue(method_exists($customer, 'isValidPassword'), 'validation password');
	}

	/**
	 * @dataProvider  validNames
	 */
	public function testValidationSuccessName($name)
	{
		$customer = $this->customer;
		$customer->setName($name);

		$this->assertTrue($customer->isValidName());
	}

	public function validNames()
	{
		return [
			"simple name" => ["John"],
			"name with trailing spaces" => [" John  "],
			"name with capital letters" => ["JohnDoe"],
			"two words" => ["John Doe"],
			"two words with several spaces" => ["John  Doe"],
			"many trailing spaces" => [" John  Doe   "],
		];
	}

	/**
	 * @dataProvider  badNames
	 */
	public function testValidationFailedName($name)
	{
		$customer = $this->customer;
		$customer->setName($name);

		$this->assertFalse($customer->isValidName());
	}

	public function badNames()
	{
		return [
			"empty name" => [""],
			"name with numbers" => ["Test10"],
			"only numbers" => ["10"],
			"name with dashes" => ["_John_"],
			"name with dash inside" => ["John_Doe"],
		];
	}

	/**
	 * @dataProvider  validEmails
	 */
	public function testValidationSuccessEmail($email)
	{
		$customer = $this->customer;
		$customer->setEmail($email);

		$this->assertTrue($customer->isValidEmail());
	}

	public function validEmails()
	{
		return [
			"email" => ["john@example.com"],
			"email with trailing spaces" => [" john@example.com  "],
			"email name with dot in name" => ["john.doe@example.com"],
			"email on subdomain" => ["john.doe@fqdn.example.com"],
			"email name with underscore" => ["john_doe@example.com"],
			"email name with digits" => ["john25@example.com"],
		];
	}

	/**
	 * @dataProvider  badEmails
	 */
	public function testValidationFailedEmails($email)
	{
		$customer = $this->customer;
		$customer->setEmail($email);

		$this->assertFalse($customer->isValidEmail());
	}

	public function badEmails()
	{
		return [
			"empty email" => [""],
			"email without name" => ["@example.com"],
			"email without domain" => ["john@"],
			"email without at sign" => ["john.example.com"],
			"email with bad domain" => ["john@example"],
			"email with spaces" => ["john doe@example.com"],
			"email without tld" => ["john@examplecom"],
		];
	}

	/**
	 * @dataProvider  validPasswords
	 */
	public function testValidationSuccessPassword($password, $confirm_password)
	{
		$customer = $this->customer;
		$customer->setPassword($password);
		$customer->setConfirmPassword($confirm_password);

		$this->assertTrue($customer->isValidPassword());
	}

	public function validPasswords()
	{
		return [
			"simple" => ["abc123", "abc123"],
			"with spaces" => ["abc 123", "abc 123"],
			"with special characters" => ["abc#21{_12!?", "abc#21{_12!?"],
		];
	}

	/**
	 * @dataProvider  badPasswords
	 */
	public function testValidationFailedPassword($password, $confirm_password)
	{
		$customer = $this->customer;
		$customer->setPassword($password);
		$customer->setConfirmPassword($confirm_password);

		$this->assertFalse($customer->isValidPassword());
	}

	public function badPasswords()
	{
		return [
			"empty" => ["", ""],
			"pass is empty" => ["", "abc123"],
			"confirm is empty" => ["abc123", ""],
			"not equal" => ["abc123", "abc12"],
		];
	}
}