<?php

class Login extends Abstract_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $datatemplate['title'] = "Login - " . $this->config->item('appName');
        $login = $this->userInfo();
        if (empty($login)) {
            $this->load->view($this->config->item('vtemplate') . 'login');
        } else {
            redirect("");
        }
    }


    public function auth()
    {
        if (!empty($_POST)) {
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('email', 'username', 'required');
            if ($this->form_validation->run() == true) {
                $password = hash('sha256', str_replace(' ', '', $this->input->post('password')));
                $data =  $this->getModelUser()->getAuth($this->input->post('email'), $password);
                if (!empty($data)) {
                    $data_login = array(
                        'id' =>$data->id,
                        'email' => $data->email,
                        'first_name' => $data->first_name,
                        'last_name' => $data->last_name,
                        'username' => $data->username,
                        'role'=> $data->role,
                    );
                    $this->session->set_userdata('userKemenag', $data_login);
                    $msg = array(
                         'alert_msg'=>'Welcome back, '.$data->name.'!',
                         'type_msg'=>'success',
                     );
                    $this->session->set_flashdata($msg);
                    redirect("");
                } else {
                    $msg = array(
                        'alert_msg'=>'Incorrect username or password.',
                        'type_msg'=>'error',
                    );
                    $this->session->set_flashdata($msg);
                }
            } else {
                $msg = array(
                    'alert_msg'=>'Please compelete input form.',
                    'type_msg'=>'error',
                );
            }
            $this->index();
        }
    }

    public function logout()
    {
        $msg = $this->session->flashdata();
        $this->session->unset_userdata('userKemenag');
        $this->session->set_flashdata($msg);
        redirect('login');
    }
}
