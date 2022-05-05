<?php
error_reporting(E_ALL);
error_reporting(0);
ini_set('display_errors', 0);
set_time_limit(3000);
defined('BASEPATH') or exit('No direct script access allowed');
class Frontend extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
       
        $this->load->model(array('user_model', 'common_model', 'admin_modal'));
        $this->load->helper(array('url', 'date', 'form', 'string', 'comman_helper'));
        $this->load->library(array('email', 'javascript', 'session', 'upload', 'My_PHPMailer', 'encryption', 'user_agent'));
        date_default_timezone_set('Asia/Kolkata');
    }
    
    public function page_element($files = '', $data = '')
    {
        $header = $content = $footer = "";
        $content_file = !empty($files['content_file']) ? $files['content_file'] : 'user/error.php';
        $header_file = !empty($files['header_file']) ? $files['header_file'] : 'header.php';
        $footer_file = !empty($files['footer_file']) ? $files['footer_file'] : 'footer.php';
        if (!empty($data['content_data'])) {
            $content = $data['content_data'];
        }
        if (!empty($data['header_data'])) {
            $header = $data['header_data'];
        }
        if (!empty($data['footer_data'])) {
            $footer = $data["footer_data"];
        }
        $this->load->view($header_file, $header);
        $this->load->view($content_file, $content);
        $this->load->view($footer_file, $footer);
    }
    //index page
    public function index()
    {
        $data = [];
       
        $this->load->view('index', $data);
    }
	
    public function map()
    {
        }
    //Start Registration Process Setion
    //Registration Page Step 1
   
    //Registration Page Step 2
    public function details()
    {
        if (isset($this->session->userdata['step'])) {
            if ($this->session->userdata['step'] == 2) {
                $this->load->view('details');
            } else {
                redirect(base_url('signup'));
            }
        } else {
            redirect(base_url('signup'));
        }
    }
    
    
    
    
    
    public function reg_searchusername() 
    {
        $ref_id = trim((isset($_POST['ref_id']) ? $_POST['ref_id'] : ''));
        //$ref_id = 'DSG983508';
            $result1 = $this->user_model->reg_user_data($ref_id);
            echo json_encode($result1);
            die();
    }
    
    //check function for duplicates(email, username)
    public function checkduplicate()
    {
        try {
            $isAvailable = '';
            if (isset($_POST["u_email"]) && !empty($_POST["u_email"])) {
                $email = $_POST['u_email'];
                $required = 'id';
            } else {
                $email = '';
            }
            if (isset($_POST["u_username"]) && !empty($_POST["u_username"])) {
                $username = $_POST['u_username'];
                $required = 'id';
            } else {
                $username = '';
            }
            if (isset($_POST["user_refferal"]) && !empty($_POST["user_refferal"])) {
                $refferal = $_POST['user_refferal'];
                $required = 'id';
            } else {
                $refferal = '';
            }
            if (isset($_POST["umobile"]) && !empty($_POST["umobile"])) {
                $phone = $_POST['umobile'];
                $required = 'members.id as userid';
            } else {
                $phone = '';
            }
            #$duplicateEmail = $this->user_model->checkDuplicate_dels('members', $required, $email, $username, '', '', '', $refferal, $phone);
        #    $duplicateEmail = $this->user_model->checkDuplicate_dels('members', $required, $email, '', '', '', '', $refferal, $phone);
            
            
            //  checl if also user is paid or not 
            $duplicateEmail = $this->user_model->checkDuplicate_dels_paid('members', $required, $email, '', '', '', '', $refferal, $phone);
            
            if ($email != '' || $username != '' || $phone != '') {
                if (count($duplicateEmail) > 0) {
                    $isAvailable = false;
                } else {
                    $isAvailable = true;
                }
            } else {
                if (count($duplicateEmail) > 0) {
                    $isAvailable = true;
                } else {
                    $isAvailable = false;
                }
            }
            echo json_encode(array('valid' => $isAvailable));
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    //ends
    
    
    
    public function test_mail()
    {
        $sms  = $this->mailsend('nctest@namecheap.com','vikash','test','asass', "no-reply@asss.io", "aaaa");
        echo $sms; 
    }
    
    public function mailsend($to = "", $name = "", $subject = "", $body = "", $from = "", $fromname = "")
    {
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
   
    
    #########################################
    #
    #
    #
    #########################################
    #For INR
    // public function generateUniqueUsername()
    // {
    //     $userName = 'AR' . rand(100000, 999999);
    //     $userNameCheck = $this->db->select('id')->from('members')->where('username', $userName)->get()->result_array();
    //     if (count($userNameCheck) > 0) {
    //         $res = $this->generateUniqueUsername();
    //     } else {
    //         $res = $userName;
    //     }
    //     return $res;
    // }
    
    #For Crypto Currency
     public function generateUniqueUsername($num_bytes = 18)
    {
        $userName = bin2hex(openssl_random_pseudo_bytes($num_bytes));
        $userNameCheck = $this->db->select('id')->from('members')->where('username', $userName)->get()->result_array();
        if (count($userNameCheck) > 0) {
            $res = $this->generateUniqueUsername($num_bytes = 18);
        } else {
            $res = $userName;
        }
        return $res;
    }
    
    // public function mynewusername($num_bytes = 18){
    //      echo bin2hex(openssl_random_pseudo_bytes($num_bytes));
    // }
	
	
	
	
	
	
	
	
	
	
	 //Start Admin login function
    public function admin_alogin()
    {
        $this->load->view('admin_new/admin-login');
       
    }
	
	public function admin_loginfn()
    {
        try {
            $username = $_POST['u_username'];
            $password = $_POST['u_password'];
            $result['user_info'] = $this->admin_modal->check_id($username, $password);
            if (count($result['user_info']) > 0) {
                $this->session->set_userdata('admin_logged_in', true);
                $this->session->set_userdata('name', $result['user_info']['display_name']);
                $this->session->set_userdata('role', $result['user_info']['role']);
                $this->session->set_userdata('username', $result['user_info']['username']);
                $this->session->set_userdata('id', $result['user_info']['id']);
		        $this->session->set_userdata('adminpk_id',$result['user_info']['id']);
                $this->session->set_userdata('mobile', $result['user_info']['mobile']);
                $this->session->set_userdata('email', $result['user_info']['email']);
                $url = base_url('admin/dashboard');
                echo json_encode(array('status' => 1, 'url' => $url));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Please Check Username or Password'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    //End Admin login function
	
	
	
}
