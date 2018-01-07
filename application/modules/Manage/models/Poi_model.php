<?php
class Poi_model extends CI_Model
{
    protected $poi = 'tbl_poi';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function insertPoi($data)
    {
        return $this->db->insert($this->poi, $data);
    }
    public function updatePoi($data, $id)
    {
        return $this->db->update($this->poi, $data, array('id' => $id));
    }
    public function getPoiDetail($id)
    {
        $this->db->select("*");
        $this->db->from($this->poi);
        $this->db->where(array($this->poi.".id" =>$id));
        return $this->db->get()->row();
    }
}
