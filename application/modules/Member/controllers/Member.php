<?php
class Member extends Abstract_Controller
{
    protected $_data_login;
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
    }

    public function index()
    {
        if ($this->_data_login['role']!='3') {
            $datatemplate['data_login'] = $this->_data_login;
            $datatemplate['full_name'] = $this->getFullName();
            $datatemplate['title'] = 'Member - '.$this->config->item('appName');
            $datatemplate['body'] = 'view';
            $datatemplate['total_member'] = $this->getModelMember()->getTotalMember();
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
    public function edit($id)
    {
        if ($this->_data_login['role']!='3') {
            $data = array(
            "is_suspend" => !empty($this->input->post('is_suspend'))?"0":"1"
            );
            if (!empty($this->input->post('is_suspend'))) {
                $data['is_verify_idcard']=1;
            }
            if ($this->getModelMember()->updateMember($data, $id)) {
                $msg = array(
                        'alert_msg'=>'Success, Member was updated',
                        'type_msg'=>'success',
                    );
            } else {
                $msg = array(
                        'alert_msg'=>'Update Member',
                        'type_msg'=>'failed',
                    );
            }
            $this->session->set_flashdata($msg);
            redirect("member");
        } else {
            $msg = array(
            'alert_msg'=>"Access denied. please contact administrator.",
            'type_msg'=>'error',
            );
            $this->session->set_flashdata($msg);
            redirect("logout");
        }
    }
    public function delete($id)
    {
        if ($this->_data_login['role']!='3') {
            $data = array(
            "updated_by" =>$this->_data_login["id"],
            "status" =>0
            );
            if ($this->getModelUser()->updateUser($data, $id)) {
                $msg = array(
                        'alert_msg'=>'Success, User was deleted',
                        'type_msg'=>'success',
                    );
            } else {
                $msg = array(
                        'alert_msg'=>'Delete User',
                        'type_msg'=>'failed',
                    );
            }
            $this->session->set_flashdata($msg);
            redirect("user");
        } else {
            $msg = array(
                'alert_msg'=>"You don't have privileges to access for delete Member",
                'type_msg'=>'failed',
            );
            $this->session->set_flashdata($msg);
            redirect("logout");
        }
    }
    public function getMemberJSON($id)
    {
        $res = $this->getModelMember()->getMember($id);
        $res->foto = $this->getModelMember()->getFoto($id);
        echo json_encode($res);
    }
    public function getHistory($id)
    {
        $res = $this->getModelMember()->getMemberHistory($id, 50);
        echo json_encode($res);
    }
    public function getMemberAjax()
    {
        $tables = 'tbl_user';
        $primaryKeys = 'uid';
        $columns = array(
            array('db' => "fullname", 'dt' => 0, 'field' => 'fullname'),
            array('db' => "phone_no", 'dt' => 1, 'field' => 'phone_no'),
            array('db' => "email", 'dt' => 2, 'field' => 'email'),
            array('db' => "is_suspend", 'dt' => 3, 'field' => 'is_suspend','formatter' => function ($id, $row) {
                if ($id=="1") {
                    $btn =  "<a><span class='label_status past'>Inactive</span></a>";
                } else {
                    $btn = "<a><span class='label_status'>Active</span></a>";
                }
                return $btn;
            }),
            array('db' => "uid", 'dt' => 4, 'field' => 'uid'),
        );
        $joinQuery = "";
        $extraWhere="is_active=1";
        $this->dataTablesAjax($tables, $primaryKeys, $columns, $joinQuery, $extraWhere);
    }
}
