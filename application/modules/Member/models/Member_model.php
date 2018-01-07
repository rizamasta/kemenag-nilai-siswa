<?php
class Member_model extends CI_Model
{
    protected $_table = 'tbl_user';
    protected $_files = 'tbl_files';
    protected $_history = 'tbl_guard_location';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMember($id)
    {
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where(array("uid"=>$id));
        return $this->db->get()->row();
    }
    public function getFotoProfile($id)
    {
        $this->db->select("path");
        $this->db->from($this->_files);
        $this->db->where(array("user_id" =>$id,
                                "_type"=>2)
                        );
        return $this->db->get()->row();
    }
    public function getFoto($id)
    {
        $this->db->select("path");
        $this->db->from($this->_files);
        $this->db->where(" user_id =".$id." AND (_type=1 OR _type=3)");
        return $this->db->get()->result();
    }
    public function getMemberHistory($id, $limit = 20)
    {
        $this->db->select("*");
        $this->db->from($this->_history);
        $this->db->where(array("userid"=>$id));
        $this->db->order_by("create_date", "desc");
        $this->db->limit($limit, 0);
        return $this->db->get()->result();
    }
    public function getMemberLastLocation($id)
    {
        $this->db->select("place_name");
        $this->db->from($this->_history);
        $this->db->where(array("userid"=>$id));
        $this->db->order_by("create_date", "desc");
        return $this->db->get()->row();
    }
    public function getTotalMember()
    {
        $this->db->select("count(uid) as total");
        $this->db->from($this->_table);
        $this->db->where(array('is_active'=>1));
        return $this->db->get()->row();
    }
    public function getAllMember()
    {
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where(array('is_active'=>1));
        return $this->db->get()->result();
    }
    public function updateMember($data, $id)
    {
        return $this->db->update($this->_table, $data, array('uid' => $id));
    }
}
