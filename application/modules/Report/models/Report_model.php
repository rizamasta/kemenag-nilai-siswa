<?php
class Report_model extends CI_Model
{
    protected $help = 'tbl_guard_help';
    protected $helping = 'tbl_guard_helping';
    protected $member = 'tbl_user';
    protected $files = 'tbl_files';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getCountAll()
    {
        $this->db->select("COUNT(".$this->help.".id) as total");
        $this->db->from($this->help);
        return $this->db->get()->row();
    }
    public function getCountWithStatus($status = 0)
    {
        $this->db->select("COUNT(".$this->help.".id) as total");
        $this->db->from($this->help);
        $this->db->where(array($this->help.".cms_status"=>$status));
        return $this->db->get()->row();
    }
    public function getHelping($id, $field, $table_helping)
    {
        $this->db->select($this->member.".fullname,".$this->files.".path");
        $this->db->from($this->member);
        $this->db->join($table_helping, $table_helping.".user_id = ".$this->member.".uid", "left");
        $this->db->join($this->files, $this->member.".uid = ".$this->files.".user_id", "left");
        $this->db->where(array($table_helping.".".$field=>$id,$this->files."._type"=>2));
        return  $this->db->get()->result();
    }
    public function getReportDetail($id, $table)
    {
        $this->db->select($table.".*,".$this->member.".fullname,".$this->member.".phone_no");
        $this->db->from($table);
        $this->db->join($this->member, $this->member.".uid = ".$table.".user_id", "left");
        $this->db->where(array($table.".id"=>$id));
        return  $this->db->get()->row();
    }
    public function updateReport($data, $table, $id)
    {
        return $this->db->update($table, $data, array('id' => $id));
    }
}
