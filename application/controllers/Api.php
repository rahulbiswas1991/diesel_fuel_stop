<?php
defined('BASEPATH') or exit('No direct script access allowed');


class api extends CI_Controller
{
    public $enc_header = ''; //

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('user_model', 'admin_modal','notificationmodel'));
        $this->load->helper(array('url', 'date', 'form', 'string', 'comman_helper'));
         $this->load->library(array('email', 'javascript', 'session', 'upload', 'My_PHPMailer', 'encryption', 'user_agent'));
		 // $this->load->helper('load_controller');
//$this->load->load_controller('frontend', 'not_found');
    }
    public function index()
    { /*Content*/
	echo "okkk"; die();
	
	}

public function mailsend($to = "", $name = "", $subject = "", $body = "", $from = "", $fromname = "")
    {
        
         //    $mail = $this->mailsend(trim($user['email']), $user['username'], $subject, $body, "no-reply" . host, "LurexTrade");

        $this->email->set_mailtype("html");
        $this->email->from($from, $fromname);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($body);
        if ($this->email->send()) {
            return 1;
        } else {
            return 0;
        }
    }


public function generate_emp_id() //need to be called from inception controller
    {
        $userName = rand(1000000,9999999).chr(rand(65,90));;
        $userNameCheck = $this->db->select('id')->from('users')->where('emp_id',$first_name)->get()->result_array();
        if(count($userNameCheck)>0) {
            $res = $this->generate_emp_id();
        } else {
            $res = $userName;
        }
		//select * from users where 
        return $res;
    }

//$otpToken = random_string('numeric', 4);

public function signup(){
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
		
		//echo "<pre>"; print_r($_REQUEST); die();
		
        $parameters = ['first_name','last_name', 'email','phone', 'password','firebasetoken','mode', 'device_id'];
        foreach ($parameters as $parameter) {
			// if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
            if (!isset($_REQUEST[$parameter])) {
				
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }    
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            
			$first_name = trim($_REQUEST['first_name']);
			$last_name = trim($_REQUEST['last_name']);
			
			//$fullname = trim($_REQUEST['fullname']);
			$email = trim($_REQUEST['email']);
			$phone = trim($_REQUEST['phone']);
			$password = trim($_REQUEST['password']);
			$firebasetoken = trim($_REQUEST['firebasetoken']);
			$device_id = trim($_REQUEST['device_id']);
			$mode = trim($_REQUEST['mode']);
				//$u_info = $this->user_model->get_data('users', ' AND phone= ' . $phone, '*', 'full');
				$u_info = $this->user_model->get_data('users', ' AND ( phone = "' . $phone.'" or email="'.$email .'" )', '*', 'full');
				if (count($u_info) > 0) {
						echo json_encode(array("status" => 201, "message" => "This Mobile / Email is already exist.")); die;
				}else{
					
					$emp_id = $this->generate_emp_id();
					
					 $dataarr = array( 
							'email' => $email,
							'emp_id' => $emp_id,
							'password' => md5($password),
							'password_text' => $password,
							'phone' => $phone,
							'first_name' => $first_name,
							'last_name' => $last_name,
							'mode' => $mode,
							'isactive' => 1,
							'device_id' => $device_id,
							'firebasetoken'=>$firebasetoken,
							'created_date' => date('Y-m-d H:i:s')
						);
						
						$userid = $this->user_model->insert_data('users', $dataarr);
						   
						if ($userid > 0) {
						   
							$infoarr = array(
								'user_id' => $userid,
								'first_name' => $first_name,
								'last_name' => $last_name,
								'status' => 1,
								'created_date' => date('Y-m-d H:i:s')
							);
							$useinfo = $this->user_model->insert_data('user_information', $infoarr);
							if($useinfo){
								// echo json_encode(array("status" => 200, "message" => "successful", "userid" => $userid));die;
								
								$response = ['status' => 200, 'message' => 'successful', 'userid' => $userid];
								
							}else{
								//echo json_encode(array("status" => 401, "message" => "Please Try Later."));die;
								$response = ['status' => 401, 'message' => 'Please Try Later.'];
							}
							
						}else{
							//echo json_encode(array("status" => 401, "message" => "Please Try Later."));die;
							$response = ['status' => 401, 'message' => 'Please Try Later.'];
						}
			
				} 
		
		}
	print json_encode($response);
}


