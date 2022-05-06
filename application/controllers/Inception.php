<?php
//echo $this->config->item('host'); die();
defined('BASEPATH') OR exit('No direct script access allowed');

class inception extends CI_Controller {

	var $enc_header = 'pixelsoftwares';
	var $error_code = array(
					'200' => 'Success',
					'201'=>'false',
					'304'=>'Unabled to modified',
					'400'=>'Bad Request',
					'401'=>'Socket Timeout',
					'402'=>'Unauthorised',
					'403'=>'Forbidden',
					'404'=>'Not Found',
					'405'=>'Method Not allowed',
					'409'=>'Duplicate',
					'410'=>'Delete',
					'413'=>'Request Entity too Large',
					'416'=>'Request range not satisfiable',
					'417'=>'Exception Failed',
					'429'=>'Too many requests',
					'500'=>'Internal Server Error',
					'502'=>'Payment Required',
					'503'=>'Service Unabalable',
					'701'=> 'Not Verified',
					'702'=> 'Account Suspended',
					'703'=> 'Token Expired',
					'704'=> 'Email not sent',
					'705'=> 'User Details not exists'
				);

	public function __construct() {
   		parent::__construct();
    
		$this->load->model(array('user_model','common_model','admin_modal'));
        $this->load->helper(array('url','date','form','string','comman_helper',));
        $this->load->library(array('email','javascript','session','upload','My_PHPMailer','encryption','user_agent'));
  	}
	public function index(){/*Content*/}
	PUBLIC FUNCTION test ()
	{
		$kyc = $this->common_model->get_data('kyc',' AND user_id=73','address_id_status,national_id_status','1');
		print_r($kyc); die;
		if(!empty($kyc))
		{
			if($kyc['address_id_status'] == 1 OR $kyc['national_id_status'] == 1)
			{
				echo 'You KYC status is pending for verification';
			}elseif ($kyc['address_id_status'] == '' OR $kyc['national_id_status'] == '') {
				echo 'Please upload you kyc documents';
			}
		}else
		{
			echo 'Please upload you kyc documents';
		}
	}
	public function headtoken()
	{
		$headers = getallheaders();
     	//echo $headers["Token"]; die;
        if(!empty($headers["token"]) && md5($this->enc_header) == $headers["token"]){
            return true;
        }else{
            echo json_encode(array("status"=>402,"message"=>"Unauthorised"));
            die;
        }
    }
    public function GetAuthTokenValid()
	{
		$headers = getallheaders();
        if(!empty($headers["Token"]) && md5($this->enc_header) == $headers["Token"] && !empty($headers["Token-Id"]))
        {
            $tokenid = base64_decode($headers["Token-Id"]);//$this->input->post('tokenid');
            $user_id = $this->common_model->get_data('members',' AND tokenid = '.$tokenid,'id','1');
            if($user_id){
            	return $user_id['id'];	
            }else{
            	echo json_encode(array("status"=>703,"message"=>"Token Expired"));
            	die;
            }
        }else
        {
            echo json_encode(array("status"=>402,"message"=>"Unauthorised",'data'=>$headers));
            die;
        }
    }
    PUBLIC FUNCTION GenerateTokenID($debug=""){
		$rnum = rand(10000000,99999999);
		//$rnum = $rnum.date("my");
			
		if(!empty($debug)){
			$rnum = $debug;
		}
		#CHECK IF EXIST
		$u_info = $this->common_model->get_data('members',' AND tokenid = '.$rnum,'id','1');
		//$u_info = getquery("tbl_user","AND tokenid = '".$rnum."'","id");
		if(count($u_info['id'])){
			return $this->GenerateTokenID();
		}
		else{
			return $rnum;
		}
	}
	PUBLIC FUNCTION UpdateMyWallet($user_id,$amount,$type)
    {
        $wallet = $this->MyWallet($user_id);

        $wallet = (($type == 1)? $wallet+$amount : $wallet-$amount);
        if($wallet >= 0){
            $data = array('amount'=>$wallet);
            $this->user_model->UpdateMyWallet($user_id,$data);
        }else{
            $this->session->set_flashdata('error', 'Something went wrong!');
            redirect(base_url('user'));
        }
        return;
    }
    PUBLIC FUNCTION MyWallet ($user_id)
    {
        $data = $this->user_model->MyWalletBalance($user_id);
        if(!empty($data)){
            return $data->amount;
        }else{
            //$wallet = $this->user_model->MyWallet ($user_id)->m_wallet;
            $this->common_model->add_data('my_wallet',array('user_id'=>$user_id,'amount'=>'0.00'));
            return $this->MyWallet($user_id);
        }
    }
	PUBLIC FUNCTION actionCheckversionandroid()
    {
        $response= array();
        $post['User'] = $this->input->get();
        if(!empty($post['User']))
        {
            isset($post['User']['version']) && !empty($post['User']['version']) ? $version = floatval($post['User']['version']) : $version = '';

	        //get device version's.
	        $data = $this->change_model->get_data("mobile_version","","device_name,version");                 
	        $android_v = $ios_v ='';
	        foreach($data as $value){
	        	if($value['device_name'] =='Android'){ $android_v = $value['version']; }
	        	else if($value['device_name'] =='ios'){ $ios_v = $value['version']; }
	        }

            //set device version's.
            $android_setversion=$android_v; //Android version last= 1.6
	        $ios_setversion=$ios_v; //IOS version

	        $setversion = floatval(isset($post['User']['device']) && $post['User']['device']=='ios' ? $ios_setversion : $android_setversion);
            
            if(!empty($setversion))
            {
            	if (version_compare((double)$version, (double)$setversion) >= 0) {

				  	$response['status'] ='true';
                    $response['isupdate'] =1;
                    $response['message'] ='Updated application';
				}else{

				 	$response['status'] ='false';
                    $response['isupdate'] =0;
                    $response['message'] ='Please update your application';
				}
            }
            else
            {
                $response['status'] ='true';
                $response['message'] ='Updated application';
            }
            echo json_encode($response); 
            die;
          }    
    }
	#SEND MAIL
	PUBLIC function mailsend($to="",$name="",$subject="",$body="",$from="",$fromname="")
	{
		$this->email->set_mailtype("html");
		$this->email->from($from, $fromname);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($body);
		if($this->email->send())
		{
			return 1;
		}
		else
		{
			return 0;
		}	
	}
	PUBLIC FUNCTION userinfo()
	{
		if(!empty($this->input->post('tokenid')))
		{
			$uinfo = $this->common_model->get_data('members',' AND tokenid = '.$this->input->post('tokenid'),'id','1');
			if($uinfo){
				$data = $this->user_model->UserInfo($uinfo);
				if($data){
					return $data;
				}
				else{
					echo json_encode(array("status"=>400,"message"=>"No data found!!"));
					die;	
				}
			}else{
				echo json_encode(array("status"=>400,"message"=>"Invalid User!!"));
				die;
			}
		}else{
				echo json_encode(array("status"=>402,"message"=>"Unauthorised"));
				die;
		}
	}
	/*
	Parameters : email Or username
	*/
	PUBLIC FUNCTION CheckDupData()
	{
		if($this->headtoken() == true){
			if(!empty($this->input->post()))
			{
				$data = $this->input->post();
				if(isset($data['email']) && isset($data['username'])){
					if(!empty($data['email']) && !empty($data['username'])){
						$email 	 = trim($_POST['email']);
						$username 	 = strtolower(trim($_POST['username']));

						$check_data = $this->common_model->get_data("members"," AND email='".$email."' OR username='".$username."'","id,username,email","1");
						// print_r($check_data); die;
						if($check_data)
						{
							if($check_data['username'] == $username){
								echo json_encode(array("status"=>409, "check"=>1, "message"=>"Username Already exists!!"));
								die;
							}else{
								echo json_encode(array("status"=>409, "check"=>2,"message"=>"Email Id Already exists!!"));
								die;
							}
						}else{
							echo json_encode(array("status"=>200,"message"=>"continue"));
						}
					}else{
						echo json_encode(array("status"=>400,"message"=>"Insufficent Data!!"));
					}
				}else{
					echo json_encode(array("status"=>400,"message"=>"Insufficent Data!!"));	
				}
			}else{
				echo json_encode(array("status"=>404,"message"=>"Not found!!"));
			}
		}else{
			echo json_encode(array("status"=>402,"message"=>"Unauthorised"));
		}
	}
	PUBLIC FUNCTION RegMethUser()
	{
		if($this->headtoken() == true){
			if(!empty($this->input->post()))
			{
				$data = $this->input->post();
				if(isset($data['email']) && isset($data['username']) && isset($data['password']) && isset($data['ref_id'])){
					if(!empty($data['email']) && !empty($data['email']) && !empty($data['email']) && !empty($data['email'])){
						$otpToken  = random_string('numeric',4);
						$username  = strtolower(trim($_POST['username']));
						$email 	 = trim($_POST['email']);
						$password  = md5(trim($_POST['password']));
						$referby   = trim($_POST['ref_id']);

						$referaldetailsdata = $this->common_model->get_data("members"," AND (ref_id='".$referby."' OR username = '".$referby."')","id,level","1");
						$referaldetails = $referaldetailsdata['id'];
						if($referaldetails){
							$user_level = $referaldetailsdata['level']+1;
							//$user_level = $this->user_model->getlevel($referaldetails[0]->id,0,'');
							$dataarr 	= array('username' => $username,'email'=>$email,'email_token'=>$otpToken,'password'=>$password,'ref_by'=>$referaldetails,'level'=>$user_level);
							$userid = $this->user_model->insert_data('members',$dataarr);
							if($userid>0)
							{
								$subject='Verification Email';
								$data['otp'] = $otpToken;
								$body = $this->load->view('templates/otp.php',$data,true);
								$mail = $this->mailsend($email,$username,$subject,$body,"no-reply".host,"Methertech");
								if($mail==1)
								{
									echo json_encode(array('status' =>200,'user_id'=>base64_encode($userid),'message'=>'Register Successfully.Please check your email for OTP code'));
							   	    die;
								}else{
								 	echo json_encode(array('status' =>704,'message' =>'There is some issue in send email.'));
							   	    die;
								}
							}else{
								echo json_encode(array("status"=>400,"message"=>"Something went wrong!!"));
							}
						}else{
							echo json_encode(array("status"=>201, "check"=>3,"message"=>"Refrerral not exists"));
							die;
						}
					}else{
						echo json_encode(array("status"=>400,"message"=>"Insufficent Data!!"));
					}
				}else{
					echo json_encode(array("status"=>400,"message"=>"Insufficent Data!!"));	
				}
			}else{
				echo json_encode(array("status"=>400,"message"=>"No data found!!"));
			}
		}else{
			echo json_encode(array("status"=>402,"message"=>"Unauthorised"));
		}
	}
	PUBLIC FUNCTION OtpVerification()
	{
		if($this->headtoken() == true){
			if(!empty($this->input->post('otp')))
			{
				$otp = str_replace(".", "", $this->input->post('otp'));
				if(!empty($this->input->post('user_id')))
				{
					$user_id = base64_decode($this->input->post('user_id'));
					$db_otp = $this->common_model->get_data("members"," AND id='".$user_id."'","email_token","1")['email_token'];
					if($db_otp == $otp){
						$userInfo 	  =  array('email_status'=>1);
				 	  	$verifyemail  =  $this->user_model->updateInfo('members',$userInfo,$user_id);

						$countries = $this->user_model->get_countries('countries','id,title,std_code',1);
						echo json_encode(array("status"=>200,"message"=>"OTP matched Successfully!!",'countries'=>$countries));
						die;
					}else{
						echo json_encode(array("status"=>201,"message"=>"OTP didn't matched!!"));
						die;	
					}
				}else{
					echo json_encode(array("status"=>400,"message"=>"Bad requests"));
					die;
				}
			}else{
				echo json_encode(array("status"=>400,"message"=>"Missing Parameters!!"));
			}
		}else{
			echo json_encode(array("status"=>402,"message"=>"Unauthorised"));
		}
	}
	PUBLIC FUNCTION SaveUserInfo()
	{
		if($this->headtoken() == true){
			if(!empty($this->input->post()))
			{
				$refid   = substr($_POST['u_first_name'], 0, 2).random_string('numeric',4);
		 		$dob 	 = $_POST['u_dob']!=''?change_date_format($_POST['u_dob'],"Y-m-d"):'';

		 		$userid  = base64_decode($_POST['user_id']);

				$infoarr = array(
						'user_id' =>$userid,
						'f_name'=>trim($_POST['u_first_name']),
						'l_name'=>trim($_POST['u_last_name']),
						'dob'=>$dob,
						'address'=>trim($_POST['u_address']),
						'city'=>trim($_POST['u_city']),
						'state'=>trim($_POST['u_state']),
						'country_id'=>$_POST['u_country'],
						'zip_code'=>trim($_POST['u_zipcode']),
						'phone'=>trim($_POST['user_phone'])
		 			);
			$user = $this->user_model->insert_data('user_information',$infoarr);
			if($user>0)
			{
				$userInfo 	  =  array('device_type'=>$_POST['device_type'],'device_token'=>$_POST['device_token'],'ref_id'=>$refid,'isactive'=>1);
	 	  		$activeuser   =  $this->user_model->updateInfo('members',$userInfo,$userid);
	 	  		$user	  =  $this->common_model->get_data("members"," AND id='".$userid."' and isactive=1","email,username","1");

	 	  		if($activeuser>0)
	 	  		{
	 	  		 	$subject = 'Register Successfully';
					$data['username'] = $user['username'];
					$body = $this->load->view('templates/welcome.php',$data,TRUE);					
					$mail = $this->mailsend($user['email'],$user['username'],$subject,$body,"no-reply".host,"Methertech");

					//get ip details
					$ip = $_POST['ip'];
		 			$ip_details = json_decode(file_get_contents("https://geoip-db.com/json/{$ip}"));
					//Get unique token
			 	 	$token = $this->GenerateTokenID();
			 	 	//update that token to the database and get him logged in
					$this->common_model->update_data('members',array('tokenid' => $token),array('id'=>$userid));
					//save login details with ip address
			 	 	$uinFoarr  = array(
									'user_id' => $userid,
									'login_time' => date('Y-m-d H:i:s'),
									//'user_agent' => $this->input->user_agent(),
									'user_agent' => $_POST['user_agent'],
									'ip_address' => $ip,
									'location' => $ip_details->city.','.$ip_details->state.','.$ip_details->country_code,
									//'user_browser' =>$this->agent->browser().' '.$this->agent->version(),
									'user_browser' => $_POST['browser'],
									'latitude' =>$ip_details->latitude,
									'logitude' =>$ip_details->longitude
									);
		 	 	  	  		$this->user_model->insert_data('login_log',$uinFoarr);
			 	 	  		echo json_encode(array("status"=>200,'token'=>base64_encode($token),"message"=>"Success"));
					//echo json_encode(array("status"=>200,"message"=>"Your Account has been created successfully!!!"));
	 	  		}
	 	  		else
	 	  		{
	 	  		 	echo json_encode(array('status' =>417,'message' =>'Exception Error'));
			   		die;
	 	  		}
			}
			else
			{
				echo json_encode(array("status"=>500,"message"=>"Internal Server Error"));
			   	die;
			}
			}else{
				echo json_encode(array("status"=>400,"message"=>"Bad Request"));
			}
		}else{
			echo json_encode(array("status"=>402,"message"=>"Unauthorised"));
		}
	}
	PUBLIC FUNCTION LoginMe()
	{
		
		if($this->headtoken() == true){
			if(!empty($this->input->post()))
			{
				 //print_r($_POST); //die();
				$email 		= strtolower(trim($_POST['u_email']));
		 		$password 	= md5(trim($_POST['u_password']));
		 		$ip = $_POST['ip'];
		 		$ip_details = json_decode(file_get_contents("https://geoip-db.com/json/{$ip}"));

		 		$required 	= 'members.device_token,members.id,members.ref_id,members.role,members.email_status,members.isactive,members.username,members.email,user_information.f_name,user_information.l_name,d.title as designation,members.phone,members.tokenid, members.currency,c.std_code,c.title as country_name, user_information.f_name,d.title as designation,CONCAT(imgdp.path,imgdp.image) as profile_pic,CONCAT(imgdp.path,imgdp.img_thumb) as profile_pic_thumb,c.title as country,c.std_code as phonecode,img.image as address_id,img.path as address_id_path,img.img_thumb as address_thumb,im.image as national_id,im.img_thumb as national_thumb,im.path as national_id_path,kyc.address_id_status,kyc.national_id_status,IFNULL(w.amount,0.00) as wallet, pp.active_date';
		 		$logindta   = $this->user_model->userLogin('members',$required,$email,$password);
		 		//print_r($logindta);die;
		 		if($logindta)
		 		{
		 			/*if($logindta[0]->device_token==$this->input->post('device_token'))
		 			{*/
			 			if($logindta[0]->email_status>0)//role
			 	 	  	{
				 	 	  	if($logindta[0]->isactive==1)
				 	 	  	{
				 	 	  		//Get unique token
				 	 	  		$token = $this->GenerateTokenID();
				 	 	  		//update that token to the database and get him logged in
				 	 	  		$this->common_model->update_data('members',array('tokenid' => $token,'device_type' => $this->input->post('device_type'),'device_token' => $this->input->post('device_token')),array('id'=>$logindta[0]->id));
				 	 	  		//mail to user for login info.
				 	 	  		$subject='Login Notification Email';
				 	 	  		$loginm['loginfoarr']  = array(
												'fullname' => $logindta[0]->f_name.' '.$logindta[0]->l_name,
												'time' => date('Y-m-d H:i:s')/*.' '.$ip_details->time_zone->abbr*/,
												//'useragent' => $this->input->user_agent(),
												'useragent' => $_POST['user_agent'],
												'ipaddress' => $ip,
												'location' => $ip_details->city.','.$ip_details->state.','.$ip_details->country_code,
												/*'browser' =>$this->agent->browser().' '.$this->agent->version()*/
												'browser' => $_POST['browser']
			 	 	  	  					);
			 	 	  	  		$body = $this->load->view('templates/login-notification.php',$loginm,TRUE);
			 	 	  	  		$mail = $this->mailsend($logindta[0]->email,$logindta[0]->username,$subject,$body,"no-reply".host,"Methertech");
				 	 	  		//save login details with ip address
				 	 	  		$uinFoarr  = array(
												'user_id' => $logindta[0]->id,
												'login_time' => date('Y-m-d H:i:s'),
												//'user_agent' => $this->input->user_agent(),
												'user_agent' => $_POST['user_agent'],
												'ip_address' => $ip,
												'location' => $ip_details->city.','.$ip_details->state.','.$ip_details->country_code,
												//'user_browser' =>$this->agent->browser().' '.$this->agent->version(),
												'user_browser' => $_POST['browser'],
												'latitude' =>$ip_details->latitude,
												'logitude' =>$ip_details->longitude
												);
			 	 	  	  		$this->user_model->insert_data('login_log',$uinFoarr);
								//$profile = $this->user_model->UserProfile($logindta['id']);
				 	 	  		echo json_encode(array("status"=>200,"user_profile"=>$logindta ,'token'=>base64_encode($token),'user_id'=>'',"message"=>"Success"));
				 	 	  	}elseif($logindta[0]->isactive==2){
				 	 	  		echo json_encode(array("status"=>702,"message"=>"Account Suspended","user_id"=>base64_encode($logindta[0]->id)));
				 	 	  	}else{
				 	 	  		echo json_encode(array("status"=>705,"message"=>"User Information not found","user_id"=>base64_encode($logindta[0]->id),'token'=>''));	
				 	 	  	}
			 			}else{
			 				//resend otp in case of email id already exists..
			 				$otpToken  = random_string('numeric',4);
							$otp_update = $this->common_model->update_data('members',array('email_token'=>$otpToken),array('email'=>$logindta[0]->email));
							if($otp_update>0)
							{
								$subject='Verification Email';
								$data['otp'] = $otpToken;
								$body = $this->load->view('templates/otp.php',$data,true);
								$mail = $this->mailsend($logindta[0]->email,$logindta[0]->username,$subject,$body,"no-reply".host,"Methertech");
								if($mail==1)
								{
									echo json_encode(array('status' =>200,'user_id'=>base64_encode($logindta[0]->id),'message'=>'Please check your email for OTP code','token'=>''));
							   	    die;
								}else{
								 	echo json_encode(array('status' =>704,'message' =>'Email not Verified.'));
							   	    die;
								}
							}
			 			}
		 		  /*}
		 		  else
		 		  {
		 		  	echo json_encode(array("status"=>400,"message"=>"Bad Request"));
		 		  }*/
				}
				else{
					echo json_encode(array("status"=>201,"message"=>"Invalid Credential"));
				}
			}else{
				echo json_encode(array("status"=>400,"message"=>"Bad Request"));
			}
		}else{
			echo json_encode(array("status"=>402, "message"=>"Unauthorised"));
		}
	}
	PUBLIC FUNCTION Logout ()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 20;
        	$data = $this->common_model->update_data('members',array('tokenid' => ''),array('id'=>$user_id));
			if($data){
				echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Logout Success"));
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	PUBLIC FUNCTION Dashboard()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			$data = $this->user_model->UserInfo($user_id);
			unset($data['id']);
			//print_r($data);
			if($data){
				$mether_wallet=$this->user_model->MyWalletBalance ($user_id);
				if(!empty($mether_wallet))
				{
				    $data['m_wallet'] = $mether_wallet->amount;
				    $data['e_wallet'] = $mether_wallet->e_wallet;
				}
				else
				{
				    $data['m_wallet'] = 0.00;
				    $data['e_wallet'] = 0.00;
				}
				//$wallets['t_buss'] = $this->GetTeamBuss($user_id);
				$data['t_profit'] = $this->user_model->total_profit($user_id)['total_profit'];
				$teaminvstarr = array();
				$teaminvest = $this->user_model->getTeaminvest($user_id,1,$teaminvstarr);
        		$data['t_buss'] =  array_sum(array_column($teaminvest, 'total_purchase'))>0?number_format(array_sum(array_column($teaminvest, 'total_purchase')),2):'0.00';
        		$data['kyc'] = !empty($this->user_model->KycStatus($user_id)['kyc'])?$this->user_model->KycStatus($user_id)['kyc']:0;
        		$data['status'] = 0; //static on dashboard need clarification......
        		$last_login = $this->common_model->get_data("login_log"," AND user_id='".$user_id."'","ip_address,login_time","1",'','','ORDER BY id',' LIMIT 1, 1');

        		$data['login_time'] = $last_login['login_time'];
        		$data['ip'] = $last_login['ip_address'];
				//$data['wallets'] = $wallets;
				
				echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	/*
		-Get Wallet amount and user mether statement
		-Type 1 for Mether statement and 2 for Earning statement.
	*/
	PUBLIC FUNCTION MetherCredit ()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 20;
			if(!empty($this->input->post('type')) && $this->input->post('type') == 1)
			{
				$data = $this->user_model->MetherWalletStatement ($user_id);

			}elseif (!empty($this->input->post('type')) && $this->input->post('type') == 2) {

				$data = $this->user_model->E_WalletStatement ($user_id);
			}else{
				echo json_encode(array("status"=>400, "wallet"=>0.00, "earning"=>0.00, 'transaction'=> array()));
				die;
			}

			if($data){
				//$data = array_reverse($data,true);
				if(!empty($this->input->post('offset')))
				{
					$data = array_slice($data, -10, 10, true);
				}
				$mether_wallet = $this->user_model->MyWalletBalance($user_id);
				if(!empty($mether_wallet)){
					$m_wallet = $mether_wallet->amount;
					$ewallet  = $mether_wallet->e_wallet;
				}else{
					$m_wallet = 0.00;
					$ewallet  = 0.00;
				}
				echo json_encode(array("status"=>200, "wallet"=>$m_wallet, "earning"=>$ewallet, 'transaction'=>$data));
			}
			else{
				echo json_encode(array("status"=>201, "wallet"=>0.00, "earning"=>0.00, 'transaction'=> array()));
			}
		}else{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
	/*
		-user listing for mether transfer
	*/
	PUBLIC FUNCTION MetherCreditInfo()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 23;
			$mether_wallet = $this->user_model->MyWalletBalance($user_id);
			if(!empty($mether_wallet)){
				$m_wallet = $mether_wallet->amount;
			}else{
				$m_wallet = 0.00;
			}

			$query = "SELECT m.id,m.username,(CASE WHEN ui.f_name != 'NULL' THEN ui.f_name ELSE 'NA' END) as name
        		FROM members m
        		left join user_information ui on m.id = ui.user_id
        		where m.isactive=1 AND m.id !=1 AND m.id !=".$user_id." order by m.username";
        		
        	$result = $this->common_model->exec_query($query,'full');

			if($result){
				echo json_encode(array("status"=>200, "wallet"=>$m_wallet,'users'=>$result));
			}
			else{
				echo json_encode(array("status"=>201, "wallet"=>$m_wallet,'users'=> array()));
			}
		}else{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
	PUBLIC FUNCTION MetherTransfer()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 23;
			if($this->input->post()){
				$data = $this->input->post();
				if(!empty($data['user_id']) && !empty($data['amount']) && !empty($data['remarks']))
				{
					$txn_id = time();
					$mether_wallet = $this->user_model->MyWalletBalance($user_id);
					if(!empty($mether_wallet)){
						$m_wallet = $mether_wallet->amount;
					}else{
						$m_wallet = 0.00;
					}

					if($m_wallet < $data['amount'])
			        {
			            echo json_encode(array("status"=>201,"message"=>"Insufficent Funds"));
						die;
			        }

			        $data['created_by'] = $user_id;
        			$data['txn_type'] = 3;
        			$data['remarks'] = (($data['remarks']=='')?'-NA-':$data['remarks']);
        			//debit amout from the user account
        			$data_debit = array(
			            'user_id'=>$user_id,
			            'front_user_id'=>$data['user_id'],
			            'type'=>2,
			            'amount'=>$data['amount'],
			            'mode'=>1,'txn_type'=>3,
			            'invoice_number'=>$txn_id,
			            'remarks'=>$data['remarks'],
			            'description'=>$data['user_id'],
			            'created_by'=>$user_id
			        );
        			$insert_id = $this->common_model->add_data('accounts',$data_debit);
        			if($insert_id){

			            //credit entry to user accounts
			            $data['description'] = $insert_id;
			            $data['front_user_id'] = $user_id;
			            $data['invoice_number'] = $txn_id;
			            $this->common_model->add_data('accounts',$data);
			            //update wallet for both users..
			            $this->UpdateMyWallet($data['user_id'],$data['amount'],1);
			            $this->UpdateMyWallet($user_id,$data['amount'],2);
			            //mail to credit user
			            $debit_user=$this->user_model->UserInfo($user_id);
			            $credit_user=$this->user_model->UserInfo($data['user_id']);

			            $debit_user['amount'] = $data['amount'];
			            $credit_user['amount'] = $data['amount'];

			            $credit_subject = 'Your wallet has been credited with an amount of USD '.$data['amount'];
			            $debit_subject = 'Your wallet has been debited with an amount of USD '.$data['amount'];

			            $credit_body = $this->load->view('templates/user_credits',$debit_user,TRUE);
			            $debit_body = $this->load->view('templates/user_debit',$credit_user,TRUE);

			            $c_mail = $this->mailsend($debit_user['email'],$debit_user['f_name'],$debit_subject,$debit_body,"no-reply".host,"Methertech");
			            $d_mail = $this->mailsend($credit_user['email'],$credit_user['f_name'],$credit_subject,$credit_body,"no-reply".host,"Methertech");

			            echo json_encode(array("status"=>200,"message"=>"Success",'txn_id'=>$txn_id));
			   			die;
        
        			}else{
        				echo json_encode(array("status"=>500,"message"=>"Internal Server Error"));
			   			die;
        			}

				}else
				{
					echo json_encode(array("status"=>400,"message"=>"Bad Request"));
					die;
				}
			}else{
				echo json_encode(array("status"=>400,"message"=>"Bad Request"));
				die;
			}
		}else{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
	PUBLIC FUNCTION MyProfile()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 24;
			$data = $this->user_model->UserDetail($user_id);
			//print_r($data);
			if($data){
				unset($data['id']);
				$data['basepath'] = base_url();
				echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	PUBLIC FUNCTION EditProfile()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if($this->input->post())
			{
				$data = $this->input->post();
				$update_data = array('modified_date' => date('Y-m-d h:i:s'));
				if(isset($data['f_name']) && !empty($data['f_name']))
				{
					$update_data['f_name'] = $data['f_name'];
				}
				if(isset($data['l_name']) && !empty($data['l_name']))
				{
					$update_data['l_name'] = $data['l_name'];
				}
				if(isset($data['dob']) && !empty($data['dob']))
				{
					$update_data['dob'] = $data['dob'];
				}
				if(isset($data['address']) && !empty($data['address']))
				{
					$update_data['address'] = $data['address'];
				}
				if(isset($data['gender']) && !empty($data['gender']))
				{
					$update_data['gender'] = $data['gender'];
				}
				if(isset($data['city']) && !empty($data['city']))
				{
					$update_data['city'] = $data['city'];
				}
				if(isset($data['state']) && !empty($data['state']))
				{
					$update_data['state'] = $data['state'];
				}
				if(isset($data['zip_code']) && !empty($data['zip_code']))
				{
					$update_data['zip_code'] = $data['zip_code'];
				}
				$update = $this->common_model->update_data('user_information',$update_data,array('user_id'=>$user_id));
				if($update){
					echo json_encode(array("status"=>200, "message"=>"Success"));
					die;
				}else{
					echo json_encode(array("status"=>500,"message"=>"Internal Server Error"));
				}
			}else{
				echo json_encode(array("status"=>400, "message"=>"Bad Request"));
				die;
			}
		}
	}
	PUBLIC FUNCTION DirectReferrals()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			
			if($this->input->post('pagelimit')!='')
		      {	
		      	$rowperpage  = 10;
				$startoffset = ($this->input->post('pagelimit')) * $rowperpage;
				$search ="";
				if($this->input->post('search')){
					$search = $this->input->post('search');
				}
				$count = count($this->user_model->RefferalData($user_id,$search));
				$data = $this->user_model->RefferalData($user_id,$search,$startoffset,$rowperpage);
				if($data){
					echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success", "total"=>$count));
				}else{
					echo json_encode(array("status"=>404, "message"=>"Not Found"));	
				}
			}
			else
			{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));
			}
		}
	}
	PUBLIC FUNCTION TeamSummary()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			$query = "";
			$levels = "";
			if($this->input->post('search'))
			{
				$query = $this->input->post('search');
			}
			if($this->input->post('level'))
			{
				$levels = $this->input->post('level');
			}
			$search = array();
			$search['query'] = $query;
			$search['level'] = $levels;
			$rowperpage  = 10;
			$startoffset = ($this->input->post('pagelimit')) * $rowperpage;

			$user_level = $this->common_model->get_data("members"," AND id=".$user_id."","level","1");
			$maxlevel 	= $this->user_model->getTeam($user_id,$user_level['level']);
        	
        	$count = $this->user_model->getTeamapi($user_id,1,$user_level['level'],'','',$search);
        	$data = $this->user_model->getTeamapi($user_id,'',$user_level['level'],$startoffset,$rowperpage,$search);
        	$level = array_column($maxlevel, 'level');
        	$level = max($level);
			
			if($data)
			{ 
				echo json_encode(array("status"=>200, "data"=>$data, 'level'=>$level, "message"=>"Success", "total"=>$count));
			}
			else
			{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	PUBLIC FUNCTION network_explorer()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			$frstnode  = $user_id!=0?$user_id:1;
		      $pteamarr  = array();
		      $data      = [];
		      $members   = array();
		      $root_user = $this->db->query("SELECT id,ref_id, username from members WHERE id=".$frstnode." AND email_status = 1 AND isactive =1 order by id asc limit 1");
		      $resultu   = $root_user->result_array();

		      $parent_key   = $resultu[0]['id'];
		      $top_member   = $resultu[0]['username'];
		      $ref_id   = $resultu[0]['ref_id'];
		      $pteam_list    = $this->user_model->get_networkdata($parent_key,$pteamarr);
		      // var_dump('expression');die;
		      $pteam_count   = count($pteam_list); 
		      array_push($members, array('id'=>$parent_key,'parent'=>'#','text'=>$top_member, 'count' =>$pteam_count, 'ref_code'=>$ref_id)); 
		      $row = $this->db->query("SELECT ref_id, id, username,ref_by as parent_id from members WHERE ref_by='".$parent_key."' AND email_status = 1 AND isactive =1");
		      $result   = $row->result_array();

		      if($row->num_rows() > 0)
		      {  $j=0;
		        for($i=0;$i<count($result);$i++) 
		           {
		             $data = $this->members_tree($parent_key,$members,$j);
		           }
		      }
		      else
		      {
		       $data=$members;
		      }
			if($data){
				echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	public function members_tree($parent_key,$members)
	{     $teamarr= array();
	  	  $row = $this->db->query("SELECT ref_id, id, username,ref_by as parent_id from members WHERE ref_by='".$parent_key."' AND email_status = 1 AND isactive =1")->result_array();

	      foreach($row as $key => $value)
	            {
	             $team_list  = $this->user_model->get_networkdata($value['id'],$teamarr);
	             $team_count = count($team_list);
	             array_push($members, array('id'=>$value['id'],'parent'=>$value['parent_id'],'text'=>$value['username'],'count'=>$team_count,'ref_code'=>$value['ref_id']));
	             $members = array_values($this->members_tree($value['id'],$members));
	            }
	        return $members;
	}
	PUBLIC FUNCTION agprofit()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			$rowperpage  = 10;
			$startoffset = ($this->input->post('pagelimit')) * $rowperpage;
        	$count = $this->user_model->AGPDataMain($user_id,1);
        	$data = $this->user_model->AGPDataMain($user_id,'',$startoffset,$rowperpage);
			if($data){
				echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success", "total"=>$count));
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	/*
		-Pass Package purchased id for
	*/
	PUBLIC FUNCTION AGPsummary()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if(!empty($this->input->post('id')))
			{
				$id = $this->input->post('id');
				if(!empty($this->input->post('start_date')) && !empty($this->input->post('end_date')))
				{
					$start_date = $this->input->post('start_date');
					$end_date = date('Y-m-d',strtotime($this->input->post('end_date') . ' +1 day'));
					$data = $this->user_model->AGPsummary($id,$user_id,$start_date,$end_date);
				}else{
					$data = $this->user_model->AGPsummary($id,$user_id);
				}
				if($data){
					echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
				}else{
					echo json_encode(array("status"=>404, "message"=>"Not Found"));	
				}
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	/*
		-type (1-Intodutory Bonus, 2-Referral Profit,3- Team/Network Profit, 4- Appraisal)
	*/
	PUBLIC FUNCTION EarnignProfit()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if(!empty($this->input->post('type')))
			{
			     if($this->input->post('pagelimit')!='')
			      {	
			      	$perpage  = 10;
					$startoffset = ($this->input->post('pagelimit')) * $perpage;
					$search ="";
					if($this->input->post('search'))
					{
						$search['query'] = $this->input->post('search');
					}

					$type = $this->input->post('type');
					if($type == 3)
					{
						$count = count($this->user_model->MyNetworkProfits($user_id,$type,'','','',$search));
						$data = $this->user_model->MyNetworkProfits($user_id,$type,'',$startoffset,$perpage,$search);
						//print_r($data);die;
					}
					else
					{
						$count = count($this->user_model->MyProfits($user_id,$type,'','','',$search));
						$data = $this->user_model->MyProfits($user_id,$type,'',$startoffset,$perpage,$search);
					}
					
					if($data){
						echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success", "total"=>$count));
					}else{
						echo json_encode(array("status"=>404, "message"=>"Not Found"));	
					}
				 }
				 else
				 {
					echo json_encode(array("status"=>400, "message"=>"Bad Request"));	
				 }
			}
			else
			{
				echo json_encode(array("status"=>400, "message"=>"Bad Request"));	
			}
		}
	}
	public function getprofts_dels()
	 {
	 	$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if(!empty($this->input->post('type')) && !empty($this->input->post('ref')))
			{
				$from = $this->input->post('ref');
				$type = $this->input->post('type');
	 			$allprofits  = $this->user_model->MyProfitsdetails($user_id,$from,$type);
	     		echo json_encode(array("status"=>200, "data"=>$allprofits, "message"=>"Success","total"=>count($allprofits)));
	     	}
	     	else
			{
				echo json_encode(array("status"=>400, "message"=>"Bad Request"));	
			}
	     }
	  }
	PUBLIC FUNCTION MyRewards()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
        	$data = $this->user_model->MyRewards($user_id);
			if($data){
				echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	PUBLIC FUNCTION Packages()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
        	$data = $this->user_model->Packages();
			if($data){
				$membership = $this->common_model->get_data("packages_purchase"," AND user_id=".$user_id." AND package_id=6 AND isactive=1","id","1");
				if($membership['id'])
				{
					array_pop($data);
				}else{
					$data = array_pop($data);
				}
				echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	PUBLIC FUNCTION wallets()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
        	$data = $this->user_model->MyWalletBalance($user_id);
	        if(!empty($data)){
	            echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
	        }else{
	            $this->common_model->add_data('my_wallet',array('user_id'=>$user_id,'amount'=>'0.00'));
	            return $this->MyWallet($user_id);
	        }
		}
	}
	PUBLIC FUNCTION InvoiceSummary()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
        	$data = $this->user_model->InvoiceSummary($user_id);
	        if(!empty($data)){
	            echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
	        }else{
	            echo json_encode(array("status"=>404, "message"=>"Not found"));;
	        }
		}
	}
	PUBLIC FUNCTION Invoice()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
	        if(!empty($this->input->post('id')))
			{
				$id = $this->input->post('id');
				$data = $this->user_model->InvoiceDetail($id,$user_id);
				if($data){
					echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
				}else{
					echo json_encode(array("status"=>404, "message"=>"Not Found"));	
				}
			}else{
				echo json_encode(array("status"=>400, "message"=>"Bad Request"));
			}
		}else{
			echo json_encode(array("status"=>400, "message"=>"Bad Request"));
		}
	}
	PUBLIC FUNCTION PackagePurchase ()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
	        if(!empty($this->input->post('pkg_id')))
			{
				//get wallet balace
				$MetherWallet = $this->MyWallet ($user_id);
				$pkg_id = $this->input->post('pkg_id');
				//get all package details
				$packageDetails = $this->user_model->PackageDetail($pkg_id);
				if($MetherWallet >= $packageDetails->price)
            	{
            		//Update wallet in my_wallet
            		$this->UpdateMyWallet($user_id,$packageDetails->price,2);
            		$inser_data = array(
	                    'user_id'=>$user_id,
	                    'package_id'=>$packageDetails->id,
	                    'title'=>$packageDetails->title,
	                    'daily_percentage'=>$packageDetails->daily_percentage,
	                    'monthly_percentage'=>$packageDetails->monthly_percentage,
	                    'description'=>$packageDetails->description,
	                    'price'=>$packageDetails->price,
	                );
	                //Insert data in package purchase table
                	$insert_id = $this->common_model->add_data('packages_purchase',$inser_data);

                	if($insert_id)
                	{

                    $insert_txn = array(
                        'user_id'=>$user_id,
                        'type'=>2,
                        'amount'=>$packageDetails->price,
                        'invoice_number'=>time(),
                        'txn_type'=>2,
                        'mode'=>1,
                        'description'=>'Package Purchased',
                        'remarks'=>'Package Purchased',
                        'ref_id'=>$insert_id,
                        'created_by'=>$user_id
                    );
                //Insert data in account table
                        $txnid = $this->common_model->add_data('accounts',$insert_txn);
                        if($txnid){
                            $user_details = $this->common_model->get_data("members"," AND id=".$user_id,"designation,email","1");
                            //upgrade the designation
                            $this->scanDesignation($user_id);
                            
                            if($packageDetails->id == 6){ 
                                //Intorudctory profit for starter package to the first only!!
                                $this->IntoductoryProfit ($txnid,$user_details['designation'],$user_id,$packageDetails->id,$user_id,1);
                            }else{
                                //Referrer profit for Satndard package to the parent!!
                                $this->ReferrerProfit ($user_id,$user_details['designation'],$txnid,$packageDetails->id);
                                $this->networkProfit ($txnid,$packageDetails->id,$user_id,$user_details['designation'],$user_id,0,0,1);
                            }
                            $user_data = $this->common_model->get_data("user_information"," AND user_id=".$user_id,"f_name","1");
                            $email_data['name']=$user_data['f_name'];
                            $email_data['amount']=$packageDetails->price;
                            $subject = 'Congratulations! Your purchase of package has been successful.';
                            $body = $this->load->view('templates/purchase_invoice',$email_data,TRUE);
                            $mail = $this->mailsend($user_details['email'],$user_data['f_name'],$subject,$body,"no-reply".host,"Methertech");
                            //create message for package successfull.
                            echo json_encode(array("status"=>200, 'id'=>$txnid, "message"=>"Package Purchase successful!"));
                        }
                        else{
                            echo json_encode(array("status"=>400, "message"=>"Bad Request"));
                            die;
                        }
                	}else{
                		echo json_encode(array("status"=>500, "message"=>"Internal Error"));
            			die;
                	}
            	}else{
            		echo json_encode(array("status"=>201, "message"=>"Insufficent balace"));
            		die;
            	}
			}else{
				echo json_encode(array("status"=>400, "message"=>"Bad Request"));
			}
		}else{
			echo json_encode(array("status"=>400, "message"=>"Bad Request"));
		}
	}
	PUBLIC FUNCTION ReferrerProfit ($user_id,$buyerdesg,$ref_id,$pkg_id)
	{
		$ParentDetails = $this->common_model->MyParentDetails ($user_id);
		if($ParentDetails['starter'] > 0){
			$pkg_datails = $this->common_model->get_data("packages"," AND id=".$pkg_id,"ditribution,id,price","1");
			if($pkg_datails){
				$ditribution = ($pkg_datails['price'] * $pkg_datails['ditribution'])/100;
					$InsertProfit = array(
							'ref_id' => $ref_id,
							'user_id'=> $ParentDetails['p_id'],
							'user_id_from'=>$user_id,
							'amount'=>$ditribution,
							'description'=>'Referrer Bonus',
							'designation'=>$ParentDetails['designation'],
							'buyer_designation'=>$buyerdesg,
							'type'=>2
						);
				$profitId = $this->common_model->add_data('profit',$InsertProfit);
        		$this->UpdateWallet($ParentDetails['p_id'],$ditribution,1,'e_wallet');
			}
		}
		return;
	}
	public function networkProfit($refid,$packageid,$buyerid,$buyerdsg,$userid,$lastpost,$lastpercentage,$level)
	 {
	 	try
	     {
	     	$profitpercent = '';
	     	$ParentDetails = $this->common_model->MyParentDetails ($userid);
	     	$parentid = $ParentDetails['p_id'];
	     	$prntpost = $ParentDetails['designation'];
	     	$userType = $ParentDetails['starter'];
	     	if($parentid>1)
	     	  {
		     	if($userType>0 && $prntpost>1 && $prntpost>$lastpost)
		     	{
		     		$package_dels 	=  $this->common_model->get_data("packages"," AND id=".$packageid,"*","1");
		     		$desg_con 		=  $this->common_model->get_data("designation"," AND id=".$prntpost,"*","1");
		     		$profitpercent 	=  $desg_con['percentage'];
		     		$profitsend 	=  $profitpercent-$lastpercentage;
		     		
		     		$networkBonus   = ($package_dels['price']*$profitsend)/100;
		     		$bonusData    = array('ref_id' => $refid,'designation' => $prntpost,'buyer_designation' => $buyerdsg,'user_id' => $parentid,'user_id_from' => $buyerid,'amount' => $networkBonus,'profit_percent' => $profitsend,'description' => 'Network Bonus','type' =>3,'level' =>$level);
				 	$this->common_model->add_data("profit",$bonusData);
	        		$this->UpdateWallet($parentid,$networkBonus,1,'e_wallet');
		     	}
		     	else
		     	{
		     		$profitpercent = $lastpercentage;
		     	}
		     	$level++;
		     	$this->networkProfit($refid,$packageid,$buyerid,$buyerdsg,$parentid,$prntpost,$profitpercent,$level);
	       }
	     }
		 catch(Exception $e)
		  {
			var_dump($e->getMessage());
		  }
	 }
	public function scanDesignation($userid)
  	{	
  		//user_id who buying the package.
	  	try
	     {
	     	if($userid!=1)
	     	{
		     	$designation = '';
		     	$ParentDetails = $this->common_model->MyParentDetails ($userid);
		  		$user_type  = $ParentDetails['my_starter'];
				$user_id 	= $ParentDetails['p_id'];
		  		if($user_type>0)
		  		 { 
		  		 	$crnt_post  = $ParentDetails['mydesignation'];
				  	$teaminvest  = $this->user_model->getTeaminvest($userid,1,array());
				  	$teaminvest  = array_sum(array_column($teaminvest, 'total_purchase'));
				  	$desg_con =  $this->common_model->get_data("designation"," AND bussiness<=".$teaminvest,"*","full","","","ORDER BY id DESC");
				  	if(!empty($desg_con))
				  	{
					  	foreach($desg_con as $key=>$designation)
			  			{
							if($designation['bussiness']>0)
							{
								$condition = $designation['desg_req1'];
								$level1 = $designation['desg_req1_lvl'];
								$count1 = $designation['count1'];
								$tot1 = $this->checkteamdesignation($condition,$userid,$level1);
								$condition = $designation['desg_req2'];
								$level2 = $designation['desg_req2_lvl'];
								$count2 = $designation['count2'];
								$tot2 = $this->checkteamdesignation($condition,$userid,$level2);
								if($count1==$tot1 && $count2==$tot2)
								  {
								  	 $designation = $designation['id'];
								  	 if($designation>$crnt_post)
								  	 {
								  	 	//echo $userid.' ';
								  	 	//echo $designation.'<br>';
								  	 	$this->UpgradeDesignation ($userid,$designation);
								  	 }
								  	 break;
								  }	  
							}
			  			}
			  		}
		  		 }
			  	  $this->scanDesignation($user_id);
		  	}
	  	  }
	  	  catch(Exception $e)
		  {
			var_dump($e->getMessage());
		  }
  	}
  	public function IntoductoryProfit ($refid,$buyerdesg,$user_id_from,$package_id,$parent_ref,$level)
	 {
	 	try
	     {
		 	//$user_dels =  $this->common_model->get_data("members"," AND id=".$parent_ref,"ref_by","1");
		 	$ParentDetails = $this->common_model->MyParentDetails ($parent_ref);
	     	//print_r($ParentDetails);die;
	     	$user_id 	= $ParentDetails['p_id'].' ';
	  		$user_type  = $ParentDetails['starter'];
	  		$crnt_post  = $ParentDetails['designation'];
		 	
		 	if($user_id==0)
		 	{
		 		return 0;
		 	}
		 	//$user_type  = $this->user_model->user_type('starter',$user_id);
		 	if($user_type>0)
		 	  {
		 	  	$package_dels =  $this->common_model->get_data("packages"," AND id=".$package_id,"*","1");
		 	  	$bonusPercent = $package_dels['ditribution'];
		 	  	$packPrice 	  = $package_dels['price'];
		 	  	$introBonus   = ($package_dels['price']*$bonusPercent)/100;
		 	  	$bonusData    = array('ref_id' => $refid,'designation' => $crnt_post,'buyer_designation' => $buyerdesg,'user_id' => $user_id,'user_id_from' => $user_id_from,'amount' => $introBonus,'profit_percent' => $bonusPercent,'description' => 'Introductory Bonus','type' =>1,'level'=>$level);
		 	  	$this->common_model->add_data("profit",$bonusData);
		 	  	return $this->UpdateWallet($user_id,$introBonus,1,'e_wallet');
		 	  }
		 	 else
		 	 {
		 	 	return $this->IntoductoryProfit($refid,$buyerdesg,$user_id_from,$package_id,$user_id,$level+1);
		 	 }
		 }
		 catch(Exception $e)
		  {
			var_dump($e->getMessage());
		  }
	 }
	public function checkteamdesignation($condition,$user_id,$level)
	  {
	  	 $i = 0;
	  	 $teamsummary = $this->user_model->getTeam($user_id,1,array());
	  	 //echo '<pre>';print_r($teamsummary); die;
	  	 foreach($teamsummary as $key=>$val)
	  		{
	  			if($val['post']==$condition && $val['level']==$level)
	  			 {
	  			 	$i++;
	  			 }
	  		}
	  	return $i;
	}
	PUBLIC FUNCTION UpgradeDesignation ($user_id,$new_designation)
    {
        $data = $this->common_model->get_data("designation"," AND id=".$new_designation,"rewards,id as new_designation","1");
        //insert designation log.
        $Insert_Desg = array('user_id' => $user_id,'designation'=>$data['new_designation']);
        $insert_desg_id = $this->common_model->add_data('designation_log',$Insert_Desg);
        //update designation in members table
        $this->common_model->update_data('members',array('designation'=>$data['new_designation']),array('id' =>$user_id));
        //insert reward points
        $add_reward = array(
        	'user_id' => $user_id,
        	'amount'=>$data['rewards'],
        	'description'=>'Rewards Credited on designation upgrade',
        	'type'=>6,
        	'designation'=>$data['new_designation']
        );
        $add_reward_id = $this->common_model->add_data('profit',$add_reward);
         $this->UpdateWallet($user_id,$data['rewards'],1,'e_wallet');
        return;
    }
    PUBLIC FUNCTION UpdateWallet($user_id,$amount,$type,$columname)
    {
    	$walletdata 	= $this->user_model->MyWalletBalance($user_id);
		$current_wallet = $walletdata->$columname;
        $wallet = (($type == 1)? $current_wallet+$amount : $current_wallet-$amount);
        if($wallet > 0)
        {
            $data = array(''.$columname.''=>$wallet);
            $this->user_model->UpdateMyWallet($user_id,$data);
        }
        else
        {
            $this->session->set_flashdata('error', 'Something went wrong!');
            redirect(base_url('user'));
        }
        return;
    }
    PUBLIC FUNCTION PaymentDetails()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 20;
        	$data['bank'] = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and type=4','','full','','','order by id desc');
        	$data['bitcoin']    = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and type=1');
	        $data['ethereum']    = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and type=2');
	        $data['perfectmoney']    = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and type=3');
	        if(!empty($data)){
	            echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
	        }else{
	            //$wallet = $this->user_model->MyWallet ($user_id)->m_wallet;
	            $this->common_model->add_data('my_wallet',array('user_id'=>$user_id,'amount'=>'0.00'));
	            return $this->MyWallet($user_id);
	        }
		}
	}
	PUBLIC FUNCTION AddBankDetail()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 20;
			if(!empty($this->input->post('bnk_beneficery')) && !empty($this->input->post('bnk_name')) && !empty($this->input->post('branch_address'))  && !empty($this->input->post('bnk_accountno')) && !empty($this->input->post('bnk_ifsc')) && !empty($this->input->post('bnk_branchcode')))
			{
				$data = $this->input->post();

				$prebnks  = $this->common_model->get_data('bank_details',' and user_id='.$user_id.' and type=4');
		        if(count($prebnks)>=3)
			 	{
			 		echo json_encode(array('status' =>201, 'message' =>'Only Three Banks are allowed'));
			 	}else{
			 		//check default payment details exists or not
			 		$defaultBank  = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and is_default=1');
					if(count($defaultBank)==0)
					{
						$isdefault = 1;
					}
					else
					{
						$isdefault = 0;
					}

					$bnkinfoarr = array(
						'user_id' =>$user_id,
						'name_in_bank'=>trim($data['bnk_beneficery']),
						'bank_name'=>trim($data['bnk_name']),
						'branch_address'=>trim($data['branch_address']),
						'account_number'=>trim($data['bnk_accountno']),
						'ifsc_code'=>trim($data['bnk_ifsc']),
						'branch_code'=>trim($data['bnk_branchcode']),
						'type'=>4,
						'is_default'=>$isdefault
					);

					$bankid = $this->common_model->add_data('bank_details',$bnkinfoarr);
					if($bankid>0)
					{
						echo json_encode(array('status' =>200,'message' =>'Data uploaded Successfully'));
					}
					else
					{
						echo json_encode(array('status' =>500,'message' =>'Internal Server Error'));
					}
			 	}
			}
			else{
				echo json_encode(array("status"=>400, "message"=>"Bad Request"));
			}
		}
	}
	PUBLIC FUNCTION AddPaymentDetail()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 20;
			if(!empty($this->input->post('type')) && !empty($this->input->post('account_number')))
			{
				$data = $this->input->post();

				$prebnks  = $this->common_model->get_data('bank_details',' and user_id='.$user_id.' and type='.$data['type']);
		        if(count($prebnks)>=1)
			 	{
			 		echo json_encode(array('status' =>201, 'message' =>'Delete existing one to add new.'));
			 	}else{
			 		//check default payment details exists or not
			 		$defaultBank  = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and is_default=1');
					if(count($defaultBank)==0)
					{
						$isdefault = 1;
					}
					else
					{
						$isdefault = 0;
					}

					$bnkinfoarr = array(
						'user_id' =>$user_id,
						'account_number'=>trim($data['account_number']),
						'type'=>$data['type'],
						'is_default'=>$isdefault
					);

					$bankid = $this->common_model->add_data('bank_details',$bnkinfoarr);
					if($bankid>0)
					{
						echo json_encode(array('status' =>200,'message' =>'Data uploaded Successfully'));
					}
					else
					{
						echo json_encode(array('status' =>500,'message' =>'Internal Server Error'));
					}
			 	}
			}
			else{
				echo json_encode(array("status"=>400, "message"=>"Bad Request"));
			}
		}
	}
	PUBLIC FUNCTION DeleteBank()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if(!empty($this->input->post('bnk_id')))
			{
				$bnk_id = $this->input->post('bnk_id');
				//$user_id = 20;
	        	$primary_check  = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and id= '.$bnk_id);
		        if(!empty($primary_check) && $primary_check[0]['is_default']==0)
				{
					$required = ' and id='.$bnk_id.' and user_id='.$user_id;
				 	$deletebnks  = $this->common_model->delete_data('bank_details',$required);
					if($deletebnks>0)
					{
						echo json_encode(array("status"=>200, "message"=>"Payment Method deleted Successfully"));
					}
					else
					{
						echo json_encode(array('status' =>500,'message' =>'Internal Server Error'));
					}
				}
				else
				{
					echo json_encode(array('status' =>405,'message' =>'To delete this bank. Please Change Default selection.'));
				}
			}else
			{
				echo json_encode(array("status"=>400, "message"=>"Bad Request"));
			}
		}
	}
	PUBLIC FUNCTION SatDefaultMethod()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 20;
        	if(!empty($this->input->post('id')))
        	{
        		$id = $this->input->post('id');
        		$mode = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and id= '.$id);
        		if($mode)
        		{
        			$unset_update =  $this->common_model->update_data('bank_details',array('is_default'=>0),array('user_id'=>$user_id));
        			$primaryset  =  $this->common_model->update_data('bank_details',array('is_default'=>1),array('user_id'=>$user_id,'id'=>$id));
        			if($primaryset>0)
				 	{
				 	  echo json_encode(array('status' => 200,'message' => 'Updated successful'));
				 	}
				 	else
				 	{
				 		echo json_encode(array("status"=>201, "message"=>"Something Went wrong"));
				 	}
        		}else{
        			echo json_encode(array("status"=>400, "message"=>"Bad Request"));
        		}
        	}else
        	{
        		echo json_encode(array("status"=>400, "message"=>"Bad Request"));
        	}
		}
	}
	/*
		Body Parameters
		id:70
		name_in_bank:
		bank_name:
		branch_address:
		account_number:
		ifsc_code:
		branch_code:
	*/
	PUBLIC FUNCTION EditPaymentDetails()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 20;
        	if(!empty($this->input->post('id')))
        	{
        		$data = $this->input->post();
        		$id = $data['id'];
        		$mode = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and id= '.$id);
        		if($mode)
        		{
        			$update =  $this->common_model->update_data('bank_details',$data,array('id'=>$id));
        			if($update>0)
				 	{
				 	  echo json_encode(array('status' => 200,'message' => 'Updated successful'));
				 	}
				 	else
				 	{
				 		echo json_encode(array("status"=>201, "message"=>"Something Went wrong"));
				 	}
        		}
        	}else
        	{
        		echo json_encode(array("status"=>400, "message"=>"Bad Request"));
        	}
		}
	}
	PUBLIC FUNCTION WithdrwalCards ()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			//$user_id = 20;
        	$data['earning'] = $this->user_model->MyWalletBalance($user_id);
        	//unset($data['earning']['amount']);
        	$data['freeLookList_amount'] = $this->user_model->MyFreeLookPeriod($user_id);
        	$data['freeLookList'] = $this->user_model->MyFreeLookPeriod($user_id,1);
        	$data['agp']=$this->user_model->AGPCardAmount($user_id);
        	if(!empty($data['agp']['amt']))
        	{
        		$data['agp']['amt'] = $data['agp'];
        	}else{
        		$data['agp']['amt'] = '0.00';
        	}
        	$data['primary']  = $this->common_model->get_data('bank_details','and user_id='.$user_id.' and is_default= 1');
	        if(!empty($data)){
	            echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
	        }else{
	            echo json_encode(array("status"=>201, "message"=>"No data Found"));
	        }
		}
	}
	PUBLIC FUNCTION WithdrwalHistory()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			$data['list_history'] = $this->user_model->WithdrawalHistory($user_id);

	        if(!empty($data)){
	            echo json_encode(array("status"=>200, "data"=>$data, "message"=>"Success"));
	        }else{
	            echo json_encode(array("status"=>201, "message"=>"No data Found"));
	        }
		}
	}
	/*
		-Type 1 -->Earning Withdrawal
		-Type 2 -->AGP Withdrawal
		-Type 3 -->Free Look Period Withdrawal
		-pay_ref (Payment method id)
		-id -->in case of freelookperiod package purchase id
	*/
	PUBLIC FUNCTION RequestWithdrawal ()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if($this->input->post())
			{
				$txn_no = time();
				$postdata = $this->input->post();
				if(!empty($postdata['type']) && !empty($postdata['pay_ref']))
				{
					if($postdata['type']==1)
			        {
			            $table = 'profit';
			            $type = 1;
			        }
			        elseif($postdata['type']==2)
			        {
			            $table = 'roi';
			            $type = 2;
			        }
			        elseif($postdata['type']==3){
			        	$this->FreelookRequest($user_id,$postdata);
			        }else{
			           echo json_encode(array("status"=>400, "message"=>"Bad Request"));
			           die;
			        }
			        //get KYC Status
			        $kyc = $this->user_model->KycStatus($user_id);
			        if($kyc['kyc'])
			        {
			            if(!empty($postdata['pay_ref']))
			            {
			                $amount = $this->user_model->WithrawAmount($user_id,$table);
			                //print_r($amount);die;
			                $min_req_bal = $this->user_model->Setting_data(1,'amount')['amount'];
			                if($amount['total'] > $min_req_bal)
			                {
			                    $data_insert = array(
			                        'user_id' => $user_id,
			                        'amount' => $amount['total'],
			                        'description'=>'Withdrawal Card Generated',
			                        'type'=>5,
			                        'isactive'=>3,
			                    );
			                    $insert_id = $this->common_model->add_data($table,$data_insert);
			                    if($insert_id){
			                        $data = array('isactive' => 3,'requested_id' => $insert_id);
			                        //update all pending earing to requested in profit table
			                        $this->common_model->update_data($table,$data,array('user_id' =>$user_id,'isactive'=>1));
			                        //update earnig wallet to zero..
			                        $this->common_model->update_data('my_wallet',array('e_wallet' => 0),array('user_id' =>$user_id));
			                        //get payment mode data
			                        $payment = $this->common_model->get_data("bank_details"," AND id='".$postdata['pay_ref']."'","name_in_bank,bank_name,branch_address,account_number,ifsc_code,branch_code,type","1");
			                        //Update status against each record of profit
			                        $data = array('user_id' => $user_id, 'ref_id'=>$insert_id,'invoice_number'=>$txn_no,'type'=>$type,'amount'=>$amount['total'],'description'=>'withdraw Requested','name_in_bank'=>$payment['name_in_bank'],'bank_name'=>$payment['bank_name'],'branch_address'=>$payment['branch_address'],'account_number'=>$payment['account_number'],'ifsc_code'=>$payment['ifsc_code'],'branch_code'=>$payment['branch_code'],'mode'=>$payment['type']);
			                        //add data to widthdrawal table
			                        $insert_id = $this->common_model->add_data('withdrawals',$data);
			                        if($insert_id){
			                        	echo json_encode(array("status"=>200, "message"=>"Requested Successfully",'Requested_id'=>$insert_id,'txn_no'=>$txn_no,'date'=>date('Y-m-d'),'mode'=>$payment['type']));
			                        	die;
			                        }else{
			                            echo json_encode(array("status"=>500, "message"=>"Internal Server Error"));
		           						die;
			                        }
			                    }else{
			                        echo json_encode(array("status"=>201, "message"=>"Please add default payment method"));
		           					die;
			                    }
			                }
			                else{
			                    echo json_encode(array("status"=>400, "message"=>"Min balance required condition not successful"));
			       				die;

			                }
			            }
			            else
		              	{
		                	echo json_encode(array("status"=>201, "message"=>"Please add default payment method"));
		           			die;
		              	}
			        }
			        else
			        {
			            echo json_encode(array("status"=>701, "message"=>"Kyc not Verified"));
			           	die;
			        }
				}else{
					echo json_encode(array("status"=>400, "message"=>"Bad Request"));
			        die;
				}
				
			}
		}
	}

	PUBLIC FUNCTION FreelookRequest($user_id,$data)
	{
		$kyc = $this->user_model->KycStatus($user_id);
		if($kyc['kyc'] == 1)
		{
			$txn_no = time();
        	if(!empty($data['id']))
	        {
	            if(!empty($data['pay_ref']))
	            {
	                $id = $data['id'];
	                $user = $this->common_model->get_data("packages_purchase"," AND id='".$id."' AND user_id=".$user_id,"*","1");
	                if($user['id'] == $id)
	                {
	                    
	                    //get payment mode data
	                    $payment = $this->common_model->get_data("bank_details"," AND id='".$data['pay_ref']."'","name_in_bank,bank_name,branch_address,account_number,ifsc_code,branch_code,type","1");

	                    $this->common_model->update_data('packages_purchase',array('isactive'=>0,'modified_date'=>date('Y-m-d h:i:s')),array('id' => $id));
	                    
	                    //data to withdraw
	                    $data = array('user_id' => $user_id, 'ref_id'=>$id,'type'=>3,'invoice_number'=>$txn_no,'amount'=>$user['price'],'description'=>'Free Look withdraw Requested','name_in_bank'=>$payment['name_in_bank'],'bank_name'=>$payment['bank_name'],'branch_address'=>$payment['branch_address'],'account_number'=>$payment['account_number'],'ifsc_code'=>$payment['ifsc_code'],'branch_code'=>$payment['branch_code'],'mode'=>$payment['type']);
	                    //add data to widthdrawal table
	                    $insert_id = $this->common_model->add_data('withdrawals',$data);
	                    
	                    echo json_encode(array("status"=>200, "message"=>"Requested Successfully",'Requested_id'=>$insert_id,'txn_no'=>$txn_no,'date'=>date('Y-m-d'),'mode'=>$payment['type']));
				        die;
	                }else{
	                    echo json_encode(array("status"=>500, "message"=>"Internal Server Error"));
			           	die;
	                }
	            }
	            else
	            {
	                echo json_encode(array("status"=>201, "message"=>"Please add default payment method"));
			        die;
	            }
	        }
	        else{
	            echo json_encode(array("status"=>201, "message"=>"Something Went wrong"));
			    die;
	        }
	    }
	    else
      	{
	        echo json_encode(array("status"=>201, "message"=>"Your Kyc not yet Verified!"));
			die;
      	}
	}
	/*
		-Support ticket listing
		-type : 1 for resolved, 2- Active tickets     
	*/
	PUBLIC FUNCTION TicketListing()
	{
		$type = "";
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if($this->input->post('type'))
			{
				$type = $this->input->post('type');
				if($type == 2){
					$type = "resolved";
				}elseif($type == 1){
					$type = "active";
				}
			}
			$tickets = $this->user_model->MyTickets($user_id,"","","","",$type);
			if($tickets){
				echo json_encode(array("status"=>200, "tickets"=>$tickets));
			}
			else{
				echo json_encode(array("status"=>404,'msg'=>'no data found'));
			}
		}else{
			echo json_encode(array("status"=>400,"message"=>"Bad Request"));
            die;
		}
	}
	PUBLIC FUNCTION TicketConversation()
	{
		$type = "";
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if($this->input->post('id'))
			{
				$id = $this->input->post('id');
				$data['ticket'] = $this->user_model->MyTicketsDetail ($id,$user_id);
        		$data['conversation'] = $this->user_model->MyTicketsConv ($id,$user_id);
        		if($data){
					echo json_encode(array("status"=>200, "conversation"=>$data));
				}
				else{
					echo json_encode(array("status"=>404,'msg'=>'Not found'));
				}
			}
		}else{
			echo json_encode(array("status"=>400,"message"=>"Bad Request"));
            die;
		}
	}
	PUBLIC FUNCTION FAQ()
	{
		$dept = 'x';
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			if($this->input->post('dept') && !empty($this->input->post('dept')))
			{
				$dept = $this->input->post('dept');
			}
			$data = $this->common_model->faq($dept);
			if($data){
				echo json_encode(array("status"=>200, "faq"=>$data));
			}
			else{
				echo json_encode(array("status"=>201,'msg'=>'false'));
			}
		}else{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
	PUBLIC FUNCTION departments()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			$data = $this->common_model->get_data('department',' AND isactive =1','id,title');
			if($data){
				echo json_encode(array("status"=>200, "departments"=>$data));
			}
			else{
				echo json_encode(array("status"=>201,'msg'=>'false'));
			}
		}else{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
	PUBLIC FUNCTION GenerateTicket()
	{
		$this->headtoken();

		$ticket_no = time();
		$imgnid = '';
  	    $items = array();
  	    $i = 0;
  	    $directory 	   		= 'uploads/tickets/';
  	    $thumb_directory	= 'uploads/tickets/';
		$thumb_h       		= 70;
		$thumb_w        	= 70;
  	    $valid_extensions 	=  array("jpeg","jpg","png");

		//$user_id = $this->GetAuthTokenValid();
		if(!empty($this->input->post('token-id')))
		{
			$user_id = $this->common_model->get_data('members',' AND tokenid="'.base64_decode($this->input->post('token-id')).'"','id','1')['id'];
			if($user_id && $user_id !=1){
				$user_id = $user_id;
			}else{
				echo json_encode(array("status"=>703,"message"=>"Token Expired"));
            	die;
			}
		}else{
			echo json_encode(array("status"=>400,"message"=>"Bad Request"));
            die;
		}
		if(!empty($user_id))
		{
			$ref_id = $this->common_model->get_data('members',' AND id='.$user_id,'ref_id','1')['ref_id'];
			$tickets = $this->user_model->MyTickets($user_id,"","","","",'active');
			if($tickets)
			{
				echo json_encode(array("status"=>304,"message"=>"You cannot Generate a new ticket till the previous one is open"));
				die;
			}else{
				if($this->input->post())
				{
					$data = $this->input->post();
					unset($data['token-id']);
					if($data['department'] && $data['subject'] && $data['body']){
						if(!empty($_FILES["image_id"]["name"]))
			            {
			      	  	  	if(count($_FILES["image_id"]["name"])<=5)
			      	  	   	{
				      	  	  foreach($_FILES["image_id"]["tmp_name"] as $key=>$tmp_name)
			            	  {
				                $file_name=$_FILES["image_id"]["name"][$key];
				                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
				                if($ext=='png' || $ext=='jpg' || $ext=='jpeg')
				                {
				                	$thumbnail = TRUE;
				                }
				                else
				                {
				                	$thumbnail = FALSE;
				                }

				                $filearr  = array('tmp_name' => $_FILES["image_id"]["tmp_name"][$key], 'name' => $_FILES["image_id"]["name"][$key]);
				      	  	  	$nid_upload = save_file($filearr,$directory,$thumb_directory,$valid_extensions,'ST'.$i.'',$ref_id,$thumbnail,$thumb_w,$thumb_h);
				      	  	  	if($nid_upload['respose']==2)
					           	{
					          	  $nidInfo = array('image'=>$nid_upload['filename'],'img_thumb'=>$nid_upload['thumb_name']!=''?$nid_upload['thumb_name']:'','extension'=>$nid_upload['extension'],'path'=>$directory);
								  $imgnid  = $this->user_model->insert_data('media',$nidInfo);
								  $items[] = $imgnid;
					           	}
					           	$i++;
					         	}
					        	$imgnid = implode(',', $items);
				           	}
					        else
					        {
					           	echo json_encode(array("status"=>416,"message"=>"Max 5 files allowed."));
	            				die;
					        }
			  	        }
			  	        else
			  	        {
			  	            $imgnid ="0";
			  	        }

			  	        $data['image_id'] = $imgnid;
				        $data['user_id']=$data['created_by']=$user_id;
				        $data['ticket_no'] = $ticket_no;
						$insertTicket =  $this->user_model->insert_data('tickets',$data);

						if($insertTicket>0)
						{
					      	echo json_encode(array("status"=>200,"message"=>"Ticket Generated successfully", "ticket_no"=>$ticket_no));
            				die;
						}
						else
						{
						    echo json_encode(array("status"=>500,"message"=>"Internal Server Error"));
            				die;
						}
					}else{
						echo json_encode(array("status"=>400,"message"=>"Insufficent Data"));
            			die;
					}
				}else{
					echo json_encode(array("status"=>400,"message"=>"Bad Request"));
            		die;
				}
			}
		}else{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
	PUBLIC FUNCTION TicketReply()
	{
		$this->headtoken();

		$ticket_no = time();

		$imgnid = '';
  	    $items = array();
  	    $i = 0;
  	    $directory 	   		= 'uploads/tickets/';
  	    $thumb_directory	= 'uploads/tickets/';
		$thumb_h       		= 70;
		$thumb_w        	= 70;
  	    $valid_extensions 	=  array("jpeg","jpg","png");

		//$user_id = $this->GetAuthTokenValid();
		if(!empty($this->input->post('token-id')))
		{
			$user = $this->common_model->get_data('members',' AND tokenid="'.base64_decode($this->input->post('token-id')).'"','id,ref_id','1');
			if($user && $user['id'] !=1){
				$user_id = $user['id'];
				$u_refid = $user['ref_id'];
			}else{
				echo json_encode(array("status"=>703,"message"=>"Token Expired"));
            	die;
			}
		}else{
			echo json_encode(array("status"=>400,"message"=>"Bad Request"));
            die;
		}
		if(!empty($user_id))
		{
			if($this->input->post())
			{
				$data = $this->input->post();
				unset($data['token-id']);
				if(!empty($data['department']) && !empty($data['ref_id']) && !empty($data['body'])){
					//check that ticket exists or not
					$ticket = $this->common_model->get_data('tickets',' AND id='.$data['ref_id'].' AND user_id='.$user_id,'id','1');
					if($ticket)
					{
						if(!empty($_FILES["image_id"]["name"]))
			            {
			      	  	  	if(count($_FILES["image_id"]["name"])<=5)
			      	  	   	{
				      	  	  foreach($_FILES["image_id"]["tmp_name"] as $key=>$tmp_name)
			            	  {
				                $file_name=$_FILES["image_id"]["name"][$key];
				                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
				                if($ext=='png' || $ext=='jpg' || $ext=='jpeg')
				                {
				                	$thumbnail = TRUE;
				                }
				                else
				                {
				                	$thumbnail = FALSE;
				                }

				                $filearr  = array('tmp_name' => $_FILES["image_id"]["tmp_name"][$key], 'name' => $_FILES["image_id"]["name"][$key]);
				      	  	  	$nid_upload = save_file($filearr,$directory,$thumb_directory,$valid_extensions,'ST'.$i.'',$u_refid,$thumbnail,$thumb_w,$thumb_h);
				      	  	  	if($nid_upload['respose']==2)
					           	{
					          	  $nidInfo = array('image'=>$nid_upload['filename'],'img_thumb'=>$nid_upload['thumb_name']!=''?$nid_upload['thumb_name']:'','extension'=>$nid_upload['extension'],'path'=>$directory);
								  $imgnid  = $this->user_model->insert_data('media',$nidInfo);
								  $items[] = $imgnid;
					           	}
					           	$i++;
					         	}
					        	$imgnid = implode(',', $items);
				           	}
					        else
					        {
					           	echo json_encode(array("status"=>416,"message"=>"Max 5 files allowed."));
	            				die;
					        }
			  	        }
			  	        else
			  	        {
			  	            $imgnid ="0";
			  	        }

			  	        $data['image_id'] = $imgnid;
				  		$data['user_id'] = $data['created_by'] =$user_id;
				  		$data['image_id']=$imgnid;
				  		$data['ticket_no'] = $ticket_no;

				  		$this->common_model->update_data('tickets',array('status'=>0),array('id' => $data['ref_id']));
						$insertTicket =  $this->user_model->insert_data('tickets',$data);
print_r($insertTicket);
die();
						if($insertTicket>0)
						{
					      	echo json_encode(array("status"=>200,"message"=>"Reply sent successfully", "ticket_no"=>$ticket_no));
	        				die;
						}
						else
						{
						    echo json_encode(array("status"=>500,"message"=>"Internal Server Error"));
	        				die;
						}
					}else{
						echo json_encode(array("status"=>400,"message"=>"Bad Request"));
        				die;
					}
				}else{
					echo json_encode(array("status"=>400,"message"=>"Insufficent Data"));
        			die;
				}
			}else{
				echo json_encode(array("status"=>400,"message"=>"Bad Request"));
        		die;
			}
			//}
		}else{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
	PUBLIC FUNCTION kyc_uploading()
	{
		$this->headtoken();
		
		$error 		   		= '';
		$success 	   		= '';
		$directory 	   		= 'uploads/kyc-docs/';
		$thumb_directory	= 'uploads/kyc-docs/';
		$thumb_h       		= 160;
		$thumb_w        	= 250;
		$valid_extensions 	=  array("jpeg","jpg","png");
		$i 	   		   = 0;

		//$userid = $this->GetAuthTokenValid();
		if(!empty($this->input->post('token-id')))
		{
			$user = $this->common_model->get_data('members',' AND tokenid="'.base64_decode($this->input->post('token-id')).'"','id,ref_id','1');
			if($user && $user['id'] !=1){
				$userid = $user['id'];
				//$u_refid = $user['ref_id'];
			}else{
				echo json_encode(array("status"=>703,"message"=>"Token Expired"));
            	die;
			}
		}else{
			echo json_encode(array("status"=>400,"message"=>"Bad Request"));
            die;
		}
		if(!empty($userid))
		{
			
      	$required     = 'id,address_id,address_id_status,national_id,national_id_status';
      	$user_kyc     = $this->user_model->get_kyc('kyc',$required,$userid);
      	if(count($user_kyc)>0)
      	  {
      	  	if(!empty($_FILES["national_id"]["name"]) && !empty($_FILES["address_proof"]["name"]))
            {
      	  		$nid_upload = save_file($_FILES["national_id"],$directory,$thumb_directory,$valid_extensions,'NID',$this->session->userdata('u_refid'),TRUE,$thumb_w,$thumb_h);
      	  		$ap_upload = save_file($_FILES["address_proof"],$directory,$thumb_directory,$valid_extensions,'AP',$this->session->userdata('u_refid'),TRUE,$thumb_w,$thumb_h);
      	  		if($nid_upload['respose']==2 && $ap_upload['respose']==2)
	          	{
	          	  $nidInfo = array('image'=>$nid_upload['filename'],'img_thumb'=>$nid_upload['thumb_name'],'extension'=>$nid_upload['extension'],'path'=>$directory);
				  $imgnid  = $this->user_model->insert_data('media',$nidInfo);
	          	  $apInfo  = array('image'=>$ap_upload['filename'],'img_thumb'=>$ap_upload['thumb_name'],'extension'=>$ap_upload['extension'],'path'=>$directory);
				  $imgapid = $this->user_model->insert_data('media',$apInfo);

				  $kycuparr = array('address_id'=>$imgapid,'national_id'=>$imgnid,'address_id_status'=>1,'national_id_status'=>1);
				  $kycupdate =  $this->user_model->updateInfor('kyc',$kycuparr,'user_id',$userid);
				  if($kycupdate>0)
				  {
				  	$this->session->unset_userdata('kyc');
				  	$this->session->set_userdata('kyc','You KYC status is pending for verification');

				  	echo json_encode(array('status'=>200,'message'=>'KYC detail upload successfully and under Verfication.'));//successfully
				  }
				  else
				  {
				  	echo json_encode(array('status' =>500,'message' =>'There is some issue to update KYC details.'));
				  }
	          	}
	          	elseif($nid_upload['respose']==2 && $ap_upload['respose']!=2)
	          	{
	          	  $nidInfo = array('image'=>$nid_upload['filename'],'img_thumb'=>$nid_upload['thumb_name'],'extension'=>$nid_upload['extension'],'path'=>$directory);
				  $imgnid  = $this->user_model->insert_data('media',$nidInfo);
				  $kycuparr = array('national_id'=>$imgnid,'national_id_status'=>1);
				  $kycupdate =  $this->user_model->updateInfor('kyc',$kycuparr,'user_id',$userid);
				  if($kycupdate>0)
				  {
				  	echo json_encode(array('status'=>200,'message'=>'Only National ID upload successfully.'));
				  }
				  else
				  {
				  	echo json_encode(array('status'=>500,'message'=>'There is some issue to save KYC details'));
				  }
	          	}
	          	elseif($nid_upload['respose']!=2 && $ap_upload['respose']==2)
	          	{
	          	  $apInfo  = array('image'=>$ap_upload['filename'],'img_thumb'=>$ap_upload['thumb_name'],'extension'=>$ap_upload['extension'],'path'=>$directory);
				  $imgapid = $this->user_model->insert_data('media',$apInfo);
				  $kycuparr = array('address_id'=>$imgapid,'address_id_status'=>1);
				  $kycupdate =  $this->user_model->updateInfor('kyc',$kycuparr,'user_id',$userid);
				  if($kycupdate>0)
				  {
				  	echo json_encode(array('status'=>200,'message'=>'Only Address Proof upload successfully.'));
				  }
				  else
				  {
				  	echo json_encode(array('status'=>201,'message'=>'There is some issue to upload KYC details'));
				  }
	          	}
	          	else
	          	{
	          		echo json_encode(array('status' =>201,'message' =>'There is some issue to upload KYC details.'));
	          	}
      	  	}
      	  	elseif (!empty($_FILES["national_id"]["name"]) && empty($_FILES["address_proof"]["name"]))
      	  	{
      	  		$nid_upload = save_file($_FILES["national_id"],$directory,$thumb_directory,$valid_extensions,'NID',$this->session->userdata('u_refid'),TRUE,$thumb_w,$thumb_h);
      	  		if($nid_upload['respose']==2)
	          	{
	      	  		$nidInfo = array('image'=>$nid_upload['filename'],'img_thumb'=>$nid_upload['thumb_name'],'extension'=>$nid_upload['extension'],'path'=>$directory);
					$imgnid  = $this->user_model->insert_data('media',$nidInfo);

					$kycuparr = array('national_id'=>$imgnid,'national_id_status'=>1);
					$kycupdate =  $this->user_model->updateInfor('kyc',$kycuparr,'user_id',$userid);
					if($kycupdate>0)
					{
						echo json_encode(array('status'=>200,'message'=>'National ID upload successfully and under Verfication.'));
					}
					else
					{
						echo json_encode(array('status' =>201,'message' =>'There is some issue to upload National Id.'));
					}
				}
				else
				{
					echo json_encode(array('status' =>201,'message' =>'There is some issue to upload National ID.'));
				}
      	  	}
      	  	elseif (empty($_FILES["national_id"]["name"]) && !empty($_FILES["address_proof"]["name"]))
      	  	{
      	  		$ap_upload = save_file($_FILES["address_proof"],$directory,$thumb_directory,$valid_extensions,'AP',$this->session->userdata('u_refid'),TRUE,$thumb_w,$thumb_h);
      	  		if($ap_upload['respose']==2)
	          	{
	      	  		$apInfo = array('image'=>$ap_upload['filename'],'img_thumb'=>$ap_upload['thumb_name'],'extension'=>$ap_upload['extension'],'path'=>$directory);
					$imgapid  = $this->user_model->insert_data('media',$apInfo);

					$kycuparr = array('address_id'=>$imgapid,'address_id_status'=>1);
					$kycupdate =  $this->user_model->updateInfor('kyc',$kycuparr,'user_id',$userid);
					if($kycupdate>0)
					{
						echo json_encode(array('status'=>200,'message'=>'Address Proof upload successfully and under Verfication.'));
					}
					else
					{
						echo json_encode(array('status' =>201,'message' =>'There is some issue to upload Address Proof.'));
					}
				}
				else
				{
					echo json_encode(array('status' =>500,'message' =>'There is some issue to upload Address Proof.'));
				}
      	  	}
      	  	else
      	  	{
      	  		echo json_encode(array('status' =>201,'message' =>'Please Upload KYC details'));
      	  	}

      	  }
      	else
      	  {
      	  	if(!empty($_FILES["national_id"]["name"]) && !empty($_FILES["address_proof"]["name"]))
            {
            	$save_NID = save_file($_FILES["national_id"],$directory,$thumb_directory,$valid_extensions,'NID',$this->session->userdata('u_refid'),TRUE,$thumb_w,$thumb_h);
            	$save_AP = save_file($_FILES["address_proof"],$directory,$thumb_directory,$valid_extensions,'AP',$this->session->userdata('u_refid'),TRUE,$thumb_w,$thumb_h);
              if($save_NID['respose']==2 && $save_AP['respose']==2)
                {
              	  $nidarr = array('image'=>$save_NID['filename'],'img_thumb'=>$save_NID['thumb_name'],'extension'=>$save_NID['extension'],'path'=>$directory);
				  $imgnid = $this->user_model->insert_data('media',$nidarr);

				  $apidarr = array('image'=>$save_AP['filename'],'img_thumb'=>$save_AP['thumb_name'],'extension'=>$save_AP['extension'],'path'=>$directory);
				  $imgap   = $this->user_model->insert_data('media',$apidarr);
				  if($imgnid>0 && $imgap>0)
				  {
				  	
				  	$kycarr = array('user_id'=>$userid,'address_id'=>$imgap,'national_id'=>$imgnid,'address_id_status'=>1,'national_id_status'=>1);
				  	$kycid = $this->user_model->insert_data('kyc',$kycarr);
				  	if($kycid>0)
				  	  {
				  	  	echo json_encode(array('status'=>200,'message'=>'KYC detail upload successfully and under Verfication.'));
				  	  }
				  	else
				  	  {
				  	  	echo json_encode(array('status' =>201,'message' =>'There is some issue in upload KYC details.'));
				  	  }
				  }
				  else
				  {
				  	echo json_encode(array('status' =>201,'message' =>'Any of document not uploaded successfully'));
				  }
        	    }
        	   elseif($save_NID['respose']==0 || $save_AP['respose']==0)
        	    {
        	  		echo json_encode(array('status' =>201,'message' =>'Any of document has wrong extension.Only allow (jpg,png,jpeg)'));
        	    }
        	   elseif($save_NID['respose']==1 || $save_AP['respose']==1)
        	    {
        	  		echo json_encode(array('status' =>201,'message' =>'Any of document not uploaded successfully'));
        	     }
        	    else
        	    {
        	  		echo json_encode(array('status' =>201,'message' =>'Something went wrong. Please try after sometime.'));
        	    }
            }
            else
            {
            	echo json_encode(array('status' =>201,'message' =>'National Id and Address Proof is required.'));
            	die;
            }
      	  }
      
		}else{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}

  PUBLIC FUNCTION notifications()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			$data = $this->user_model->get_alertdata($user_id,'','','','',1);
			if(count($data)>0)
			{
				unset($data['user_id']);
				unset($data['upimage']);
				unset($data['path']);
	        	$unread = count($this->user_model->get_alertdata($user_id,'','','',1));
	        	echo json_encode(array("status"=>200,"data"=>$data,"unread"=>$unread));
	        }
	        else
	        {
	        	echo json_encode(array("status"=>404, "message"=>"Not Found"));	
	        }
		}
		else
		{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
  PUBLIC FUNCTION showNotification()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
			$notification_id = $_POST['id'];
			$newview = '';  		
  			$alert_details = $this->common_model->get_data('notification nf','and nf.id='.$notification_id.'','nf.subject,nf.id,nf.notification_message,nf.view_user_id,nf.create_date,me.image','1','left join media as me on nf.image = me.id');
  			$alertview = $alert_details['view_user_id'];
  			if(!empty($alertview) && $alertview!='')
  			{
  				if (strpos($alertview, $user_id) === false)
  				{
				    $newview = $alertview.','.$user_id;
				  	$this->common_model->update_data('notification',array('view_user_id'=>$newview),array('id' => $notification_id));
				}
  			}
  			else
  			{
  				$newview = $user_id;
  				$this->common_model->update_data('notification',array('view_user_id'=>$newview),array('id' => $notification_id));
  			}
  			echo json_encode(array("status"=>200,"data"=>$alert_details));
		}
		else
		{
			echo json_encode(array("status"=>404,"message"=>"Not Found"));
            die;
		}
	}
	PUBLIC FUNCTION ShareReferral()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
        	$ref_id = $this->common_model->get_data('members',' AND id='.$user_id,'ref_id','1')['ref_id'];
			if($ref_id){
				echo json_encode(array("status"=>200, "ref_id"=>$ref_id, "message"=>"Success"));
			}else{
				echo json_encode(array("status"=>404, "message"=>"Not Found"));	
			}
		}
	}
	PUBLIC FUNCTION closeTicket()
	{
		$user_id = $this->GetAuthTokenValid();
		if(!empty($user_id))
		{
        	if($this->input->post('ticket_id') && !empty($this->input->post('ticket_id')))
        	{
        		$ticket_id = $this->input->post('ticket_id');
        		$ticket_detail = $this->common_model->get_data('tickets',' AND status !=2 AND user_id='.$user_id.' AND id='.$ticket_id,'id',1);
        		if($ticket_detail){
        			$update = array('isactive'=>0,'status'=>2,'closing_at'=>date('Y-m-d H:i:s'));
        			//update ticket details..4
        			$closeticket = $this->common_model->update_data('tickets',$update,array('id' => $ticket_id));
        			if($closeticket>0)
				 	{
				 		echo json_encode(array("status"=>200, "message"=>"Success"));
				 		die;
				 	}
				 	else
				 	{
				 		echo json_encode(array("status"=>500,"message"=>"Internal Server Error"));
				 		die;
				 	}
        		}else{
        			echo json_encode(array("status"=>400,"message"=>"Bad Request"));
        			die;
        		}
        	}else{
        		echo json_encode(array("status"=>400,"message"=>"Bad Request"));
        		die;
        	}
		}
	}
	PUBLIC FUNCTION ForgetPass()
	{
		if($this->headtoken() == true)
		{
			$fotp='';
        	if($this->input->post('u_email') && !empty($this->input->post('u_email')))
        	{
        		$email = $this->input->post('u_email');
        		$user = $this->common_model->get_data("members"," AND email='".$email."'","id,username,email","1");
        		if($user>0){
        			$passToken  =  random_string('numeric',12);
				 	$rparr  	  =  array('password_token'=>$passToken,'password_status'=>1,'last_resetPass_at'=>date('Y-m-d H:i:s'));
				 	$dpupdate   =  $this->user_model->updateInfor('members',$rparr,'id',$user['id']);

        			if($dpupdate>0)
				 	{
						if($this->input->post('fotp') && !empty($this->input->post('fotp')))
        	{
				$passToken  =  random_string('numeric',4);
				 	$rparr  	  =  array('password_token'=>$passToken,'password_status'=>1,'last_resetPass_at'=>date('Y-m-d H:i:s'));
				 	$dpupdate   =  $this->user_model->updateInfor('members',$rparr,'id',$user['id']);
						$subject1 = 'OTP For forgot password request.';
						 $body1    = 'Your OTP for forget Password:' . $passToken;
                       // $body    = $this->load->view('email_templates/forgot_password.php', $data, true);
                        $mail    = $this->mailsend($user['email'], $user['username'], $subject1, $body1);
			}
			else
			{
				 		$subject='Reset Password Link';
				 		$data['link'] = base_url().'reset-password/'.$passToken;
						$body = $this->load->view('templates/forgot.php',$data,TRUE);
						$mail = $this->mailsend($user['email'],$user['username'],$subject,$body,"no-reply".host,"Methertech");
			}
						if($mail==1)
						{
							echo json_encode(array('status' =>200,'message' =>'Mail Sent, Please check your account'));
							die;
						}
						else
						{
						 	echo json_encode(array('status' =>704,'message' =>'Mail not sent'));
					   	    die;
						}
				 		echo json_encode(array("status"=>200, "message"=>"Success"));
				 		die;
				 	}
				 	else
				 	{
				 		echo json_encode(array("status"=>500,"message"=>"Internal Server Error"));
				 		die;
				 	}
        		}else{
        			echo json_encode(array("status"=>304,"message"=>"Email Id not registered, Please enter registered Email id"));
        			die;
        		}
        	}else{
        		echo json_encode(array("status"=>400,"message"=>"Bad Request"));
        		die;
        	}
		}else{
			echo json_encode(array("status"=>402,"message"=>"Unauthorised"));
		}
	}
	PUBLIC FUNCTION UpdateProfilePic()
	{
		if(!empty($this->input->post('token-id')))
		{
			$user = $this->common_model->get_data('members',' AND isactive=1 AND tokenid="'.base64_decode($this->input->post('token-id')).'"','id,ref_id','1');
			if($user && $user['id'] !=1){
				$userid = $user['id'];
				$u_refid = $user['ref_id'];
			}else{
				echo json_encode(array("status"=>703,"message"=>"Token Expired"));
            	die;
			}
		}else{
			echo json_encode(array("status"=>400,"message"=>"Bad Request"));
            die;
		}
		if($this->headtoken() == true)
		{
        	if(!empty($_FILES["profile_pic"]["name"]))
        	{
        		$directory 	   		= 'uploads/profile-pic/';
				$thumb_directory	= 'uploads/profile-pic/';
				$thumb_h       		= 250;
				$thumb_w        	= 250;
				$valid_extensions 	=  array("jpeg","jpg","png");
				//$userid 	   		= $user_id;

				//$u_refid = $this->common_model->get_data('members',' AND id='.$userid,'ref_id','1')['ref_id'];
				
				$user_dp = save_file($_FILES["profile_pic"],$directory,$thumb_directory,$valid_extensions,'DP',$u_refid,TRUE,$thumb_w,$thumb_h);
				if($user_dp['respose']==2)
				{
				  	$dpInfo = array('image'=>$user_dp['filename'],'img_thumb'=>$user_dp['thumb_name'],'extension'=>$user_dp['extension'],'path'=>$directory);
					$imgid  = $this->user_model->insert_data('media',$dpInfo);
					if($imgid>0)
					{
						$dparr  = array('profile_pic'=>$imgid);
						$dpupdate =  $this->user_model->updateInfor('members',$dparr,'id',$userid);
						if($dpupdate>0)
						{
							echo json_encode(array('status' =>200,'message' =>'Prfile Pic Updated Successfully'));
							die;
						}
						else
						{
							echo json_encode(array('status' =>500,'message' =>'Internal Server Error'));
							die;
						}
					}
					else
					{
					  	echo json_encode(array('status' =>500,'message' =>'Internal Server Error'));
						die;
					}
			  
				}else
				{
					echo json_encode(array('status' =>500,'message' =>'Internal Server Error'));
					die;
				}
        	}else{
        		echo json_encode(array("status"=>400,"message"=>"Bad Request"));
        		die;
        	}
		}
	}
} // Close Class