<?php

class Report extends Abstract_Controller
{
    protected $data;
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
    }

    public function index()
    {
        $datatemplate['title'] = 'All Report - '.$this->config->item('appName');
        $datatemplate['body'] = 'all';
        $datatemplate['data_login'] = $this->_data_login;
        $datatemplate['full_name'] = $this->getFullName();

        $this->load->view($this->config->item('vtemplate') . 'myheader', $datatemplate);
    }
    public function called()
    {
        $datatemplate['title'] = 'Called By CS Report - '.$this->config->item('appName');
        $datatemplate['body'] = 'called';
        $datatemplate['data_login'] = $this->_data_login;
        $datatemplate['full_name'] = $this->getFullName();
        $this->load->view($this->config->item('vtemplate') . 'myheader', $datatemplate);
    }
    public function waiting()
    {
        $datatemplate['title'] = 'Waiting Report - '.$this->config->item('appName');
        $datatemplate['body'] = 'waiting';
        $datatemplate['data_login'] = $this->_data_login;
        $datatemplate['full_name'] = $this->getFullName();
        $this->load->view($this->config->item('vtemplate') . 'myheader', $datatemplate);
    }
    public function helped()
    {
        $datatemplate['title'] = 'Helped Report - '.$this->config->item('appName');
        $datatemplate['body'] = 'helped';
        $datatemplate['data_login'] = $this->_data_login;
        $datatemplate['full_name'] = $this->getFullName();
        $this->load->view($this->config->item('vtemplate') . 'myheader', $datatemplate);
    }
    public function getReportJSON($id, $table)
    {
        if (!empty($_GET['type'])) {
            $p = $_GET['type'];
        } else {
            $p =1;
        }
        if ($p==1) {
            $this->type="Family Guard Help";
            $primaryKeys = 'id';
        } elseif ($p==2) {
            $this->type="Siskamling Help";
            $primaryKeys = 'id';
        } elseif ($p==3) {
            $this->type="Tour Help";
            $primaryKeys = 'id';
        }
        
        $res = $this->getModelReport()->getReportDetail($id, $table);
        $formatingDate = new DateTime($res->create_date);
        $res->create_date = $formatingDate->format('d M Y H:i');
        //get placename
        if (!empty($res->latitude) && !empty($res->longitude)) {
            try {
                $place_name = $this->getPlaceName($res->latitude, $res->longitude);
            } catch (Exception $e) {
                $place_name = '-';
            }
        } else {
            $place_name = '-';
        }
        //get user helping
        if ($res->status==0) {
            $table_helping = $table.'ing';
            $field = str_replace('tbl_', '', $table_helping);
            $helping = $this->getModelReport()->getHelping($res->id, $field, $table_helping);
            $res->helping = $helping;
        } else {
            $res->helping = array();
        }
        $res->place_name = $place_name;
        $res->type = $this->type;
        echo json_encode($res);
    }
    public function updateStatus()
    {
        $type_page = !empty($_GET['type'])?'?type='.$_GET['type']:'';
        $id = $this->input->post('id');
        $redirect = $this->input->post('cur_url');
        $table = $this->input->post('table');
        $settingTo = $this->input->post('set');
        $data = array(
            "cms_status" => $this->input->post('status'),
            "condition" => $this->input->post('condition')
        );
        if ($this->getModelReport()->updateReport($data, $table, $id)) {
            $msg = array(
                'alert_msg'=>'Set '.$settingTo,
                'type_msg'=>'success',
            );
        } else {
            $msg = array(
                'alert_msg'=>'Set '.$settingTo,
                'type_msg'=>'failed',
            );
        }
        $this->session->set_flashdata($msg);
        redirect($redirect.$type_page);
    }
    public function getAllAjax($p=1)
    {
        $this->tables = 'tbl_guard_help';
        $this->type="";
        $primaryKeys = 'id';
        if ($p==1) {
            $this->tables = 'tbl_guard_help';
            $this->type="Family Guard Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid) 
                                    RIGHT JOIN  tbl_guard as g on (g.id=h.guard_id)";
            $extraWhere ="g.type_guard=1";
        } elseif ($p==2) {
            $this->tables = 'tbl_siskamling_help';
            $this->type="Siskamling Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid)";
        } elseif ($p==3) {
            $this->tables = 'tbl_guard_help';
            $this->type="Tour Guard Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid) 
                          RIGHT JOIN  tbl_guard as g on (g.id=h.guard_id)";
            $extraWhere ="g.type_guard=2";
        }
        $columns = array(
                array('db' => "h.create_date", 'dt' => 0, 'field' => 'create_date','formatter'=>function ($create_date, $row) {
                    $date = new DateTime($create_date);
                    return  $date->format('d F Y');
                }),
                array('db' => "u.fullname", 'dt' => 1, 'field' => 'fullname'),
                array('db' => "u.phone_no", 'dt' => 2, 'field' => "phone_no",'formatter'=>function ($text, $row) {
                    return $this->type;
                }),
                array('db' => "u.place_name", 'dt' => 3, 'field' => 'place_name','formatter'=>function ($text, $row) {
                    if (!empty($row[6]) && !empty($row[7])) {
                        return $this->getPlaceName($row[6], $row[7]);
                    } else {
                        return "-";
                    }
                }),
               
                array('db' => "h.status", 'dt' => 4, 'field' => 'status'),
                array('db' => "h.cms_status", 'dt' => 5, 'field' => 'cms_status'),
                array('db' => "h.latitude", 'dt' => 6, 'field' => 'latitude'),
                array('db' => "h.longitude", 'dt' => 7, 'field' => 'longitude'),
                array('db' => "'$this->tables'", 'dt' => 8, 'field' => $this->tables),
                array('db' => "h.id", 'dt' => 9, 'field' => "id"),
            );
        $this->dataTablesAjax($this->tables, $primaryKeys, $columns, $joinQuery);
    }
    public function getAllCallAjax($p=1)
    {
        $this->tables = 'tbl_guard_help';
        $this->type="";
        $primaryKeys = 'id';
        if ($p==1) {
            $this->tables = 'tbl_guard_help';
            $this->type="Family Guard Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid) 
                          RIGHT JOIN  tbl_guard as g on (g.id=h.guard_id)";
            $extraWhere="h.cms_status=1 AND g.type_guard=1";
        } elseif ($p==2) {
            $this->tables = 'tbl_siskamling_help';
            $this->type="Siskamling Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid)";
            $extraWhere = "h.cms_status=1";
        } elseif ($p==3) {
            $this->tables = 'tbl_guard_help';
            $this->type="Tour Guard Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid) 
                          RIGHT JOIN  tbl_guard as g on (g.id=h.guard_id)";
            $extraWhere = "h.cms_status=1 AND g.type_guard=2";
        }
        $columns = array(
                array('db' => "h.create_date", 'dt' => 0, 'field' => 'create_date','formatter'=>function ($create_date, $row) {
                    $date = new DateTime($create_date);
                    return  $date->format('d F Y');
                }),
                array('db' => "u.fullname", 'dt' => 1, 'field' => 'fullname'),
                array('db' => "u.phone_no", 'dt' => 2, 'field' => "phone_no",'formatter'=>function ($text, $row) {
                    return $this->type;
                }),
                array('db' => "u.place_name", 'dt' => 3, 'field' => 'place_name','formatter'=>function ($text, $row) {
                    if (!empty($row[6]) && !empty($row[7])) {
                        return $this->getPlaceName($row[6], $row[7]);
                    } else {
                        return "-";
                    }
                }),
                array('db' => "h.status", 'dt' => 4, 'field' => 'status'),
                array('db' => "h.cms_status", 'dt' => 5, 'field' => 'cms_status'),
                array('db' => "h.latitude", 'dt' => 6, 'field' => 'latitude'),
                array('db' => "h.longitude", 'dt' => 7, 'field' => 'longitude'),
                array('db' => "'$this->tables'", 'dt' => 8, 'field' => $this->tables),
                array('db' => "h.id", 'dt' => 9, 'field' => "id"),
            );
        $this->dataTablesAjax($this->tables, $primaryKeys, $columns, $joinQuery);
    }
    public function getAllWaitingAjax($p=1)
    {
        $this->tables = 'tbl_guard_help';
        $this->type="";
        $primaryKeys = 'id';
        if ($p==1) {
            $this->tables = 'tbl_guard_help';
            $this->type="Family Guard Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid) 
                          RIGHT JOIN  tbl_guard as g on (g.id=h.guard_id)";
            $extraWhere ="h.cms_status=0 AND g.type_guard=1 ";
        } elseif ($p==2) {
            $this->tables = 'tbl_siskamling_help';
            $this->type="Siskamling Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid)";
            $extraWhere ="h.cms_status=0";
        } elseif ($p==3) {
            $this->tables = 'tbl_guard_help';
            $this->type="Tour Guard Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid)
                          RIGHT JOIN  tbl_guard as g on (g.id=h.guard_id)";
            $extraWhere ="h.cms_status=0 AND g.type_guard=2";
        }
        $columns = array(
                array('db' => "h.create_date", 'dt' => 0, 'field' => 'create_date','formatter'=>function ($create_date, $row) {
                    $date = new DateTime($create_date);
                    return  $date->format('d F Y');
                }),
                array('db' => "u.fullname", 'dt' => 1, 'field' => 'fullname'),
                array('db' => "u.phone_no", 'dt' => 2, 'field' => "phone_no",'formatter'=>function ($text, $row) {
                    return $this->type;
                }),
                array('db' => "u.place_name", 'dt' => 3, 'field' => 'place_name','formatter'=>function ($text, $row) {
                    if (!empty($row[6]) && !empty($row[7])) {
                        return $this->getPlaceName($row[6], $row[7]);
                    } else {
                        return "-";
                    }
                }),
                array('db' => "h.status", 'dt' => 4, 'field' => 'status'),
                array('db' => "h.cms_status", 'dt' => 5, 'field' => 'cms_status'),
                array('db' => "h.latitude", 'dt' => 6, 'field' => 'latitude'),
                array('db' => "h.longitude", 'dt' => 7, 'field' => 'longitude'),
                array('db' => "'$this->tables'", 'dt' => 8, 'field' => $this->tables),
                array('db' => "h.id", 'dt' => 9, 'field' => "id"),
            );
        $this->dataTablesAjax($this->tables, $primaryKeys, $columns, $joinQuery, $extraWhere);
    }
    public function getAllHelpedAjax($p=1)
    {
        $this->tables = 'tbl_guard_help';
        $this->type="";
        $primaryKeys = 'id';
        $andQuery ="";
        if ($p==1) {
            $this->tables = 'tbl_guard_help';
            $this->type="Family Guard Help";
            $primaryKeys = 'id';
            $andQuery ="";
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid)
                         RIGHT JOIN  tbl_guard as g on (g.id=h.guard_id)";
            $extraWhere = "h.status=0 AND g.type_guard=1";
        } elseif ($p==2) {
            $this->tables = 'tbl_siskamling_help';
            $this->type="Siskamling Help";
            $primaryKeys = 'id';
            $andQuery ="";
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid)";
            $extraWhere = "h.status=0";
        } elseif ($p==3) {
            $this->tables = 'tbl_guard_help';
            $this->type="Tour Guard Help";
            $primaryKeys = 'id';
            $joinQuery = "FROM ".$this->tables." as h RIGHT JOIN  tbl_user as u on (h.user_id=u.uid) 
                          RIGHT JOIN  tbl_guard as g on (g.id=h.guard_id)";
            $extraWhere ="h.status=0 AND g.type_guard=2";
        }
        $columns = array(
                array('db' => "h.create_date", 'dt' => 0, 'field' => 'create_date','formatter'=>function ($create_date, $row) {
                    $date = new DateTime($create_date);
                    return  $date->format('d F Y');
                }),
                array('db' => "u.fullname", 'dt' => 1, 'field' => 'fullname'),
                array('db' => "u.phone_no", 'dt' => 2, 'field' => "phone_no",'formatter'=>function ($text, $row) {
                    return $this->type;
                }),
                array('db' => "u.place_name", 'dt' => 3, 'field' => 'place_name','formatter'=>function ($text, $row) {
                    if (!empty($row[6]) && !empty($row[7])) {
                        return $this->getPlaceName($row[6], $row[7]);
                    } else {
                        return "-";
                    }
                }),
                array('db' => "h.status", 'dt' => 4, 'field' => 'status'),
                array('db' => "h.cms_status", 'dt' => 5, 'field' => 'cms_status'),
                array('db' => "h.latitude", 'dt' => 6, 'field' => 'latitude'),
                array('db' => "h.longitude", 'dt' => 7, 'field' => 'longitude'),
                array('db' => "'$this->tables'", 'dt' => 8, 'field' => $this->tables),
                array('db' => "h.id", 'dt' => 9, 'field' => "id"),
            );
        
        $this->dataTablesAjax($this->tables, $primaryKeys, $columns, $joinQuery, $extraWhere);
    }
}
