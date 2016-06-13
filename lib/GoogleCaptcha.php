<?php
namespace App;

use Phelium\Component\reCAPTCHA;

class GoogleCaptcha
{
	/**
	 * Site key for Google Captcha
	 *
	 * @var string
	 **/
	private $site_key;

	/**
	 * Secret key for Google Captcha
	 *
	 * @var string
	 **/
	private $secret_key;

	/**
	 * User submitted data for Google Captcha
	 *
	 * @var string
	 **/
	private $user_responce;

	/**
	 * Error string for not valid captcha
	 *
	 * @var string
	 **/
	private $error;

	function __construct($site_key, $secret_key)
	{
		$this->site_key = $site_key;
		$this->secret_key = $secret_key;
	}

	/**
	 * Return captcha HTML-code for web-page
	 *
	 * @return string
	 * @author Michael Strohyi
	 **/
	public function getHtmlCode()
	{
		if ($this->isDevelompmentMode()) {
			return '';
		}
		return '<div class="g-recaptcha" data-sitekey="' . $this->site_key . '"></div>';
	}

	/**
	 * Return captcha JScript-code for web-page
	 *
	 * @return string
	 * @author Michael Strohyi
	 **/
	public function getJSCode()
	{
		if ($this->isDevelompmentMode()) {
			return '';
		}
		return '<script src="https://www.google.com/recaptcha/api.js"></script>';
	}

	/**
	 * Validate user-submitted data for captcha.
	 * Set error if captcha is not valid.
	 *
	 * @return self
	 * @author Michael Strohyi
	 **/
	public function validate()
	{
		$this->error = '';
		$reCAPTCHA = new reCAPTCHA($this->site_key, $this->secret_key);
		if (!$reCAPTCHA->isValid($this->user_responce)) {
			$this->error = 'Captcha is not valid.';
		} 
		return $this;
	}
	/**
	 * Return true if development mode is set, otherwise return false.
	 *
	 * @return boolean
	 * @author Michael Strohyi
	 **/
	private function isDevelompmentMode()
	{
		return defined('ENVIRONMENT') && ENVIRONMENT == 'development';
	}

	/**
	 * Return User submitted data for captcha from the given $info. 
	 *
	 * @param array $info
	 * @return self
	 * @author Michael Strohyi
	 **/
	public function fetchInfo($info)
	{
		if (isset($info['g-recaptcha-response'])) {
			$this->user_responce = $info['g-recaptcha-response'];
		}
		return $this;
	}

	/**
	 * Return error string when captcha is not valid.
	 *
	 * @return string
	 * @author Michael Strohyi
	 **/
	public function getErrorString()
	{
		return $this->error;
	}

	/**
	 * Return true if captcha is valid, otherwise return false.
	 *
	 * @return boolean
	 * @author Michael Strohyi
	 **/
	public function isValid()
	{
		return empty($this->error);
	}
}
