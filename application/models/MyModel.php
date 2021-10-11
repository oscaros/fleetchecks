<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization")

class MyModel extends CI_Model {

    var $client_service = "frontend-client";
    var $auth_key       = "simplerestapi";

    public function check_auth_client(){
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
        if($client_service == $this->client_service && $auth_key == $this->auth_key){
            return true;
        } else {
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        }
    }

    public function login($username,$password)
    {
        $q  = $this->db->select('password,id')->from('users')->where('username',$username)->get()->row();
        if($q == ""){
            return array('status' => 204,'message' => 'Username not found.');
        } else {
            $hashed_password = $q->password;
            $id              = $q->id;
            if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
               $last_login = date('Y-m-d H:i:s');
               $token = crypt(substr( md5(rand()), 0, 7));
               $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
               $this->db->trans_start();
               $this->db->where('id',$id)->update('users',array('last_login' => $last_login));
               $this->db->insert('users_authentication',array('users_id' => $id,'token' => $token,'expired_at' => $expired_at));
               if ($this->db->trans_status() === FALSE){
                  $this->db->trans_rollback();
                  return array('status' => 500,'message' => 'Internal server error.');
               } else {
                  $this->db->trans_commit();
                  return array('status' => 200,'message' => 'Successfully login.','id' => $id, 'token' => $token);
               }
            } else {
               return array('status' => 204,'message' => 'Wrong password.');
            }
        }
    }

    public function logout()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $this->db->where('users_id',$users_id)->where('token',$token)->delete('users_authentication');
        return array('status' => 200,'message' => 'Successfully logout.');
    }

    public function auth()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $q  = $this->db->select('expired_at')->from('users_authentication')->where('users_id',$users_id)->where('token',$token)->get()->row();
        if($q == ""){
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        } else {
            if($q->expired_at < date('Y-m-d H:i:s')){
                return json_output(401,array('status' => 401,'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('users_id',$users_id)->where('token',$token)->update('users_authentication',array('expired_at' => $expired_at,'updated_at' => $updated_at));
                return array('status' => 200,'message' => 'Authorized.');
            }
        }
    }

    public function book_all_data()
    {
        //return $this->db->select('id,title,author')->from('books')->order_by('id','desc')->get()->result();

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
    
    public function weekly_all_data()
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
    
    public function daily_answers_all_data()
    {
        $this->db->select( 
        'id, vehicle_reg, user_id, response_type, response_on');
        $this->db->from('answers');
        $this->db->where('answers.response_type', 'daily');
        //$this->db->where('answers.user_id', 6);
        $this->db->order_by('answers.response_on', 'desc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function weekly_answers_all_data()
    {
        $this->db->select( 
        'id, vehicle_reg, user_id, response_type, response_on');
        $this->db->from('answers');
        $this->db->where('answers.response_type', 'weekly');
        $this->db->order_by('answers.response_on', 'desc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function create_user($params){
        //pick username and compare with what is in db
        //$user = $params['username'];
        $email = strtolower($this->security->xss_clean($params['email']));
        
        //recieve params
        $valueArray = array('email'=>$email, 'password'=>password_hash($params['password'], PASSWORD_DEFAULT),
         'username'=>$params['username'], 'name'=>$params['name'], 
         'role_id'=>$params['role_id'], 'telephone'=>$params['telephone']);
       
        $query = $this->db->insert('users',$valueArray);

        if($query){
            return array('status' => 201,'message' => 'User has been created.');
        }else{
            return array('status' => 400,'message' => 'User creation failed.');
        }
            
    }

    public function checkuserexists($email){
        $this->db->select("email");
        $this->db->from("users");
        $this->db->where("email", $email);        
        $query = $this->db->get();

        return $query->result();
    }

    public function loginFromAPI($email, $password){
        // fetch by username first
        $this->db->select("email, password");
        $this->db->from("users");
        $this->db->where("email", $email);        
        $query = $this->db->get();
        $result = $query->row_array(); // get the row first

        if ($query->num_rows() == 1) {
            return password_verify($password, $result['password']);
        } else {
            return false;
         }
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
        $this->db->where('users.email', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function create_daily_check($params){
        //pick username and compare with what is in db
        $user = $params['user_email'];
        $vehicle_reg = $params['vehicle'];
        $user_id = $this->getUserid($params);
        $comment = $params['comment'];
        // //sanitize params to remain with only those to be inserted to bd
        $res= $params;
        unset($res['vehicle']);
        unset($res['user_email']);
        unset($res['comment']);
        
        // //print_r($res);

        // //recieve params
        $valueArray = array(
            'vehicle_reg'=>$vehicle_reg,
            'user_id'=>$user_id,
            'response_on'=>date('Y-m-d H:i:s'),
            'response_type'=>'daily',
            'response_ids' => json_encode($res),
            'comment'=>$comment
        );       
       //check if that regno has been submitted already
       $check = $this->check_already_inspected($vehicle_reg);
       if($check == FALSE){
           $query = $this->db->insert('answers',$valueArray);

           if($query){
               return array('status' => 201,'message' => 'check has been created.');
           }else{
               return array('status' => 400,'message' => 'check creation failed.');
           }  
       }else{
           return array('status' => 401,'message' => 'check creation failed.');
       }
                 
    }

    public function create_weekly_check($params){
        //pick username and compare with what is in db
        $user = $params['user_email'];
        $vehicle_reg = $params['vehicle'];
        $user_id = $this->getUserid($params);
        $comment = $params['comment'];
        // //sanitize params to remain with only those to be inserted to bd
        $res= $params;
        unset($res['vehicle']);
        unset($res['user_email']);
        unset($res['comment']);
        // //print_r($res);

        // //recieve params
        $valueArray = array(
            'vehicle_reg'=>$vehicle_reg,
            'user_id'=>$user_id,
            'response_on'=>date('Y-m-d H:i:s'),
            'response_type'=>'weekly',
            'response_ids' => json_encode($res),
            'comment'=>$comment
        );  
        
        //check if that regno has been submitted already
        $check = $this->check_already_inspected_weekly($vehicle_reg);
        if($check == FALSE){
            $query = $this->db->insert('answers',$valueArray);

            if($query){
                return array('status' => 201,'message' => 'check has been created.');
            }else{
                return array('status' => 400,'message' => 'check creation failed.');
            }  
        }else{
            return array('status' => 401,'message' => 'check creation failed.');
        }
        
                 
    }

    public function getUserid($params){return $this->db->select('id')->from('users')->where('email',$params['user_email'])->get()->row('id');}
    
    public function check_already_inspected($regno)
    {
        $this->db->select('id, vehicle_reg');
        $this->db->from('answers');
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
        $this->db->where('answers.vehicle_reg', $regno);
        $this->db->where("DATE_FORMAT(answers.response_on,'%Y-%m-%d') >=", $firstdaythisweek);
        $this->db->where("DATE_FORMAT(answers.response_on,'%Y-%m-%d') <=", $today);
        $query = $this->db->get()->result();
        return $query;
    }












    public function bettype_detail_data($id)
    {
        $this->db->select( 
        't.fixture,
        t.tip_type,
        t.tip_type2,
        t.odd_for_tip_type1,
        t.odd_for_tip_type2,
        t.fixture_time_date, 
        t.score,
        t.is_finished,
        t.time,
        t.status,
        cptn.name as competition_name,
        c.name as category_name,
        u.username,
        t.comment');
        $this->db->from('tips as t');
        $this->db->join('users as u', 'u.id = t.user_id','left');
        $this->db->join('categories as c', 'c.id = t.category_id','left');
        $this->db->join('competitions as cptn', 'cptn.id = t.competition_id','left');
        $this->db->where('t.category_id', $id);
        $query = $this->db->get()->result();
        return $query;
    }

    public function book_detail_data($id)
    {
        return $this->db->select('id,fixture,tip_type')->from('tips')->where('id',$id)->order_by('id','desc')->get()->row();
    }

    public function book_create_data($data)
    {
        $this->db->insert('books',$data);
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function book_update_data($id,$data)
    {
        $this->db->where('id',$id)->update('books',$data);
        return array('status' => 200,'message' => 'Data has been updated.');
    }

    public function book_delete_data($id)
    {
        $this->db->where('id',$id)->delete('books');
        return array('status' => 200,'message' => 'Data has been deleted.');
    }

}