public function social_signup(){     
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
		
		//echo "<pre>"; print_r($_REQUEST); die();
		
        $parameters = ['first_name','last_name', 'email','social_id','firebasetoken','mode', 'device_id'];
        foreach ($parameters as $parameter) {
			// if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
            if (!isset($_REQUEST[$parameter])) {
				
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }    
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            
			$first_name = trim($_REQUEST['first_name']);
			$last_name = trim($_REQUEST['last_name']);
			
			//$fullname = trim($_REQUEST['fullname']);
			$email = trim($_REQUEST['email']);
			$social_id = trim($_REQUEST['social_id']);
			$firebasetoken = trim($_REQUEST['firebasetoken']);
			$device_id = trim($_REQUEST['device_id']);
			$mode = trim($_REQUEST['mode']);
			
				$u_info = $this->user_model->get_data('users', ' AND ( fb_id = "' . $social_id.'" or google_id="'.$social_id .'" )', '*', 'full');
				if (count($u_info) > 0) {
						echo json_encode(array("status" => 201, "message" => "This account is already Registered, Please Login."));die;
				}else{
				    
				    $u_info1 = $this->user_model->get_data('users', ' AND email= "' . $email.'"', '*', 'full');
				    if (count($u_info1) > 0) {
						    echo json_encode(array("status" => 201, "message" => "This account Email is already Registered."));die;
        				}else{ 
        				  
            					$emp_id = $this->generate_emp_id();
            					$google_id='';
            					$fb_id ='';
            					if($mode == 1){
            					    $google_id = $social_id;
            					}else if($mode == 2){
            					    $fb_id = $social_id;
            					}
        					
        					 $dataarr = array( 
        							'email' => $email,
        							'emp_id' => $emp_id,
        				// 			'password' => md5($password),
        				// 			'password_text' => $password,
        				// 			'phone' => $phone,
        							'first_name' => $first_name,
        							'last_name' => $last_name,
        							'fb_id' => $fb_id,
        							'google_id' => $google_id,
        							'mode' => $mode,
        							'isactive' => 1,
        							'device_id' => $device_id,
        							'firebasetoken'=>$firebasetoken,
        							'created_date' => date('Y-m-d H:i:s')
        						);
        						
        						$userid = $this->user_model->insert_data('users', $dataarr);
        						   
        						if ($userid > 0) {
        						   
        							$infoarr = array(
        								'user_id' => $userid,
        								'first_name' => $first_name,
        								'last_name' => $last_name,
        								'status' => 1,
        								'created_date' => date('Y-m-d H:i:s')
        							);
        							$useinfo = $this->user_model->insert_data('user_information', $infoarr);
        							if($useinfo){
        								// echo json_encode(array("status" => 200, "message" => "successful", "userid" => $userid));die;
        								
        								$response = ['status' => 200, 'message' => 'successful', 'userid' => $userid];
        								
        							}else{
        								//echo json_encode(array("status" => 401, "message" => "Please Try Later."));die;
        								$response = ['status' => 401, 'message' => 'Please Try Later.'];
        							}
        							
        						}else{
        							//echo json_encode(array("status" => 401, "message" => "Please Try Later."));die;
        							$response = ['status' => 401, 'message' => 'Please Try Later.'];
        						}
				    }
				} 
		
		}
	print json_encode($response);
}

public function login_password(){
	
	
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['username', 'password'];
		
		//echo "<pre>"; print_r($_REQUEST); die();
		
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            $username = $_REQUEST['username'];
            $password = md5(trim($_REQUEST['password']));
            $firebasetoken = trim($_REQUEST['firebasetoken']);
             $device_id = trim($_REQUEST['device_id']);
			 //$response = ['status' => 'error', 'errors' => 'username and password is incorrect'];
			 
			 
			$u_info = $this->user_model->get_data('users', ' AND ( email = "' . $username.'" or phone="'.$username .'" )', '*', '1');
			
			//echo $this->db->last_query();die;
			
				if($u_info){
					//echo "<pre>"; print_r($u_info); die();
					//0: inactive, 1: active, 2: deactive account, 3: block by admin';
					
					if($u_info['isactive'] == 0 ){
						$msg = "Inactive Account"; 
					}elseif($u_info['isactive'] == 2 ){
						$msg = "Deactive Account"; 
					}elseif($u_info['isactive'] == 3 ){
						$msg = "Blocked"; 
					}
					
					if($u_info['isactive'] == 1){
						if($password == $u_info['password']){
						    
						    
						    	$userInfo1 = array(
                                     'firebasetoken' => trim($_REQUEST['firebasetoken']),
                                     'device_id' => trim($_REQUEST['device_id'])
                                );
                                  $where  = array('id' => $u_info['id']);
                                  $up_otp = $this->user_model->update_data('users', $userInfo1, $where);
						    
						    
							//echo json_encode(array("status" => 200, "message" => "successful", "userid" => $u_info['id']));die;
							$response = ['status' => 200, 'message' => 'successful', 'userid' => $u_info['id']];
						}else{
							//echo json_encode(array("status" => 202, "message" => "Password Wrong"));die;
							$response = ['status' => 202, 'message' => 'Password Wrong'];
						} 
						
						 
					}else{
						//echo json_encode(array("status" => 202, "message" => $msg));die;
						$response = ['status' => 202, 'message' => $msg];
					}
				}else{
					$response = ['status' => 202, 'message' => 'Wrong Username / Password'];
				}
			
			
        }
        print json_encode($response);
	
} 



public function social_login(){
	
	
		$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['email','social_id', 'mode','firebasetoken'];
		
		//echo "<pre>"; print_r($_REQUEST); die();
		
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            $email = $_REQUEST['email'];
            $social_id = trim($_REQUEST['social_id']);
            $mode = trim($_REQUEST['mode']);
            $firebasetoken = trim($_REQUEST['firebasetoken']);
             $device_id = trim($_REQUEST['device_id']);
			 //$response = ['status' => 'error', 'errors' => 'username and password is incorrect'];
			 
			 
			$u_info = $this->user_model->get_data('users', 'AND mode = ' . $mode.' AND ( fb_id = "' . $social_id.'" or google_id="'.$social_id .'" )', '*', '1');
			
			//echo $this->db->last_query();die;
			
				if($u_info){
					//echo "<pre>"; print_r($u_info); die();
					//0: inactive, 1: active, 2: deactive account, 3: block by admin';
					
					if($u_info['isactive'] == 0 ){
						$msg = "Inactive Account"; 
					}elseif($u_info['isactive'] == 2 ){
						$msg = "Deactive Account"; 
					}elseif($u_info['isactive'] == 3 ){
						$msg = "Blocked"; 
					}
					
					
					
					if($u_info['isactive'] == 1){  
						//if($password == $u_info['password']){
						    
						    
						    	$userInfo1 = array(
                                     'firebasetoken' => trim($_REQUEST['firebasetoken']),
                                     'device_id' => trim($_REQUEST['device_id'])
                                );
                                  $where  = array('id' => $u_info['id']);
                                  $up_otp = $this->user_model->update_data('users', $userInfo1, $where);
						    
						    
							//echo json_encode(array("status" => 200, "message" => "successful", "userid" => $u_info['id']));die;
							$response = ['status' => 200, 'message' => 'successful', 'userid' => $u_info['id']];
				// 		}else{
				// 			//echo json_encode(array("status" => 202, "message" => "Password Wrong"));die;
				// 			$response = ['status' => 202, 'message' => 'Password Wrong'];
				// 		} 
						
						 
					}else{
						//echo json_encode(array("status" => 202, "message" => $msg));die;
						$response = ['status' => 202, 'message' => $msg];
					}
				}else{
					$response = ['status' => 202, 'message' => 'This account is not Registered , Please Sign Up.'];
				}
			
			
        }
        print json_encode($response);
	
} 


