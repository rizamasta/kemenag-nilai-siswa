<?php

class Tourguard extends Abstract_Controller
{
    protected $data;
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
    }

    public function index()
    {
        if ($this->_data_login['role']!='3') {
            $datatemplate['title'] = 'Manage Tour Guard - '.$this->config->item('appName');
            $datatemplate['body'] = 'view';
            $datatemplate['data_login'] = $this->_data_login;
            $datatemplate['full_name'] = $this->getFullName();
            $datatemplate['tour_guard'] = $this->getModelManage()->countGuardian(2);
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
    public function getTourGuardAjax()
    {
        $tables = 'tbl_guard';
        $primaryKeys = 'id';
        $columns = array(
            array('db' => "g.name", 'dt' => 0, 'field' => 'name','formatter'=>function ($name, $row) {
                return  $name;
            }),
            array('db' => "g.start", 'dt' => 1, 'field' => 'start','formatter'=>function ($start, $row) {
                $date = new DateTime($start);
                return  $date->format('d F Y');
            }),
            array('db' => "g.end", 'dt' => 2, 'field' => 'end','formatter'=>function ($end, $row) {
                $date = new DateTime($end);
                return  $date->format('d F Y');
            }),
            array('db' => "g.id", 'dt' => 3, 'field' => 'id','formatter' => function ($id, $row) {
                $ug = $this->getModelManage()->getAllUnderGuard($id);
                return count($ug);
            }),
            array('db' => "g.status", 'dt' => 4, 'field' => 'status','formatter' => function ($status, $row) {
                $s ="";
                if ($status==1) {
                    $s="<span class='label_status'>Active</span>";
                } else {
                    $s="<span class='label_status past'>Inactive</span>";
                }
                return $s;
            }),
        );
        $joinQuery = " FROM tbl_guard as g LEFT JOIN  tbl_guard_list as l on (g.id=l.guard_id)
        LEFT JOIN tbl_user as u ON (u.uid=l.user_id) WHERE g.type_guard=2 AND l.type_guard_group=1";
        $this->dataTablesAjax($tables, $primaryKeys, $columns, $joinQuery);
    }
}
