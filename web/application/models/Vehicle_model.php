<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Vehicle_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function vehicleListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.name, BaseTbl.regno, BaseTbl.department, BaseTbl.color, BaseTbl.model');
        $this->db->from('vehicles as BaseTbl');
        if(!empty($searchText)) {

            $likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%'
            OR  BaseTbl.regno  LIKE '%".$searchText."%'
            OR  BaseTbl.department  LIKE '%".$searchText."%'
                            OR  BaseTbl.model  LIKE '%".$searchText."%'
                            OR  BaseTbl.color  LIKE '%".$searchText."%'
                           )";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        // $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function vehicleListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.id as vehicle_id, BaseTbl.name, BaseTbl.regno, BaseTbl.department, BaseTbl.color, BaseTbl.model, BaseTbl.is_assigned');
        $this->db->from('vehicles as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name  LIKE '%".$searchText."%'
            OR  BaseTbl.regno  LIKE '%".$searchText."%'
            OR  BaseTbl.department  LIKE '%".$searchText."%'
                            OR  BaseTbl.model  LIKE '%".$searchText."%'
                            OR  BaseTbl.color  LIKE '%".$searchText."%'
                           )";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        // $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function getDepartments(){
        $this->db->select('id as deptId, name');
        $this->db->from('departments');
        $this->db->where('is_deleted =', 0);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getColors(){
        $this->db->select('id as colorId, name');
        $this->db->from('colors');
        $this->db->where('is_deleted =', 0);
        $query = $this->db->get();
        
        return $query->result();
    }

    function addNewVehiclePost($vehicleInfo){        
            $this->db->trans_start();
            $this->db->insert('vehicles', $vehicleInfo);            
            $insert_id = $this->db->insert_id();            
            $this->db->trans_complete();            
            return $insert_id;        
    }

    function getVehicleInfo($vehicleId)
    {
        $this->db->select('id as vehicleId, name, model, regno, color, department');
        $this->db->from('vehicles');
        $this->db->where('is_deleted', 0);
        $this->db->where('id', $vehicleId);
        $query = $this->db->get();
        
        return $query->row();
    }

    function editVehicle($vehicleInfo, $vehicleId)
    {
        $this->db->where('id', $vehicleId);
        $this->db->update('vehicles', $vehicleInfo);        
        return TRUE;
    }

    function getAssignmentInfoPerVehicle($vehicleId){
        $this->db->select('vehicles.name,
        vehicle_assignment.vehicle_id,
        vehicle_assignment.user_id,
        vehicle_assignment.id as assignId,
        vehicles.model,
        vehicles.regno,
        users.name as custodian,
        vehicles.color,
        users.telephone,
        vehicle_assignment.assigned_by,
        vehicle_assignment.assignedDtm');
        $this->db->from('vehicle_assignment');
        $this->db->join('vehicles', 'vehicle_assignment.vehicle_id = vehicles.id', 'inner');
        $this->db->join('users', 'vehicle_assignment.user_id = users.id', 'inner');
        $this->db->where('vehicle_assignment.is_deleted', 0);
        $this->db->where('vehicle_assignment.vehicle_id', $vehicleId);
        $query = $this->db->get();        
        return $query->result();
    }

    function getAssignmentInfoRow($vehicleId, $assignId){
        $this->db->select('id as assignId, vehicle_id, user_id');
        $this->db->from('vehicle_assignment');
        //$this->db->where('is_deleted', 0);
        $this->db->where('vehicle_id', $vehicleId);
        $this->db->where('id', $assignId);
        $query = $this->db->get();
        
        return $query->row();  
    }

    function getVehicleAssignmentRecords(){
        $this->db->select('id, vehicle_id');
        $this->db->from('vehicle_assignment');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        
        return $query->result();  
    }

    function getregNo($vehicleId){
        $this->db->select('id, regno');
        $this->db->from('vehicles');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }

    function getUsers(){
        $this->db->select('id as userid, name');
        $this->db->from('users');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        
        return $query->result();
    }

    function assignVehiclePost($vehicleInfo, $vehicleId, $updateInfo){
        $this->db->trans_start();
        $this->db->insert('vehicle_assignment', $vehicleInfo);            
        $insert_id = $this->db->insert_id();            
        $this->db->trans_complete(); 

        $this->db->where('id', $vehicleId);
        $this->db->update('vehicles', $updateInfo);  

        return $insert_id;   
    }

    function editVehicleAssignmentPost($vehicleInfo, $assignId){
        $this->db->where('id', $assignId);
        $this->db->update('vehicle_assignment', $vehicleInfo);        
        return TRUE;
    }

    function DailySubmissions(){
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.response_on');
        $this->db->from('answers');
        $this->db->where('answers.is_deleted', 0);
        $this->db->where('answers.response_type', 'daily');
        $this->db->where("DATE_FORMAT(response_on,'%Y-%m-%d') =", date('Y-m-d'));
        $query = $this->db->get();
        
        return $query->result();
    }

    function getDailySubmissions($searchText, $fromDate, $toDate, $page, $segment){
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.response_on, users.name as custodian');
        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'inner');
        if(!empty($searchText)) {
            $likeCriteria = "(answers.vehicle_reg  LIKE '%".$searchText."%'
            OR  users.name  LIKE '%".$searchText."%' 
           )";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(answers.response_on, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(answers.response_on, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('answers.is_deleted', 0);
        $this->db->where('answers.response_type', 'daily');
        $this->db->order_by('answers.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getDailySubmissionsCount($searchText, $fromDate, $toDate)
    {
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.response_on, users.name as custodian');
        if(!empty($searchText)) {
            $likeCriteria = "(answers.vehicle_reg  LIKE '%".$searchText."%'
            OR  users.name  LIKE '%".$searchText."%' 
           )";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(answers.response_on, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(answers.response_on, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }

        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'inner');
        $this->db->where('answers.is_deleted', 0);
        $this->db->where('answers.response_type', 'daily');
        $this->db->order_by('answers.id', 'DESC');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function getDailySubmissionsForOneVehicle($answersId){
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.response_on, users.name as custodian');
        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'inner');
        $this->db->where('answers.is_deleted', 0);
        $this->db->where('answers.id', $answersId);
        $this->db->where('answers.response_type', 'daily');
        $this->db->order_by('answers.response_on', 'DESC');
        $query = $this->db->get();
        
        return $query->row();
    }

    function getWeeklySubmissionsForOneVehicle($answersId){
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.response_on, users.name as custodian');
        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'inner');
        $this->db->where('answers.is_deleted', 0);
        $this->db->where('answers.id', $answersId);
        $this->db->where('answers.response_type', 'weekly');
        $this->db->order_by('answers.response_on', 'DESC');
        $query = $this->db->get();
        
        return $query->row();
    }

    function getDailyChecks(){
        $this->db->select('id as checkid, title, check_type');
        $this->db->from('checks');
        $this->db->where('is_deleted', 0);
        $this->db->where('check_type', 'daily');
        
        $query = $this->db->get();
        
        return $query->result();
    }

    function getWeeklyChecks(){
        $this->db->select('id as checkid, title, check_type');
        $this->db->from('checks');
        $this->db->where('is_deleted', 0);
        $this->db->where('check_type', 'weekly');
        
        $query = $this->db->get();
        
        return $query->result();
    }

    //methods for the dashbaord
    function getTotalVehicles(){
        $this->db->select('id');
        $this->db->from('vehicles');
        $this->db->where('is_deleted', 0);
        $query = $this->db->count_all_results();        
        return $query;
    }

    function getTotalChecksToday(){
        $this->db->select('id');
        $this->db->from('answers');
        $this->db->where('is_deleted', 0);        
        $this->db->where('response_type', 'daily');        
        $this->db->where("DATE_FORMAT(response_on,'%Y-%m-%d') =", date('Y-m-d'));
        $query = $this->db->count_all_results();        
        return $query;
    }

    function getTotalChecksWeekly($today,$firstdaythisweek){
        $this->db->select('id');
        $this->db->from('answers');
        $this->db->where('is_deleted', 0);        
        $this->db->where('response_type', 'weekly');        
        $this->db->where("DATE_FORMAT(response_on,'%Y-%m-%d') >=", $firstdaythisweek);
        $this->db->where("DATE_FORMAT(response_on,'%Y-%m-%d') <=", $today);
        $query = $this->db->count_all_results();        
        return $query;
    }


    function getWeeklySubmissions($searchText, $fromDate, $toDate, $page, $segment){
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.response_on, users.name as custodian');
        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'inner');
        if(!empty($searchText)) {
            $likeCriteria = "(answers.vehicle_reg  LIKE '%".$searchText."%'
            OR  users.name  LIKE '%".$searchText."%' 
           )";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(answers.response_on, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(answers.response_on, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        $this->db->where('answers.is_deleted', 0);
        $this->db->where('answers.response_type', 'weekly');
        $this->db->order_by('answers.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getWeeklySubmissionsCount($searchText, $fromDate, $toDate)
    {
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.response_on, users.name as custodian');
        if(!empty($searchText)) {
            $likeCriteria = "(answers.vehicle_reg  LIKE '%".$searchText."%'
            OR  users.name  LIKE '%".$searchText."%' 
           )";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(answers.response_on, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(answers.response_on, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }

        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'inner');
        $this->db->where('answers.is_deleted', 0);
        $this->db->where('answers.response_type', 'weekly');
        $this->db->order_by('answers.id', 'DESC');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function deleteVehicle($vehicleId, $vehicleInfo)
    {
        $this->db->where('id', $vehicleId);
        $this->db->update('vehicles', $vehicleInfo);
        
        return $this->db->affected_rows();
    }
  
}