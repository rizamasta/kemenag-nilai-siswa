<?php

class Siskamling extends Abstract_Controller
{
    protected $data;
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
    }

    public function index()
    {
        if ($this->_data_login['role']!='3') {
            $datatemplate['title'] = 'Manage Siskamling - '.$this->config->item('appName');
            $datatemplate['body'] = 'view';
            $datatemplate['data_login'] = $this->_data_login;
            $datatemplate['total'] = $this->getModelSiskamling()->countSiskamling();
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
    public function getSiskamlingJSON($id)
    {
        $res = $this->getModelSiskamling()->getSiskamling($id);
        $res->member = $this->getModelSiskamling()->getAllMember($id);
        echo json_encode($res);
    }
    public function getSiskamlingAjax()
    {
        $tables = 'tbl_siskamling';
        $primaryKeys = 'id';
        $columns = array(
            array('db' => "name", 'dt' => 0, 'field' => 'name'),
            array('db' => "address", 'dt' => 1, 'field' => 'address'),
            array('db' => "'total'", 'dt' => 2, 'field' => 'total','formatter'=>function ($total, $row) {
                return  $total." Member";
            }),
            array('db' => "create_date", 'dt' => 3, 'field' => 'create_date','formatter'=>function ($create_date, $row) {
                $date = new DateTime($create_date);
                return  $date->format('d F Y');
            }),
            array('db' => "status", 'dt' => 4, 'field' => 'status','formatter' => function ($status, $row) {
                return $status;
            }),
            array('db' => "id", 'dt' => 5, 'field' => 'id')
        );
        $joinQuery = ",(SELECT COUNT(*) FROM tbl_siskamling_list as l WHERE l.siskamling_id = tbl_siskamling.id ) as total FROM tbl_siskamling";
        $this->dataTablesAjax($tables, $primaryKeys, $columns, $joinQuery);
    }
}