public function login_otp(){
	
	
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['phone', 'device_id','firebasetoken'];
		
		//echo "<pre>"; print_r($_REQUEST); die();
		
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            $phone = $_REQUEST['phone'];
            $device_id = trim($_REQUEST['device_id']);
            $firebasetoken = trim($_REQUEST['firebasetoken']);
            $opt_verify = trim($_REQUEST['opt_verify']);
			 //$response = ['status' => 'error', 'errors' => 'username and password is incorrect'];
			 
			 
			$u_info = $this->user_model->get_data('users', ' AND  phone="'.$phone .'" ', '*', '1');
			
			//echo $this->db->last_query();die;
			
				if($u_info){
					//echo "<pre>"; print_r($u_info); die();
					//0: inactive, 1: active, 2: deactive account, 3: block by admin';
					
					if($u_info['isactive'] == 0 ){
						$msg = "Inactive Account"; 
					}elseif($u_info['isactive'] == 2 ){
						$msg = "Deactive Account"; 
					}elseif($u_info['isactive'] == 3 ){
						$msg = "Blocked"; 
					}
					
					if($u_info['isactive'] == 1){
					//	if($password == $u_info['password']){
						    
						    
						    	$userInfo1 = array(
                                     'firebasetoken' => trim($_REQUEST['firebasetoken']),
                                     'device_id' => trim($_REQUEST['device_id'])
                                );
                                  $where  = array('id' => $u_info['id']);
                                  $up_otp = $this->user_model->update_data('users', $userInfo1, $where);
						    
						    
							//echo json_encode(array("status" => 200, "message" => "successful", "userid" => $u_info['id']));die;
							$response = ['status' => 200, 'message' => 'successful', 'userid' => $u_info['id']];
				// 		}else{
				// 			//echo json_encode(array("status" => 202, "message" => "Password Wrong"));die;
				// 			$response = ['status' => 202, 'message' => 'Password Wrong'];
				// 		} 
						
						 
					}else{
						//echo json_encode(array("status" => 202, "message" => $msg));die;
						$response = ['status' => 202, 'message' => $msg];
					}
				}else{
					$response = ['status' => 202, 'message' => 'Mobile No not Registered With Us'];
				}
			
			
        }
        print json_encode($response);
	
} 



public function getUserProfile(){  
	
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            $userid = $_REQUEST['userid'];
			
			$profile = $this->user_model->User_profile($userid);  
			if ($profile) { 
				 //echo json_encode(array("status" => 200, 'message' => 'User Profile Details', "data" => $profile, "Bank-details" => $object));
				 
				 $response = ['status' => 200, 'message' => 'User Profile Details', 'data' => $profile];
				 
			} else {
				//echo json_encode(array("status" => 500, 'message' => 'Internal Server Error'));
				 $response = ['status' => 500, 'message' => 'Internal Server Error'];
			}
		
		}
		print json_encode($response, JSON_UNESCAPED_SLASHES);
}


public function edit_user_profile()
    {
       
       
        $response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
             $userid = $_REQUEST['userid'];
			 
			 $userInfo = array(
               // 'user_id' => trim($_REQUEST['userid']),
                'first_name'=>trim($_REQUEST['first_name']),
                'last_name'=>trim($_REQUEST['last_name']),
                // 'phone'=>trim($_REQUEST['phone']),
                // 'email'=>trim($_REQUEST['email']),
                'dob'=>trim($_REQUEST['dob']),
                'family_information'=>trim($_REQUEST['family_information']),
                'hobbies'=>trim($_REQUEST['hobbies']),
                'city' => trim($_REQUEST['city']),
                'address' => trim($_REQUEST['address']),
            );
			
			$userInfo1 = array(
                //'user_id' => trim($_REQUEST['userid']),
                'first_name'=>trim($_REQUEST['first_name']),
                'last_name'=>trim($_REQUEST['last_name']),
                'phone'=>trim($_REQUEST['phone']),
                'email'=>trim($_REQUEST['email']),
                'dob'=>trim($_REQUEST['dob']),
                'city' => trim($_REQUEST['city']),
                'address' => trim($_REQUEST['address']),
            );


	        $useraddresses = array(
                'user_id' => trim($_REQUEST['userid']),
                'address' => trim($_REQUEST['address']),
                'created_date' => date('Y-m-d H:i:s')
            );


//echo "<pre>"; print_r($userInfo); die();

              $where  = array('id' => $userid);
              $up_otp = $this->user_model->update_data('users', $userInfo1, $where);
			
			if(isset($userInfo))
			{
			    $where1  = array('user_id' => $userid);
                $activeuser = $this->user_model->updateUserInfo('user_information', $userInfo, $where1);
                
                $addata = $this->user_model->insert_data('user_address', $useraddresses);
                
			}
			else{
			}
		
            if ($activeuser > 0) {
                $response = ['status' => 200, 'message' => 'Profile Update successfully.'];
            } else {
                $response = ['status' => 201, 'message' => 'There is some issue to update user profile.'];
            }
        	 
        }
       
			print json_encode($response);
            
    }


 public function slider_image(){ 
         $get_appimage_details = $this->common_model->get_data("app_sliders", " AND status = 1", "*", "full");
         $app_mage_data=array();
         foreach($get_appimage_details as $data){
              $get_id = $data['id'];
              $get_name = $data['name'];
              $get_description = $data['description'];
              
              $get_imgname= $data['image_name'];
              
              $get_status = $data['status'];
           
            $img_url = base_url().'assets/images/slider_images/'.$get_imgname;
            
        $app_mage_data[] = array("id"=>$get_id,"name"=>$get_name,"description"=>$get_description,"img_name"=>$get_imgname,"img_url"=>$img_url,"status"=>$get_status);
       
           //  print_r($app_image_api);
              // return($app_image_api);
        //die();
         }
        
        // $app_image_api = ["status" => "success", "data" => $app_mage_data];
        // //print_r($app_image_api);
        //   $json =  json_encode($app_image_api, JSON_UNESCAPED_SLASHES);
      
        //  print $json;
       //print_r($app_mage_data);
       return $app_mage_data;
    }
    
    
    
