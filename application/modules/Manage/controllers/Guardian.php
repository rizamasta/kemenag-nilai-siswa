<?php

class Guardian extends Abstract_Controller
{
    protected $data;
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
    }

    public function index()
    {
        if ($this->_data_login['role']!='3') {
            $datatemplate['title'] = 'Manage Guardian - '.$this->config->item('appName');
            $datatemplate['body'] = 'view';
            $datatemplate['data_login'] = $this->_data_login;
            $datatemplate['full_name'] = $this->getFullName();
            $datatemplate['guardian'] = $this->getModelManage()->countGuardian(1);
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
    public function getGuardianAjax()
    {
        $tables = 'tbl_guard';
        $primaryKeys = 'id';
        $columns = array(
            array('db' => "g.name", 'dt' => 0, 'field' => 'name','formatter'=>function ($name, $row) {
                return  $name;
            }),
            array('db' => "g.create_date", 'dt' => 1, 'field' => 'create_date','formatter'=>function ($create_date, $row) {
                $date = new DateTime($create_date);
                return  $date->format('d F Y');
            }),
            array('db' => "u.fullname", 'dt' => 2, 'field' => 'fullname','formatter'=>function ($name, $row) {
                return  $name;
            }),
            array('db' => "is_suspend", 'dt' => 3, 'field' => 'is_suspend','formatter' => function ($id, $row) {
                $ug = $this->getModelGuardian()->getAllUnderGuard($row[4]);
                $guardian = "<div class='user'>";
                foreach ($ug as $v) {
                    $foto = $this->getModelMember()->getFotoProfile($v->uid);
                    if (!empty($foto->path)) {
                        $guardian .="<div class='ratio1_1 box_img'> 
                                        <div class='img_con' title='".$v->fullname."'> 
                                            <img src='".$foto->path."' alt='".substr($v->fullname, 0, 1)."'> 
                                        </div> 
                                    </div>";
                    } else {
                        $guardian .="<div class='ratio1_1 box_img'> 
                                        <div class='img_con' title='".$v->fullname."'> 
                                            ".substr($v->fullname, 0, 1)." 
                                        </div> 
                                    </div>";
                    }
                }
                return $guardian."</div>";
            }),
            array('db' => "g.id", 'dt' => 4, 'field' => 'id'),
        );
        $joinQuery = "FROM tbl_guard as g RIGHT JOIN  tbl_guard_list as l on (g.id=l.guard_id)
        RIGHT JOIN tbl_user as u ON (u.uid=l.user_id) WHERE g.type_guard=1 AND l.type_guard_group=1";
        $this->dataTablesAjax($tables, $primaryKeys, $columns, $joinQuery);
    }
}
