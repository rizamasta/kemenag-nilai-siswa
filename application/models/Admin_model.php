<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public $strTableName = "ads_admin";

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function createData($arrData)
    {
        $arrSavingDb = array();
        $result = $this->db->list_fields($this->strTableName);
        
        foreach($result as $field){
            //Insert Default Tracking data
            switch (strtolower($field)) {
                case 'is_created': $arrSavingDb[$field] = date('Y-m-d H:i:s'); break;
            }
            
            if (isset($arrData[$field])){
                $arrSavingDb[$field] = $arrData[$field];
            }
        }

        $this->db->insert($this->strTableName, $arrSavingDb);
    }

    public function editData($arrData, $arrWhere = array())
    {
        $arrSavingDb = array();
        $result = $this->db->list_fields($this->strTableName);
        $bolValidWhere = false;
        
        //Data To Update
        foreach($result as $field){
            //Insert Default Tracking data
            switch (strtolower($field)) {
                case 'is_updated': $arrSavingDb[$field] = date('Y-m-d H:i:s'); break;
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
                $this->db->update($this->strTableName, $arrSavingDb);
            }
        }
    }

    public function deleteData($arrWhere = array())
    {
        $bolValidWhere = false;
        $result = $this->db->list_fields($this->strTableName);
        
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
                    $this->db->delete($this->strTableName);
                }
            }
        }
    }

    public function getAllRecord($arrWhere = array(), $arrOrder = array(), $type = "AND")
    {
        //Flush Param
        $this->db->flush_cache();
            
        //Criteria
        if($type == "AND"){
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
        }else{
            if (count($arrWhere) > 0){
                foreach ($arrWhere as $strField => $strValue){
                    if (is_array($strValue)){
                        $this->db->where_in($strField, $strValue);
                    }elseif (preg_match("/(\s|<|>|!|=|is null|is not null)/i", $strValue)){
                        $this->db->or_where($strField." ".$strValue);
                    }else{
                        $this->db->or_where($strField, $strValue);
                    }
                }
            }
        }
        
        //Order By
        if (count($arrOrder) > 0){
            foreach ($arrOrder as $strField => $strValue){
                $this->db->order_by($strField, $strValue);
            }
        }
        $query = $this->db->get($this->strTableName)->result();
        
        return $query;
    }

    public function getAllRecordLike($arrLike = array(), $arrOrder = array(), $limit = 10, $offset = 0)
    {
        //Flush Param
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
        $query = $this->db->get($this->strTableName, $limit, $offset)->result();

        return $query;
    }

    public function getLimitRecord($arrWhere = array(), $arrOrder = array(), $limit = 10, $offset = 0)
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
    
        return $query = $this->db->get($this->strTableName, $limit, $offset)->result();
    }

    public function getRows(){
        return $this->db->count_all_results($this->strTableName);
    }

    public function getLimitRows($arrWhere = array(), $arrOrder = array(), $limit = 10, $offset = 0){
        $this->getLimitRecord($arrOrder, $arrWhere);
        return $this->db->count_all_results($this->strTableName);
    }

}