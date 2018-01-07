<?php
class Terms_model extends CI_Model
{
    protected $_table = 'tbl_static_content';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getTerms($type = 1)
    {
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where(array("type"=>$type));
        return $this->db->get()->row();
    }
    public function insertTerms($data)
    {
        return $this->db->insert($this->_table, $data);
    }
    public function updateTerms($data, $id)
    {
        return $this->db->update($this->_table, $data, array('id' => $id));
    }
}
