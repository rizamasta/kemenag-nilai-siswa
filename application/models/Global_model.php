<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This is an model Global
 * 
 *
 * @package         CodeIgniter
 * @category        Model
 * @author          Arief Budi Santoso
 */

class Global_model extends CI_Model {
    

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function createData($arrData = array(), $database = "")
    {
    	$arrSavingDb = array();
        $result = $this->db->list_fields($database);
        
        foreach($result as $field){
            //Insert Default Tracking data
            switch (strtolower($field)) {
                case 'is_created': $arrSavingDb[$field] = date('Y-m-d H:i:s'); break;
            }
            
            if (isset($arrData[$field])){
                $arrSavingDb[$field] = $arrData[$field];
            }
        }

        $this->db->insert($database, $arrSavingDb);
    }

    public function editData($arrData = array(), $arrWhere = array(), $database = "")
    {
        $arrSavingDb = array();
        $result = $this->db->list_fields($database);
        $bolValidWhere = false;
        
        //Data To Update
        foreach($result as $field){
            //Insert Default Tracking data
            switch (strtolower($field)) {
                case 'is_modified': $arrSavingDb[$field] = date('Y-m-d H:i:s'); break;
            }
            
            if (isset($arrData[$field])){
                $arrSavingDb[$field] = $arrData[$field];
            }
            
            if (isset($arrWhere[$field])){
                $bolValidWhere = true;
                
                if (is_array($arrWhere[$field])){
                    $this->db->where_in($field, $arrWhere[$field]);
                }else{
                    $this->db->where($field, $arrWhere[$field]);
                }
            }
        }
        
        if ($bolValidWhere){
            if (count($arrWhere) > 0){
                $this->db->update($database, $arrSavingDb);
            }
        }
    }

    public function deleteData($arrWhere = array(), $database = "")
    {
        $bolValidWhere = false;
        $result = $this->db->list_fields($this->strTableOrg);
        
        if (count($arrWhere) > 0){
            foreach($result as $field){
                if (isset($arrWhere[$field])){
                    $bolValidWhere = true;
                    if (is_array($arrWhere[$field])){
                        $this->db->where_in($field, $arrWhere[$field]);
                    }else{
                        $this->db->where($field, $arrWhere[$field]);
                    }
                }
            }
            
            if ($bolValidWhere){
                if (count($arrWhere) > 0){
                    $this->db->delete($database);
                }
            }
        }
    }

    public function getAllRecord($arrWhere = array(), $arrOrder = array(), $database = "")
    {
        //Flush Param
        $this->db->flush_cache();
            
        //Criteria
        if (count($arrWhere) > 0){
            foreach ($arrWhere as $strField => $strValue){
                if (is_array($strValue)){
                    $this->db->where_in($strField, $strValue);
                }elseif (preg_match("/(\s|<|>|!|=|is null|is not null)/i", $strValue)){
                    $this->db->where($strField." ".$strValue);
                }else{
                    $this->db->where($strField, $strValue);
                }
            }
        }
        
        //Order By
        if (count($arrOrder) > 0){
            foreach ($arrOrder as $strField => $strValue){
                $this->db->order_by($strField, $strValue);
            }
        }
        $query = $this->db->get($database)->result();

        return $query;
    }

    public function getAllRecordLike($arrLike = array(), $arrOrder = array(), $limit = 10, $offset = 0, $database = "")
    {
        //Flush Param if need
        //$this->db->flush_cache();

        //Criteria
        if (count($arrLike) > 0){
            foreach ($arrLike as $strField => $strValue){
                $this->db->like($strField, $strValue);
            }
        }

        //Order By
        if (count($arrOrder) > 0){
            foreach ($arrOrder as $strField => $strValue){
                $this->db->order_by($strField, $strValue);
            }
        }
        $query = $this->db->get($database, $limit, $offset)->result();

        return $query;
    }

    public function getLimitRecord($arrWhere = array(), $arrOrder = array(), $limit = 10, $offset = 0, $database = "")
    {
        //Criteria
        if (count($arrWhere) > 0){
            foreach ($arrWhere as $strField => $strValue){
                if (is_array($strValue)){
                    $this->db->where_in($strField, $strValue);
                }else{
                    $this->db->where($strField, $strValue);
                }
            }
        }
        
        //Order By
        if (count($arrOrder) > 0){
            foreach ($arrOrder as $strField => $strValue){
                $this->db->order_by($strField, $strValue);
            }
        }
    
        return $query = $this->db->get($database, $limit, $offset)->result();
    }

    public function getRows($database = ""){
        return $this->db->count_all_results($database);
    }

    public function getLimitRows($arrWhere = array(), $arrOrder = array(), $limit = 10, $offset = 0, $database = ""){
        $this->getLimitRecord($arrWhere, $arrOrder);
        return $this->db->count_all_results($database);
    }

    public function getCustomRows($arrWhere = array(), $arrOrder = array(), $database = ""){
        $this->getAllRecord($arrWhere, $arrOrder);
        return $this->db->count_all_results($database);
    }

}