public function dashboard(){
	
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            $userid = $_REQUEST['userid'];
			
			$profile = $this->user_model->User_profile($userid);
			if ($profile) {
				 
				 $return_data['userid'] = $userid;
				 $return_data['user_profile'] = $profile;
				 $return_data['leads_till_date'] = count($this->user_model->leads_tilldate($userid));
				 $return_data['leads_inprocess'] = count($this->user_model->leads_inprocess($userid));
				 $return_data['total_leads'] = count($this->user_model->leads_success($userid));
				 $return_data['leads_cancelled'] = count($this->user_model->leads_cancelled($userid));
				 
				  $return_data['reward_earned'] = $this->user_model->reward_earned($userid);
				   $return_data['reward_transferred'] = $this->user_model->reward_transferred($userid);
				    $return_data['reward_pending'] = $this->user_model->reward_pending($userid);
				     $return_data['reward_inprocess'] = $this->user_model->reward_inprocess($userid);
								
					$return_data['slider_image'] = $this->slider_image();
					
				 $response = ['status' => 200, 'message' => 'successful', 'DashboardData' => $return_data];
			//$response = ['status' => 200, 'message' => 'successful', 'DashboardData' => $profile];
				 
			} else {
				
				 $response = ['status' => 500, 'message' => 'Internal Server Error'];
			}
		
		}
		print json_encode($response, JSON_UNESCAPED_SLASHES);
}


public function update_profilepic(){
      
    $response = $errors = [];
        $error = false;
        //$_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        
        // echo "<pre>"; print_r($_REQUEST);
        // echo "<pre>"; print_r($_FILES); die();
        
        $parameters = ['userid'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
        
            $userid = $_REQUEST['userid'];
            try {
                if (!empty($_FILES["profile_pic"]["name"])) { 
                    $directory = 'uploads/profile-pic/';
                    $thumb_directory = 'uploads/profile-pic/';
                    $thumb_h = 250;
                    $thumb_w = 250;
                    $valid_extensions = array("jpeg", "jpg", "png");

                    $user_dp = save_file($_FILES["profile_pic"], $directory, $thumb_directory, $valid_extensions, 'DP', $userid, true, $thumb_w, $thumb_h);


                    if ($user_dp['respose'] == 2) {
                        // $dpInfo = array('image' => $user_dp['filename'], 'img_thumb' => $user_dp['thumb_name'], 'extension' => $user_dp['extension'], 'path' => base_url() . $directory);
                        // $imgid = $this->user_model->insert_data('media', $dpInfo);
                        // if ($imgid > 0) {
                            $dparr = array('profile_pic' =>  $user_dp['filename']); 

                            $dpupdate = $this->user_model->updateInfor('user_information', $dparr, 'user_id', $userid);

                            if ($dpupdate > 0) {
                                $response = ['status' => 200, 'message' => 'Profile Picture Update successfully.', 'thumb' => base_url() . $thumb_directory . $user_dp['thumb_name']];
                            } else {
                                $response = ['status' => 0, 'message' => 'There is some issue to save User Profile Image data.'];
                            }
                        // } else {
                        //     $response = ['status' => 0, 'message' => 'There is some issue to save Image data.'];
                        // }
                    } else {
                        $response = ['status' => 0, 'message' => $user_dp['message']];
                    }
                }else{
                     $response = ['status' => 0, 'message' => 'Please Upload Image'];
                }
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
            
            
        }
    	print json_encode($response, JSON_UNESCAPED_SLASHES);
    
}

public function save_bank_details(){
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid','bnk_beneficery', 'bnk_name','bnk_accountno', 'bnk_ifsc'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            

            $isdefault = '';
            $userid = $_REQUEST['userid'];
			
           // $required = 'and user_id=' . $userid . ' and type=5';    
            // $prebnks = $this->common_model->get_data('bank_details', $required);
            // if (count($prebnks) >= 3) {
                // $response = ['status' => '0', 'message' => 'Only Three Banks are allowed.'));
                // $this->session->set_flashdata('error', 'Only Three Bank details are allowed.');
				
            // } else {
                $other = $this->common_model->get_data('bank_details', 'and user_id=' . $userid . ' and is_default=1');
                if (count($other) == 0) {$isdefault = 1;} else { $isdefault = 0;}
                $bnkinfoarr = array(
                    'user_id' => $userid,
                    'name_in_bank' => trim(isset($_REQUEST['bnk_beneficery'])?$_REQUEST['bnk_beneficery']:''),
                    'bank_name' => trim(isset($_REQUEST['bnk_name'])?$_REQUEST['bnk_name']:''),
                    'branch_address' => trim(isset($_REQUEST['branch_address'])?$_REQUEST['branch_address']:''),
                    'account_number' => trim(isset($_REQUEST['bnk_accountno'])?$_REQUEST['bnk_accountno']:''),
                    'ifsc_code' => trim(isset($_REQUEST['bnk_ifsc'])?$_REQUEST['bnk_ifsc']:''),
                    //'branch_code' => trim(isset($_REQUEST['bnk_branchcode'])?$_REQUEST['bnk_branchcode']:''),
                    
                    'is_default' => $isdefault,
                    'created_date' => date('Y-m-d H:i:s')
                );
                $bankid = $this->user_model->insert_data('bank_details', $bnkinfoarr);
				//echo $this->db->last_query();die;
                if ($bankid > 0) {
                    //$bnkscount = count($this->common_model->get_data('bank_details', 'and user_id=' . $userid));
                    //$bankid = $bankid;
                    // $beneficry = trim(isset($_REQUEST['bnk_beneficery'])?$_REQUEST['bnk_beneficery']:'');
                    // $bankname = trim(isset($_REQUEST['bnk_name'])?$_REQUEST['bnk_name']:'');
                    // $account = trim(isset($_REQUEST['bnk_accountno'])?$_REQUEST['bnk_accountno']:'');
                    // $ifsc = trim(isset($_REQUEST['bnk_ifsc'])?$_REQUEST['bnk_ifsc']:'');
                 //   $brnchcode = trim(isset($_REQUEST['bnk_branchcode'])?$_REQUEST['bnk_branchcode']:'');
                 //  $brnchadd = trim(isset($_REQUEST['branch_address'])?$_REQUEST['branch_address']:'');
 
                   $response = ['status' => 200,'message' => 'Bank Information added Successfully.', 'bank_details' => $bnkinfoarr];
                   
                } else {
					
                    
                   // $response = ['status' => '0', 'message' => 'There is some issue to save Bank Data.'));
                    $response = ['status' => 201, 'message' => 'There is some issue to save Bank Data.'];
                }
           // } 
		
		}
	print json_encode($response);
}






