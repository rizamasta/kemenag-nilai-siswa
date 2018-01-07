<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH . "third_party/MX/Controller.php";


class Abstract_Controller extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @param type $array
     * @return array beutifier
     */
    public function pr($array)
    {
        echo "<pre>";
        print_r($array);
        die;
    }
    /**
     *
     * @param type $array
     *
     */
    public function setAlert($title, $msg, $type)
    {
        echo "<script type='text/javascript'>
            var alert = {
                msg: '".$msg."',
                title: '".$title."',
                type: '".$type."'
            }
            localStorage.setItem('alert', JSON.stringify(alert));
            </script>";
    }
    /**
     * @description Get Model User_model
     * @param String Get Extension
     * @return Logger
     */
    public function getModelUser()
    {
        $this->load->model('User/User_model');
        return new User_model();
    }
    /**
     * Dashboard Model function
     *
     * @return void
     */
    public function getModelDashboard()
    {
        $this->load->model('Dashboard/Dash_model');
        return new Dash_model();
    }
    /**
     * Member function
     *
     * @return void
     */
    public function getModelMember()
    {
        $this->load->model('Member/Member_model');
        return new Member_model();
    }
    /**
     * Manage Guardian function
     *
     * @return void
     */
    public function getModelGuardian()
    {
        $this->load->model('Manage/Guardian_model');
        return new Guardian_model();
    }
    /**
     * Manage Guardian function
     *
     * @return void
     */
    public function getModelManage()
    {
        $this->load->model('Manage/Manage_model');
        return new Manage_model();
    }
    /**
     * Report function
     *
     * @return void
     */
    public function getModelReport()
    {
        $this->load->model('Report/Report_model');
        return new Report_model();
    }
    /**
     * Poi function
     *
     * @return void
     */
    public function getModelPoi()
    {
        $this->load->model('Manage/Poi_model');
        return new Poi_model();
    }

    /**
     * Siskamling function
     *
     * @return void
     */
    public function getModelSiskamling()
    {
        $this->load->model('Manage/Siskamling_model');
        return new Siskamling_model();
    }
    /**
     * Terms function
     *
     * @return void
     */
    public function getModelTerms()
    {
        $this->load->model('Setting/Terms_model');
        return new Terms_model();
    }
    /**
     *
     * @return Array  Of User info
     */
    public function userInfo()
    {
        return $this->session->userdata('userKemenag');
    }
   
    /**
     *
     * @param String $accessRole
     * @return boolean Access Login
     */
    public function checkLogin()
    {
        $status = $this->session->userdata('userKemenag');
        if (empty($status)) {
            redirect('login');
        } else {
            return $status;
        }
    }
    public function getFullName()
    {
        $data = $this->checkLogin();
        $len = strlen($data['last_name']);
        if ($len > 10) {
            $name =$data['first_name']." ".substr($data['last_name'], 0, 1);
        } else {
            $name =$data['first_name']." ".$data['last_name'];
            ;
        }
        return ucwords($name);
    }
    public function getPlaceName($lat = "", $lon = "")
    {
        if (!empty($lat) && !empty($lon)) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lon.'&key='.GMAP_API,
            ));
            $resp = curl_exec($curl);
            curl_close($curl);
            $rs_arr = json_decode($resp);
            if (count($rs_arr->results)>0) {
                return $rs_arr->results[0]->formatted_address;
            } else {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lon.'&key='.GMAP_API_CMS,
                ));
                $resp = curl_exec($curl);
                curl_close($curl);
                $rs_arr = json_decode($resp);
                if (count($rs_arr->results)>0) {
                    return $rs_arr->results[0]->formatted_address;
                } else {
                    return $rs_arr->status;
                }
            }
        } else {
            return "-";
        }
    }
     /**
     *
     * @param type $action
     * @param type $string
     * @param type $secret_key
     * @return type
     */
    public function encrypt_decrypt($action, $string, $secret_key)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_iv = "";

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } elseif ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    /**
     *
     * @param String Get Extension
     * @return String Extension
     */
    public function getExtension($str)
    {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i+1, $l);
        return $ext;
    }

    public function dataTablesAjax($table, $primaryKey, $columsArray = array(), $sqljoinQuery = null, $extraWhere = null, $groupBy = null)
    {
        $tables = $table;
      // primaryKeys Tables
        $primaryKeys = $primaryKey;

      // echo $tables;die;
        $columns = $columsArray;
        $database = $this->load->database('default', true);
        $sql_details = array(
          'user' => $database->username,
          'pass' => $database->password,
          'db' => $database->database,
          'host' => $database->hostname,
        );
      // print_r($sql_details);die;
        require APPPATH . "third_party/MX/ssp.customized.class.php";
        echo json_encode(
              SSP::simple($_GET, $sql_details, $tables, $primaryKeys, $columns, $sqljoinQuery, $extraWhere, $groupBy)
        );
      // echo $this->db->last_query();die;
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
        $text = trim($text, '-');

      // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

      // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
