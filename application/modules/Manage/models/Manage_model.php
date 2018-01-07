<?php
class Manage_model extends CI_Model
{
    protected $user = 'tbl_user';
    protected $guard = 'tbl_guard';
    protected $list = 'tbl_guard_list';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function countGuardian($type)
    {
        $this->db->select("count(".$this->guard.".id) as total");
        $this->db->from($this->guard);
        $this->db->join($this->list, $this->list.".guard_id = ".$this->guard.".id", "left");
        $this->db->join($this->user, $this->user.".uid = ".$this->list.".user_id", "left");
        $this->db->where(array(
                                $this->guard.".type_guard"=>$type,
                                $this->list.".type_guard_group"=>1
                                ));
        return $this->db->get()->row();
    }
    public function getAllUnderGuard($guard_id)
    {
        $this->db->select($this->user.".fullname,".$this->user.".uid");
        $this->db->from($this->list);
        $this->db->join($this->user, $this->user.".uid = ".$this->list.".user_id", "left");
        $this->db->where(array(
                                $this->list.".guard_id" =>$guard_id,
                                $this->list.".type_guard_group!="=>1));
        return $this->db->get()->result();
    }
}
