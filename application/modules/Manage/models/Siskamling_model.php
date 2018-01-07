<?php
class Siskamling_model extends CI_Model
{
    protected $table = 'tbl_siskamling';
    protected $user = 'tbl_user';
    protected $list = 'tbl_siskamling_list';
    protected $file = 'tbl_files';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function countSiskamling()
    {
        $this->db->select("count(".$this->table.".id) as total");
        $this->db->from($this->table);
        return $this->db->get()->row();
    }
    public function getSiskamling($id)
    {
        $this->db->select("name,address");
        $this->db->from($this->table);
        return $this->db->get()->row();
    }
    public function getAllMember($id)
    {
        $this->db->select($this->user.".fullname,".$this->file.".path");
        $this->db->from($this->list);
        $this->db->join($this->user, $this->user.".uid = ".$this->list.".user_id", "left");
        $this->db->join($this->file, $this->user.".uid = ".$this->file.".user_id", "left");
        $this->db->where(array(
                                $this->list.".siskamling_id" =>$id,
                                $this->file."._type"=>2));
        return $this->db->get()->result();
    }
}
