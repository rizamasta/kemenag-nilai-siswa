<?php

class Custom extends Abstract_Controller
{
    public function __construct()
    {
    }

    public function error_404()
    {
        $datatemplate['title'] = '404 PAGE NOT FOUND - '.$this->config->item('appName');
        $this->load->view($this->config->item('verror') . '404', $datatemplate);
    }
}
