<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @package     Enums
* @author      Arief Budi SAntoso
* @copyright   Copyright(c) 2016
* @version     1.0.0
**/

class Enums
{
	public function enumsGender($intId = 0){
		$arrGender = array(0 => "male", 1 => "Female", 2 => "unknown");
		
		return $arrGender[$intId];
	}
	
	public function enumsMonthName($intId){
		$arrMonth = array(1 => "Januari", 
							2 => "Februari", 
							3 => "Maret", 
							4 => "April", 
							5 => "Mei", 
							6 => "Juni", 
							7 => "Juli", 
							8 => "Agustus", 
							9 => "September", 
							10 => "Oktober", 
							11 => "November", 
							12 => "Desember");
		if ($intId == 0){
			return $arrMonth;		
		}else{
			return $arrMonth[$intId];		
		}
	}

	public function enumsMonthNumber($string = ""){
		$arrMonth = array("January" => 1, 
							"February" => 2, 
							"March" => 3, 
							"April" => 4, 
							"May" => 5, 
							"June" => 6, 
							"July" => 7, 
							"August" => 8, 
							"September" => 9, 
							"October" => 10, 
							"November" => 11, 
							"December" => 12
						);
		if ($value == ""){
			return $arrMonth;		
		}else{
			return $arrMonth[$value];		
		}
	}
}

