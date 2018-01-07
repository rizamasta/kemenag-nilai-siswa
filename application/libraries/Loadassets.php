<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @package     Load Assets
* @author      Arief Budi SAntoso
* @copyright   Copyright(c) 2016
* @version     1.0.0
**/

/**
* Default Path : assets/js | assets/css | assets/images
* You can give the value single path or array path. The return wiil be css or js html tag with the path
*
* Example load CSS:
* $CSSvalue = array("font-awesome.min.css", "bootstrap.min.css", "style.css");
* $data["loadCSS"] = $this->loadAssets->loadCSS($CSSvalue);
*
* Example load JS:
* $JSvalue = array("font-awesome.min.js", "jquery.min.js");
* $data["loadJS"] = $this->loadAssets->loadJS($JSvalue);
*
* Example load Image:
* $data["logo"] = $this->loadAssets->loadImage(array($1 => $2));
* $1 & $2 = string
* $1 = name for alt and title. example: "logo" / "Image1" / "Image Pertama"
* $2 = path logo. example: "logo.svg" / "logo/logo.svg"
**/

class LoadAssets{
	public function loadCSS($ArrPath){
		$fullpath = "";
		$basepath = base_url()."assets/vendor/css/";
		for($i=0; $i < count($ArrPath); $i++ ){
			$fullpath .= '<link rel="stylesheet" href="'.$basepath.$ArrPath[$i].'">';
		}
		return $fullpath;
	}

	public function loadJS($ArrPath){
		$fullpath = "";
		$basepath = base_url()."assets/js/";
		for($i=0; $i < count($ArrPath); $i++ ){
			$fullpath .= '<script src="'.$basepath.$ArrPath[$i].'"></script>';
		}
		return $fullpath;
	}
	public function loadImage($ArrPath){
		$fullpath = "";
		$basepath = base_url()."assets/images/";
		foreach ($ArrPath as $name => $value) {
		    $fullpath .= '<img src="'.$basepath.$value.'" title="'.$name.'" alt="'.$name.'" />';
		}
		return $fullpath;
	}

	public function loadVendorsCSS($ArrPath){
		$fullpath = "";
		$basepath = base_url();
		for($i=0; $i < count($ArrPath); $i++ ){
			$fullpath .= '<link rel="stylesheet" href="'.$basepath.$ArrPath[$i].'">';
		}
		return $fullpath;
	}

	public function loadVendorsJS($ArrPath){
		$fullpath = "";
		$basepath = base_url();
		for($i=0; $i < count($ArrPath); $i++ ){
			$fullpath .= '<script src="'.$basepath.$ArrPath[$i].'"></script>';
		}
		return $fullpath;
	}
}

/* End of file LoadAssets.php */
/* Location: ./application/libraries/LoadAssets.php */
