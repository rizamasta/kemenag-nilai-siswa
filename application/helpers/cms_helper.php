<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Directory Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	CMS Global
 * @author		Arief Budi Santoso
 * @link		https://codeigniter.com/user_guide/helpers/directory_helper.html
 */

// ------------------------------------------------------------------------

	if( !function_exists('load_day') ) {
    	/**
		 * Load Day Option
		 *
		 * Write option with day value 
		 *
		 * @return	option day value
		*/
	    function load_registration_day($value = "") {

	    	//Loop Day
	    	for ($i=0; $i <= 31; $i++) { 
	    		if ($i == 0) {
	    			echo '<option value="">Day</option>';
	    		}else{
	    			if ( !empty($value) && $value == $i) {
	    				echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
	    			}else{
	    				echo '<option value="'.$i.'">'.$i.'</option>';
	    			}
	    		}
	    	}
	    }
    }

    if( !function_exists('load_month') ) {
    	/**
		 * Load Month Option
		 *
		 * Write option with month value 
		 *
		 * @return	option month value
		*/
	    function load_registration_month($value = "") {

	    	//Loop Month
	    	for ($i=0; $i <= 12; $i++) { 
	    		if ($i == 0) {
	    			echo '<option value="">Month</option>';
	    		}else{
	    			if ( !empty($value) && changeMonth(2, $value) == $i ) {
	    				echo '<option value="'.$i.'" selected="selected">'.changeMonth(1, $i).'</option>';
	    			}else{
	    				echo '<option value="'.$i.'">'.changeMonth(1, $i).'</option>';
	    			}
	    		}
	    	}
	    	
	    }
    
  	}

  	if( !function_exists('load_year') ) {
    	/**
		 * Load Year Option
		 *
		 * Write option with year value 
		 *
		 * @return	option year value
		*/
	    function load_registration_year($value = "") {
	    	//Setting Year
	    	$maxYear 	= date('Y', strtotime('-12 years'));
	    	$minYear 	= date('Y', strtotime('-70 years'));

	    	//Loop year
	    	for ( $i = $maxYear; $i != $minYear; $i-- ) { 
	    		if ( $i == $maxYear ) {
	    			echo '<option value="">Year</option>';
	    		}else{
	    			if ( !empty($value) && $value == $i) {
	    				echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
	    			}else{
	    				echo '<option value="'.$i.'">'.$i.'</option>';
	    			}
	    		}
	    	}
	    }
    }
    if( !function_exists('generateRandomString') ) {
    	/**
		 * Generate Random String
		 *
		 * Generate Random String to give name / code to value (Default length : 10)
		 *
		 * @return	encrypted string
		*/
    	function generateRandomString($length = 10) {
	        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	        $randomString = '';
	        for ($i = 0; $i < $length; $i++) {
	            $randomString .= $characters[rand(0, strlen($characters) - 1)];
	        }
	        return $randomString;
	    }
	}

    if( !function_exists('cms_encrypt') ) {
    	/**
		 * Encrypt Standart CMS
		 *
		 * Encrypt some word / value to parse in another controller, view or model
		 *
		 * @return	encrypted string
		*/
		function cms_encrypt($string = "")
		{
			$key = "1234567890royal0987654321";
			$iv = mcrypt_create_iv(
			    mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
			    MCRYPT_DEV_URANDOM
			);

			$encrypted = base64_encode(
			    $iv .
			    mcrypt_encrypt(
			        MCRYPT_RIJNDAEL_128,
			        hash('sha256', $key, true),
			        $string,
			        MCRYPT_MODE_CBC,
			        $iv
			    )
			);

			return urlencode($encrypted);
		}
	}

	if( !function_exists('cms_decrypt') ) {
    	/**
		 * Decrypt Standart CMS
		 *
		 * Decrypt some word / value to parse in another controller, view or model
		 *
		 * @return	decrypted string
	*/
		function cms_decrypt($string = "")
		{
			$key = "1234567890royal0987654321";
			$data = base64_decode(urldecode($string));
			$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

			$decrypted = rtrim(
			    mcrypt_decrypt(
			        MCRYPT_RIJNDAEL_128,
			        hash('sha256', $key, true),
			        substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
			        MCRYPT_MODE_CBC,
			        $iv
			    ),
			    "\0"
			);

			return $decrypted;
		}
	}

	if( !function_exists('mask_email') ) {
    	/**
		 * Masking Email
		 *
		 * Masking email for secret the email address
		 *
		 * @return	email with mask * . example : abcdlkjlkjk@hotmail.com -> abc********@*****il.com
		*/
	    function mask_email($email = "")
		{
		    $em   = explode("@",$email);
		    $last = end($em);
		    $name = implode(array_slice($em, 0, count($em)-1), '@');
		    $len  = floor(strlen($name)/3);
		    $xxx  = floor(strlen($last)/2);

		    return substr($name,0, $len) . str_repeat('*', strlen($name)-$len) . "@" . str_repeat('*', $xxx). substr($last,$xxx, strlen($last));

		}
    }
