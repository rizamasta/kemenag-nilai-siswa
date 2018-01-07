<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @package     Imageloader
* @author      Arief Budi SAntoso
* @copyright   Copyright(c) 2016
* @version     1.0.0
**/

class ImageLoader
{
	public $CI;
	public $values;
	
	public function __construct()
    {
        // get CodeIgniter instance
        $this->CI = &get_instance();
 
        // get config file
        $this->CI->config->load('imageloader', TRUE);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    function url_exists($url) {
        $hdrs = @get_headers($url);
        return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;   
    }

    public function fBannerUploadImage($strImagePath, $strObjectFile, $strFileName = "")
    {
        $arrResult = array();
        
        // Generate Pathing untuk Picture
        $strImagePath = $strImagePath;
        $strFilePath = './'.$strImagePath;
        
        if(!is_dir($strFilePath)){
            mkdir($strFilePath, 0777, true); 
        }
        
        //Upload Image
        $img_cfg['image_library'] = 'gd2';
        $config['upload_path'] = $strFilePath;           
        if ($strFileName != ""){
            $config['file_name'] = $strFileName;
        }

        //$arrResult["Message"] = $strFilePath;
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = str_replace(",", "|", str_replace(".", "", $this->CI->config->item('allowedImage')));
        //$config['max_size'] = '1024';
        
        //Load Library
        $this->CI->load->library('upload', $config);
        
        //Check Upload
        if (!$this->CI->upload->do_upload($strObjectFile)){
            $arrResult["Valid"] = false;
            $arrResult["Message"] = $this->CI->upload->display_errors();
        }else{
            $upload_data = $this->CI->upload->data(); 
            $arrResult["Valid"] = true;
            $arrResult["FileName"] = $upload_data['file_name'];
            $arrResult["FilePath"] = $strImagePath;
        }
        
        return $arrResult;
    }

    function fUploadImage($strImagePath, $strObjectFile, $strFileName = ""){
        $arrResult = array();
        
        // Generate Pathing untuk Picture
        $strImagePath = 'assets/'.$strImagePath;
        $strFilePath = './'.$strImagePath;
        
        if(!is_dir($strFilePath)){
            mkdir($strFilePath, 0777, true); 
        }
        
        //Upload Image
        $img_cfg['image_library'] = 'gd2';
        $config['upload_path'] = $strFilePath;           
        if ($strFileName != ""){
            $config['file_name'] = $strFileName;
        }

        //$arrResult["Message"] = $strFilePath;
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = str_replace(",", "|", str_replace(".", "", $this->CI->config->item('allowedImage')));
        //$config['max_size'] = '1024';
        
        //Load Library
        $this->CI->load->library('upload', $config);
        
        //Check Upload
        if (!$this->CI->upload->do_upload($strObjectFile)){
            $arrResult["Valid"] = false;
            $arrResult["Message"] = $this->CI->upload->display_errors();
        }else{
            $upload_data = $this->CI->upload->data(); 
            $arrResult["Valid"] = true;
            $arrResult["FileName"] = $upload_data['file_name'];
            $arrResult["FilePath"] = $strImagePath;
        }
        
        return $arrResult;
    }
    
    function fContentImage($objNews, $strType = 0, $classname = "") {
        $strImage = "";
        $strImagePath = "";
        $strRootPath = $_SERVER{'DOCUMENT_ROOT'}.$this->CI->config->item('rootPath');

        if (file_exists($strRootPath."/".$objNews->UserPhoto) && $objNews->UserPhoto != "") {
            $strImage = base_url().$objNews->UserPhoto;
            //echo $strImage;break;
        }else{
            $dtNewsEntry = strtotime($objNews->CreateDate);
            //$dtNewsDatePublish = strtotime($objNews->news_date_publish);
            $strTopPath = "/assets/content/member/".$classname."/".date("Y",$dtNewsEntry)."/".date("m",$dtNewsEntry)."/".date("d",$dtNewsEntry);
            //$strTopPath2 = "/assets/content/images/media/i/w/news/".date("Y",$dtNewsDatePublish)."/".date("m",$dtNewsDatePublish)."/".date("d",$dtNewsDatePublish)."/".$objNews->news_id;
            $strTopIndoPath = "/assets/content/member/".$classname."/".date("Y",$dtNewsEntry)."/".date("m",$dtNewsEntry)."/".date("d",$dtNewsEntry);

            if ($strType == 1 || $strType == ""){
                $strTopPath = $strTopPath."/original/";
                //$strTopPath2 = $strTopPath2."/660x330/";
                $strNewPath = $strTopIndoPath."/original/";
            }elseif ($strType == 3){
                $strTopPath = $strTopPath."/80x40/";
                //$strTopPath2 = $strTopPath2."/80x40/";
                $strNewPath = $strTopIndoPath."/icon/";
            }else{
                $strTopPath = $strTopPath."/300x150/";
                //$strTopPath2 = $strTopPath2."/300x150/";
                $strNewPath = $strTopIndoPath."/thumb/";
            }

            if (file_exists($strRootPath.$strTopPath.$objNews->UserPhoto)) {
                $strImage = base_url().$strTopPath.$objNews->UserPhoto;
                //echo "rerwe";break;
            }
            /*elseif (file_exists($strRootPath.$strTopPath2.$objNews->ContentImage)) {
                $strImage = base_url().$strTopPath2.$objNews->ContentImage;
            }*/
            elseif (file_exists($strRootPath.$strNewPath.$objNews->UserPhoto)) {
                $strImage = base_url().$strNewPath.$objNews->UserPhoto;
                //echo "dgs";break;
            }else{
                
                if ($strType == 3){
                    if (file_exists($strRootPath.$strTopIndoPath."/original/".$objNews->UserPhoto)) {
                        if(!is_dir('./'.$strNewPath)){
                            mkdir('./'.$strNewPath, 0777, true); 
                        }   
                        //echo "23213123";break;
                        //Resize Image Icon
                        $this->resize_image('.'.$strTopIndoPath."/original/".$objNews->UserPhoto, './'.$strNewPath.$objNews->UserPhoto, 80, 40);
                    }else{
                    	//echo "55555";break;
                        $strImage = base_url()."/assets/public/images/global/no_image.png";
                    }
                }else{
                	//echo "4";break;
                    //$strImage = base_url().$strNewPath.$objNews->ContentImage;
                    //$strImage = base_url()."/assets/public/images/global/no_image.png";
                    $strImage = base_url().$strTopPath.$objNews->UserPhoto;
                }

            }
        }
    
        return $strImage;
    }

    

    function fContentImageDetails($objNews, $strType = 0) {
        $strImage = "";
        $strImagePath = "";
        $strRootPath = $_SERVER{'DOCUMENT_ROOT'}.$this->CI->config->item('rootPath');

        if (file_exists($strRootPath."/".$objNews->news_image) && $objNews->news_image != "") {
            $strImage = base_url().$objNews->news_image;
        }else{
            $dtNewsEntry = strtotime($objNews->news_entry);
           // $dtNewsDatePublish = strtotime($objNews->news_date_publish);
            $strTopPath = "/assets/content/blog/gallery/media/i/w/news/".date("Y",$dtNewsEntry)."/".date("m",$dtNewsEntry)."/".date("d",$dtNewsEntry)."/".$objNews->news_id;
            //$strTopPath2 = "/assets/contentgallery/media/i/w/news/".date("Y",$dtNewsEntry)."/".date("m",$dtNewsEntry)."/".date("d",$dtNewsEntry)."/".$objNews->news_id;
            $strNewPath = '/assets/content/blog/gallery/content/'.date("Y",$dtNewsEntry)."/".date("m",$dtNewsEntry)."/".date("d",$dtNewsEntry);

            if ($strType == 1 || $strType == ""){
                $strTopPath = $strTopPath."/660x330/";
                //$strTopPath2 = $strTopPath2."/660x330/";
                $strNewPath = $strNewPath."/original/";
            }else{
                $strTopPath = $strTopPath."/300x150/";
                //strTopPath2 = $strTopPath2."/300x150/";
                $strNewPath = $strNewPath."/thumb/";
            }


            if (file_exists($strRootPath.$strTopPath.$objNews->news_image)) {
                $strImage = base_url().$strTopPath.$objNews->news_image;
            }//elseif (file_exists($strRootPath.$strTopPath2.$objNews->news_image)) {
                //$strImage = base_url().$strTopPath2.$objNews->news_image;
            //}
            elseif (file_exists($strRootPath.$strNewPath.$objNews->news_image)) {
                $strImage = base_url().$strNewPath.$objNews->news_image;
            }else{
                $strImage = base_url()."/assets/images/web/defaultcontent.jpg";
            }
        }

        return $strImage;
    }

    function fNewsImageGalery($objNews, $imageName, $strType = 0) {
        $strImage = "";
        $strImagePath = "";
        $strRootPath = $_SERVER{'DOCUMENT_ROOT'}.$this->CI->config->item('rootPath');

        if (file_exists($strRootPath."/".$imageName) && $imageName != "") {
            $strImage = base_url().$imageName;
        }elseif ($this->url_exists($imageName)) {
            $strImage = $imageName;
        }elseif (file_exists($strRootPath."/assets/content/blog/gallery/".$imageName) && $imageName != "") {
            $strImage = base_url()."/assets/content/blog/gallery/".$imageName;
        }else{
            $dtNewsEntry = strtotime($objNews->news_entry);
            $strNewPath = '/assets/content/blog/gallery/content/'.date("Y",$dtNewsEntry)."/".date("m",$dtNewsEntry)."/".date("d",$dtNewsEntry)."/";

            if ($strType == 1 || $strType == ""){
                $strNewPath = $strNewPath."/original/";
            }else{
                $strNewPath = $strNewPath."/thumb/";
            }
			
		
           if (file_exists($strRootPath.$strNewPath.$imageName)) {
                $strImage = base_url().$strNewPath.$imageName;
            }else{
                $strImage = base_url()."/assets/images/web/defaultcontent.jpg";
            }
        }

        return $strImage;
    }

    
	
	function resize_image($sourcePath, $desPath, $width = '500', $height = '500', $bolGreaterOnly = true){
        $this->CI->load->library('image_lib', array());
		$this->CI->image_lib->clear();
		
		$strNewPathName = "";
		$bolValid = false;
		
		if ($sourcePath != ""){
			//Create Directory Destination
			if ($desPath != ""){
				if (strrpos($desPath, 'assets/content/member/') === false){
					$desPath = 'assets/content/member/'.$desPath;
				}
				$strDesPathDir = "";
				
				$arrTemp = explode("/", $desPath);
				$intPathLength = count($arrTemp);
				for ($i = 0; $i < $intPathLength - 1; $i++) {
					if ($strDesPathDir != ""){
						$strDesPathDir .= '/';
					}
					$strDesPathDir .= $arrTemp[$i];
				}
				
				if(!is_dir($strDesPathDir)){
					mkdir($strDesPathDir, 0777, true); 
				}
			}
			
			if ($bolGreaterOnly){
				list($picWidth, $picHeight) = getimagesize($sourcePath);
				
				if ($picWidth > $width || $picHeight > $height){
					$bolValid = true;
				}
			}else{
				$bolValid = true;
			}
			
			if ($bolValid){
				if ($desPath == ""){
					$arrTemp = explode("/", $sourcePath);
					$intPathLength = count($arrTemp);
					for ($i = 0; $i < $intPathLength - 1; $i++) {
						if ($strNewPathName != ""){
							$strNewPathName .= '/';
						}
						$strNewPathName .= $arrTemp[$i];
					}
					
					$arrTemp2 = explode(".", $arrTemp[$intPathLength - 1]);
					$strNewPathName .= "/Temp.".$arrTemp2[1];
				}else{
					$strNewPathName = $desPath;
				}				
				
				$config['image_library'] = 'gd2';
				$config['source_image'] = $sourcePath;
				$config['new_image'] = $strNewPathName;
				$config['quality'] = '50%';
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = true;
				$config['thumb_marker'] = '';
				$config['width'] = $width;
				$config['height'] = $height;
				$this->CI->image_lib->initialize($config);
				
				if ($this->CI->image_lib->resize()){
					if ($desPath == ""){
						unlink($sourcePath);
						rename($strNewPathName, $sourcePath);
						
						return true;
					}else{
						return true;
					}
				}
			}
		}
        return false;
    }

    function resize_imageGallery($sourcePath, $desPath, $width = '500', $height = '500', $bolGreaterOnly = true){
        $this->CI->load->library('image_lib', array());
        $this->CI->image_lib->clear();
        
        $strNewPathName = "";
        $bolValid = false;
        
        if ($sourcePath != ""){
            //Create Directory Destination
            if ($desPath != ""){
                if (strrpos($desPath, 'assets/content/class/') === false){
                    $desPath = 'assets/content/class/'.$desPath;
                }
                $strDesPathDir = "";
                
                $arrTemp = explode("/", $desPath);
                $intPathLength = count($arrTemp);
                for ($i = 0; $i < $intPathLength - 1; $i++) {
                    if ($strDesPathDir != ""){
                        $strDesPathDir .= '/';
                    }
                    $strDesPathDir .= $arrTemp[$i];
                }
                
                if(!is_dir($strDesPathDir)){
                    mkdir($strDesPathDir, 0777, true); 
                }
            }
            
            if ($bolGreaterOnly){
                list($picWidth, $picHeight) = getimagesize($sourcePath);
                
                if ($picWidth > $width || $picHeight > $height){
                    $bolValid = true;
                }
            }else{
                $bolValid = true;
            }
            
            if ($bolValid){
                if ($desPath == ""){
                    $arrTemp = explode("/", $sourcePath);
                    $intPathLength = count($arrTemp);
                    for ($i = 0; $i < $intPathLength - 1; $i++) {
                        if ($strNewPathName != ""){
                            $strNewPathName .= '/';
                        }
                        $strNewPathName .= $arrTemp[$i];
                    }
                    
                    $arrTemp2 = explode(".", $arrTemp[$intPathLength - 1]);
                    $strNewPathName .= "/Temp.".$arrTemp2[1];
                }else{
                    $strNewPathName = $desPath;
                }               
                
                $config['image_library'] = 'gd2';
                $config['source_image'] = $sourcePath;
                $config['new_image'] = $strNewPathName;
                $config['quality'] = '50%';
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = true;
                $config['thumb_marker'] = '';
                $config['width'] = $width;
                $config['height'] = $height;
                $this->CI->image_lib->initialize($config);
                
                if ($this->CI->image_lib->resize()){
                    if ($desPath == ""){
                        unlink($sourcePath);
                        rename($strNewPathName, $sourcePath);
                        
                        return true;
                    }else{
                        return true;
                    }
                }
            }
        }
        return false;
    }
	
    public function generateUrl($title){
        $now = date('Ymd');
        $now = substr($now, 2);
        $sec = date('His');
        $sec = substr($sec, 3);
        $date = $now.$sec;

        $title = strtolower($title);
        $spaceurl = str_replace(" ", "-", $title);
        $comaurl = str_replace(",", "", $spaceurl);
        $seruurl = str_replace("!", "", $comaurl);
        $doturl = str_replace(".", "", $seruurl);
        $askurl = str_replace("?", "", $doturl);
        $askurl = str_replace("%", "", $askurl);
        $askurl = str_replace("$", "", $askurl);
        $askurl = str_replace("#", "", $askurl);
        $askurl = str_replace("'", "", $askurl);
        $askurl = str_replace("&", "", $askurl);
        $askurl = str_replace("(", "", $askurl);
        $askurl = str_replace(")", "", $askurl);
        $askurl = str_replace("[", "", $askurl);
        $askurl = str_replace("]", "", $askurl);
        $askurl = str_replace("{", "", $askurl);
        $askurl = str_replace("}", "", $askurl);
        $askurl = str_replace("+", "", $askurl);
        $askurl = str_replace("=", "", $askurl);
        $askurl = str_replace("_", "", $askurl);
        $askurl = str_replace("^", "", $askurl);
        $askurl = str_replace("*", "", $askurl);
        $askurl = str_replace("/", "", $askurl);
        $url = str_replace("\"", "", $askurl);
        $fixurl = $url."-".$date;

        return $fixurl;
    }
	
}