<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Directory Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Arief Budi Santoso
 * @link		https://codeigniter.com/user_guide/helpers/directory_helper.html
 */

// ------------------------------------------------------------------------

	if( !function_exists('load_template_CSS') ) {
    	/**
		 * Load CSS di dalam template
		 *
		 * Write CSS tag and path for template.
		 *
		 * @return	CSS HTML tag with url path
		*/
	    function load_template_CSS() {
	    	$baseurl = get_instance()->config->base_url();

	    	echo '
	    		<link rel="stylesheet" href="'.$baseurl.'assets/vendors/bootstrap/dist/css/bootstrap.min.css">
	    		<link rel="stylesheet" href="'.$baseurl.'assets/vendors/font-awesome/css/font-awesome.min.css">
	    		<link rel="stylesheet" href="'.$baseurl.'assets/css/dashboard/maps/jquery-jvectormap-2.0.3.css">
	    		<link rel="stylesheet" href="'.$baseurl.'assets/vendors/pnotify/dist/pnotify.css">
	    		<link rel="stylesheet" href="'.$baseurl.'assets/vendors/pnotify/dist/pnotify.buttons.css">
	    		<link rel="stylesheet" href="'.$baseurl.'assets/css/dashboard/custom.css">
					<link rel="stylesheet" href="'.$baseurl.'assets/vendors/animate.css/animate.min.css">
	    		';
	    }
    }



    if( !function_exists('load_footer') ) {
    /**
             * Load JS di dalam template
             *
             * Write JS tag and path for template.
             *
             * @return	JS HTML tag with url path
            */
        function load_footer() {
            echo "<div class='container-fluid container-fixed-lg footer'>
          <div class='copyright sm-text-center'>
            <p class='small no-margin pull-left sm-pull-reset'>
              <span class='hint-text'>Copyright &copy; 2014 </span>
              <span class='font-montserrat'>REVOX</span>.
              <span class='hint-text'>All rights reserved. </span>
              <span class='sm-block'><a href='#'' class='m-l-10 m-r-10'>Terms of use</a> | <a href='#' class='m-l-10'>Privacy Policy</a></span>
            </p>
            <p class='small no-margin pull-right sm-pull-reset'>
              <a href='#''>Hand-crafted</a> <span class='hint-text'>&amp; Made with Love ®</span>
            </p>
            <div class='clearfix'></div>
          </div>
        </div>
                  ";
        }

    }

    if( !function_exists('load_template_JS') ) {
    	/**
		 * Load JS di dalam template
		 *
		 * Write JS tag and path for template.
		 *
		 * @return	JS HTML tag with url path
		*/
	    function load_template_JS() {
	    	$baseurl = get_instance()->config->base_url();

	    	echo '
	    		<script src="'.$baseurl.'assets/vendors/jquery/dist/jquery.min.js"></script>
	    		<script src="'.$baseurl.'assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	    		<script src="'.$baseurl.'assets/js/dashboard/moment/moment.min.js"></script>
	    		<script src="'.$baseurl.'assets/vendors/pnotify/dist/pnotify.js"></script>
	    		<script src="'.$baseurl.'assets/vendors/pnotify/dist/pnotify.buttons.js"></script>
          <script src ="'.$baseurl.'assets/vendors/build/js/custom.min.js"></script>
	    		';
	    }

  	}

  	if( !function_exists('load_template_favicon') ) {
    	/**
		 * Load CSS di dalam template
		 *
		 * Write CSS tag and path for template.
		 *
		 * @return	CSS HTML tag with url path
		*/
	    function load_template_favicon() {
	    	$baseurl = get_instance()->config->base_url();

	    	echo '
	    		<meta name="theme-color" content="#ffffff">
				<link rel="apple-touch-icon" sizes="57x57" href="'.$baseurl.'assets/images/favicons/apple-icon-57x57.png">
				<link rel="apple-touch-icon" sizes="60x60" href="'.$baseurl.'assets/images/favicons/apple-icon-60x60.png">
				<link rel="apple-touch-icon" sizes="72x72" href="'.$baseurl.'assets/images/favicons/apple-icon-72x72.png">
				<link rel="apple-touch-icon" sizes="76x76" href="'.$baseurl.'assets/images/favicons/apple-icon-76x76.png">
				<link rel="apple-touch-icon" sizes="114x114" href="'.$baseurl.'assets/images/favicons/apple-icon-114x114.png">
				<link rel="apple-touch-icon" sizes="120x120" href="'.$baseurl.'assets/images/favicons/apple-icon-120x120.png">
				<link rel="apple-touch-icon" sizes="144x144" href="'.$baseurl.'assets/images/favicons/apple-icon-144x144.png">
				<link rel="apple-touch-icon" sizes="152x152" href="'.$baseurl.'assets/images/favicons/apple-icon-152x152.png">
				<link rel="apple-touch-icon" sizes="180x180" href="'.$baseurl.'assets/images/favicons/apple-icon-180x180.png">
				<link rel="icon" type="image/png" sizes="192x192"  href="'.$baseurl.'assets/images/favicons/android-icon-192x192.png">
				<link rel="icon" type="image/png" sizes="32x32" href="'.$baseurl.'assets/images/favicons/favicon-32x32.png">
				<link rel="icon" type="image/png" sizes="96x96" href="'.$baseurl.'assets/images/favicons/favicon-96x96.png">
				<link rel="icon" type="image/png" sizes="16x16" href="'.$baseurl.'assets/images/favicons/favicon-16x16.png">
				<link rel="manifest" href="'.$baseurl.'assets/images/favicons/manifest.json">
				<meta name="msapplication-TileColor" content="#ffffff">
				<meta name="msapplication-TileImage" content="'.$baseurl.'assets/images/favicons/ms-icon-144x144.png">
				<meta name="theme-color" content="#ffffff">
	    		';
	    }
    }
