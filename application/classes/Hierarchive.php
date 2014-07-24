<?php

class Hierarchive {

	public static $version = '0.1.0';

	public static function env()
	{
		if (Kohana::$environment == Kohana::PRODUCTION)
		{
			return 'production';
		}
		if (Kohana::$environment == Kohana::STAGING)
		{
			return 'staging';
		}
		elseif (Kohana::$environment == Kohana::TESTING)
		{
			return 'testing';
		}
		elseif (Kohana::$environment == Kohana::DEVELOPMENT)
		{
			return 'development';
		}
		else
		{
			throw HTTP_Exception::factory(500, 'Environment not supported.');
		}
	}

	public static function msg($msg, $vals)
	{
		$prefixed_vals = array();
		foreach ($vals as $k=>$v)
		{
			$prefixed_vals[":$k"] = $v;
		}
		return __(Kohana::message('hierarchive', $msg), $prefixed_vals);
	}

}