public function update_bank_details(){
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['update_id','userid','bnk_beneficery', 'bnk_name','bnk_accountno', 'bnk_ifsc'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            

            $isdefault = '';
            $userid = $_REQUEST['userid'];
			$update_id = $_REQUEST['update_id'];
			
                $other = $this->common_model->get_data('bank_details', 'and user_id=' . $userid . ' and is_default=1');
                if (count($other) == 0) {$isdefault = 1;} else { $isdefault = 0;}
                $bnkinfoarr = array(
                    //'user_id' => $userid,
                    'name_in_bank' => trim(isset($_REQUEST['bnk_beneficery'])?$_REQUEST['bnk_beneficery']:''),
                    'bank_name' => trim(isset($_REQUEST['bnk_name'])?$_REQUEST['bnk_name']:''),
                    'branch_address' => trim(isset($_REQUEST['branch_address'])?$_REQUEST['branch_address']:''),
                    'account_number' => trim(isset($_REQUEST['bnk_accountno'])?$_REQUEST['bnk_accountno']:''),
                    'ifsc_code' => trim(isset($_REQUEST['bnk_ifsc'])?$_REQUEST['bnk_ifsc']:''),
                    //'branch_code' => trim(isset($_REQUEST['bnk_branchcode'])?$_REQUEST['bnk_branchcode']:''),

                    'created_date' => date('Y-m-d H:i:s')
                );
				
				$bank_update = $this->user_model->update_data('bank_details', $bnkinfoarr, array('id' => $update_id, 'user_id' => $userid ));
				
                //$bankid = $this->user_model->insert_data('bank_details', $bnkinfoarr);
                if ($bank_update) {
                    //$bnkscount = count($this->common_model->get_data('bank_details', 'and user_id=' . $userid));
                    // $bankid = $bankid;
                    // $beneficry = trim(isset($_POST['bnk_beneficery'])?$_POST['bnk_beneficery']:'');
                    // $bankname = trim(isset($_POST['bnk_name'])?$_POST['bnk_name']:'');
                    // $account = trim(isset($_POST['bnk_accountno'])?$_POST['bnk_accountno']:'');
                    // $ifsc = trim(isset($_POST['bnk_ifsc'])?$_POST['bnk_ifsc']:'');
                 //   $brnchcode = trim(isset($_POST['bnk_branchcode'])?$_POST['bnk_branchcode']:'');
                 //  $brnchadd = trim(isset($_POST['branch_address'])?$_POST['branch_address']:'');
 
                   $response = ['status' => 200,'message' => 'Bank Information updated Successfully.', 'bank_details' => $bnkinfoarr];
                   
                } else {
					
                    
                   // $response = ['status' => '0', 'message' => 'There is some issue to save Bank Data.'));
                    $response = ['status' => 201, 'message' => 'There is some issue to update Bank Data.'];
                }
           
		
		}
	print json_encode($response);
}




public function  bank_details(){
	
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            
			$userid = trim($_REQUEST['userid']);
			
				$u_bankinfo = $this->user_model->get_data('bank_details', ' AND user_id= ' . $userid, '*', 'full');
				
				//echo $this->db->last_query();die;
				//echo count($u_bankinfo); die();
				if (count($u_bankinfo) > 0) {
						$response = ["status" => 200, "message" => "success", "bank_details" => $u_bankinfo];
				}else{
					$response = ["status" => 200, "message" => "Not Any Bank detail Added"];
				}
		}
		
		print json_encode($response);
	// this->notification();
}



