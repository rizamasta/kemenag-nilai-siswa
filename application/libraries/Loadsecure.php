<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @package     Load Secure
* @author      Arief Budi SAntoso
* @copyright   Copyright(c) 2016
* @version     1.0.0
**/


class LoadSecure{
	function getUserIP()
	{
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }

	    return $ip;
	}
}

/* End of file LoadAssets.php */
/* Location: ./application/libraries/LoadAssets.php */