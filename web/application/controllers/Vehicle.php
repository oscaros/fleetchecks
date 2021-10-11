<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Vehicle extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vehicle_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'FleetChecks : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function vehicleListing()
    {
        if(!$this->isAdmin()) 
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->vehicle_model->vehicleListingCount($searchText);

			$returns = $this->paginationCompress ( "vehicleListing/", $count, 10 );
            
            $data['vehicleRecords'] = $this->vehicle_model->vehicleListing($searchText, $returns["page"], $returns["segment"]);
            $data['vehicleAssignmentRecords'] = $this->vehicle_model->getVehicleAssignmentRecords();
            
            $this->global['pageTitle'] = 'FleetChecks : Vehicle Listing';
            
            $this->loadViews("vehicle", $this->global, $data, NULL);
        }
    }

    function addNewVehicle()
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('vehicle_model');
            $data['depts'] = $this->vehicle_model->getDepartments();
            
            $this->global['pageTitle'] = 'FleetChecks : Add New Vehicle';

            $this->loadViews("addNewVehicle", $this->global, $data, NULL);
        }
    }

    function dailyReports()
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');           
            
            $count = $this->vehicle_model->getDailySubmissionsCount($searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "dailyReports/", $count, 10);

            $data['dailyrecords'] = $this->vehicle_model->getDailySubmissions($searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'FleetChecks : Daily Inspections History';
            
            $this->loadViews("dailyReports", $this->global, $data, NULL);
        }        
    }

    function weeklyReports()
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

           // $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->vehicle_model->getWeeklySubmissionsCount($searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "weeklyReports/", $count, 10);

            $data['weeklyrecords'] = $this->vehicle_model->getWeeklySubmissions($searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'FleetChecks : Weekly Inspections History';
            
            $this->loadViews("weeklyReports", $this->global, $data, NULL);
        }        
    }

    function addNewVehiclePost()
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {    
            $name = $this->security->xss_clean($this->input->post('name'));
            $regno = $this->security->xss_clean($this->input->post('regno'));
            $model = $this->input->post('model');
            $dept = $this->input->post('dept');
            $color = $this->input->post('color');
            
            $vehicleInfo = array('name'=>$name, 'regno'=>$regno,
                'model'=> $model, 'department'=>$dept, 'created_by'=>$this->vendorId, 'color'=>$color,
                'createdDtm'=>date('Y-m-d H:i:s'));
            //var_dump($vehicleInfo);
            $this->load->model('vehicle_model');
            $result = $this->vehicle_model->addNewVehiclePost($vehicleInfo);
            
            if($result > 0){
                $this->session->set_flashdata('success', 'New Vehicle created successfully');
            } else {
                $this->session->set_flashdata('error', 'Vehicle creation failed');
            }
            
            redirect('addNewVehicle');
        }        
    }

    function editVehicle($vehicleId = NULL)
    {
        if(!$this->isAdmin())
        {
            $this->loadThis();
        }
        else
        {
            if($vehicleId == null)
            {
                redirect('vehicleListing');
            }
            
            $this->load->model('vehicle_model');
            $data['vehicleInfo'] = $this->vehicle_model->getVehicleInfo($vehicleId);
            $data['depts'] = $this->vehicle_model->getDepartments();
            $data['colors'] = $this->vehicle_model->getColors();

            $this->global['pageTitle'] = 'FleetChecks : Edit User';
            
            $this->loadViews("editVehicle", $this->global, $data, NULL);
        }
    }

    function editVehiclePost(){
         if(!$this->isAdmin())
            {
                $this->loadThis();
            }
            else
            {            
                $vehicleId = $this->input->post('vehicleId');
                $name = $this->security->xss_clean($this->input->post('name'));
                $model = $this->security->xss_clean($this->input->post('model'));
                $regno = $this->input->post('regno');
                $color = $this->input->post('color');
                $dept = $this->security->xss_clean($this->input->post('dept'));               
                
                $vehicleInfo = array();                
               
                $vehicleInfo = array('name'=>$name, 'model'=>$model, 'regno'=>$regno, 'color'=>$color, 'department'=>$dept,
                        'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
               
                $result = $this->vehicle_model->editVehicle($vehicleInfo, $vehicleId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Vehicle updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Vehicle update failed');
                }
                
                redirect('vehicleListing');                
            }
        }

        function viewAssignedCustodians($vehicleId = NULL)
        {
            if(!$this->isAdmin())
            {
                $this->loadThis();
            }
            else
            {
                if($vehicleId == null)
                {
                    redirect('vehicleListing');
                }
                
                $this->load->model('vehicle_model');
                $data['assignmentinfo'] = $this->vehicle_model->getAssignmentInfoPerVehicle($vehicleId);
                $data['usersinfo'] = $this->vehicle_model->getUsers();
                $data['vehiclereg'] = $this->vehicle_model->getregNo($vehicleId);

    
                $this->global['pageTitle'] = 'FleetChecks : View Vehicle Assignment';
                
                $this->loadViews("viewAssignedCustodians", $this->global, $data, NULL);
            }
        }

        function AssignVehicle($vehicleId = NULL)
        {
            if(!$this->isAdmin())
            {
                $this->loadThis();
            }
            else
            {
                if($vehicleId == null)
                {
                    redirect('vehicleListing');
                }
                
                $this->load->model('vehicle_model');
                //$data['assignmentinfo'] = $this->vehicle_model->getAssignmentInfoPerVehicle($vehicleId);
                $data['usersinfo'] = $this->vehicle_model->getUsers();
                $data['vehicleinfo'] = $this->vehicle_model->getVehicleInfo($vehicleId);
    
                $this->global['pageTitle'] = 'FleetChecks : Assignment Vehicle';                
                $this->loadViews("assignVehicle", $this->global, $data, NULL);
            }
        }


        function assignVehiclePost(){
            if(!$this->isAdmin())
            {
                $this->loadThis();
            }
            else
            {            
                $vehicleId = $this->input->post('vehicleId');
                $userid = $this->input->post('userid');          
                
                $vehicleInfo = array();   
                $updateInfo = array();             
               
                $vehicleInfo = array('vehicle_id'=>$vehicleId, 'user_id'=>$userid, 
                        'assigned_by'=>$this->vendorId, 'assignedDtm'=>date('Y-m-d H:i:s'));

                $updateInfo = array('is_assigned'=>1);
               
                $result = $this->vehicle_model->assignVehiclePost($vehicleInfo, $vehicleId, $updateInfo);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Vehicle assigned successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Vehicle assignment failed');
                }
                
                redirect('vehicleListing');                
            }
        }

        function editVehicleAssignment($vehicleId = NULL, $assignId = NULL)
        {
            if(!$this->isAdmin())
            {
                $this->loadThis();
            }
            else
            {
                if($vehicleId == null && $assignId = NULL)
                {
                    redirect('vehicleListing');
                }
                $this->load->model('vehicle_model');
                $data['vehicleInfo'] = $this->vehicle_model->getVehicleInfo($vehicleId);
                $data['assignmentInfo'] = $this->vehicle_model->getAssignmentInfoRow($vehicleId, $assignId);
                $data['usersinfo'] = $this->vehicle_model->getUsers();
    
                $this->global['pageTitle'] = 'FleetChecks : Edit Vehicle';
                
                $this->loadViews("editVehicleAssignment", $this->global, $data, NULL);
            }
        }

        function editVehicleAssignmentPost(){
            if(!$this->isAdmin())
            {
                $this->loadThis();
            }
            else
            {            
                $assignId = $this->input->post('assignId');   
                $userid = $this->input->post('userid');   
                $vehicleId = $this->input->post('vehicleId');         
                
                $vehicleInfo = array();   
                //$updateInfo = array();             
               
                $vehicleInfo = array('user_id'=>$userid,'assigned_by'=>$this->vendorId, 'assignedDtm'=>date('Y-m-d H:i:s'));

                //$updateInfo = array('is_assigned'=>1);
               
                $result = $this->vehicle_model->editVehicleAssignmentPost($vehicleInfo, $assignId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Vehicle re-assigned successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Vehicle assignment edit failed');
                }
                
                redirect('viewAssignedCustodians/'.$vehicleId);                
            }
        }

      function viewInspectionDetail($answersId = NULL, $detailType = NULL){
            if(!$this->isAdmin())
                {
                    $this->loadThis();
                }
                else
                {
                    if($answersId == null)
                    {
                        redirect('dashboard');
                    }
                    $this->load->model('vehicle_model');
                    //$data['dailyrecords'] = $this->vehicle_model->getDailySubmissions();                    
                    $data['usersinfo'] = $this->vehicle_model->getUsers();
                    $data['detailtype'] = $detailType;

                    if($detailType == "daily"){
                    $data['checksinfo'] = $this->vehicle_model->getDailyChecks();
                    $data['answersforvehicle'] = $this->vehicle_model->getDailySubmissionsForOneVehicle($answersId);
                    
                    }elseif($detailType == "weekly"){
                        $data['checksinfo'] = $this->vehicle_model->getWeeklyChecks();
                        $data['answersforvehicle'] = $this->vehicle_model->getWeeklySubmissionsForOneVehicle($answersId);
                    }

                    $this->global['pageTitle'] = 'FleetChecks : View Daily Inspection Detail';
                    
                    $this->loadViews("viewInspectionDetail", $this->global, $data, NULL);
                }
      }

      function deleteVehicle()
      {
          if(!$this->isAdmin())
          {
              echo(json_encode(array('status'=>'access')));
          }
          else
          {
              $vehicleId = $this->input->post('vehicleId');
              $vehicleInfo = array('is_deleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
              
              $result = $this->vehicle_model->deleteVehicle($vehicleId, $vehicleInfo);
              
              if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
              else { echo(json_encode(array('status'=>FALSE))); }
          }
      }
      


}

?>