public function savecard(){ 
		$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
		
		//echo "<pre>"; print_r($_REQUEST); die();
		
        $parameters = ['userid','name_oncard', 'card_number','expire_date', 'cvv_no'];
        foreach ($parameters as $parameter) {
			// if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
            if (!isset($_REQUEST[$parameter])) {
				
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }    
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            
			$userid = trim($_REQUEST['userid']);
			$name_oncard = trim($_REQUEST['name_oncard']);
		
			$card_number = trim($_REQUEST['card_number']);
			$expire_date = trim($_REQUEST['expire_date']);
			$cvv_no = trim($_REQUEST['cvv_no']);
				$u_info = $this->user_model->get_data('cards', ' AND card_number = ' . $card_number, '*', 'full');
				if (count($u_info) > 0) {
						echo json_encode(array("status" => 201, "message" => "This card number no is already exist.")); die;
				}else{
					
					$emp_id = $this->generate_emp_id();
					
					 $dataarr = array( 
							'user_id' => $userid,
							'name_oncard' => $name_oncard,
							'card_number' => $card_number,
							'expire_date' => $expire_date,
							'cvv_no' => $cvv_no,
							'created_date' => date('Y-m-d H:i:s')
						);
						
						$userid = $this->user_model->insert_data('cards', $dataarr);
						   
						if ($userid > 0) {
						   
							
						
								$response = ['status' => 200, 'message' => 'successful', 'userid' => $userid];
								
						
						}else{
							//echo json_encode(array("status" => 401, "message" => "Please Try Later."));die;
							$response = ['status' => 401, 'message' => 'Please Try Later.'];
						}
			
				} 
		
		}
	print json_encode($response);
	
}




public function cardslist(){
		$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            
			$userid = trim($_REQUEST['userid']);
			
				$u_cardinfo = $this->user_model->get_data('cards', 'AND isactive=1  AND user_id= ' . $userid, '*', 'full');
				
				//echo $this->db->last_query();die;
				//echo count($u_bankinfo); die();
				if (count($u_cardinfo) > 0) {
						$response = ["status" => 200, "message" => "success", "cards_details" => $u_cardinfo];
				}else{
					$response = ["status" => 200, "message" => "Not Any card detail Added"];
				}
		}
		
		print json_encode($response);
}



public function deletecard(){
	
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid', 'card_id'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
         
         $userid = trim($_REQUEST['userid']);
         $card_id = trim($_REQUEST['card_id']);
             	$u_info = $this->user_model->get_data('cards', ' AND id = ' . $card_id.' AND user_id ='. $userid, '*', 'full');
             	
             	//echo "<pre>"; print_r($u_info); die();
             	
				if (count($u_info) == 0) {
						echo json_encode(array("status" => 201, "message" => "This card number is not exist.")); die;
				}else{
					
						 $update = $this->user_model->update_data('cards', array('isactive' => 2), array('id' => $card_id));   
						if ($update) {
						   
								$response = ['status' => 200, 'message' => 'successful Deleted', 'userid' => $userid];
								
						
						}else{
							//echo json_encode(array("status" => 401, "message" => "Please Try Later."));die;
							$response = ['status' => 401, 'message' => 'Please Try Later.'];
						}
			
				} 
		}
	print json_encode($response);
}






public function leadslisting(){
		$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            
			$userid = trim($_REQUEST['userid']);
			
				//$u_cardinfo = $this->user_model->get_data('leads', 'AND isactive=1  AND user_id= ' . $userid, '', 'full');
				
				
				//SELECT `id`, `user_id`, `name`, `company_name`, `phone`, `email`, `city`, `designation`, `isactive`, `status`, `created_date`, `complete_date` FROM `leads` WHERE 1
				$colums = 'ld.id,ld.user_id,ld.name,ld.company_name,ld.phone,ld.email,ld.city,ld.designation,ld.created_date,ld.complete_date,(CASE WHEN ld.status=0 THEN "Inprocess" WHEN ld.status=1 THEN "Complete" WHEN ld.status=2 THEN "cancelled" WHEN ld.status=3 THEN "Hold" ELSE "Inactive" END) as status';
                // $where_array = array('a.profit_type'=>$profit_type);
        
                $this->db->select($colums);
                $this->db->from('leads ld');
               
                $this->db->where(array('user_id' => $userid, 'isactive' => 1));
        
                $this->db->order_by('ld.created_date', 'DESC');
                $query = $this->db->get();
                $res = $query->result_array();
				
				
				//echo $this->db->last_query();die;
				//echo count($u_bankinfo); die();
				if (count($res) > 0) {
						$response = ["status" => 200, "message" => "success", "leads_details" => $res];
				}else{
					$response = ["status" => 200, "message" => "Not Any lead detail Added"];
				}
		}
		
		print json_encode($response);
}

