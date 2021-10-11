<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Book extends CI_Controller {
    

	public function __construct()
    {
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        parent::__construct();
        
       
        //$this->load->helper('json_output_helper.php'); 
        /*
        	$check_auth_client = $this->MyModel->check_auth_client();
		if($check_auth_client != true){
			die($this->output->get_output());
		}
		*/
    }

	public function index()
	{
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			//$check_auth_client = $this->MyModel->check_auth_client();
			//if($check_auth_client == true){
		        	//$response = $this->MyModel->auth();
		        	//if($response['status'] == 200){
		        		//$resp = $this->MyModel->book_all_data();
	    				//json_output($response['status'],$resp);
		        	//}
			//}
			
    	   // header('Content-type: application/json');
        //     header("Access-Control-Allow-Origin: *");
        //     header("Access-Control-Allow-Methods: GET");
        //     header("Access-Control-Allow-Methods: GET, OPTIONS");
        //     header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			
			$resp = $this->MyModel->book_all_data();
			if ($resp){
				json_output(200,$resp);
			}
		}
	}
	
	
    public function weekly()
    {
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
          
            
            $resp = $this->MyModel->weekly_all_data();
            if ($resp){
                json_output(200,$resp);
            }
        }
    }
    
    public function dailyAnswers()
    {
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
          
            
            $resp = $this->MyModel->daily_answers_all_data();
            if ($resp){
                json_output(200,$resp);
            }
        }
    }

	public function weeklyAnswers()
    {
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
          
            
            $resp = $this->MyModel->weekly_answers_all_data();
            if ($resp){
                json_output(200,$resp);
            }
        }
    }

	public function get_assigned_vehicles($id)
    {       
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {          
            
            $resp = $this->MyModel->get_assigned_vehicles($id);
            if ($resp){
                json_output(200,$resp);
            }
        }
    }
    

	public function register()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {		
		       
			$params = json_decode(file_get_contents('php://input'), TRUE);
			$check = $this->MyModel->checkuserexists(strtolower($this->security->xss_clean($params['email'])));
			//$respStatus = $response['status'];
			if ($check == TRUE) {
				$respStatus = 400;
				$resp = array('status' => 400,'message' =>  'username is already taken');
			} else {
				$resp = $this->MyModel->create_user($params);
			}
			json_output(201, $resp);
			}	
		
	}

	public function create_daily_check(){
	    // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {		
		       
			$params = json_decode(file_get_contents('php://input'), TRUE);
			//check if user had already submitted today's checklist
			
			$resp = $this->MyModel->create_daily_check($params['answers']);
			json_output(200, $resp);
			}
		
	}

	public function create_weekly_check(){
	    
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {		
		       
			$params = json_decode(file_get_contents('php://input'), TRUE);
			//check if user had already submitted today's checklist
			
			$resp = $this->MyModel->create_weekly_check($params['answers']);
			json_output(200, $resp);
			}
		
	}

	public function loginFromAPI(){		
        $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {		       
			$params = json_decode(file_get_contents('php://input'), TRUE);
			//$check = $this->MyModel->checkuserexists(strtolower($this->security->xss_clean($params['email'])));
			$email = $params['email'];    
			$password = $params['password'];
			$data_user = $this->MyModel->loginFromAPI($email, $password);

          if($data_user == TRUE){
			 json_output(200, $data_user);

				}else{
					json_output(200, $data_user);
				}
			
			}
    }

	
    
 public function bettype_detail($id)
    {
      
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output(400,array('status' => 400,'message' => 'Bad request.'));
        } else {
          
            
            $resp = $this->MyModel->bettype_detail_data($id);
            if ($resp){
                json_output(200,$resp);
            }
        }
    }
    
	public function detail($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	if($response['status'] == 200){
		        		$resp = $this->MyModel->book_detail_data($id);
					json_output($response['status'],$resp);
		        	}
			}
		}
	}

	public function create()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	$respStatus = $response['status'];
		        	if($response['status'] == 200){
					$params = json_decode(file_get_contents('php://input'), TRUE);
					if ($params['title'] == "" || $params['author'] == "") {
						$respStatus = 400;
						$resp = array('status' => 400,'message' =>  'Title & Author can\'t empty');
					} else {
		        			$resp = $this->MyModel->book_create_data($params);
					}
					json_output($respStatus,$resp);
		        	}
			}
		}
	}

	public function update($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'PUT' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	$respStatus = $response['status'];
				if($response['status'] == 200){
					$params = json_decode(file_get_contents('php://input'), TRUE);
					$params['updated_at'] = date('Y-m-d H:i:s');
					if ($params['title'] == "" || $params['author'] == "") {
						$respStatus = 400;
						$resp = array('status' => 400,'message' =>  'Title & Author can\'t empty');
					} else {
		        			$resp = $this->MyModel->book_update_data($id,$params);
					}
					json_output($respStatus,$resp);
		       		}
			}
		}
	}

	public function delete($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'DELETE' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        	$response = $this->MyModel->auth();
		        	if($response['status'] == 200){
		        		$resp = $this->MyModel->book_delete_data($id);
					json_output($response['status'],$resp);
		        	}
			}
		}
	}

}
