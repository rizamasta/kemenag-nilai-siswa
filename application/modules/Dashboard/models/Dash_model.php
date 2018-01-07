<?php
class Dash_model extends CI_Model
{
    protected $guard = 'tbl_guard';
    protected $help = 'tbl_guard_help';
    protected $helping = 'tbl_guard_helping';
    protected $siskamling = 'tbl_siskamling';
    protected $siskamling_help = 'tbl_siskamling_help';
    protected $files = 'tbl_files';
    protected $siskamling_helping = 'tbl_siskamling_helping';
    protected $user = 'tbl_user';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getHelp()
    {
        $this->db->select("DATE_FORMAT(".$this->help.".create_date".", '%d %M') as tanggal,".
                          $this->help.".id,".
                          "IF(".$this->guard.".type_guard = '1','1', '3') as type,".
                          "IF(".$this->guard.".type_guard = '1','family', 'tour') as icon,".
                          $this->files.".path,".
                          $this->help.".latitude,".
                          $this->help.".longitude,".
                          $this->help.".place_name as location,".
                          $this->help.".status,".
                          $this->help.".create_date,".
                          $this->help.".cms_status,".
                          $this->user.".fullname,".
                          $this->user.".phone_no,".
                          "IF(".$this->guard.".type_guard = '1','Family Guard', 'Tour Guard') as report_type"
                        );
        $this->db->from($this->help);
        $this->db->join($this->guard, $this->guard.".id = ".$this->help.".guard_id", "left");
        $this->db->join($this->helping, $this->helping.".guard_helping = ".$this->help.".id", "left");
        $this->db->join($this->user, $this->user.".uid = ".$this->help.".user_id", "left");
        $this->db->join($this->files, $this->user.".uid = ".$this->files.".user_id", "left");
        $this->db->where(array($this->help.".cms_status"=>0,
                                $this->files."._type"=>2
                                ));
        $this->db->order_by($this->help.".create_date", "desc");
        return $this->db->get()->result();
    }
    public function getHelpSiskamling()
    {
        $this->db->select("DATE_FORMAT(".$this->siskamling_help.".create_date".", '%d %M') as tanggal,".
                            $this->siskamling_help.".id,".
                            "'2' as type,".
                            "'siskamling' as icon,".
                            $this->files.".path,".
                            $this->siskamling_help.".latitude,".
                            $this->siskamling_help.".longitude,".
                            $this->siskamling_help.".place_name as location,".
                            $this->siskamling_help.".status,".
                            $this->siskamling_help.".create_date,".
                            $this->siskamling_help.".cms_status,".
                            $this->user.".fullname,".
                            $this->user.".phone_no,".
                            "IF(".$this->siskamling.".type = '1','Siskamling House', 'Siskamling Friend') as report_type"
                        );
        $this->db->from($this->siskamling_help);
        $this->db->join($this->siskamling, $this->siskamling.".id = ".$this->siskamling_help.".idsiskamling", "left");
        $this->db->join($this->siskamling_helping, $this->siskamling_helping.".siskamling_helping = ".$this->siskamling_help.".id", "left");
        $this->db->join($this->user, $this->user.".uid = ".$this->siskamling_help.".user_id", "left");
        $this->db->join($this->files, $this->user.".uid = ".$this->files.".user_id", "left");
        $this->db->where(array($this->siskamling_help.".cms_status"=>0,$this->files."._type"=>2));
        $this->db->order_by($this->siskamling_help.".create_date", "desc");
        return $this->db->get()->result();
    }
    public function updateLocation($tbl, $data, $id)
    {
        return $this->db->update($tbl, $data, array('id'=>$id));
    }
}
