<?php

class Dashboard extends Abstract_Controller
{
    protected $data;
    public function __construct()
    {
        $this->_data_login= $this->checkLogin();
    }

    public function index()
    {
        $datatemplate['title'] = 'Dashboard';
        $datatemplate['body'] = 'view';
        $datatemplate['full_name'] = $this->getFullName();
        $datatemplate['data_login'] = $this->_data_login;
        $this->load->view($this->config->item('vtemplate') . 'myheader', $datatemplate);
    }
    public function getDataNotification()
    {
        $dataHelp = $this->getModelDashboard()->getHelp();
        $dataSiskamling = $this->getModelDashboard()->getHelpSiskamling();
        $total_notif =0;
        $total_notif =count($dataHelp)+count($dataSiskamling);
        foreach ($dataSiskamling as $siskamling) {
            array_push($dataHelp, $siskamling);
        }
        $result = array();
        foreach ($dataHelp as $data) {
            if (empty($data->location)) {
                $place = $this->getPlaceName($data->latitude, $data->longitude);
                $data->location = $place;
                $updateTbl = array('place_name'=>$place);
                $tbl = $data->type==2?'tbl_siskamling_help':'tbl_guard_help';
                $this->getModelDashboard()->updateLocation($tbl, $updateTbl, $data->id);
            }
            $id = $data->tanggal;
            if (isset($result[$id])) {
                $result[$id][] = $data;
            } else {
                $result[$id] = array($data);
            }
        }
        $summary = array(
            'total' => $total_notif,
            'data' => $result
        );
        // $this->pr($summary);
        echo json_encode($summary);
    }
}
