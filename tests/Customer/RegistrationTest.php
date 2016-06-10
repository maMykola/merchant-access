<?php

use App\Customer;

class CustomerRegistrationTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->customer = new Customer;
	}

	private function postData()
	{
		return [
			"name" => "John Doe",
			"email" => "john.doe@example.com",
			"password" => "JohnDoePassword",
			"password_confirm" => "JohnDoePassword",
		];
	}

	private function postDataWithSpaces()
	{
		return [
			"name" => " John  Doe ",
			"email" => " john.doe@example.com  ",
			"password" => "John Doe Password",
			"password_confirm" => "John Doe Password",
		];
	}

	public function testGatheredMerchantInfo()
	{
		$customer = $this->customer;
		$customer->fetchInfo($this->postData());

		$this->assertEquals($customer->getName(), 'John Doe');
		$this->assertEquals($customer->getEmail(), 'john.doe@example.com');
		$this->assertEquals($customer->getPassword(), md5('JohnDoePassword'));
	}

	public function testGatheredMerchantInfoSpaceFree()
	{
		$customer = $this->customer;
		$customer->fetchInfo($this->postDataWithSpaces());

		$this->assertEquals($customer->getName(), 'John Doe');
		$this->assertEquals($customer->getEmail(), 'john.doe@example.com');
		$this->assertEquals($customer->getPassword(), md5('John Doe Password'));
	}

	public function testGatheredMerchantInfoIsValid()
	{
		$customer = $this->customer;
		$customer->fetchInfo($this->postData());

		$this->assertTrue($customer->isValid());
	}
}