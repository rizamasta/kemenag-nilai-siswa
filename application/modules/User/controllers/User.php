<?php
class User extends Abstract_Controller
{
    protected $_data_login;
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
    }

    public function index()
    {
        if ($this->_data_login['role']=='1') {
            $datatemplate['full_name'] = $this->getFullName();
            $datatemplate['title'] = 'User - '.$this->config->item('appName');
            $datatemplate['body'] = 'view';
            $datatemplate['data_login'] = $this->_data_login;
            $datatemplate['data_user'] = $this->getModelUser()->getAllUser();
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
        if ($this->_data_login['role']=='1') {
            if (!empty($_POST)) {
                $data = array(
                "first_name" => $this->input->post('first_name'),
                "last_name" => $this->input->post('last_name'),
                "username" => $this->input->post('username'),
                "email" => $this->input->post('email'),
                "password" => hash('sha256', str_replace(' ', '', $this->input->post('username'))),
                "role" =>$this->input->post('role'),
                "created_by" =>$this->_data_login["id"],
                "updated_by" =>$this->_data_login["id"],
                "status" =>"1",
                 );
                if ($this->getModelUser()->insertUser($data)) {
                    $msg = array(
                           'alert_msg'=>'Success adding new user',
                           'type_msg'=>'success',
                       );
                } else {
                      $msg = array(
                          'alert_msg'=>'Add User',
                          'type_msg'=>'failed',
                      );
                }
                  $this->session->set_flashdata($msg);
                  redirect("user");
            } else {
                $datatemplate['full_name'] = $this->getFullName();
                $datatemplate['title'] = 'User - '.$this->config->item('appName');
                $datatemplate['body'] = 'form';
                $datatemplate['formTitle']='Tambah Data Pengguna';
                $datatemplate['data_login'] = $this->_data_login;
                $datatemplate['data_user'] = $this->getModelUser()->getAllUser();
                $this->load->view($this->config->item('vtemplate') . 'myheader', $datatemplate);
            }
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
        if ($this->_data_login['role']=='1') {
            if(!empty($_POST)){
                $data = array(
                "first_name" => $this->input->post('first_name'),
                "last_name" => $this->input->post('last_name'),
                "username" => $this->input->post('username'),
                "email" => $this->input->post('email'),
                "role" =>$this->input->post('role'),
                "updated_by" =>$this->_data_login["id"],
                );
                if (!empty($this->input->post('password'))) {
                    $data['password']=hash('sha256', str_replace(' ', '', $this->input->post('password')));
                }
                if ($this->getModelUser()->updateUser($data, $id)) {
                    $msg = array(
                            'alert_msg'=>'Success, User was updated',
                            'type_msg'=>'success',
                        );
                } else {
                    $msg = array(
                            'alert_msg'=>'Update User',
                            'type_msg'=>'failed',
                        );
                }
                $this->session->set_flashdata($msg);
                redirect("user");
            }
            else {
                $datatemplate['full_name'] = $this->getFullName();
                $datatemplate['title'] = 'User - '.$this->config->item('appName');
                $datatemplate['body'] = 'form';
                $datatemplate['formTitle']='Ubah Data Pengguna';
                $datatemplate['data_login'] = $this->_data_login;
                $datatemplate['data_user'] = $this->getModelUser()->getAllUser();
                $this->load->view($this->config->item('vtemplate') . 'myheader', $datatemplate);
            }
        } else {
            $msg = array(
                'alert_msg'=>"Access denied. please contact administrator.",
                'type_msg'=>'error',
            );
            $this->session->set_flashdata($msg);
            redirect("logout");
        }
    }
    public function saveSetting()
    {
        $post = json_decode(file_get_contents('php://input'));
        $data = array(
            "first_name" => $post->first_name,
            "last_name" => $post->last_name,
            "updated_by" =>$this->_data_login["id"],
          );
        if (!empty($post->password)) {
            $data['password']=hash('sha256', str_replace(' ', '', $post->new_password));
        }
        if ($this->getModelUser()->updateUser($data, $this->_data_login["id"])) {
            $user = $this->getModelUser()->getUser($this->_data_login['id']);
            $data_user = array(
                'id' =>$user->id,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'role'=> $user->role,
            );
            $this->session->set_userdata('userKemenag', $data_user);
            $msg = array(
                        'alert_msg'=>'Success, User was updated',
                        'type_msg'=>'success',
                    );
        } else {
            $msg = array(
                        'alert_msg'=>'Update User',
                        'type_msg'=>'failed',
                    );
        }
        echo json_encode($msg);
    }
    public function delete($id)
    {
        if ($this->_data_login['role']=='1') {
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
                'alert_msg'=>"You don't have privileges to delete user",
                'type_msg'=>'failed',
            );
            $this->session->set_flashdata($msg);
            redirect("logout");
        }
    }
    public function getUserSetting()
    {
        $id = $this->_data_login["id"];
        $res = $this->getModelUser()->getUser($id);
        echo json_encode($res);
    }
    public function checkPassword()
    {
        $post = json_decode(file_get_contents('php://input'));
        $pw = hash('sha256', str_replace(' ', '', $post->password));
        $user = $this->getModelUser()->getUser($this->_data_login['id']);
        if ($user->password == $pw) {
            echo "true";
        } else {
            echo "false";
        }
    }
    public function getUserJSON($id)
    {
        if ($this->_data_login['role']=='1') {
            $res = $this->getModelUser()->getUser($id);
        } else {
            $res = array(
                'status' =>400,
                'msg' =>'Forbidden Access'
            );
        }
        echo json_encode($res);
    }
}
