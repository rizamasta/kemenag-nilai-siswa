<?php
class Termcondition extends Abstract_Controller
{
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
    }
    public function index()
    {
        if ($this->_data_login['role']!='3') {
            $datatemplate['title'] = 'Term & Condition - '.$this->config->item('appName');
            $datatemplate['body'] = 'index';
            $datatemplate['full_name'] = $this->getFullName();
            $datatemplate['data_login'] = $this->_data_login;
            $dataGTC = $this->getModelTerms()->getTerms(1);
            if (empty($dataGTC)) {
                $dt = array(
                'type' =>1
            );
                $this->getModelTerms()->insertTerms($dt);
                $dataGTC = $this->getModelTerms()->getTerms(1);
            }
            $datatemplate['data'] = $dataGTC;
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
    public function privacy()
    {
        if ($this->_data_login['role']!='3') {
            $datatemplate['title'] = 'Term & Condition - '.$this->config->item('appName');
            $datatemplate['body'] = 'privacy_policy';
            $datatemplate['full_name'] = $this->getFullName();
            $datatemplate['data_login'] = $this->_data_login;
            $dataPRV = $this->getModelTerms()->getTerms(2);
            if (empty($dataPRV)) {
                $dt = array(
                'type' =>2
            );
                $this->getModelTerms()->insertTerms($dt);
                $dataPRV = $this->getModelTerms()->getTerms(1);
            }
            $datatemplate['data'] = $dataPRV;
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
    public function update($id)
    {
        if ($this->_data_login['role']!='3') {
            $redirect = $this->input->post('cur_url');
            $data = array(
            "content" => $this->input->post('content'),
          );
            if ($this->getModelTerms()->updateTerms($data, $id)) {
                $msg = array(
                        'alert_msg'=>'Success, Term and condition was updated',
                        'type_msg'=>'success',
                    );
            } else {
                $msg = array(
                        'alert_msg'=>'Update Term And Condition',
                        'type_msg'=>'failed',
                    );
            }
            $this->session->set_flashdata($msg);
            redirect($redirect);
        } else {
            $msg = array(
            'alert_msg'=>"Access denied. please contact administrator.",
            'type_msg'=>'error',
            );
            $this->session->set_flashdata($msg);
            redirect("logout");
        }
    }
}
