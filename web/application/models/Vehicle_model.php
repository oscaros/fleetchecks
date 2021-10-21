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
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.comment, answers.response_on, users.name as custodian');
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
        $this->db->select('answers.id as answerid, answers.response_ids, answers.vehicle_reg, answers.user_id, answers.comment, answers.response_on, users.name as custodian');
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

    function deleteAnswer($answerId, $answerInfo)
    {
        $this->db->where('id', $answerId);
        $this->db->update('answers', $answerInfo);
        
        return $this->db->affected_rows();
    }


    function dailyInspCount($searchText = '', $vendor)
    {
        $this->db->select('BaseTbl.id as check_id, BaseTbl.vehicle_reg, BaseTbl.response_on');
        $this->db->from('answers as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "( BaseTbl.vehicle_reg  LIKE '%".$searchText."%'
            OR  BaseTbl.response_on  LIKE '%".$searchText."%'
                           )";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.response_type =', 'daily');
        $this->db->where('BaseTbl.user_id =', $vendor);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function dailyInsp($searchText = '', $page, $segment, $vendor)
    {
        $this->db->select('BaseTbl.id as check_id, BaseTbl.vehicle_reg, BaseTbl.response_on');
        $this->db->from('answers as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "( BaseTbl.vehicle_reg  LIKE '%".$searchText."%'
            OR  BaseTbl.response_on  LIKE '%".$searchText."%'
                           )";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.response_type =', 'daily');
        $this->db->where('BaseTbl.user_id =', $vendor);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function weeklyInspCount($searchText = '', $vendor)
    {
        $this->db->select('BaseTbl.id as check_id, BaseTbl.vehicle_reg, BaseTbl.response_on');
        $this->db->from('answers as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "( BaseTbl.vehicle_reg  LIKE '%".$searchText."%'
            OR  BaseTbl.response_on  LIKE '%".$searchText."%'
                           )";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.user_id =', $vendor);
        $this->db->where('BaseTbl.response_type =', 'weekly');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function weeklyInsp($searchText = '', $page, $segment, $vendor)
    {
        $this->db->select('BaseTbl.id as check_id, BaseTbl.vehicle_reg, BaseTbl.response_on');
        $this->db->from('answers as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "( BaseTbl.vehicle_reg  LIKE '%".$searchText."%'
            OR  BaseTbl.response_on  LIKE '%".$searchText."%'
                           )";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.user_id =', $vendor);
        $this->db->where('BaseTbl.response_type =', 'weekly');
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    public function get_assigned_vehicles($id)
    {
        $this->db->select( 
        'users.email,
        vehicle_assignment.id,
        vehicles.regno,
        vehicles.model,
        vehicles.name,
        vehicles.department');
        $this->db->from('vehicle_assignment');
        $this->db->join('users', 'vehicle_assignment.user_id  = users.id','inner');
        $this->db->join('vehicles', 'vehicle_assignment.vehicle_id = vehicles.id','inner');
        $this->db->where('vehicle_assignment.user_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    
    public function dailyCheckQuestions()
    {
        
        $this->db->select('vehicle_sub_systems.name,
        checks.options,
        checks.id,
        checks.title,
        checks.description');
        $this->db->from('checks');
        $this->db->join('vehicle_sub_systems', 'checks.vehicle_sub_system_id = vehicle_sub_systems.id','inner');
        $this->db->order_by('checks.title', 'asc');
        $this->db->where('checks.check_type', 'daily');

        $query = $this->db->get()->result();
        return $query;
    }
    
    public function weeklyCheckQuestions()
    {
        $this->db->select('vehicle_sub_systems.name,
        checks.options,
        checks.id,
        checks.title,
        checks.description');
        $this->db->from('checks');
        $this->db->join('vehicle_sub_systems', 'checks.vehicle_sub_system_id = vehicle_sub_systems.id','inner');
        $this->db->order_by('checks.title', 'asc');
        $this->db->where('checks.check_type', 'weekly');
        $query = $this->db->get()->result();
        return $query;
    }

    public function addNewWeeklyInspPost($userID, $vehicle_reg, $comment, $response_ids){
        //pick username and compare with what is in db
        //$params=json_encode($param);
        //$user = $params['user_email'];
        //$vehicle_reg = json_decode($params['vehicle']);
        // $vehicle_reg = 'UAA22';
        $user_id = $userID;
        //$comment = $params['comment'];
        //sanitize params to remain with only those to be inserted to bd
        //$res= $params;
        //unset($res['vehicle']);
        //unset($res['user_email']);
        //unset($res['comment']);
        
        // //print_r($res);

        // //recieve params
        $valueArray = array(
            // 'vehicle_reg'=>$vehicle_reg,
            // 'user_id'=>$user_id,
            // 'response_on'=>date('Y-m-d H:i:s'),
            // 'response_type'=>'weekly',
            // 'response_ids' => $res,
            // 'comment'=>$comment

            'vehicle_reg'=>$vehicle_reg,
            'user_id'=>$user_id,
            'response_on'=>date('Y-m-d H:i:s'),
            'response_type'=>'weekly',
            'response_ids' => json_encode($response_ids),
            'comment'=> $comment
        );       
       //check if that regno has been submitted already
       //$check = $this->check_already_inspected_weekly($vehicle_reg);
       //if($check == FALSE){
        $this->db->trans_start();
        $query = $this->db->insert('answers',$valueArray);
        $insert_id = $this->db->insert_id();            
        $this->db->trans_complete();            
            

        if($query){
            return $insert_id;  
        }
      
              
    }

    public function addNewDailyInspPost($userID, $vehicle_reg, $comment, $response_ids){
        $user_id = $userID;
        // //recieve params
        $valueArray = array(
            'vehicle_reg'=>$vehicle_reg,
            'user_id'=>$user_id,
            'response_on'=>date('Y-m-d H:i:s'),
            'response_type'=>'daily',
            'response_ids' => json_encode($response_ids),
            'comment'=> $comment
        );       

            $this->db->trans_start();
            $query = $this->db->insert('answers',$valueArray);
            $insert_id = $this->db->insert_id();            
            $this->db->trans_complete();            
                
            if($query){
                return $insert_id;  
            } 
                 
    }

    public function check_already_inspected($regno)
    {
        $this->db->select('id, vehicle_reg');
        $this->db->from('answers');
        $this->db->where('answers.is_deleted !=', 1);
        $this->db->where('answers.response_type =', 'daily');
        $this->db->where('answers.vehicle_reg', $regno);
        $this->db->where("DATE_FORMAT(answers.response_on,'%Y-%m-%d') =", date('Y-m-d'));
        $query = $this->db->get()->result();
        return $query;
    }

    public function check_already_inspected_weekly($regno)
    {
        $today = date('Y-m-d');
        $firstdaythisweek = date('Y-m-d', strtotime("next Monday") - 604800);
        $this->db->select('id, vehicle_reg');
        $this->db->from('answers');
        $this->db->where('answers.is_deleted !=', 1);
        $this->db->where('answers.response_type =', 'weekly');
        $this->db->where('answers.vehicle_reg', $regno);
        $this->db->where("DATE_FORMAT(answers.response_on,'%Y-%m-%d') >=", $firstdaythisweek);
        $this->db->where("DATE_FORMAT(answers.response_on,'%Y-%m-%d') <=", $today);
        $query = $this->db->get()->result();
        return $query;
    }
  
}