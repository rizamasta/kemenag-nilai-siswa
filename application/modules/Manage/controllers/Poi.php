<?php

class Poi extends Abstract_Controller
{
    protected $data;
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
        $this->load->helper('s3');
    }

    public function index()
    {
        if ($this->_data_login['role']!='3') {
            $datatemplate['title'] = 'Manage POI - '.$this->config->item('appName');
            $datatemplate['body'] = 'view';
            $datatemplate['data_login'] = $this->_data_login;
            $datatemplate['full_name'] = $this->getFullName();
            $this->load->view($this->config->item('vtemplate') . 'myheader', $datatemplate);
        } else {
            $msg = array(
                    'alert_msg'=>"Access denied. please contact administrator.",
                    'type_msg'=>'error',
                );
            $this->session->set_flashdata($msg);
            redirect("logout");
        }
    }
    public function add()
    {
        if ($this->_data_login['role']!='3') {
            $poi_type = !empty($_GET['poi_type'])?'?poi_type='.$_GET['poi_type']:'';
            $data = array(
            "poi_name" => $this->input->post('poi_name'),
            "poi_type" => $this->input->post('poi_type'),
            "phone_no" => $this->input->post('phone_no'),
            "phone_no_24" => $this->input->post('phone_no_24'),
            "image_name" => $this->input->post('image_name'),
            "region" => $this->input->post('region'),
            "latitude" => $this->input->post('latitude'),
            "longitude" => $this->input->post('longitude'),
            "address" =>$this->input->post('address'),
            "status" =>"1",
            );
            if (empty($this->input->post('is_24hours'))) {
                $data['is_24hours'] = 0;
                $data['open'] =$this->input->post('open');
                $data['close'] = $this->input->post('close');
            }
            if (!empty($_FILES['gambar'])) {
                $image = $_FILES['gambar'];
                $extension = $this->getExtension($image['name']);
                $image_name = md5(str_replace(' ', '_', date('Ymdhis') . $image['name'])) . '.' . $extension;
                $image_path = $this->config->item('s3_folder');
                $destination = 's3://' . $this->config->item('s3_bucket') . $image_path . $image_name;
                $image_url = $this->config->item('cdn');
                if (move_uploaded_file($image['tmp_name'], $destination)) {
                    $data['image_url'] = $image_url.$image_path . $image_name;
                }
            }
            if ($this->getModelPoi()->insertPoi($data)) {
                $msg = array(
                        'alert_msg'=>'Success adding new POI',
                        'type_msg'=>'success',
                    );
            } else {
                $msg = array(
                        'alert_msg'=>'Add POI',
                        'type_msg'=>'failed',
                    );
            }
            $this->session->set_flashdata($msg);
            redirect("manage/poi".$poi_type);
        } else {
            $msg = array(
                'alert_msg'=>"Access denied. please contact administrator.",
                'type_msg'=>'error',
            );
            $this->session->set_flashdata($msg);
            redirect("logout");
        }
    }
    public function edit($id)
    {
        if ($this->_data_login['role']!='3') {
            $poi_type = !empty($_GET['poi_type'])?'?poi_type='.$_GET['poi_type']:'';
            $data = array(
            "poi_name" => $this->input->post('poi_name'),
            "poi_type" => $this->input->post('poi_type'),
            "phone_no" => $this->input->post('phone_no'),
            "phone_no_24" => $this->input->post('phone_no_24'),
            "image_name" => $this->input->post('image_name'),
            "region" => $this->input->post('region'),
            "latitude" => $this->input->post('latitude'),
            "longitude" => $this->input->post('longitude'),
            "address" =>$this->input->post('address')
            );
            if (empty($this->input->post('is_24hours'))) {
                $data['is_24hours'] = 0;
                $data['open'] =$this->input->post('open');
                $data['close'] = $this->input->post('close');
            }
            if (!empty($_FILES['gambar'])) {
                $image = $_FILES['gambar'];
                $extension = $this->getExtension($image['name']);
                $image_name = md5(str_replace(' ', '_', date('Ymdhis') . $image['name'])) . '.' . $extension;
                $image_path = $this->config->item('s3_folder');
                $destination = 's3://' . $this->config->item('s3_bucket') . $image_path . $image_name;
                $image_url = $this->config->item('cdn');
                if (move_uploaded_file($image['tmp_name'], $destination)) {
                    $data['image_url'] = $image_url.$image_path . $image_name;
                }
            }

            if ($this->getModelPoi()->updatePoi($data, $id)) {
                $msg = array(
                        'alert_msg'=>'Success, POI was updated',
                        'type_msg'=>'success',
                    );
            } else {
                $msg = array(
                        'alert_msg'=>'Update POI',
                        'type_msg'=>'failed',
                    );
            }
            $this->session->set_flashdata($msg);
            redirect("manage/poi".$poi_type);
        } else {
            $msg = array(
                'alert_msg'=>"Access denied. please contact administrator.",
                'type_msg'=>'error',
            );
            $this->session->set_flashdata($msg);
            redirect("logout");
        }
    }
    public function getPoiAjax($type)
    {
        $tables = 'tbl_poi';
        $primaryKeys = 'id';
        $columns = array(
            array('db' => "poi_name", 'dt' => 0, 'field' => 'poi_name'),
            array('db' => "address", 'dt' => 1, 'field' => 'address'),
            array('db' => "phone_no_24", 'dt' => 2, 'field' => 'phone_no_24'),
            array('db' => "region", 'dt' => 3, 'field' => 'region'),
            array('db' => "is_24hours", 'dt' => 4, 'field' => 'is_24hours'),
            array('db' => "phone_no", 'dt' => 5, 'field' => 'phone_no'),
            array('db' => "id", 'dt' => 6, 'field' => 'id')
        );
        $joinQuery ="FROM tbl_poi WHERE poi_type=".$type." AND status=1";
        $this->dataTablesAjax($tables, $primaryKeys, $columns, $joinQuery);
    }
    public function getPOI($id)
    {
        echo json_encode($this->getModelPoi()->getPoiDetail($id));
    }
}