public function add_newlead(){
	     $response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
		
		//echo "<pre>"; print_r($_REQUEST); die();
		
        $parameters = ['userid','company_name','contact_name','DOT_number','phone_no', 'email','no_of_trucks','street','city','state','zip_code','potential_gallons','description_field'];
        foreach ($parameters as $parameter) {
			// if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
            if (!isset($_REQUEST[$parameter])) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }    
        }
        if ($error == true) {   
            $response = ['status' => 201, 'message' => $errors]; 
        } else {
            $userid = trim($_REQUEST['userid']);
			$name = trim($_REQUEST['contact_name']);
			$company_name = trim($_REQUEST['company_name']);
			
			$DOT_number = trim($_REQUEST['DOT_number']);
			$no_of_trucks = trim($_REQUEST['no_of_trucks']);
			$email = trim($_REQUEST['email']);
			$phone = trim($_REQUEST['phone_no']);
			$street = trim($_REQUEST['street']);
			$city = trim($_REQUEST['city']);
			$state = trim($_REQUEST['state']);
			$zip_code = trim($_REQUEST['zip_code']);
			$potential_gallons = trim($_REQUEST['potential_gallons']);
			$description_field = trim($_REQUEST['description_field']);
			//AND isactive = 0  
				$u_info = $this->user_model->get_data('leads', ' AND user_id= ' . $userid, '*', 'full');
				// if (count($u_info) > 0) {
				// 		echo json_encode(array("status" => 201, "message" => "Already Lead In Process."));die;
				// }else{
					
					 $dataarr = array( 
							'user_id' => $userid,
							'email' => $email,
							'phone_no' => $phone,
							'DOT_number' => $DOT_number,
							'contact_name' => $name,
							'company_name' => $company_name,
							'street' => $street,
							'city' => $city,
							'state' => $state,
							'zip_code' => $zip_code,
							'potential_gallons' => $potential_gallons,
							'description_field' => $description_field,
							'no_of_trucks'=>$no_of_trucks,  
							'created_date' => date('Y-m-d H:i:s')
						);
						$lead = $this->user_model->insert_data('leads', $dataarr);
						   
						if ($lead > 0) {
						   
								$response = ['status' => 200, 'message' => 'successful', 'userid' => $userid];
							
						}else{
							//echo json_encode(array("status" => 401, "message" => "Please Try Later."));die;
							$response = ['status' => 401, 'message' => 'Please Try Later.'];
						}
			
			//	} 
		
		}
	print json_encode($response);
}

  


public function  address_listing(){  
	
	$response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }  
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        } else {
            
			$userid = trim($_REQUEST['userid']);
			
				$u_addinfo = $this->user_model->get_data('user_address', 'AND address != "" AND isactive=1 AND user_id= ' . $userid, '*', 'full');
				
				//echo $this->db->last_query();die;
				//echo count($u_bankinfo); die();
				if (count($u_addinfo) > 0) {
						$response = ["status" => 200, "message" => "success", "address_details" => $u_addinfo];
				}else{
					$response = ["status" => 201, "message" => "Not Any Address Added"];
				}
		}
		
	print json_encode($response, JSON_UNESCAPED_SLASHES);
	// this->notification();
}




public function about_us(){
    $this->load->view('about.php');
}

public function terms_service(){
    $this->load->view('terms_service.php');
}

public function privacy_policy(){
    $this->load->view('privacy_policy.php');
}



public function validate_mobile($mobile)
{
    if(preg_match('/^([1-9]){1}([0-9]){9}+$/', $mobile)){
		return 1;
	}else{
		return 2;
	}
}

public function verifyotp(){
        $response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['phone', 'user_id', 'otp'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'errors' => $errors];
        }else{
            $mobile = $_REQUEST['phone'];
            $userid = $_REQUEST['userid'];
            $otp = $_REQUEST['otp'];
			$otp_type = $_REQUEST['otp_type'];
        }

    if($userid !='' && $mobile !='' && $otp !=''){
		
		$mobile_validate = $this->validate_mobile($mobile); 
	    if($mobile_validate ==1){ 
		 //and otp='$otp' 
// 			$qry ="SELECT * FROM `customer_tbl_otp` where userid = '$userid' order by id desc limit 0,1";
// 			$result = $mysqli->query($qry);
// 			$num_rows =$result->num_rows;
			
			$user = $this->common_model->get_data("customer_tbl_otp", " AND userid='" . $userid . "' AND otp_type = '".$otp_type."' order by id desc limit 0,1", "*", "1");
		//echo count($user); die();
			if($user){// echo "<pre>"; print_r($user); die();
				//while($row = $result->fetch_assoc()) {
					$fetched_time = $user['createdDate'];
					$fetched_otp = $user['otp'];
					$otp_status = $user['status'];
					//$userid = $row['userid'];
					$otpid = $user['id'];
				//}
				//echo $otpid; die();
				if($otp_status == 0){
				// 	$time_rs ="select sysdate() as tt";
				// 	$time_rs_result = $mysqli->query($time_rs);
				// 	$time_row = $time_rs_result->fetch_assoc();
				// 	$current_datetime = $time_row['tt'];
				    
				    $current_datetime = date('Y-m-d H:i:s');
					$f_time=strtotime($fetched_time);       
					$c_time=strtotime($current_datetime);
					$diffww = $c_time - $f_time; 
					$diff_minute = $diffww / 60;
					
			if($diff_minute < '5'){     
					
					if($fetched_otp == $otp){
						//$mysqli->autocommit(FALSE);
				// 		$otp_qry ="UPDATE `customer_tbl_otp` SET status = '1' WHERE id = '$otpid' and userid = '$userid'";
				// 		$otp_qry_sql = $mysqli->query($otp_qry);
				// 		$otp_qry_sql_ins=$mysqli->affected_rows;
						
						
						
                        $otpData['status'] = 1;
        	        	$otp_qry_sql_ins = $this->user_model->update_data('customer_tbl_otp', $otpData, array('id' => $otpid));
						//echo "<pre>"; print_r($otp_qry_sql_ins); die();
						if($otp_qry_sql_ins){
				// 			$qry_user ="SELECT * FROM `members` WHERE `id`='$userid'";
				// 			$result_user = $mysqli->query($qry_user);
				// 			$num_rows_user =$result_user->num_rows;
				// 			while($row_user = $result_user->fetch_assoc()) {
				// 				$user_status = $row_user['status'];
				// 			}
							
								if($otp_qry_sql_ins){
									$msg = 'OTP Matched';
									$return_data['userid'] = $userid;
								
								// 	$resp[]=$return_data;   
								// 	return $resp;
								    $response = ['status' => 200, 'message' => $msg, 'data' => $return_data];
								}else{
									//$mysqli->rollback();
									$msg='Resend OTP';
								//	return FALSE;
									$response = ['status' => 201, 'message' => $msg];
								}
			
							
						}
						else{
							//$mysqli->rollback();
							$msg='Error Occured while verifying OTP';
						//	return FALSE;
							$response = ['status' => 201, 'message' => $msg];
						}
					}
					else{
						$msg='Invalid OTP';
					//	return FALSE;
					$response = ['status' => 201, 'message' => $msg];
					}
				}else{
					$msg='OTP Expire, Please Re-enter Mobile No';
					//return FALSE;
					$response = ['status' => 201, 'message' => $msg];
				}
				}
				else{
					$msg='OTP Already in Use, Please Resend OTP';
					//return FALSE;
					$response = ['status' => 201, 'message' => $msg];
				}
				
			}else{
				$msg='User Not Found';
				//return FALSE;
				$response = ['status' => 401, 'message' => $msg];
			}
		}else{
			$msg='Please Enter Correct Mobile No';
		   // return FALSE;
		  $response = ['status' => 201, 'messagemessage' => $msg];
		}
	}else{
		$msg='Please Enter Details';
		//return FALSE;
		$response = ['status' => 201, 'message' => $msg];
	}
	print json_encode($response); 
}


