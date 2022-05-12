<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once dirname(__FILE__) . "/Common.php";
class Admin extends Common
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('notificationmodel');
        $this->load->model('common_model');
        $this->load->model('user_model');
        $this->load->model('admin_modal');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->helper('comman_helper');
        $this->load->library('javascript');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->library("pagination");
        $this->load->library("excel");
        // $this->load->library("IOFactory");
        $this->load->helper('string');

        date_default_timezone_set('Asia/Kolkata');

        if ($this->session->userdata('admin_logged_in') != true) {
            redirect(base_url('frontend/admin_alogin'));
        }
        #vikash
        // $data['assignPrivileges'] = $this->common_model->get_data('assign_privileges as ap','and user_id = '.$this->session->userdata('adminpk_id').'','ap.*,pm.name as pname','full','LEFT JOIN privileges_menu as pm on ap.privileges_menu = pm.id');

        // $main = array();
        // foreach($data['assignPrivileges'] as $key => $value)
        // {
        // $main[$value['pname']]['privileges_menu'] = $value['privileges_menu'];
        // $main[$value['pname']]['permission_id'][] = $value['permission_id'];
        // }

        //$data['main'] = $main;
        //$this->global = $main;
        $this->sessionuserrole  =  $this->session->userdata('role');
        $this->sessionuserid    =  $this->session->userdata('adminpk_id');
        // $phase_detail =   $this->common_model->get_data('coin_phases', 'AND status = 1 order by id desc ', '*', '1');
        // $this->phase_id = $phase_detail['phase_id'] ? $phase_detail['phase_id'] : 0 ; 

        $this->load->view('admin_new/header.php');
    }

    public function index()
    {
        $this->dashboard();
    }

    public function dashboard()
    {
        //$this->load->view('admin_new/header.php');
        //$data['tot_users'] = count($this->admin_modal->ManageUserListing());
        $data['tot_users'] = count($this->common_model->get_data('users', ''));
        $data['today_users'] = count($this->common_model->get_data('users', ' AND DATE(created_date) = "' . date("Y-m-d") . '"'));

        // $data['total_fund_transfer'] = $this->common_model->get_data('accounts', 'and txn_type =1 and profit_type=7 and created_by = 0', 'sum(amount) as total_fund_transfer', '1');
        // $data['today_fund_transfer'] = $this->common_model->get_data('accounts', 'and txn_type =1 and profit_type=7 and created_by =0 AND DATE(created_date) = "'.date("Y-m-d").'"', 'sum(amount) as today_fund_transfer', '1');


        #$data['tot_buy'] = $this->common_model->get_data('accounts', ' AND isactive=2 AND type=1 AND txn_type=2', 'sum(amount) as total_purchase', '1');
        //    $data['tot_buy'] = $this->common_model->get_data('packages_purchase', ' AND (status=0 OR status=1 OR  status=2)', 'sum(price) as total_purchase', '1');

        #$data['today_buy'] = $this->common_model->get_data('accounts', ' AND isactive=2 AND type=1 AND txn_type=2 AND DATE(created_date) = CURDATE()', 'sum(amount) as total_purchase', '1');
        // $data['today_buy'] = $this->common_model->get_data('packages_purchase', ' AND (status=0 OR status=1) AND DATE(created_date) = "'.date("Y-m-d").'"', 'sum(price) as total_purchase', '1');

        // $data['wallet_earnings'] = $this->user_model->get_profit_count(0, 1);
        // $data['money_order'] = $this->user_model->get_profit_count(0, 2);
        // $data['paytm'] = $this->user_model->get_profit_count(0, 3);
        // $data['upi'] = $this->user_model->get_profit_count(0, 4);
        // $data['bank'] = $this->user_model->get_profit_count(0, 5);
        // $data['recent_updates'] = $this->admin_modal->recent_updates();
        // $data['cashbackEarning'] = $this->user_model->pchartdata('', 1, date("Y"), 'month');
        // $data['referralEarning'] = $this->user_model->pchartdata('', 21, date("Y"), 'month');
        // $data['levelOri'] =   $this->user_model->pchartdata('', 2, date("Y"), 'month');
        // $data['binaryIncome'] =   $this->user_model->pchartdata('', 32, date("Y"), 'month');
        // $data['levelBinary'] =   $this->user_model->pchartdata('', 19, date("Y"), 'month');

        //echo '<pre>';print_r($data['recent_updates']);die;
        $this->load->view('admin_new/dashboard', $data);
        $this->load->view('admin_new/footer.php');
    }
    public function user()
    {
        $data['users'] = $this->admin_modal->ManageUserListing();
        //echo '<pre>';print_r($user_data);die;
        //$this->load->view('admin_new/header.php');

        $this->load->view('admin_new/ManageUser', $data);
        $this->load->view('admin_new/footer.php');
    }

    public function ManageUser($rowno = 0)
    {
        //Start Search Section
        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['condition'] = (isset($_GET['condition'])) ? $_GET['condition'] : '';
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        $role = $this->session->userdata('role');
        $id = $this->session->userdata('adminpk_id');
        // //End Search Section

        $config["base_url"] = base_url("admin/ManageUser");
        $rowperpage = $this->config->item('per_page');
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = count($this->admin_modal->get_all_users());
        $config['use_page_numbers'] = true;
        $config['enable_query_strings'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = false;
        if ($search['search_by'] != '' || $search['condition'] != '' || $search['query'] != '') {
            $config['suffix'] = '?' . http_build_query($search, '', "&amp;");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($search, '', "&amp;");
        }
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>' . "\n";
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>' . "\n";
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>' . "\n";
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>' . "\n";
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        $data['row'] = $rowno;
        #echo "<pre>"; print_r($data); die();
        $data['users'] = $this->admin_modal->get_all_users();
        // echo "<pre>"; print_r($data['users']); die();
        if (array_key_exists("Manage Users", $this->global) || ($role == "admin" && $id == 1)) {

            if (isset($this->global["Manage Users"])) {
                $data["permission"] = $this->global["Manage Users"];
            }
            $data['sessionuserid'] = $this->sessionuserid;
            $data['sessionuserrole'] = $this->sessionuserrole;
            $this->load->view('admin_new/users.php', $data);
            $this->load->view('admin_new/footer.php');
        } else {
            redirect(base_url('admin/dashboard'));
        }
    }
    // Added by Rahul
    public function fuel_report()
    {
        $roi_alldataa = array();
        $config = array();
        $roi_alldataa = $this->admin_modal->fuel_management(null);
        // $config['base_url'] = base_url() . 'admin/fuel_report';
        // $config['total_rows'] = $this->common_model->countAll();
        // $config['per_page'] = 20;
        // $config['uri_segment']  = 3;
        // $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        // $config['full_tag_close'] = '</ul>';
        // $config['attributes'] = array('class' => 'page_link');
        // $config['full_tag_open'] = '<ul class="pagination">';
        // $config['full_tag_close'] = '</ul><!--pagination-->';
        // $config['first_link'] = '&laquo; First';
        // $config['first_tag_open'] = '<li class="prev page">';
        // $config['first_tag_close'] = '</li>' . "\n";
        // $config['last_link'] = 'Last &raquo;';
        // $config['last_tag_open'] = '<li class="next page">';
        // $config['last_tag_close'] = '</li>' . "\n";
        // $config['next_link'] = 'Next &rarr;';
        // $config['next_tag_open'] = '<li class="next page">';
        // $config['next_tag_close'] = '</li>' . "\n";
        // $config['prev_link'] = '&larr; Previous';
        // $config['prev_tag_open'] = '<li class="prev page">';
        // $config['prev_tag_close'] = '</li>' . "\n";
        // $config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0);">';
        // $config['cur_tag_close'] = '</a></li>';
        // $config['num_tag_open'] = '<li class="page">';
        // $config['num_tag_close'] = '</li>' . "\n";
        
        // $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        // $data["results"] = $this->common_model->get_fuel_data($config['per_page'], $page);

        // $this->pagination->initialize($config);
        // $data["pagination"] = $this->pagination->create_links();


        $search = array();
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $search['query'] = $_GET['query'];
        }
        
        if (isset($_GET['startdate']) && !empty($_GET['startdate'])) {
            $startdate = DateTime::createFromFormat("d/m/Y", $_GET['startdate']);
            $startdate = $startdate->format('Y-m-d');
            $search['startdate'] = $startdate;
        }

        if (isset($_GET['search_by']) && !empty($_GET['search_by'])) {
            $search['search_by'] = $_GET['search_by'];
        }

        if (isset($_GET['enddate']) && !empty($_GET['enddate'])) {
            $enddate = DateTime::createFromFormat("d/m/Y", $_GET['enddate']);
            $enddate = $enddate->format('Y-m-d');
            $search['enddate'] = $enddate;
        }
        if(count($search)>0){
            
            $roi_details = $this->admin_modal->fuel_management($search);
            $data['results'] = $roi_details;
        } 
        else {
            $data["results"] = $roi_alldataa;
        }
        // print_r($this->db->last_query()); die();
    $this->load->view('admin_new/fuel_report.php', $data);
    $this->load->view('admin_new/footer.php');
}

    // 	Added By Krishan //
    // Edited by Rahul // 

    public function ManageLeadsByAgents()
    {
        $roi_alldataa = array();
        $roi_alldataa = $this->admin_modal->ManageUserListing(null);
        $search = array();
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $search['query'] = $_GET['query'];
        }
        
        if (isset($_GET['startdate']) && !empty($_GET['startdate'])) {
            $startdate = DateTime::createFromFormat("d/m/Y", $_GET['startdate']);
            $startdate = $startdate->format('Y-m-d');
            $search['startdate'] = $startdate;
        }

        if (isset($_GET['search_by']) && !empty($_GET['search_by'])) {
            $search['search_by'] = $_GET['search_by'];
        }

        if (isset($_GET['enddate']) && !empty($_GET['enddate'])) {
            $enddate = DateTime::createFromFormat("d/m/Y", $_GET['enddate']);
            $enddate = $enddate->format('Y-m-d');
            $search['enddate'] = $enddate;
        }
        if(count($search)>0){
            
            $roi_details = $this->admin_modal->ManageUserListing($search);
            $data['users'] = $roi_details;
        } 
        else {
            $data["users"] = $roi_alldataa;
        }
        $this->load->view('admin_new/leadsusers.php', $data);
        $this->load->view('admin_new/footer.php');
    }

    // 	Added By Krishan //
    public function generate_emp_id() //need to be called from inception controller
    {
        $userName = rand(1000000, 9999999) . chr(rand(65, 90));;
        $userNameCheck = $this->db->select('id')->from('users')->where('emp_id', $first_name)->get()->result_array();
        if (count($userNameCheck) > 0) {
            $res = $this->generate_emp_id();
        } else {
            $res = $userName;
        }
        //select * from users where 
        return $res;
    }


    function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    public function add_newagent()
    {
        // $lead_data = array(
        //     'username' => trim($_POST['username']),
        //     'email' => trim($_POST['email'])

        // );

        //         $u_info = $this->user_model->get_data('users', ' AND email= "' . $email.'"', '*', 'full');
        // 		if (count($u_info1) > 0) {
        // 			echo json_encode(array("status" => 201, "message" => "This account Email is already Registered."));die;
        //         }else{
        //               $usrinfo = array(
        //                     'username' => trim($_POST['username']),
        //                     'email' => trim($_POST['email']),
        //                     'complete_date' => date('Y-m-d H:i:s'),
        //                     'created_date' => date('Y-m-d H:i:s')
        //                 );
        //                 $user_update = $this->user_model->insert_data('users', $usrinfo);

        //                 if ($user_update > 0) { 
        //                     echo json_encode(array('status' => 1, 'message' => 'Agent Added Successfully. Details send to User Mail'));
        //                 } else {
        //                     echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
        //                 }
        //         }



        $first_name = trim($_REQUEST['username']);

        $email = trim($_REQUEST['email']);
        $password = $this->randomPassword();
        $firebasetoken = "";
        $device_id = "";
        $phone = "";
        $mode = 0;
        $u_info = $this->user_model->get_data('users', ' AND  email= "' . $email . '"', '*', 'full');
        if (count($u_info) > 0) {
            echo json_encode(array("status" => 0, "message" => "This Email is already exist."));
            die;
        } else {

            $emp_id = $this->generate_emp_id();

            $dataarr = array(
                'email' => $email,
                'emp_id' => $emp_id,
                'password' => md5($password),
                'password_text' => $password,
                'phone' => $phone,
                'first_name' => $first_name,
                'last_name' => "",
                'mode' => $mode,
                'isactive' => 1,
                'device_id' => $device_id,
                'firebasetoken' => $firebasetoken,
                'created_date' => date('Y-m-d H:i:s')
            );

            $userid = $this->user_model->insert_data('users', $dataarr);

            if ($userid > 0) {

                $infoarr = array(
                    'user_id' => $userid,
                    'first_name' => $first_name,
                    'last_name' => "",
                    'status' => 1,
                    'created_date' => date('Y-m-d H:i:s')
                );
                $useinfo = $this->user_model->insert_data('user_information', $infoarr);
                if ($useinfo) {

                    $data['name'] = $first_name;
                    $data['email'] = $email;
                    $data['password'] = $password;

                    $subject = 'Agent Register Diesel Fuel Stop';
                    $body = $this->load->view('templates/registerbyadmin.php', $data, true);
                    $mail = $this->mailsend($email, $first_name, $subject, $body, "no-reply" . host, "dieselfuelstop.com");

                    echo json_encode(array("status" => 1, "message" => "Agent Added successfully"));
                    die;

                    //$response = ['status' => 200, 'message' => ''];

                } else {
                    echo json_encode(array("status" => 0, "message" => "Please Try Later."));
                    die;
                }
            } else {
                echo json_encode(array("status" => 0, "message" => "Please Try Later."));
                die;
            }
        }
    }

    public function ManageLeads($rowno = 0)
    {
        $role = $this->session->userdata('role');
        $id = $this->session->userdata('adminpk_id');
        if (array_key_exists("Manage Wallet", $this->global) || ($role == "admin" && $id == 1)) {
            if (isset($this->global["Manage Wallet"])) {
                $data["permission"] = $this->global["Manage Wallet"];
            }
            $data['sessionuserid'] = $this->sessionuserid;
            $data['sessionuserrole'] = $this->sessionuserrole;
            // $this->load->view('admin_new/add-investment', $data);
            // $this->load->view('admin_new/footer');
        } else {
            $this->session->set_flashdata('error', 'You Dont have Permission to open this.');
            redirect(base_url('admin/dashboard'));
        }

        $data['total_leads'] = $this->common_model->get_data('leads', '', 'count(*) as total_leads', '1');
        $data['today_leads'] = $this->common_model->get_data('leads', ' AND DATE(created_date) = "' . date("Y-m-d") . '"', 'count(*) as today_leads', '1');

        $startdate = '';
        $enddate = '';
        if (isset($_GET['startdate']) && !empty($_GET['startdate'])) {
            $startdate = DateTime::createFromFormat("d/m/Y", $_GET['startdate']);
            $startdate = $startdate->format('Y-m-d');
        }
        if (isset($_GET['enddate']) && !empty($_GET['startdate'])) {
            $enddate = DateTime::createFromFormat("d/m/Y", $_GET['enddate']);
            $enddate = $enddate->format('Y-m-d');
        }

        //Start Search Section
        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['condition'] = (isset($_GET['condition'])) ? $_GET['condition'] : '';
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        $search['startdate'] = $startdate;
        $search['enddate'] = $enddate;
        //End Search Section


        //echo "<pre>"; print_r($search); die(); 

        $config["base_url"] = base_url("admin/manageLeads");
        $rowperpage = $this->config->item('per_page');

        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = $this->admin_modal->Allleads(1, '', '', $search);
        $config['use_page_numbers'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = false;

        $config['enable_query_strings'] = true;
        if ($search['search_by'] != '' || $search['condition'] != '' || $search['query'] != '' || $search['startdate'] != '' || $search['enddate'] != '') {
            $config['suffix'] = '?' . http_build_query($search, '', "&amp;");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($search, '', "&amp;");
        }

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page"> ';
        $config['first_tag_close'] = '</li>' . "\n";
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>' . "\n";
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>' . "\n";
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>' . "\n";
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        $data['row'] = $rowno;
        #echo "<pre>"; print_r($data); die();
        $data['history'] = $this->admin_modal->Allleads('', $rowno, $rowperpage, $search);
        $this->load->view('admin_new/ManageLeads.php', $data);
        $this->load->view('admin_new/footer.php');
    }


    public function mannual_share()
    {
        // echo "hlww"; die();
        $roi_alldataa = array();
        //  $roi_details = $this->common_model->get_data("mannual_share_per", " ","*", "full");

        $share = $this->common_model->get_data('mannual_share_per as msp', 'AND msp.status=1', 'msp.*,u.first_name as first_name,u.emp_id ', 'full', 'LEFT JOIN users as u on msp.user_id = u.id');

        //echo $this->db->last_query(); die();
        $data['roi_detailss'] = $share;
        //echo "<pre>"; print_r($data); die();

        $this->load->view('admin_new/reward_share_per.php', $data);
        $this->load->view('admin_new/footer.php');
    }


    public function mannualshare_perdata()
    {
        // echo "<pre>"; print_r($_POST); die();
        $share_percentage = $_POST['mannual_per'];
        $user_id = $_POST['user_id'];
        //   echo "<pre>"; print_r($roi_percentage); die();
        $myarraydata = array(
            'user_id' => $user_id,
            'share_percentage' => $share_percentage,
            'status' => "1",
            'created_date' => date('Y-m-d H:i:s')
        );

        $updatedata = array(
            'status' => "0",
        );

        //  echo "<pre>"; print_r($myarraydata); die();
        $insertedid = $this->common_model->add_data('mannual_share_per', $myarraydata);
        //echo "<pre>"; print_r($insertedid); die();
        if (!empty($insertedid)) {

            // $this->common_model->update_data('mannual_share_per', $updatedata, 'id !=' . $insertedid);
            $this->common_model->update_data('mannual_share_per', $updatedata, array('id!= ' => $insertedid, 'user_id' => $user_id));
            //echo $this->db->last_query(); die();  
            //echo "yess"; die();
            $this->session->set_flashdata('success', 'Entered successfully .'); //die();
            redirect(base_url('mannual_share'));
        } else {
            // echo "no"; die();
            $this->session->set_flashdata('error', 'Please try again.');
            redirect(base_url('mannual_share'));
        }
    }




    public function upload_record_sheet()
    {
        $search = array();
        $roi_alldataa = array();
        $roi_alldataa = $this->common_model->get_data("diesel_fuel_records", "AND isactive=1", "*", "full");
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $search['query'] = $_GET['query'];
        }
        
        if (isset($_GET['startdate']) && !empty($_GET['startdate'])) {
            $startdate = DateTime::createFromFormat("d/m/Y", $_GET['startdate']);
            $startdate = $startdate->format('Y-m-d');
            $search['startdate'] = $startdate;
        }

        if (isset($_GET['search_by']) && !empty($_GET['search_by'])) {
            $search['search_by'] = $_GET['search_by'];
        }

        if (isset($_GET['enddate']) && !empty($_GET['enddate'])) {
            $enddate = DateTime::createFromFormat("d/m/Y", $_GET['enddate']);
            $enddate = $enddate->format('Y-m-d');
            $search['enddate'] = $enddate;
        }
        if(count($search)>0){            
            $roi_details = $this->admin_modal->get_fuel_lead_data($search);
            // print_r($this->db->last_query());die;
            $data['roi_detailss'] = $roi_details;
        } 
        else {
            $data["roi_detailss"] = $roi_alldataa;
        }
        

        // echo $this->db->last_query(); die(); 
        // $data["roi_detailss"] = $roi_alldataa;
        $this->load->view('admin_new/fuel_records_list.php', $data);
        $this->load->view('admin_new/footer.php');
    }


    public function insert_record_sheet()
    {
        // echo "<pre>"; print_r($_POST); die();
        // $share_percentage = $_POST['mannual_per'];

        // //   echo "<pre>"; print_r($roi_percentage); die();
        //   $myarraydata = array(
        //          'share_percentage' => $share_percentage,
        //          'status' => "1",
        //          'created_date' => date('Y-m-d H:i:s')
        //       );
        //      //  echo "<pre>"; print_r($myarraydata); die();
        //       $insertedid = $this->common_model->add_data('diesel_fuel_records', $myarraydata);
        //      //echo "<pre>"; print_r($insertedid); die();
        //       if(!empty($insertedid)){
        //           //echo "yess"; die();
        //           $this->session->set_flashdata('success', 'Entered successfully .'); //die();
        //             redirect(base_url('recordsheet_upload'));
        //       }else{
        //          // echo "no"; die();
        //           $this->session->set_flashdata('error', 'Please try again.');
        //             redirect(base_url('recordsheet_upload')); 
        //       }

        //echo "<pre>"; print_r($_FILES); die();
        $roi_details = $this->common_model->get_data("mannual_share_per", "AND status=1 order by id desc", "*", "1");

        //echo "<pre>"; print_r($roi_details['share_percentage']); die();
        $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
        if (in_array($_FILES['file']['type'], $mimes)) {
            if (isset($_FILES["file"]["name"])) {
                echo "<pre>";
                print_r($_FILES); //die();
                $path = $_FILES["file"]["tmp_name"];

                if ($_FILES['file']['size'] > 0) {

                    //get the csv file 
                    $file = $_FILES['file']['tmp_name'];
                    // $handle = fopen($file,"r");
                    $rec = 0;

                    if (($handle = fopen($file, "r")) !== FALSE) {


                        // if (($data = fgetcsv($handle, 1000, ',')) !== FALSE)
                        //     {
                        //         echo '<tr><th>'.implode('</th><th>', $data).'</th></tr>';
                        //     }

                        fgetcsv($handle);
                        $i = 0;
                        $j = 0;
                        $fuel = array();
                        $fuel_share = array();
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $user_id = 0;
                            // echo "<pre>"; print_r($data); die();

                            $num = count($data);
                            for ($c = 0; $c < $num; $c++) {
                                $col[$c] = $data[$c];
                            }


                            $checkdata = $this->common_model->get_data('diesel_fuel_records', "and carrier_name='" . $col[0] . "' and company='" . $col[1] . "' and billing_card='" . $col[2] . "' and acct='" . $col[3] . "' and pfj_ascend='" . $col[4] . "' and acct_type='" . $col[5] . "' and fuel_gallons='" . $col[6] . "'", '*', 'full');
                            if (count($checkdata) > 0) {

                                //Carrier NameCompanyBilling CardAcct#PFJ Ascend #Acct TypeGallons



                                $total_share = ($col[6] * $roi_details['share_percentage']) / 100;



                                $user_id = $this->common_model->get_data("users", " AND emp_id='" . $col[3] . "'", "id", "1")['id'];


                                $fuel[$i]['carrier_name'] = $col[0];
                                $fuel[$i]['company'] = $col[1];
                                $fuel[$i]['billing_card'] = $col[2];
                                $fuel[$i]['acct'] = $col[3];
                                $fuel[$i]['pfj_ascend'] = $col[4];
                                $fuel[$i]['acct_type'] = $col[5];
                                $fuel[$i]['fuel_gallons'] = $col[6];
                                $fuel[$i]['share_per'] = $roi_details['share_percentage'];
                                $fuel[$i]['total_share'] =  $total_share;
                                $fuel[$i]['isactive'] = 1;
                                $fuel[$i]['created_date'] = date('Y-m-d H:i:s');
                                $i++;
                                // SQL Query to insert data into DataBase


                                if ($user_id > 0) {
                                    $fuel_share[$j]['user_id'] = $user_id;
                                    $fuel_share[$j]['profit_type'] = 1;
                                    $fuel_share[$j]['reward_point'] = $total_share;
                                    $fuel_share[$j]['isactive'] = 1;
                                    $fuel_share[$j]['created_date'] = date('Y-m-d H:i:s');
                                }
                                $j++;

                                $rec++;
                            }
                        }


                        // echo "<pre>"; print_r($fuel); die();
                        // echo "<pre>"; print_r($fuel_share); die();
                        if (count($fuel) > 0 && count($fuel_share) > 0) {



                            $roiCount = $this->common_model->insertBatch('diesel_fuel_records', $fuel);
                            if (count($fuel_share) > 0) {
                                $roiCountreward = $this->common_model->insertBatch('rewards', $fuel_share);
                            }

                            fclose($handle);

                            if ($roiCount) {
                                $this->session->set_flashdata('success', 'Sheet Upload Successfully'); //die();
                                redirect(base_url('recordsheet_upload'));
                            } else {
                                $this->session->set_flashdata('error', 'Please try again.');
                                redirect(base_url('recordsheet_upload'));
                            }
                        } else {
                            $this->session->set_flashdata('success', 'Make sure CSV File is correct ?'); //die();
                            redirect(base_url('recordsheet_upload'));
                        }
                    }
                    die();
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Please Upload Only CSV file.');
            redirect(base_url('recordsheet_upload'));
        }
    }
    /*******Add by Rahul*******/
    public function import_lead_from_sheet()
    {

        // $roi_details = $this->common_model->get_data("mannual_share_per", "AND status=1 order by id desc","*", "1");
        $shareper = 0;
        //echo "<pre>"; print_r($roi_details['share_percentage']); die();
        // $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
        // if(in_array($_FILES['file']['type'],$mimes)){

        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            // print_r($worksheet->getTitle());die;
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn(3, 2);
            $i = 0;$j = 0;
            for ($row = 2; $row <= $highestRow; $row++) {

                $emp_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $lead_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $company_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $dot_number = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $mobile = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $email = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $numberOfTrucks = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $street = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $city = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                $state = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                $zip_code = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                $potential_gallons = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                $description_field = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                $month = $worksheet->getTitle();
                $checkdata = $this->common_model->get_data('leads', 'and contact_name="' . $lead_name . '" and company_name="' . $company_name . '" and phone_no="' . $mobile . '" and email="' . $email . '" and city="' . $city . '" and street="' . $street . '" and state="' . $state . '"and zip_code="' . $zip_code . '"and potential_gallons="' . $potential_gallons . '"and description_field="' . $description_field . '"and DOT_number="' . $dot_number . '"and no_of_trucks="' . $numberOfTrucks . '"', '*', 'full');
                // print_r($month);die;
                $month_num = null;
                    switch ($month) {
                        case 'January':
                            $month_num = 1;
                            break;
                        case 'February':
                            $month_num = 2;
                            break;
                        case 'March':
                            $month_num = 3;
                            break;
                        case 'April':
                            $month_num = 4;
                            break;
                        case 'May':
                            $month_num = 5;
                            break;
                        case 'June':
                            $month_num = 6;
                            break;
                        case 'July':
                            $month_num = 7;
                            break;
                        case 'August':
                            $month_num = 8;
                            break;
                        case 'September':
                            $month_num = 9;
                            break;
                        case 'October':
                            $month_num = 10;
                            break;
                        case 'November':
                            $month_num = 11;
                            break;
                        case 'December':
                            $month_num = 12;
                            break;
                    }
                if (count($checkdata) > 0) {
                } else {

                    $user_id = $this->common_model->get_user_id($emp_id);
                    // print_r($potential_gallons);die;
                    if ($potential_gallons > 0) {
                        $roi_details = $this->common_model->get_data("mannual_share_per", "AND status=1 AND user_id = (select id from users where emp_id = '".$emp_id."') order by id desc", "*", "1");
                        // print_r($this->db->last_query());die;
                        $shareper = $roi_details['share_percentage'];

                        $total_share = ($potential_gallons * $shareper) / 100;
                    } else {
                        $total_share = 0;
                    }
                    

                    $lead[$i]['user_id'] = $user_id['id'];
                    $lead[$i]['contact_name'] = $lead_name;
                    $lead[$i]['company_name'] = $company_name;
                    $lead[$i]['DOT_number'] = $dot_number;
                    $lead[$i]['phone_no'] = $mobile;
                    $lead[$i]['email'] = $email;
                    $lead[$i]['no_of_trucks'] = $numberOfTrucks;
                    $lead[$i]['street'] = $street;
                    $lead[$i]['city'] = $city;
                    $lead[$i]['state'] = $state;
                    $lead[$i]['zip_code'] = $zip_code;
                    $lead[$i]['potential_gallons'] = $potential_gallons;
                    $lead[$i]['description_field'] =  $description_field;
                    $lead[$i]['isactive'] = 1;
                    $lead[$i]['month'] = $month;
                    $lead[$i]['year'] = $_POST['year'];
                    $lead[$i]['month_num'] = $month_num;
                    $lead[$i]['created_date'] = date('Y-m-d H:i:s');
                    $i++;
                    
                    if ($user_id > 0) {
                        $fuel_share[$j]['user_id'] = $user_id['id'];
                        $fuel_share[$j]['profit_type'] = 1;
                        $fuel_share[$j]['reward_point'] = $total_share;
                        $fuel_share[$j]['isactive'] = 1;
                        $fuel_share[$j]['created_date'] = date('Y-m-d H:i:s');
                    }
                    $j++;

                    // $rec++;
                }
            }
        }
        
        //  echo "<pre>"; print_r($lead); die();
        //  echo "<pre>"; print_r($fuel_share); die();
        if (count($lead) > 0) {
            $roiCount = $this->common_model->insertBatch('leads', $lead);
            if (count($fuel_share) > 0) {
                $roiCountreward = $this->common_model->insertBatch('rewards', $fuel_share);
            }
            // print_r(base_url('recordsheet_upload'));die;
            if ($roiCount) {
                $this->session->set_flashdata('success', 'Sheet Upload Successfully'); //die();
                redirect(base_url('admin/ManageLeadsByAgents'));
            } else {
                $this->session->set_flashdata('error', 'Please try again.');
                redirect(base_url('recordsheet_upload'));
            }
        } else {
            $this->session->set_flashdata('success', 'Make sure CSV File is correct ?'); //die();
            redirect(base_url('recordsheet_upload'));
        }

        // } else {
        //   $this->session->set_flashdata('error', 'Please Upload Only CSV file.');
        //   redirect(base_url('recordsheet_upload'));
        // } 

    }
    public function importlead_sheet()
    {
        $shareper = 0;
        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn(3, 2);
            $i = 0;
            for ($row = 2; $row <= $highestRow; $row++) {

                $photo = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $agent_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $emp_id = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                $checkdata = $this->common_model->get_data('users');
                if (count($checkdata) > 0) {
                } else {
                    $lead[$i]['photo'] = $photo;
                    $lead[$i]['agent_name'] = $agent_name;
                    $lead[$i]['emp_id'] = $emp_id;
                    $i++;
                }
            }
        }
        if (count($lead) > 0) {
            $roiCount = $this->common_model->insertBatch('diesel_fuel_records', $lead);

            if ($roiCount) {
                $this->session->set_flashdata('success', 'Sheet Upload Successfully'); //die();
                redirect(base_url('recordsheet_upload'));
            } else {
                $this->session->set_flashdata('error', 'Please try again.');
                redirect(base_url('recordsheet_upload'));
            }
        } else {
            $this->session->set_flashdata('success', 'Make sure CSV File is correct ?'); //die();
            redirect(base_url('recordsheet_upload'));
        }
    }

    public function importfuelrecord_sheet()
    {

        // $roi_details = $this->common_model->get_data("mannual_share_per", "AND status=1 order by id desc","*", "1");
        $shareper = 0;
        //echo "<pre>"; print_r($roi_details['share_percentage']); die();
        // $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
        // if(in_array($_FILES['file']['type'],$mimes)){

        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            // print_r($worksheet->getTitle());die;
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn(3, 2);
            // $i=0;$j=0;
            for ($row = 2; $row <= $highestRow; $row++) {

                $carrier_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $company = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $billing_card = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $acct = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $pfj_ascend = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $acct_type = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $fuel_gallons = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $month = $worksheet->getTitle();
                $year = $_POST['year'];
                // print_r($month);die;
                $checkdata = $this->common_model->get_data('diesel_fuel_records', 'and carrier_name="' . $carrier_name . '" and company="' . $company . '" and billing_card="' . $billing_card . '" and acct="' . $acct . '" and pfj_ascend="' . $pfj_ascend . '" and acct_type="' . $acct_type . '" and fuel_gallons="' . $fuel_gallons . '"', '*', 'full');
                $month_num = null;
                    switch ($month) {
                        case 'January':
                            $month_num = 1;
                            break;
                        case 'February':
                            $month_num = 2;
                            break;
                        case 'March':
                            $month_num = 3;
                            break;
                        case 'April':
                            $month_num = 4;
                            break;
                        case 'May':
                            $month_num = 5;
                            break;
                        case 'June':
                            $month_num = 6;
                            break;
                        case 'July':
                            $month_num = 7;
                            break;
                        case 'August':
                            $month_num = 8;
                            break;
                        case 'September':
                            $month_num = 9;
                            break;
                        case 'October':
                            $month_num = 10;
                            break;
                        case 'November':
                            $month_num = 11;
                            break;
                        case 'December':
                            $month_num = 12;
                            break;
                    }
                if (count($checkdata) > 0) {
                } else {

                    $user_id = $this->common_model->get_data("users", " AND emp_id='" . $acct . "'", "id", "1")['id'];
                    if ($fuel_gallons > 0) {
                        $roi_details = $this->common_model->get_data("mannual_share_per", "AND status=1 AND user_id = '144569' order by id desc", "*", "1");
                        $shareper = $roi_details['share_percentage'];

                        $total_share = ($fuel_gallons * $shareper) / 100;
                    } else {
                        $total_share = 0;
                    }


                    $fuel[$i]['carrier_name'] = $carrier_name;
                    $fuel[$i]['company'] = $company;
                    $fuel[$i]['billing_card'] = $billing_card;
                    $fuel[$i]['acct'] = $acct;
                    $fuel[$i]['pfj_ascend'] = $pfj_ascend;
                    $fuel[$i]['acct_type'] = $acct_type;
                    $fuel[$i]['fuel_gallons'] = $fuel_gallons;
                    $fuel[$i]['share_per'] = $shareper;
                    $fuel[$i]['total_share'] =  $total_share;
                    $fuel[$i]['isactive'] = 1;
                    $fuel[$i]['month'] = $month;
                    $fuel[$i]['year'] = $year;
                    $fuel[$i]['month_num'] = $month_num;
                    $fuel[$i]['created_date'] = date('Y-m-d H:i:s');
                    $i++;



                    // if ($user_id > 0) {
                    //     $fuel_share[$j]['user_id'] = $user_id;
                    //     $fuel_share[$j]['profit_type'] = 1;
                    //     $fuel_share[$j]['reward_point'] = $total_share;
                    //     $fuel_share[$j]['isactive'] = 1;
                    //     $fuel_share[$j]['created_date'] = date('Y-m-d H:i:s');
                    // }
                    // $j++;

                    // $rec++;
                }
            }
        }

        //  echo "<pre>"; print_r($fuel); die();
        //  echo "<pre>"; print_r($fuel_share); die();
        if (count($fuel) > 0) {
            $roiCount = $this->common_model->insertBatch('diesel_fuel_records', $fuel);
            // if (count($fuel_share) > 0) {
            //     $roiCountreward = $this->common_model->insertBatch('rewards', $fuel_share);
            // }

            if ($roiCount) {
                $this->session->set_flashdata('success', 'Sheet Upload Successfully'); //die();
                redirect(base_url('recordsheet_upload'));
            } else {
                $this->session->set_flashdata('error', 'Please try again.');
                redirect(base_url('recordsheet_upload'));
            }
        } else {
            $this->session->set_flashdata('success', 'Make sure CSV File is correct ?'); //die();
            redirect(base_url('recordsheet_upload'));
        }

        // } else {
        //   $this->session->set_flashdata('error', 'Please Upload Only CSV file.');
        //   redirect(base_url('recordsheet_upload'));
        // } 

    }




    public function ManageUserold($rowno = 0)
    {
        //Start Search Section
        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['condition'] = (isset($_GET['condition'])) ? $_GET['condition'] : '';
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        //End Search Section

        $config["base_url"] = base_url("admin/ManageUser");
        $rowperpage = $this->config->item('per_page');
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = count($this->admin_modal->ManageUserListing());
        $config['use_page_numbers'] = true;
        $config['enable_query_strings'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = false;
        if ($search['search_by'] != '' || $search['condition'] != '' || $search['query'] != '') {
            $config['suffix'] = '?' . http_build_query($search, '', "&amp;");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($search, '', "&amp;");
        }
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>' . "\n";
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>' . "\n";
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>' . "\n";
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>' . "\n";
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        $data['row'] = $rowno;
        $data['users'] = $this->admin_modal->ManageUserListing();
        #echo $this->db->last_query();die;
        $this->load->view('admin_new/users.php', $data);
        $this->load->view('admin_new/footer.php');
    }



    public function user_excel($rowno = 0)
    {
        if ($_GET['search_by'] != '' || $_GET['search_by'] != 0) {
            $search['search_by'] = $_GET['search_by'];
        } else {
            $search['search_by'] = '';
        }

        if ($_GET['condition'] != '' || $_GET['condition'] != 0) {
            $search['condition'] = $_GET['condition'];
        } else {
            $search['condition'] = '';
        }

        if ($_GET['query'] != '' || $_GET['query'] != 0) {
            $search['query'] = $_GET['query'];
        } else {
            $search['query'] = '';
        }
        //print_r($search);die;
        $randnum = random_string('numeric', 4);
        $config["base_url"] = base_url("admin/ManageUser");

        $user_list = $this->admin_modal->ManageUserListing();
        //echo '<pre>';print_r($user_list);die;
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("Auto inc ID.", "Register Date", "User Name", "Name", "User Email", "User Phone", "Status", "Password", "Name In Bank", "Bank Name", "Account Number", "IFSC Code");
        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field)->getStyle(1)->getFont()->setBold(true);
            $column++;
        }
        $excel_row = 2;
        $i = 1;
        foreach ($user_list as $obj) {
            // $text = "";
            // $pos ='';
            // switch ($obj->kyc) {
            // case "1":
            // $text = "No Documents";
            // break;
            // case "2":
            // $text = "Approved";
            // break;
            // case "3":
            // $text = "Pending";
            // break;
            // case "4":
            // $text = "Rejected";
            // break;
            // default:
            // $text = "";
            // }

            // switch ($obj->leg) {
            // case "0":
            // $pos = "Left";
            // break;
            // case "1":
            // $pos = "Right";
            // break;
            // default:
            // $pos = "";
            // }

            // $data_part = $this->db->select('ref_id')->from('users')->where(['id' => $obj->parent_id])->get()->row();
            //echo "</pre>"; print_r($data_part); die();

            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $obj->id);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $obj->created_date);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $obj->username);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $obj->name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $obj->email);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $obj->phone);
            //    $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $obj->level);
            //    $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $text);
            // $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $obj->pname);
            // $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $obj->p_username);
            // $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $obj->pemail);
            // $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $obj->p_phone);
            //    $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $pos);
            //    $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $data_part->ref_id);
            //    $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, round($obj->price));
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $obj->isactive == 1 ? 'Active' : 'Inactive');

            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, round($obj->password_text));

            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, ($obj->name_in_bank));
            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, ($obj->bank_name));
            //    $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, ($obj->account_number));
            $object->getActiveSheet()->getCellByColumnAndRow(10, $excel_row)->setValueExplicit($obj->account_number, PHPExcel_Cell_DataType::TYPE_STRING);

            $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, ($obj->ifsc_code));
            $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, ($obj->pancard_no));
            //    $object->getActiveSheet()->setCellValueByColumnAndRow(22, $excel_row, ($obj->paid_date));
            $excel_row++;
        }
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . date('dmYHis') . 'user_excel' . $randnum . '.xls"');
        $object_writer->save('php://output');
    }


    public function ManageKYC($rowno = 0)
    {
        //Start Search Section
        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['condition'] = (isset($_GET['condition'])) ? $_GET['condition'] : '';
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        $role = $this->session->userdata('role');
        $id = $this->session->userdata('adminpk_id');
        //End Search Section

        $config["base_url"] = base_url("admin/ManageKYC");
        $rowperpage = $this->config->item('per_page');
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = count($this->admin_modal->ManageUserListing());
        $config['use_page_numbers'] = true;
        $config['enable_query_strings'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = false;
        if ($search['search_by'] != '' || $search['condition'] != '' || $search['query'] != '') {
            $config['suffix'] = '?' . http_build_query($search, '', "&amp;");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($search, '', "&amp;");
        }
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>' . "\n";
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>' . "\n";
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>' . "\n";
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>' . "\n";
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        $data['row'] = $rowno;
        $data['users'] = $this->admin_modal->ManageUserListing();
        #echo $this->db->last_query();die;
        if (array_key_exists("Manage KYC", $this->global) || ($role == "admin" && $id == 1)) {

            if (isset($this->global["Manage KYC"])) {
                $data["permission"] = $this->global["Manage KYC"];
            }
            $data['sessionuserid'] = $this->sessionuserid;
            $data['sessionuserrole'] = $this->sessionuserrole;
            $this->load->view('admin_new/ManageKYC', $data);
            $this->load->view('admin_new/footer.php');
        } else {
            redirect(base_url('admin/ManageKYC'));
        }
    }


    public function manage_kyc()
    {
        $data['kyc'] = $this->admin_modal->UserKYC('');
        //echo '<pre>';print_r($data['kyc']);die;
        //$this->load->view('admin_new/header.php');
        $this->load->view('admin_new/manage-kyc');
        $this->load->view('admin_new/footer.php');
    }
    public function logout()
    {
        $this->session->set_userdata('admin_logged_in', false);
        $this->session->sess_destroy();
        redirect(base_url('admin'));
    }

    public function manage_account()
    {
        //$this->load->view('admin_new/header.php');
        $this->load->view('admin_new/manage_account.php');
        $this->load->view('admin_new/footer.php');
    }
    public function support($rowno = 0)
    {
        //Start Search Section
        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['condition'] = (isset($_GET['condition'])) ? $_GET['condition'] : '';
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        //End Search Section

        $config["base_url"] = base_url("admin/support");
        $rowperpage = $this->config->item('per_page');
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = $this->user_model->MyTickets('', 1, '', '', $search);
        $config['use_page_numbers'] = true;
        $config['enable_query_strings'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = false;
        if ($search['search_by'] != '' || $search['condition'] != '' || $search['query'] != '') {
            $config['suffix'] = '?' . http_build_query($search, '', "&amp;");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($search, '', "&amp;");
        }
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>' . "\n";
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>' . "\n";
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>' . "\n";
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>' . "\n";
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        $data['row'] = $rowno;

        $data['tickets'] = $this->user_model->MyTickets('', '', $rowno, $rowperpage, $search);
        //echo '<pre>'; print_r($data['tickets']); die;
        $this->load->view('admin_new/support.php', $data);
        $this->load->view('admin_new/footer.php');
    }

    public function support_excel($rowno = 0)
    {
        $search['search_by'] = '';
        $search['condition'] = '';
        $search['query'] = '';

        if ($_GET['search_by'] != '' || $_GET['search_by'] != 0) {
            $search['search_by'] = $_GET['search_by'];
        }

        if ($_GET['condition'] != '' || $_GET['condition'] != 0) {
            $search['condition'] = $_GET['condition'];
        }

        if ($_GET['query'] != '' || $_GET['query'] != 0) {
            $search['query'] = $_GET['query'];
        }

        //print_r($search);die;
        $randnum = random_string('numeric', 4);
        $config["base_url"] = base_url("admin/support");

        $support_list = $this->user_model->MyTickets('', '', '', '', $search);
        //echo '<pre>';print_r($user_list);die;
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("S No.",  "Ticket No.", "Department", "Subject", "User Name", "Name", "User Email", "User Phone",  "Message", "Created Date",  "Status");
        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field)->getStyle(1)->getFont()->setBold(true);
            $column++;
        }
        $excel_row = 2;
        $i = 1;
        foreach ($support_list as $obj) {
            $text = "";
            switch ($obj['status']) {
                case "0":
                    $text = "Pending";
                    break;
                case "1":
                    $text = "Replied";
                    break;
                case "2":
                    $text = "Resolved";
                    break;
                case "3":
                    $text = "On Hold";
                    break;
                default:
                    $text = "";
            }
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $i++);

            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $obj['ticket_no']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $obj['dept']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $obj['subject']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $obj['username']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $obj['name']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $obj['email']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $obj['phone']);

            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $obj['msg']);

            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  change_date_format($obj['created_date'], "d-M-Y h:i:s"));
            $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $text);
            $excel_row++;
        }
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . date('dmYHis') . 'suppot_excel' . $randnum . '.xls"');
        $object_writer->save('php://output');
    }


    public function reward_points($rowno = 0)
    {
        $fullarray = array();

        $role = $this->session->userdata('role');
        $id = $this->session->userdata('adminpk_id');
        if (array_key_exists("All Purchases", $this->global) || ($role == "admin" && $id == 1)) {
            if (isset($this->global["All Purchases"])) {
                $data["permission"] = $this->global["All Purchases"];
            }
            $data['sessionuserid'] = $this->sessionuserid;
            $data['sessionuserrole'] = $this->sessionuserrole;
            // $this->load->view('admin_new/add-investment', $data);
            // $this->load->view('admin_new/footer');
        } else {
            $this->session->set_flashdata('error', 'You Dont have Permission to open this.');
            redirect(base_url('admin/dashboard'));
        }

        $data['tot_buy'] = $this->common_model->get_data('rewards', ' AND isactive=1', 'sum(reward_point) as total_purchase', '1');
        $data['today_buy'] = $this->common_model->get_data('rewards', ' AND isactive=1 AND DATE(created_date) = "' . date("Y-m-d") . '"', 'sum(reward_point) as total_purchase', '1');



        //Start Search Section
        $startdate = '';
        $enddate = '';
        if (isset($_GET['startdate']) && !empty($_GET['startdate'])) {
            $startdate = DateTime::createFromFormat("d/m/Y", $_GET['startdate']);
            $startdate = $startdate->format('Y-m-d');
        }
        if (isset($_GET['enddate']) && !empty($_GET['startdate'])) {
            $enddate = DateTime::createFromFormat("d/m/Y", $_GET['enddate']);
            $enddate = $enddate->format('Y-m-d');
        }

        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['startdate'] = $startdate;
        $search['enddate'] = $enddate;
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        $rowno = isset($_GET['per_page']) ? $_GET['per_page'] : 0;
        //End Search Section

        $config["base_url"] = base_url("admin/reward_points");
        $rowperpage = $this->config->item('per_page');
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = count($this->admin_modal->reward_pointManagement('', '', $search));
        $config['use_page_numbers'] = true;
        $config['enable_query_strings'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = true;

        $config['page_query_string'] = true;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>' . "\n";
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>' . "\n";
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>' . "\n";
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>' . "\n";
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        $data['row'] = $rowno;

        $data['listing'] = $this->admin_modal->reward_pointManagement($rowno, $rowperpage, $search);
        #echo $this->db->last_query();die;
        // echo "<pre>"; print_r($data['listing']);die;

        #echo "<pre>"; print_r($fullarray); die();
        //$data['mylistings'] = $fullarray;
        # echo "<pre>"; print_r($data['mylistings']); die();
        #monika end(25-01-2021)
        $this->load->view('admin_new/reward_point_management', $data);
        $this->load->view('admin_new/footer');
    }
    //manage excel function
    public function purchase_excel($rowno = 0)
    {
        //Start Search Section
        $startdate = '';
        $enddate = '';
        if (isset($_GET['startdate']) && !empty($_GET['startdate'])) {
            $startdate = DateTime::createFromFormat("d/m/Y", $_GET['startdate']);
            $startdate = $startdate->format('Y-m-d');
        }
        if (isset($_GET['enddate']) && !empty($_GET['startdate'])) {
            $enddate = DateTime::createFromFormat("d/m/Y", $_GET['enddate']);
            $enddate = $enddate->format('Y-m-d');
        }

        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['startdate'] = $startdate;
        $search['enddate'] = $enddate;
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        //End Search Section
        #print_r($search);die;

        $randnum = random_string('numeric', 4);
        $excelData = $this->admin_modal->purchaseManagement('', '', $search);
        #echo '<pre>';print_r($excelData);die;
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("S No.", "Date", "Name", "User Name", "Email", "Refer Name", "Refer User Name", "Activated By ID", "Activated By Name", "Total Purchase", "Mode");
        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field)->getStyle(1)->getFont()->setBold(true);
            $column++;
        }
        $excel_row = 2;
        $i = 1;
        $mode = '';
        foreach ($excelData as $obj) {
            if ($obj['payment_via'] == 1) {
                $payment_via = "Bitcoin";
            }
            if ($obj['payment_via'] == 0) {
                $payment_via = "Wallet";
            }
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $i++);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, change_date_format($obj['created_date'], "d-M-Y h:i:s")); //invoice_number
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $obj['name']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $obj['username']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $obj['email']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $obj['ref_name']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $obj['ref_username']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $obj['acm_username']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $obj['acm_name']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $obj['amount']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $payment_via);
            /*$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,($obj['status']==1?"Confirmed":"On Hold"));*/
            $excel_row++;
        }
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . date('dmYHis') . 'Purchase_excel' . $randnum . '.xls"');
        $object_writer->save('php://output');
    }
    //end Purchase Function



    public function support_ticket_detail()
    {
        $id = $this->uri->segment(3);
        $data['ticket'] = $this->user_model->MyTicketsDetail($id, 0);
        $data['conversation'] = $this->user_model->MyTicketsConv($id, 0);
        $this->load->view('admin_new/support_ticket_detail.php', $data);
        $this->load->view('admin_new/footer.php');
    }
    public function ApproveStatus()
    {
        $data = $this->input->post();
        $stat = (($data['status'] == 2 or $data['status'] == 0) ? 1 : 2);
        $status = array('isactive' => $stat);
        $where_array = array('id' => $data['id']);
        $this->common_model->update_data($data['tbl'], $status, $where_array);
        return;
    }
    public function userinfo()
    {
        $user_id = $this->uri->segment(3);
        $this->load->view('admin_new/error');
        $this->load->view('admin_new/footer');
    }
    public function no_record()
    {
        $this->load->view('admin_new/error');
        $this->load->view('admin_new/footer');
    }
    public function user_lead_details($userid)
    {

        $data['userdata'] = $this->admin_modal->get_user_lead_data_by_id($userid);
        // print_r($data['userdata']);die;
        if($data['userdata'])
        {
            //echo '<pre>'; print_r($data);die;
            $this->load->view('admin_new/user_lead_details.php', $data);
            $this->load->view('admin_new/footer.php');
        } else {
            $this->session->set_flashdata('error', 'Bad request.');
            redirect(base_url('admin/dashboard'));
        }
    }
    public function user_details($userid)
    {
        $role = $this->session->userdata('role');
        $id = $this->session->userdata('adminpk_id');   #vikash

        $data['userdata'] = $this->user_model->UserDetail($userid);
        $data['bank_details'] = $this->common_model->get_data('bank_details', 'and user_id=' . $userid, '', 'full', '', '', 'order by id desc');

        //echo '<pre>'; print_r($data);die;
        $data['userid'] = $userid;
        // $data['bitcoin'] = $this->common_model->get_data('bank_details', 'and user_id=' . $userid . ' and type=1');
        // $data['ethereum'] = $this->common_model->get_data('bank_details', 'and user_id=' . $userid . ' and type=2');
        // $data['perfectmoney'] = $this->common_model->get_data('bank_details', 'and user_id=' . $userid . ' and type=3');
        //  $data['countries'] = $this->user_model->get_countries('countries', 'id,title,std_code', 1);
        #echo '<pre>'; print_r($data['userdata']);die;

        // $this->load->view('admin_new/udetails', $data);
        // $this->load->view('admin_new/footer');

        if (array_key_exists("Manage Users", $this->global) || ($role == "admin" && $id == 1)) {

            if (isset($this->global["Manage Users"])) {
                $data["permission"] = $this->global["Manage Users"];
            }
            $data['sessionuserid'] = $this->sessionuserid;
            $data['sessionuserrole'] = $this->sessionuserrole;
            //echo '<pre>'; print_r($data);die;
            $this->load->view('admin_new/udetails_new.php', $data);

            $this->load->view('admin_new/footer.php');
        } else {
            $this->session->set_flashdata('error', 'Bad request.');
            redirect(base_url('admin/dashboard'));
        }
    }

    public function sendnotification()
    {
        if ($this->input->post()) {
            // print_r($_POST);
            // die();
            $file = '';
            if ($_FILES['filename']['name'] != '') {
                $file = $_FILES['filename'];
            }
            $status = $this->notificationmodel->savenotification($this->input->post(), $file);
            // print_r($status);
            // die();
            if ($status == 1) {
                $msg = 'Notification send successfully!!';
                $this->session->set_flashdata('success', 'Notification Sent Successfully.');
                redirect('admin/notificationlist');
            } else {
                $error_msg = 'Some thing went wrong!!';
                $this->session->set_flashdata('error', 'Something went wrong.');
                redirect('admin/notifications');
                //echo "<script>window.history.back();</script>";
            }
        } else {
            $this->session->set_flashdata('error', 'Bad request.');
            redirect('admin/notifications');
        }
    }

    /*public function notifications()
    {
        $this->load->view('admin_new/notifications.php');
        $this->load->view('admin_new/footer.php');
    }*/
    public function notifications()
    {
        /**Rakesh code ***/
        $data['members_data'] = $this->admin_modal->members_data('created_date', 'DESC');
        /***End Rakesh code**/
        $this->load->view('admin_new/notifications.php', $data);
        $this->load->view('admin_new/footer.php');
    }
    public function notificationlist($rowno = 0)
    {
        //Start Search Section
        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['condition'] = (isset($_GET['condition'])) ? $_GET['condition'] : '';
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        //End Search Section

        $config["base_url"] = base_url("admin/notificationlist");
        $rowperpage = $this->config->item('per_page');
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = $this->notificationmodel->notification_data(1, '', '', $search);
        $config['use_page_numbers'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = false;

        $config['enable_query_strings'] = true;
        if ($search['search_by'] != '' || $search['condition'] != '' || $search['query'] != '') {
            $config['suffix'] = '?' . http_build_query($search, '', "&amp;");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($search, '', "&amp;");
        }

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>' . "\n";
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>' . "\n";
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>' . "\n";
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>' . "\n";
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        $data['row'] = $rowno;

        $data['notifications'] = $this->notificationmodel->notification_data('', $rowno, $rowperpage, $search);
        //$data = $this->notificationmodel->notification_data();

        //echo '<pre>';print_r($mainarr);die;
        $this->load->view('admin_new/notification-list', $data);
        $this->load->view('admin_new/footer.php');
    }

    public function faq($rowno = 0)
    {
        //Start Search Section
        $search['search_by'] = (isset($_GET['search_by'])) ? $_GET['search_by'] : '';
        $search['condition'] = (isset($_GET['condition'])) ? $_GET['condition'] : '';
        $search['query'] = (isset($_GET['query'])) ? $_GET['query'] : '';
        //End Search Section

        $config["base_url"] = base_url("admin/faq");
        $rowperpage = $this->config->item('per_page');
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }
        $allcount = $this->admin_modal->faq_data(1, '', '', $search);
        $config['use_page_numbers'] = true;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['reuse_query_string'] = false;

        $config['enable_query_strings'] = true;
        if ($search['search_by'] != '' || $search['condition'] != '' || $search['query'] != '') {
            $config['suffix'] = '?' . http_build_query($search, '', "&amp;");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($search, '', "&amp;");
        }

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>' . "\n";
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>' . "\n";
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>' . "\n";
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>' . "\n";
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>' . "\n";
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        $data['row'] = $rowno;

        $data['department'] = $this->admin_modal->department_data();
        $data['faq'] = $this->admin_modal->faq_data('', $rowno, $rowperpage, $search);
        //echo '<pre>';print_r($data['faq']);die;
        $this->load->view('admin_new/faqlist.php', $data);
        $this->load->view('admin_new/footer.php');
    }




    public function manageRewards()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $data['rewards'] = $this->db->select('*')->from('manage_rewards')->where(['id' => $id])->get()->row_array();
        if (!empty($data['rewards'])) {
            $this->load->view('admin_new/rewardUpdate.php', $data);
            $this->load->view('admin_new/footer.php');
        } else {
            $data['Package'] = $this->db->select('*')->from('manage_rewards')->get()->result();
            $this->load->view('admin_new/rewardsList.php', $data);
            $this->load->view('admin_new/footer.php');
        }
    }

    public function rewardsUpdate()
    {
        if (isset($_POST) && is_array($_POST) && count($_POST) > 0) {
            $dataarray = $_POST;
            $id = $_POST['id'];
            $dataarray['modified_date'] = date("Y-m-d H:i:s");
            $this->common_model->update_data('manage_rewards', $dataarray, 'id=' . $id);
            $this->session->set_flashdata('success', 'Rewards Updated successfully !!');
            redirect(base_url("admin/manageRewards"));
        } else {
            $this->session->set_flashdata('error', 'Somthing went wrong.');
            redirect(base_url("admin/manageRewards"));
        }
    }





    public function change_password()
    {
        $this->load->view('admin_new/change-password.php');
        $this->load->view('admin_new/footer.php');
    }

    public function ispwd()
    {
        $old_pwd = $_POST['old_password'];
        $data = $this->db->select('password')->from('admin')->where(['id' => 1, 'password' => md5($old_pwd)])->get()->result_array();
        if (!empty($data)) {
            if (!empty($_POST['new_password'])) {
                $cpData['password'] = md5($_POST['new_password']);
                $cpData['pTxt'] = $_POST['new_password'];
                $this->common_model->update_data('admin', $cpData, ['id' => 1]);
            }
            echo "<span style='color:green'>Password updated successfully!</span>";
            die;
        } else {
            echo "<span style='color:red'>Old Password does not match!</span>";
            die;
        }
    }

    #######################
    #
    #   config_web
    #
    #######################
    public function webConfig()
    {
        $data['config_web'] = $this->common_model->get_data("config_web", " and status=1", "*", "1");

        #echo "<pre>";print_r($data);die;
        $this->load->view('admin_new/webConfig.php', $data);
        $this->load->view('admin_new/footer.php');
    }
}