public function send_otp($mobile,$user_id, $otp, $otp_type){
	    $data_otp = array(
			'userid' => $user_id,
			'mobile' => $mobile,
			'otp' => $otp,
			'otp_type' =>$otp_type,
			'createdDate' => date('Y-m-d H:i:s'),
		);
		
		$subject = "OTP";
		$message = "Ypur OTP for signup is 1234";
		$otpinsertedd = $this->Notificationmodel->send_notifications($user_id,$subject,$message,$filename,"","");
		
		//$otpinserted = $this->user_model->insert_data('customer_tbl_otp', $data_otp);
		
// 		firebase send msg code here 
		$otpinserted=1;
		if($otpinserted){
			return 1;
		}else{
			return 2;
		}
}


public function test_notif(){
// 	    $data_otp = array(
// 			'userid' => $user_id,
// 			'mobile' => $mobile,
// 			'otp' => $otp,
// 			'otp_type' =>$otp_type,
// 			'createdDate' => date('Y-m-d H:i:s'),
// 		);
		
	//	echo "saasssssad"; die();
		   
		$subject = "OTP";
		$message = "Y0ur OTP for signup is 1234";
		$otpinsertedd = $this->notificationmodel->send_notifications(9,$subject,$message,"","","");
		
		echo "<pre>"; print_r($otpinsertedd); die();
		
		
		
}



public function forget_password()
    {
       $response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        
        
        //echo "<pre>"; print_r($_REQUEST); die();
        
        $parameters = ['phone'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        }else{
            $phone = $_REQUEST['phone'];
            
            $user = $this->common_model->get_data("users", " AND phone='" . $phone . "'", "id,email,phone", "1");
            //print_r($user);die;
            if (count($user) > 0) {
                //$passToken = random_string('numeric', 12);
				
				$otpToken = random_string('numeric', 4);
				
				
				$send_otp = $this->send_otp($phone, $user['id'], $otpToken, 3);
				if($send_otp == 1){
					
					$return_data['phone'] = $phone;
					$return_data['userid'] = $user['id'];
					
					
					$response = ['status' => 200, 'message' => 'OTP send to your Mobile Successfully', 'phone' => $phone];
				}else{
					$response = ['status' => 201, 'message' => 'There is some issue in send message.'];
				}
	
            } else {
                //$response = ['status' => 0, 'message' => 'Please Enter Correct User Name.'));
                $response = ['status' => 201, 'message' => 'Please Enter Correct User Name'];
            }
		}
        print json_encode($response);
    }
 


public function password_reset()
    { 
        $response = $errors = [];
        $error = false;
        $_REQUEST = (array)json_decode(file_get_contents('php://input'), TRUE);
        $parameters = ['userid','password'];
        foreach ($parameters as $parameter) {
            if (!isset($_REQUEST[$parameter]) || !$_REQUEST[$parameter]) {
                $error = true;
                $errors[$parameter] = $parameter . " can't be blank.";
            }
        }
        if ($error == true) {
            $response = ['status' => 201, 'message' => $errors];
        }else{
              $phone = $_REQUEST['phone'];
			//$user_id = $_REQUEST['userid'];
            
		
		
            $userid = $user_id;
            $newpassword = md5($_REQUEST['password']);
            $passarr = array('password' => $newpassword, 'password_text' => $_REQUEST['password']);
            $passupdate = $this->user_model->updateInfor('users', $passarr, 'id', $userid);
				if ($passupdate > 0) {
					$user = $this->common_model->get_data("users", " AND id='" . $userid . "'", "emp_id,email", "1");
					//print_r($user);die;
					$subject = 'Reset Password Successfully';
			   
					   $response = ['status' => 200, 'message' => $subject];
				   
				} else {
					$response = ['status' => 200, 'message' => 'There is some issue to update password. Try again after some time.'];
				}
			}
        print json_encode($response);

	}




// 	public function mailsend($to, $name = "", $subject, $body, $from = "no-reply" . host, $fromname = "Trade Radar", $attachment = "")
//     {

//         $this->load->library('email');
//         $this->email->set_mailtype("html");

//         $this->email->from($from, $fromname);
//         $this->email->to($to);
//         //$this->email->cc('another@another-example.com');
//         //$this->email->bcc('them@their-example.com');
//         $this->email->subject($subject);
//         $this->email->message($body);
//       return  $this->email->send();
		
		
//     }
	
	
	
	
	
	
	
	
	
	
	
}