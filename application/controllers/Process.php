<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Process extends CI_Controller
{
    public $uid;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->library('javascript');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->library('email');
        //$this->load->model('User_model');
        $this->load->model('common_model');
        $this->load->helper('string');
        $this->load->library('My_PHPMailer');
        $this->load->library('encryption');
        $this->load->helper('comman_helper');
        date_default_timezone_set('Asia/Kolkata');
        
        
        //echo "<pre>"; print_r($this->session->userdata); die();
        
        if ($this->session->userdata('admin_logged_in') == true) {
            if (isset($this->session->userdata['u_id'])) {
                if (isset($_POST['utype']) && $_POST['utype'] == 'admin') {
                    $this->uid = 0;
                } else {
                    $this->uid = $this->encryption->decrypt($this->session->userdata['u_id']);
                }
            } else {
                $this->uid = 0;
            }
        } else if ($this->session->userdata['u_id']) {
            $this->uid = $this->encryption->decrypt($this->session->userdata['u_id']);
        } else {
            redirect(base_url('diesel-master'));
        }
    }
    public function index()
    { }
	
	public function delete_lead(){
        $delete_id= $_POST['ref'];
        $this->admin_modal->delete_lead($delete_id);
        try {
            $rowvalue = $_POST['values'];
            $status = $_POST['ref'];
            $msg = '';
            // $user_update = $this->common_model->update_status('users', $rowvalue, array('isactive' => ""));
            // user_information
            // users
            //bank_details
            //rewards
            //user_address
            
            
            $lead_update = $this->admin_modal->delete_lead($delete_id);
           
           
            $lead_update=1;
            if ($lead_update > 0) {
                    $msg = 'Lead Deleted Successfully';                
                if ($_POST['type'] == 1) {
                    echo json_encode(array('status' => 1, 'message' =>  $msg));
                } else {
                    $this->session->set_flashdata('success', $msg);
                    echo json_encode(array('status' => 1));
                }
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
	 public function lead_details()
    {
        $this->load->model("Admin_modal");
        $id = $_POST['ref']; 
        $bank = $this->admin_modal->get_lead_by_id($id);
        if (!empty($bank)) {
            echo json_encode(array('status' => 1, 'data' => $bank->result_array()));
        } else {
            echo json_encode(array('status' => 0));
        }
    }
	
	public function adupdate_lead()
    {
        $lead_data = array(
            'user_id' => trim($_POST['user_id']),
            'contact_name' => trim($_POST['lead_name']),
            'company_name' => trim($_POST['company_name']),
            'phone_no' => trim($_POST['phone']),
            'email' => trim($_POST['email']),
            'DOT_number' => trim($_POST['DOT_number']),
            'street' => trim($_POST['street']),
            'city' => trim($_POST['city']),
            'state' => trim($_POST['state']),
            'zip_code' => trim($_POST['zip_code']),
            'no_of_trucks' => trim($_POST['total_trucks']),
            'potential_gallons' => trim($_POST['potential_gallons']),
            'status' => trim($_POST['lead_status']),
             'complete_date' => date('Y-m-d H:i:s')
          
        );
        if($_POST['lead_ref_id'] !='' ){
             $bank_update = $this->user_model->updateInfor('leads', $lead_data, 'id', $_POST['lead_ref_id']);
        }else{
              $bnkinfoarr = array(
                    'user_id' => $_POST['b_user_id'],
                    'name' => trim($_POST['lead_name']),
                    'company_name' => trim($_POST['company_name']),
                    'phone' => trim($_POST['phone']),
                    'email' => trim($_POST['email']),
                    'city' => trim($_POST['city']),
                   'designation' => trim($_POST['designation']),
                    'status' => trim($_POST['lead_status']),
                     'complete_date' => date('Y-m-d H:i:s'),
                    'created_date' => date('Y-m-d H:i:s')
                );
                $bank_update = $this->user_model->insert_data('lead', $bnkinfoarr);
        }
        if ($bank_update > 0) { 
            echo json_encode(array('status' => 1, 'data' => $lead_data, 'message' => 'Lead Update Successfully.'));
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
        }
    }
	
	
	
	
    //save bank details
    public function save_bank_details()
    {
        try {
            // echo "aasas </br>";
            //echo "<pre>"; print_r($_FILES['userfile']); die;
           
        //   if($_FILES['userfile']['tmp_name'] =='' || $_POST['bnk_beneficery'] =='' || $_POST['bnk_name'] =='' || $_POST['branch_address'] =='' || $_POST['bnk_accountno'] =='' || $_POST['bnk_ifsc'] =='' || $_POST['bnk_branchcode'] =='' ){
        //       $this->session->set_flashdata('error', 'Please Fill All Fileds And Select Bank Proof Image..');
        //             #echo json_encode(array('status' => '1', 'banks_count' => $bnkscount, 'ref' => $bankid, 'name' => $bankname, 'num' => $account, 'beneficry' => $beneficry, 'ifsc' => $ifsc, 'bradd' => $brnchadd, 'brcode' => $brnchcode, 'message' => 'Bank Information added Successfully.', 'default' => $isdefault));
        //         redirect(base_url("user/profile"));
        //   } 
           
            if (isset($_FILES['userfile']['tmp_name']) && $_FILES['userfile']['tmp_name'] != '') {
                
                 //echo "<pre>";print_r($_FILES);die;
                
                $name = $_FILES["userfile"]["name"];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $target_dir = "uploads/kyc-docs/";
                $target_file1 = $target_dir . "-" . time() . "-" . "." . $ext;
                $source = $_FILES["userfile"]["tmp_name"];
                $image_check = getimagesize($source);
                $height = $image_check['0'];
                $width = $image_check['1'];
                $mime = $image_check['mime'];
                if ($mime == "image/png") {
                    $srcimage = @imagecreatefrompng($source);
                } else {
                    $srcimage = @imagecreatefromjpeg($source);
                }
                
                
                $imagick = new \Imagick(realpath($source));
                $imagick->setImageFormat('jpeg');
                $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
                $imagick->setImageCompressionQuality(70);
                $imagick->thumbnailImage($height, $width, false, false);
                // $filename_no_ext = "thisisname";
                if (file_put_contents($target_file1, $imagick) === false) {
                    throw new Exception("Could not put contents.");
                }
            }
            //die();
            $isdefault = '';
            $userid = $this->uid;
            $required = 'and user_id=' . $userid . ' and type=5';
            $prebnks = $this->common_model->get_data('bank_details', $required);
            if (count($prebnks) >= 3000) {
               
                $this->session->set_flashdata('error', 'Only Three Bank details are allowed.');
                echo json_encode(array('status' => '0', 'message' => 'Only Three Banks are allowed.'));
                die();
                //redirect(base_url("user/profile"));
            } else {
                $other = $this->common_model->get_data('bank_details', 'and user_id=' . $userid . ' and is_default=1');
                if (count($other) == 0) {
                    $isdefault = 1;
                } else {
                    $isdefault = 0;
                }
                $bnkinfoarr = array(
                    'user_id' => $userid,
                    'name_in_bank' => trim(isset($_POST['bnk_beneficery']) ? $_POST['bnk_beneficery'] : ''),
                    'bank_name' => trim(isset($_POST['bnk_name']) ? $_POST['bnk_name'] : ''),
                    'branch_name' => trim(isset($_POST['bnk_branch']) ? $_POST['bnk_branch'] : ''),
                    'branch_address' => trim(isset($_POST['branch_address']) ? $_POST['branch_address'] : ''),
                    'account_number' => trim(isset($_POST['bnk_accountno']) ? $_POST['bnk_accountno'] : ''),
                    'ifsc_code' => trim(isset($_POST['bnk_ifsc']) ? $_POST['bnk_ifsc'] : ''),
                    'branch_code' => trim(isset($_POST['bnk_branchcode']) ? $_POST['bnk_branchcode'] : ''),
                    'nominee_name' => trim(isset($_POST['nominee_name']) ? $_POST['nominee_name'] : ''),
                    'nominee_relation' => trim(isset($_POST['nominee_relation']) ? $_POST['nominee_relation'] : ''),
                    'cheque_receipt' => trim(isset($target_file1) ? $target_file1 : ''),
                    'path' => trim(isset($target_dir) ? $target_dir : ''),
                    'type' => 5,
                    'isactive' => 2,
                    'is_default' => $isdefault,
                    'created_date' => date('Y-m-d H:i:s')
                );
                $bankid = $this->user_model->insert_data('bank_details', $bnkinfoarr);
                if ($bankid > 0) {
                    $bnkscount = count($this->common_model->get_data('bank_details', 'and user_id=' . $userid . ' and type=4'));
                    $bankid = $bankid;
                    $beneficry = trim(isset($_POST['bnk_beneficery']) ? $_POST['bnk_beneficery'] : '');
                    $bankname = trim(isset($_POST['bnk_name']) ? $_POST['bnk_name'] : '');
                    $bnk_branch = trim(isset($_POST['bnk_branch']) ? $_POST['bnk_branch'] : '');
                    $account = trim(isset($_POST['bnk_accountno']) ? $_POST['bnk_accountno'] : '');
                    $ifsc = trim(isset($_POST['bnk_ifsc']) ? $_POST['bnk_ifsc'] : '');
                    $brnchcode = trim(isset($_POST['bnk_branchcode']) ? $_POST['bnk_branchcode'] : '');
                    $brnchadd = trim(isset($_POST['branch_address']) ? $_POST['branch_address'] : '');
                    $this->session->set_flashdata('success', 'Bank Information added Successfully.');
                    echo json_encode(array('status' => '1', 'banks_count' => $bnkscount, 'ref' => $bankid, 'name' => $bankname,  'branch' => $bnk_branch, 'num' => $account, 'beneficry' => $beneficry, 'ifsc' => $ifsc, 'bradd' => $brnchadd, 'brcode' => $brnchcode, 'message' => 'Bank Information added Successfully.', 'default' => $isdefault));
                    die();
                  //  redirect(base_url("user/profile"));
                } else {
                    $this->session->set_flashdata('error', 'There is some issue to save Bank Data.');
                    echo json_encode(array('status' => '0', 'message' => 'There is some issue to save Bank Data.'));
                    die();
                  // redirect(base_url("user/profile"));
                }
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function delete_banks()
    {
        try {
            //print_r($_POST);die;
            $userid = $this->uid;
            $primary_check = $this->common_model->get_data('bank_details', 'and user_id=' . $this->uid . ' and id= ' . $_POST['ref'] . ' and type=5');
            //print_r($primary_check);die;
            /*if($primary_check[0]['is_default']==0)
            {*/
            $required = 'and id=' . $_POST['ref'] . ' and user_id=' . $userid . ' and type=5';
            $deletebnks = $this->common_model->delete_data('bank_details', $required);
            if ($deletebnks > 0) {
                $usrbnks = $this->common_model->get_data('bank_details', ' and user_id=' . $userid . ' and type=4');
                $this->session->set_flashdata('success', 'Bank delete Successfully.');
                echo json_encode(array('status' => '1', 'message' => 'Bank delete Successfully.', 'count' => count($usrbnks), 'ref' => $_POST['ref']));
            } else {
                $this->session->set_flashdata('error', 'There is some issue to delete selected Bank.');
                echo json_encode(array('status' => '0', 'message' => 'There is some issue to delete selected Bank.'));
            }
            /*}
        else
        {
        echo json_encode(array('status' =>'0','message' =>'To delete this bank. Please Change Default selection.'));
        }*/
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    //ends
    //check account number duplicacy function
    public function check_account_no()
    {
        $isAvailable = '';
        $account_no = trim($_POST['bnk_accountno']);
        $duplicateaccount = $this->user_model->chkDuplicat_account('bank_details', 'id,user_id', $account_no);
        if (count($duplicateaccount) > 0) {
            if (!empty($_POST['type']) && $_POST['type'] == 'admin') {
                if ($duplicateaccount[0]->user_id == $_POST['user'] && $duplicateaccount[0]->id == $_POST['bnkex']) {
                    $isAvailable = true;
                } else {
                    $isAvailable = false;
                }
            } else {
                $isAvailable = false;
            }
        } else {
            $isAvailable = true;
        }
        echo json_encode(array('valid' => $isAvailable));
    }
    //ends
    
     #vikash
         //check txn number duplicacy function
    public function check_duplicate_ecashtxn()
    {
        $isAvailable = '';
        $txn_no = trim($_POST['txn_no']);
        $chkDuplicat_ecash_request = $this->user_model->chkDuplicat_ecash_request('ecash_request', '*', $txn_no);
        if (count($chkDuplicat_ecash_request) > 0) {
            $isAvailable = false;
        } else {
            $isAvailable = true;
        }
        echo json_encode(array('valid' => $isAvailable));
    }
    //ends
     public function pancard_validate()
    {
        $isvalid = '';
        $u_pancard_no = $_POST['u_pancard_no'];
        if (!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", $u_pancard_no)) {
            $isvalid = false;
        }else{
            $isvalid = true;
        }
        echo json_encode(array('valid' => $isvalid));
    }
    
    //change user password function
    public function change_password()
    {
        try {
            $old_password = md5($_POST['u_oldpass']);
            $nw_password = $_POST['u_newpass'];
            $nw_cpassword = $_POST['u_cnewpass'];
            if ($nw_password == $nw_cpassword) {
                $userid = $this->encryption->decrypt($this->session->userdata('u_id'));
                $getoldpass = $this->user_model->user_details('members', 'password,username,email', $userid);
                if ($old_password == $getoldpass[0]->password) {
                    // $userInfo = array('password' => md5($_POST['u_newpass']));
                   $userInfo = array('password' => md5($_POST['u_newpass']),'password_text' => $_POST['u_newpass']); 

                    $verifyemail = $this->user_model->updateInfo('members', $userInfo, $userid);
                    /***Rakesh Code ***/
                    //print_r($user);die;
                    // $subject = 'Changed Password Successfully';
                    // $data['name'] = $getoldpass[0]->username;
                    // //$body      = 'Hi '.$user['username'].', You have successfully been able to reset your password. Please note: Don\'t share your new password with anyone and keep it confidential for your own use.</br>Regards </br> Mether Team';
                    // $body = $this->load->view('templates/change_password.php', $data, true);
                    // $mail = $this->mailsend($getoldpass[0]->email, $getoldpass[0]->username, $subject, $body, "no-reply" . host, "Lurextrades.com");
                    /***End rakesh code ***/
                    echo json_encode(array('status' => '1', 'message' => 'New Password Update Successfully.')); //
                } else {
                    echo json_encode(array('status' => '0', 'message' => 'Old Password is not correct'));
                }
            } else {
                echo json_encode(array('status' => '0', 'message' => 'New Password and confirm password not matched'));
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => '2', 'message' => $e->getMessage()));
        }
    }
    //ends
    //Submit KYC data function
    public function submit_kyc()
    {
        $error = '';
        $success = '';
        $directory = 'uploads/kyc-docs/';
        $thumb_directory = 'uploads/kyc-docs/';
        $thumb_h = 160;
        $thumb_w = 250;
        $valid_extensions = array("jpeg", "jpg", "png");
        $i = 0;
        $userid = $this->uid;
        try {
            $required = 'id,address_id,address_id_status,national_id,national_id_status,pancard,pancard_status';
            $user_kyc = $this->user_model->get_kyc('kyc', $required, $userid);
            if (count($user_kyc) > 0) {
                if (!empty($_FILES["national_id"]["name"]) && !empty($_FILES["address_proof"]["name"]) && !empty($_FILES["pancard"]["name"])) {
                    $nid_upload = save_file($_FILES["national_id"], $directory, $thumb_directory, $valid_extensions, 'NID', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                    $ap_upload = save_file($_FILES["address_proof"], $directory, $thumb_directory, $valid_extensions, 'AP', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                    $pan_upload = save_file($_FILES["pancard"], $directory, $thumb_directory, $valid_extensions, 'PAN', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                    if ($nid_upload['respose'] == 2 && $ap_upload['respose'] == 2 && $pan_upload['respose'] == 2) {
                        $nidInfo = array('image' => $nid_upload['filename'], 'img_thumb' => $nid_upload['thumb_name'], 'extension' => $nid_upload['extension'], 'path' => $directory);
                        $imgnid = $this->user_model->insert_data('media', $nidInfo);
                        $apInfo = array('image' => $ap_upload['filename'], 'img_thumb' => $ap_upload['thumb_name'], 'extension' => $ap_upload['extension'], 'path' => $directory);
                        $imgapid = $this->user_model->insert_data('media', $apInfo);
                        
                        $panInfo = array('image' => $pan_upload['filename'], 'img_thumb' => $pan_upload['thumb_name'], 'extension' => $pan_upload['extension'], 'path' => $directory);
                        $imgpanid = $this->user_model->insert_data('media', $panInfo);   #VIKASH
                        
                        $kycuparr = array('address_id' => $imgapid, 'national_id' => $imgnid,  'pancard' => $imgpanid, 'address_id_status' => 1, 'national_id_status' => 1, 'pancard_status' => 1, 'modified_date' => date('Y-m-d H:i:s'));
                        $kycupdate = $this->user_model->updateInfor('kyc', $kycuparr, 'user_id', $userid);
                        if ($kycupdate > 0) {
                            $this->session->unset_userdata('kyc');
                            $this->session->set_userdata('kyc', 'You KYC status is pending for verification');
                            echo json_encode(array('status' => '1', 'message' => 'KYC detail upload successfully and under Verfication.')); //successfully
                        } else {
                            echo json_encode(array('status' => '0', 'message' => 'There is some issue to update KYC details.'));
                        }
                    } elseif ($nid_upload['respose'] == 2 && $ap_upload['respose'] != 2) {
                        $nidInfo = array('image' => $nid_upload['filename'], 'img_thumb' => $nid_upload['thumb_name'], 'extension' => $nid_upload['extension'], 'path' => $directory);
                        $imgnid = $this->user_model->insert_data('media', $nidInfo);
                        $kycuparr = array('national_id' => $imgnid, 'national_id_status' => 1, 'modified_date' => date('Y-m-d H:i:s'));
                        $kycupdate = $this->user_model->updateInfor('kyc', $kycuparr, 'user_id', $userid);
                        if ($kycupdate > 0) {
                            echo json_encode(array('status' => '1', 'message' => 'Only National ID upload successfully.'));
                        } else {
                            echo json_encode(array('status' => '0', 'message' => 'There is some issue to save KYC details'));
                        }
                    } elseif ($nid_upload['respose'] != 2 && $ap_upload['respose'] == 2) {
                        $apInfo = array('image' => $ap_upload['filename'], 'img_thumb' => $ap_upload['thumb_name'], 'extension' => $ap_upload['extension'], 'path' => $directory);
                        $imgapid = $this->user_model->insert_data('media', $apInfo);
                        $kycuparr = array('address_id' => $imgapid, 'address_id_status' => 1, 'modified_date' => date('Y-m-d H:i:s'));
                        $kycupdate = $this->user_model->updateInfor('kyc', $kycuparr, 'user_id', $userid);
                        if ($kycupdate > 0) {
                            echo json_encode(array('status' => '1', 'message' => 'Only Address Proof upload successfully.'));
                        } else {
                            echo json_encode(array('status' => '0', 'message' => 'There is some issue to upload KYC details'));
                        }
                    } else {
                        echo json_encode(array('status' => '0', 'message' => 'There is some issue to upload KYC details.'));
                    }
                } elseif (!empty($_FILES["national_id"]["name"]) && empty($_FILES["address_proof"]["name"])) {
                    $nid_upload = save_file($_FILES["national_id"], $directory, $thumb_directory, $valid_extensions, 'NID', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                    if ($nid_upload['respose'] == 2) {
                        $nidInfo = array('image' => $nid_upload['filename'], 'img_thumb' => $nid_upload['thumb_name'], 'extension' => $nid_upload['extension'], 'path' => $directory);
                        $imgnid = $this->user_model->insert_data('media', $nidInfo);
                        $kycuparr = array('national_id' => $imgnid, 'national_id_status' => 1, 'modified_date' => date('Y-m-d H:i:s'));
                        $kycupdate = $this->user_model->updateInfor('kyc', $kycuparr, 'user_id', $userid);
                        if ($kycupdate > 0) {
                            echo json_encode(array('status' => '2', 'message' => 'National ID upload successfully and under Verfication.'));
                        } else {
                            echo json_encode(array('status' => '0', 'message' => 'There is some issue to upload National Id.'));
                        }
                    } else {
                        echo json_encode(array('status' => '0', 'message' => 'There is some issue to upload National ID.'));
                    }
                } elseif (empty($_FILES["national_id"]["name"]) && !empty($_FILES["address_proof"]["name"])) {
                    $ap_upload = save_file($_FILES["address_proof"], $directory, $thumb_directory, $valid_extensions, 'AP', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                    if ($ap_upload['respose'] == 2) {
                        $apInfo = array('image' => $ap_upload['filename'], 'img_thumb' => $ap_upload['thumb_name'], 'extension' => $ap_upload['extension'], 'path' => $directory);
                        $imgapid = $this->user_model->insert_data('media', $apInfo);
                        $kycuparr = array('address_id' => $imgapid, 'address_id_status' => 1, 'modified_date' => date('Y-m-d H:i:s'));
                        $kycupdate = $this->user_model->updateInfor('kyc', $kycuparr, 'user_id', $userid);
                        if ($kycupdate > 0) {
                            echo json_encode(array('status' => '3', 'message' => 'Address Proof upload successfully and under Verfication.'));
                        } else {
                            echo json_encode(array('status' => '0', 'message' => 'There is some issue to upload Address Proof.'));
                        }
                    } else {
                        echo json_encode(array('status' => '0', 'message' => 'There is some issue to upload Address Proof.'));
                    }
                } else {
                    echo json_encode(array('status' => '0', 'message' => 'Please Upload KYC details'));
                }
            } else {
                if (!empty($_FILES["national_id"]["name"]) && !empty($_FILES["address_proof"]["name"]) && !empty($_FILES["pancard"]["name"])) {
                    $save_NID = save_file($_FILES["national_id"], $directory, $thumb_directory, $valid_extensions, 'NID', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                    $save_AP = save_file($_FILES["address_proof"], $directory, $thumb_directory, $valid_extensions, 'AP', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                    $save_PAN = save_file($_FILES["pancard"], $directory, $thumb_directory, $valid_extensions, 'PAN', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                     if ($save_NID['respose'] == 2 && $save_AP['respose'] == 2 && $save_PAN['respose'] == 2) {
                        $nidarr = array('image' => $save_NID['filename'], 'img_thumb' => $save_NID['thumb_name'], 'extension' => $save_NID['extension'], 'path' => $directory);
                        $imgnid = $this->user_model->insert_data('media', $nidarr);
                        $apidarr = array('image' => $save_AP['filename'], 'img_thumb' => $save_AP['thumb_name'], 'extension' => $save_AP['extension'], 'path' => $directory);
                        $imgap = $this->user_model->insert_data('media', $apidarr);
                        #vikash
                        $panidarr = array('image' => $save_PAN['filename'], 'img_thumb' => $save_PAN['thumb_name'], 'extension' => $save_PAN['extension'], 'path' => $directory);
                        $imgpan = $this->user_model->insert_data('media', $panidarr);
                        if ($imgnid > 0 && $imgap > 0 && $imgpan > 0) {
                            $kycarr = array('user_id' => $userid, 'address_id' => $imgap, 'national_id' => $imgnid, 'pancard' => $imgpan, 'address_id_status' => 1, 'national_id_status' => 1, 'pancard_status' => 1, 'created_date' => date('Y-m-d H:i:s'));
                            $kycid = $this->user_model->insert_data('kyc', $kycarr);
                            if ($kycid > 0) {
                                echo json_encode(array('status' => '1', 'message' => 'KYC detail upload successfully and under Verfication.'));
                            } else {
                                echo json_encode(array('status' => '0', 'message' => 'There is some issue in upload KYC details.'));
                            }
                        } else {
                            echo json_encode(array('status' => '0', 'message' => 'Any of document not uploaded successfully'));
                        }
                    } elseif ($save_NID['respose'] == 0 || $save_AP['respose'] == 0 || $save_PAN['respose'] == 0) {
                        echo json_encode(array('status' => '0', 'message' => 'Any of document has wrong extension.Only allow (jpg,png,jpeg)'));
                    } elseif ($save_NID['respose'] == 1 || $save_AP['respose'] == 1 || $save_PAN['respose'] == 1) {
                        echo json_encode(array('status' => '0', 'message' => 'Any of document not uploaded successfully'));
                    } else {
                        echo json_encode(array('status' => '0', 'message' => 'Something went wrong. Please try after sometime.'));
                    }
                } else {
                    echo json_encode(array('status' => '0', 'message' => 'National Id, Address Proof and Pancard is required.'));
                    die;
                }
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    //ends
    //Edit user profile function
    public function edit_user_profile()
    {
       // echo "hooo";
        // print_r($_POST);die;
         $tron_address = $_POST['u_aadhar_no'];
         $state_id = $_POST['state'];
         $district_id = $_POST['district'];
        //   print_r($state_id);//die;
        //   print_r($district_id);//die;
        // echo $_POST['u_lname']; die;
        try {
             //echo "YSS"; die();
        //      print_r($state_id);//die;
        //   print_r($district_id);die();
            // $dob          = $_POST['u_dob']!=''?change_date_format($_POST['u_dob'],"Y-m-d"):'';
            // $l_name     = $_POST['u_lname']!=''?trim($_POST['u_lname']):'';
            
            #monika(comment it)
            if (!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", $_POST['u_pancard_no'])) {
            //  if (empty( $_POST['u_aadhar_no'])) {
                // echo "yes"; die();
                     echo json_encode(array('status' => '0', 'message' => 'Please Enter Valid Tron Address No.'));
                    // echo json_encode(array('status' => '1', 'message' => 'Profile Update successfully.'));
                    exit();
            }
            // echo  "<pre>"; print_r($_POST);
            // die();
            //   $getstatebyid = $this->common_model->get_data("states", " AND id =".$state_id, "name", "1");
            //   $statename = $getstatebyid['name'];
            //  // echo "<pre>"; print_r($statename); die();
            //  $getdistrictbyid = $this->common_model->get_data("districts", " AND id =".$district_id, "name", "1");
            //  $districtname = $getdistrictbyid['name'];
            //  // echo "<pre>"; print_r($districtname); die();
             
            $userInfo = array(
                'f_name' => trim($_POST['u_fname']),
                // 'l_name'=>$l_name,
                // 'gender'=>$_POST['u_gender'],
                // 'dob'=>$dob,
                'address' => trim($_POST['u_address']),
                'city' => trim($_POST['u_city']),
                // 'state' => $statename,
                // 'district' => $districtname,
                'zip_code' => trim($_POST['u_pincode']),
                'aadhar_no' => $tron_address,
                 'pancard_no' => trim($_POST['u_pancard_no'])
                
            );
           // echo "<pre>"; print_r($tron_address); die();
           // $member_table = array('full_name' => $_POST['u_fname']);
            $member_table = array('full_name' => $_POST['u_fname'],'email' => $_POST['u_email'],'phone' => $_POST['u_phone']);

            
              $activeuser = $this->user_model->updateInfor('user_information', $userInfo, 'user_id', $this->uid);
              $member_table = $this->user_model->updateInfor('members', $member_table, 'id', $this->uid);
            // $activeuser = $this->user_model->updateInfor('user_information', $userInfo, 'user_id', $this->uid);
            if ($activeuser > 0) {
                echo json_encode(array('status' => '1', 'message' => 'Profile Update successfully.'));
            } else {
                echo json_encode(array('status' => '0', 'message' => 'There is some issue to update user profile.'));
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => '2', 'message' => 'There is some unknown Response'));
            //var_dump($e->getMessage());
        }
    }
    //end
    
    
    #monika start
     public function edit_user_profile_monika()
    {
          echo "hooo";
         print_r($_POST);die;
         $tron_address = $_POST['u_aadhar_no'];
         $state_id = $_POST['state'];
         $district_id = $_POST['district'];
        //   print_r($state_id);//die;
        //   print_r($district_id);//die;
        // echo $_POST['u_lname']; die;
        try {
             //echo "YSS"; die();
        //      print_r($state_id);//die;
        //   print_r($district_id);die();
            // $dob          = $_POST['u_dob']!=''?change_date_format($_POST['u_dob'],"Y-m-d"):'';
            // $l_name     = $_POST['u_lname']!=''?trim($_POST['u_lname']):'';
            
            #monika(comment it)
            if (!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", $_POST['u_pancard_no'])) {
            //  if (empty( $_POST['u_aadhar_no'])) {
                // echo "yes"; die();
                     echo json_encode(array('status' => '0', 'message' => 'Please Enter Valid Tron Address No.'));
                    // echo json_encode(array('status' => '1', 'message' => 'Profile Update successfully.'));
                    exit();
            }
            // echo  "<pre>"; print_r($_POST);
            // die();
            //   $getstatebyid = $this->common_model->get_data("states", " AND id =".$state_id, "name", "1");
            //   $statename = $getstatebyid['name'];
            //  // echo "<pre>"; print_r($statename); die();
            //  $getdistrictbyid = $this->common_model->get_data("districts", " AND id =".$district_id, "name", "1");
            //  $districtname = $getdistrictbyid['name'];
            //  // echo "<pre>"; print_r($districtname); die();
             
            $userInfo = array(
                'f_name' => trim($_POST['u_fname']),
                // 'l_name'=>$l_name,
                // 'gender'=>$_POST['u_gender'],
                // 'dob'=>$dob,
                'address' => trim($_POST['u_address']),
                'city' => trim($_POST['u_city']),
                // 'state' => $statename,
                // 'district' => $districtname,
                'zip_code' => trim($_POST['u_pincode']),
                'aadhar_no' => $tron_address,
                 'pancard_no' => trim($_POST['u_pancard_no'])
                
            );
           // echo "<pre>"; print_r($tron_address); die();
           // $member_table = array('full_name' => $_POST['u_fname']);
            $member_table = array('full_name' => $_POST['u_fname'],'email' => $_POST['u_email'],'phone' => $_POST['u_phone']);

            
              $activeuser = $this->user_model->updateInfor('user_information', $userInfo, 'user_id', $this->uid);
              $member_table = $this->user_model->updateInfor('members', $member_table, 'id', $this->uid);
            // $activeuser = $this->user_model->updateInfor('user_information', $userInfo, 'user_id', $this->uid);
            if ($activeuser > 0) {
                echo json_encode(array('status' => '1', 'message' => 'Profile Update successfully.'));
            } else {
                echo json_encode(array('status' => '0', 'message' => 'There is some issue to update user profile.'));
            }
        } catch (Exception $e) {
            echo json_encode(array('status' => '2', 'message' => 'There is some unknown Response'));
            //var_dump($e->getMessage());
        }
    }
    //end
    #monika end
    public function generateTicket()
    {
        //echo '<pre>'; print_r(count($_FILES["image_id"]["name"])); die;
        $imgnid = '';
        $items = array();
        $i = 0;
        $directory = 'uploads/tickets/';
        $thumb_directory = 'uploads/tickets/';
        $thumb_h = 70;
        $thumb_w = 70;
        $valid_extensions = array("jpeg", "jpg", "png", "pdf");
        $data = $this->input->post();
        //print_r($data);die;
        if ($data) {
            if (!empty($_FILES["image_id"]["name"])) {
                if (count($_FILES["image_id"]["name"]) <= 5) {
                    foreach ($_FILES["image_id"]["tmp_name"] as $key => $tmp_name) {
                        /*echo $file_name=$_FILES["image_id"]["name"][$key].'  ';
                        echo $file_tmp=$_FILES["image_id"]["tmp_name"][$key].'  ';
                        echo $ext=pathinfo($file_name,PATHINFO_EXTENSION).'  <br>';*/
                        $file_name = $_FILES["image_id"]["name"][$key];
                        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                        if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
                            $thumbnail = true;
                        } else {
                            $thumbnail = false;
                        }
                        $filearr = array('tmp_name' => $_FILES["image_id"]["tmp_name"][$key], 'name' => $_FILES["image_id"]["name"][$key]);
                        $nid_upload = save_file($filearr, $directory, $thumb_directory, $valid_extensions, 'ST' . $i . '', $this->session->userdata('u_refid'), $thumbnail, $thumb_w, $thumb_h);
                        if ($nid_upload['respose'] == 2) {
                            $nidInfo = array('image' => $nid_upload['filename'], 'img_thumb' => $nid_upload['thumb_name'] != '' ? $nid_upload['thumb_name'] : '', 'extension' => $nid_upload['extension'], 'path' => $directory);
                            $imgnid = $this->user_model->insert_data('media', $nidInfo);
                            $items[] = $imgnid;
                        }
                        $i++;
                    }
                    $imgnid = implode(',', $items);
                    //die;
                } else {
                    $this->session->set_flashdata('error', "Maximum 5 files allowed to upload.");
                    redirect(base_url('user/support'));
                    die;
                }
            } else {
                $imgnid = "0";
            }
            $data['image_id'] = $imgnid;
            $data['user_id'] = $data['created_by'] = $this->uid;
            $insertTicket = $this->user_model->insert_data('tickets', $data);
            if ($insertTicket > 0) {
                $this->session->set_flashdata('success', "We Will in touch soon.");
                redirect(base_url('user/support'));
            } else {
                $this->session->set_flashdata('error', "Sorry something went wrong.Please try after sometime.");
                redirect(base_url('user/support'));
            }
        } else {
            $this->session->set_flashdata('error', "Sorry something went wrong.Please try after sometime.");
            redirect(base_url('user/support'));
        }
    }
    public function TicketReply()
    { //echo count($_FILES["image_id"]["name"]);die;
        //echo '<pre>';print_r($_FILES).' </br>';
        /*echo '<pre>';print_r($this->input->post());
        die;*/
        try {
            $imgnid = '';
            $thumbnail = '';
            $items = array();
            $i = 0;
            $directory = 'uploads/tickets/';
            $thumb_directory = 'uploads/tickets/';
            $thumb_h = 70;
            $thumb_w = 70;
            $valid_extensions = array("jpeg", "jpg", "png", "pdf");
            $message = $this->input->post('body');
            $refid = $this->input->post('ref_id');
            $data = $this->input->post();
            if (!empty($message) && !empty($refid)) {
                if (!empty($_FILES["image_id"]["name"])) {
                    if (count($_FILES["image_id"]["name"]) <= 5) {
                        foreach ($_FILES["image_id"]["tmp_name"] as $key => $tmp_name) {
                            $file_name = $_FILES["image_id"]["name"][$key];
                            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') {
                                $thumbnail = true;
                            } else {
                                $thumbnail = false;
                            }
                            $filearr = array('tmp_name' => $_FILES["image_id"]["tmp_name"][$key], 'name' => $_FILES["image_id"]["name"][$key]);
                            $nid_upload = save_file($filearr, $directory, $thumb_directory, $valid_extensions, 'ST' . $i . '', $this->session->userdata('u_refid'), $thumbnail, $thumb_w, $thumb_h);
                            if ($nid_upload['respose'] == 2) {
                                $nidInfo = array('image' => $nid_upload['filename'], 'img_thumb' => $nid_upload['thumb_name'] != '' ? $nid_upload['thumb_name'] : '', 'extension' => $nid_upload['extension'], 'path' => $directory);
                                $imgnid = $this->user_model->insert_data('media', $nidInfo);
                                $items[] = $imgnid;
                            }
                            $i++;
                        }
                        $imgnid = implode(',', $items);
                    } else {
                        $this->session->set_flashdata('error', "Maximum 5 files allowed to upload.");
                        echo '<script>history.back();</script>';
                        die;
                    }
                }
                $ticket_user = $this->common_model->get_data("tickets", " AND id=" . $data['ref_id'], "user_id", "1");
                $data['user_id'] = $ticket_user['user_id'];
                $data['created_by'] = $this->uid;
                $data['image_id'] = $imgnid;
                if ($this->uid == 0) {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $this->common_model->update_data('tickets', array('status' => $status), array('id' => $data['ref_id']));
                $insertTicket = $this->user_model->insert_data('tickets', $data);
                if ($insertTicket > 0) {
                    $this->session->set_flashdata('success', "Reply sent successfully.");
                    echo '<script>history.back();</script>';
                } else {
                    $this->session->set_flashdata('error', "There is some issue to send reply.Try after some time.");
                    echo '<script>history.back();</script>';
                    die;
                }
            } else {
                $this->session->set_flashdata('error', "Please Enter some message.");
                echo '<script>history.back();</script>';
                die;
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', "Something went wrong. Please try after some time.");
            echo '<script>history.back();</script>';
            die;
        }
    }
    public function edit_profile_pic()
    {
        try {
            if (!empty($_FILES["profile_pic"]["name"])) {
                $directory = 'uploads/profile-pic/';
                $thumb_directory = 'uploads/profile-pic/';
                $thumb_h = 250;
                $thumb_w = 250;
                $valid_extensions = array("jpeg", "jpg", "png");
                $userid = $this->uid;
                $user_dp = save_file($_FILES["profile_pic"], $directory, $thumb_directory, $valid_extensions, 'DP', $this->session->userdata('u_refid'), true, $thumb_w, $thumb_h);
                if ($user_dp['respose'] == 2) {
                    $dpInfo = array('image' => $user_dp['filename'], 'img_thumb' => $user_dp['thumb_name'], 'extension' => $user_dp['extension'], 'path' => $directory);
                    $imgid = $this->user_model->insert_data('media', $dpInfo);
                    if ($imgid > 0) {
                        $dparr = array('profile_pic' => $imgid);
                        $dpupdate = $this->user_model->updateInfor('members', $dparr, 'id', $userid);
                        if ($dpupdate > 0) {
                            echo json_encode(array('status' => '1', 'message' => 'Profile Picture Update successfully.', 'thumb' => base_url() . $thumb_directory . $user_dp['thumb_name']));
                        } else {
                            echo json_encode(array('status' => '0', 'message' => 'There is some issue to save User Profile Image data.'));
                        }
                    } else {
                        echo json_encode(array('status' => '0', 'message' => 'There is some issue to save Image data.'));
                    }
                } else {
                    echo json_encode(array('status' => '0', 'message' => $user_dp['message']));
                }
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function delete_bank()
    {
        try {
            $bank_id = $this->encryption->decrypt($_POST['ref']);
            $required = 'and id=' . $bank_id;
            $prebnks = $this->common_model->delete_data('bank_details', $required);
            if ($prebnks > 0) {
                echo json_encode(array('status' => '1', 'message' => 'Bank Delete Successfully.'));
            } else {
                echo json_encode(array('status' => '0', 'message' => 'There is some issue to delete bank.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    public function closeTicket()
    {
        if (!empty($_POST['ticketid'])) {
            if ($this->uid == 0) {
                $update = array('status' => 2, 'closing_at' => date('Y-m-d H:i:s'));
                $url = 'apcompundpower/support';
            } else {
                $update = array('isactive' => 0, 'status' => 2, 'closing_at' => date('Y-m-d H:i:s'));
                $url = 'user/Support';
            }
            $closeticket = $this->common_model->update_data('tickets', $update, array('id' => $_POST['ticketid']));
            if ($closeticket > 0) {
                $this->session->set_flashdata('success', "Ticket Close successfully.");
                $url = base_url() . $url;
                echo json_encode(array('status' => '1', 'url' => $url));
            } else {
                echo json_encode(array('status' => '0', 'message' => 'Something went wrong. Please try after some time.'));
            }
        } else {
            echo json_encode(array('status' => '0', 'message' => 'Something went wrong. Please try after some time.'));
        }
    }
    
    public function banks_details()
    {
        $bank = $this->common_model->get_data("bank_details", " AND id=" . $_POST['ref'], "id,user_id,name_in_bank,bank_name,branch_address,account_number,ifsc_code,branch_code", "1");
        if (!empty($bank)) {
            echo json_encode(array('status' => 1, 'data' => $bank));
        } else {
            echo json_encode(array('status' => 0));
        }
    }
    public function adupdate_bank()
    {
        $bank_data = array(
            'name_in_bank' => trim($_POST['bnk_beneficery']),
            'bank_name' => trim($_POST['bank_name']),
            'branch_address' => trim($_POST['branch_address']),
            'account_number' => trim($_POST['bnk_accountno']),
            'ifsc_code' => trim($_POST['ifsc_code']),
            'isactive' => 1
            //'branch_code'=>trim($_POST['branch_code'])
        );
        if($_POST['bank_ref'] !='' ){
             $bank_update = $this->user_model->updateInfor('bank_details', $bank_data, 'id', $_POST['bank_ref']);
        }else{
              $bnkinfoarr = array(
                    'user_id' => $_POST['b_user_id'],
                    'name_in_bank' => trim(isset($_POST['bnk_beneficery']) ? $_POST['bnk_beneficery'] : ''),
                    'bank_name' => trim(isset($_POST['bank_name']) ? $_POST['bank_name'] : ''),
                    'branch_address' => trim(isset($_POST['branch_address']) ? $_POST['branch_address'] : ''),
                    'account_number' => trim(isset($_POST['bnk_accountno']) ? $_POST['bnk_accountno'] : ''),
                    'ifsc_code' => trim(isset($_POST['ifsc_code']) ? $_POST['ifsc_code'] : ''),
                    'type' => 5,
                    'is_default' => 1,
                    'isactive' => 1,
                    'created_date' => date('Y-m-d H:i:s')
                );
                $bank_update = $this->user_model->insert_data('bank_details', $bnkinfoarr);
        }
        if ($bank_update > 0) {
            echo json_encode(array('status' => 1, 'data' => $bank_data, 'message' => 'Bank Update Successfully.'));
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
        }
    }
    // bank image update
    public function adupdate_bank_img()
    {
        
        //echo "<pre>"; print_r($_FILES); die();
        try {
          
            if (isset($_FILES['bank_proof']['tmp_name']) && $_FILES['bank_proof']['tmp_name'] != '') {
                
                 //echo "<pre>";print_r($_FILES);die;
                
                $name = $_FILES["bank_proof"]["name"];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $target_dir = "uploads/kyc-docs/";
                $target_file1 = $target_dir . "-" . time() . "-" . "." . $ext;
                $source = $_FILES["bank_proof"]["tmp_name"];
                $image_check = getimagesize($source);
                $height = $image_check['0'];
                $width = $image_check['1'];
                $mime = $image_check['mime'];
                if ($mime == "image/png") {
                    $srcimage = @imagecreatefrompng($source);
                } else {
                    $srcimage = @imagecreatefromjpeg($source);
                }
                
                
                $imagick = new \Imagick(realpath($source));
                $imagick->setImageFormat('jpeg');
                $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
                $imagick->setImageCompressionQuality(70);
                $imagick->thumbnailImage($height, $width, false, false);
                // $filename_no_ext = "thisisname";
                if (file_put_contents($target_file1, $imagick) === false) {
                    throw new Exception("Could not put contents.");
                }
            }
            //die();
           
            $ref_id = $_POST["bank_ref_img"];
            $b_img_user_id = $_POST["b_img_user_id"];
            $required = 'and user_id=' . $b_img_user_id . ' and type=5';
            $prebnks = $this->common_model->get_data('bank_details', $required);
            if (count($prebnks) >= 3000) {
               
                $this->session->set_flashdata('error', 'Only Three Bank details are allowed.');
                #echo json_encode(array('status' => '0', 'message' => 'Only Three Banks are allowed.'));
                redirect(base_url("user/profile"));
            } else {
                
                if($_POST['bank_ref_img'] > '0' ){
                    $bnkinfoarr = array(
                        'cheque_receipt' => trim(isset($target_file1) ? $target_file1 : ''),
                        'path' => trim(isset($target_dir) ? $target_dir : ''),
                        'isactive' => 1
                    );
                    $bank_update = $this->user_model->updateInfor('bank_details', $bnkinfoarr, 'id', $_POST['bank_ref_img']);
                }else{
                    $bnkinfoarr = array(
                    'user_id' => $_POST['b_img_user_id'],
                    'name_in_bank' => trim(isset($_POST['bnk_beneficery']) ? $_POST['bnk_beneficery'] : ''),
                    'bank_name' => trim(isset($_POST['bnk_name']) ? $_POST['bnk_name'] : ''),
                    'branch_address' => trim(isset($_POST['branch_address']) ? $_POST['branch_address'] : ''),
                    'account_number' => trim(isset($_POST['bnk_accountno']) ? $_POST['bnk_accountno'] : ''),
                    'ifsc_code' => trim(isset($_POST['bnk_ifsc']) ? $_POST['bnk_ifsc'] : ''),
                    'cheque_receipt' => trim(isset($target_file1) ? $target_file1 : ''),
                    'path' => trim(isset($target_dir) ? $target_dir : ''),
                    'type' => 5,
                    'is_default' => 1,
                    'isactive' => 1,
                    'created_date' => date('Y-m-d H:i:s')
                );
                    $bank_update = $this->user_model->insert_data('bank_details', $bnkinfoarr);
                }
                if ($bank_update > 0) {
                   
                   $this->session->set_flashdata('success', 'Bank Information added Successfully.');
                   echo json_encode(array('status' => 1, 'data' => $bnkinfoarr, 'message' => 'Bank Proof Updated Successfully.'));
                   #redirect(base_url("user/profile"));
                } else {
                    $this->session->set_flashdata('error', 'There is some issue to save Bank Data.');
                    echo json_encode(array('status' => '0', 'message' => 'There is some issue to save Bank Data.'));
                    #redirect(base_url("user/profile"));
                }
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
       
    }
    
     // kyc image update
    public function adupdate_kyc_img()
    {
        
       // echo "<pre>"; print_r($_POST); die();
        try {
          
            if (isset($_FILES['kyc_proof']['tmp_name']) && $_FILES['kyc_proof']['tmp_name'] != '') {
                
                 $pic_type = $_POST["pic_type"];
                if($pic_type==1){
                     $txt="NID";
                }else if($pic_type==2){
                    $txt="AP";
                }else if($pic_type==3){
                    $txt="PAN";
                }
                $ref_id = $_POST["ref_img"];
                $kyc_user_id = $_POST["kyc_user_id"];
                
                
                $error = '';
                $success = '';
                $directory = 'uploads/kyc-docs/';
                $thumb_directory = 'uploads/kyc-docs/';
                $thumb_h = 160;
                $thumb_w = 250;
                $valid_extensions = array("jpeg", "jpg", "png");
                $i = 0;
                $pan_upload = save_file($_FILES["kyc_proof"], $directory, $thumb_directory, $valid_extensions, $txt, $ref_id, true, $thumb_w, $thumb_h);
                  if ($pan_upload['respose'] == 2) {
                       
                        $panInfo = array('image' => $pan_upload['filename'], 'img_thumb' => $pan_upload['thumb_name'], 'extension' => $pan_upload['extension'], 'path' => $directory);
                        $imgpanid = $this->user_model->insert_data('media', $panInfo);   #VIKASH
                        
                        if($pic_type==1){
                            $kycuparr = array('national_id' => $imgpanid, 'national_id_status' => 1, 'modified_date' => date('Y-m-d H:i:s'));
                        }elseif($pic_type==2){
                            $kycuparr = array('address_id' => $imgpanid, 'address_id_status' => 1, 'modified_date' => date('Y-m-d H:i:s'));
                        }elseif($pic_type==3){
                            $kycuparr = array('pancard' => $imgpanid, 'pancard_status' => 1, 'modified_date' => date('Y-m-d H:i:s'));
                        }else{
                             echo json_encode(array('status' => '0', 'pic_type' => $pic_type,'message' => 'There is some issue to upload KYC details.')); die();
                        }
                        
                        $required = 'and user_id=' . $kyc_user_id;
                        $prekyc = $this->common_model->get_data('kyc', $required);
                        if (count($prekyc) > 0) {
                            $kycupdate = $this->user_model->updateInfor('kyc', $kycuparr, 'id', $ref_id);
                        }else{
                            $kycarr = array('user_id' => $kyc_user_id, 'created_date' => date('Y-m-d H:i:s'));
                            $as = array_merge($kycuparr,$kycarr);
                            $kycupdate = $this->user_model->insert_data('kyc', $as);
                        }
                        if ($kycupdate > 0) {
                           // $this->session->unset_userdata('kyc');
                          //  $this->session->set_userdata('kyc', 'You KYC status is pending for verification');
                            $this->session->set_flashdata('success', 'KYC Information added Successfully and Under Verfication.');
                            echo json_encode(array('status' => '1', 'pic_type' => $pic_type,'message' => 'KYC detail upload successfully and under Verfication.')); die(); //successfully
                        } else {
                            echo json_encode(array('status' => '0','pic_type' => $pic_type, 'message' => 'There is some issue to update KYC details.')); die();
                        }
                     }else {
                        echo json_encode(array('status' => '0', 'pic_type' => $pic_type,'message' => 'There is some issue to upload KYC details.')); die();
                    } 
            }else{
                 echo json_encode(array('status' => '0', 'pic_type' => $pic_type,'message' => 'There is some issue to upload KYC details.')); die();
                   
            }
           
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
       
    }
    
    
    
    public function change_status()
    {
        try {
            $rowvalue = $_POST['values'];
            $status = $_POST['ref'];
            $msg = '';
            $user_update = $this->common_model->update_status('users', $rowvalue, array('isactive' => $status));
            if ($user_update > 0) {
                if ($status == 1) {
                    $msg = 'Activate';
                } elseif ($status == 0) {
                    $msg = 'Deactivate';
                } else {
                    $msg = '';
                }
                if ($_POST['type'] == 1) {
                    echo json_encode(array('status' => 1, 'message' => "User " . $msg . " Successfully"));
                } else {
                    $this->session->set_flashdata('success', "User " . $msg . " Successfully.");
                    echo json_encode(array('status' => 1));
                }
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    
     public function delete_agent()
    {
        try {
            $rowvalue = $_POST['values'];
            $status = $_POST['ref'];
            $msg = '';
            // $user_update = $this->common_model->update_status('users', $rowvalue, array('isactive' => ""));
            // user_information
            // users
            //bank_details
            //rewards
            //user_address
            
            
            $user_update = $this->common_model->delete_data('user_information', 'and user_id= '.$rowvalue);
            $user_update = $this->common_model->delete_data('users', 'and id= '.$rowvalue);
            $user_update = $this->common_model->delete_data('bank_details', 'and user_id= '.$rowvalue);
            $user_update = $this->common_model->delete_data('rewards', 'and user_id= '.$rowvalue);
            $user_update = $this->common_model->delete_data('user_address', 'and user_id= '.$rowvalue);
            $user_update = $this->common_model->delete_data('cards', 'and user_id= '.$rowvalue);
           
           
            $user_update=1;
            if ($user_update > 0) {
                // if ($status == 1) {
                //     $msg = 'Activate';
                // } elseif ($status == 0) {
                //     $msg = 'Deactivate';
                // } else {
                    $msg = 'Agent Deleted Successfully';
                // }
                if ($_POST['type'] == 1) {
                    echo json_encode(array('status' => 1, 'message' =>  $msg));
                } else {
                    $this->session->set_flashdata('success', $msg);
                    echo json_encode(array('status' => 1));
                }
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    
    
    
    
        public function change_status_kyc()
    {
        try {
           
          //  echo "<pre>"; print_r($_POST); die();  
            $rowvalue = $_POST['values'];
            $status = $_POST['ref'];
            $msg = ' ';
            
            $remarks = 'Update kyc by admin Directly Based on pancard';
            
            //$rowvalue = '121212';
            
            $banks_dels = $this->common_model->get_data('bank_details', 'and user_id=' . $rowvalue . '', '', 'full','','','order by id desc','limit 0,1'); 
            
            $kyc_dels = $this->common_model->get_data('kyc', 'and user_id=' . $rowvalue . '', '', 'full','','','order by id desc','limit 0,1'); 
            
           // echo json_encode(array('status' => 1, 'message' => "Under Testing..")); die();
            
            if(count($kyc_dels) >0){
                 $kyc_id =  $kyc_dels[0]['id'];
                
                $user_update = $this->common_model->update_status('kyc', $kyc_id, array('pancard_status' => $status, 'address_id_status' => $status, 'national_id_status' => $status));
            }else{
                
                $kycData['user_id'] = $rowvalue;
                $kycData['pancard_status'] = $status;
                $kycData['address_id_status'] = $status;
                $kycData['national_id_status'] = $status;
                $kycData['created_date'] = date('Y-m-d H:i:s');
                $kycData['ap_remarks'] = $remarks;
                $kycData['nid_remarks'] = $remarks;
                $kycData['pan_remarks'] = $remarks;
               # echo "<pre>";print_r($kycData);//die;
                $user_update = $this->common_model->add_data('kyc', $kycData);
            } 
            
            if(count($banks_dels) >0){
                 $bank_id =  $banks_dels[0]['id'];
                
               $bank_update = $this->common_model->update_status('bank_details', $bank_id, array('isactive' => $status,'nid_remarks' => $remarks));
            }else{
                $bankData['user_id'] = $rowvalue;
                $bankData['name_in_bank'] = 'Direct Admin';
                $bankData['bank_name'] = 'Direct Admin';
                $bankData['branch_address'] = 'Direct Admin';
                $bankData['account_number'] = '';
                $bankData['ifsc_code'] = '';
                $bankData['branch_code'] = '';
                $bankData['nid_remarks'] = $remarks;
                $bankData['created_by'] = '';
                $bankData['isactive'] = $status;
               # echo "<pre>";print_r($bankData);//die;
                $bank_update = $this->common_model->add_data('bank_details', $bankData);
            } 
            //die(); 
            
            if ($user_update > 0  || $bank_update > 0 ) {
                if ($status == 2) {
                    $msg = 'Approved KYC';
                } elseif ($status == 3) {
                    $msg = 'Reject KYC';
                } else {
                    $msg = '';
                }
                if ($_POST['type'] == 1) {
                    echo json_encode(array('status' => 1, 'message' => "User " . $msg . " Successfully")); die();
                } else {
                    $this->session->set_flashdata('success', "User " . $msg . " Successfully."); 
                    echo json_encode(array('status' => 1)); die();
                }
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.')); die();
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    public function user_data()
    {
        die; //print_r($_POST);
    }
    public function searchusername() 
    {
        $username = trim((isset($_POST['username']) ? $_POST['username'] : ''));
        if (!empty($_POST['type']) && isset($_POST['type'])) {
            $result = $this->user_model->user_data($username, '');
            echo json_encode($result);
        } else {
            $result = $this->user_model->user_data($username, $this->uid);
            echo json_encode($result);
        }
    }
    
    // public function reg_searchusername() 
    // {
    //     //$ref_id = trim((isset($_POST['ref_id']) ? $_POST['ref_id'] : 'DSG983508'));
    //     $ref_id = 'DSG983508';
    //         $result1 = $this->user_model->reg_user_data($ref_id);
    //         echo json_encode($result1);
    //         die();
    // }
    public function change_primary()
    {
        try {
            //print_r($_POST['type']);die;
            $userid = $this->uid;
            $type = $_POST['type'];
            $isactivestats = 2;
            $primaryset = '';
            if (isset($_POST['mode']) && $_POST['mode'] == 1) {
                $isactivestats = 1;
            }
            $where = array('user_id' => $userid);
            if ($type == 2) {
                //$detype = $type;
                $primaryset = $this->common_model->update_data('members', array('default_payment_mode' => $isactivestats), array('id' => $userid));
            } else {
                $primaryset = $this->common_model->update_data('bank_details', array('isactive' => $isactivestats), array('user_id' => $userid, 'type' => $type));
            }
            //$this->common_model->update_data('bank_details',array('isactive'=>1),array('user_id'=>$userid,'type !='=>$type));
            if ($primaryset > 0) {
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function get_banksdata()
    {
        try {
            $userid = $this->uid;
            $type = $_POST['type'];
            $where = array('user_id' => $userid);
            $banks_dels = $this->common_model->get_data('bank_details', 'and user_id=' . $this->uid . ' and type= ' . $type . '', '', 1);
            if (!empty($banks_dels)) {
                $bankid = $banks_dels['id'];
                $this->common_model->update_data('bank_details', array('isactive' => 2), array('id' => $bankid));
                echo json_encode(array('banksno' => 1));
            } else {
                echo json_encode(array('banksno' => 0));
            }
            //print_r($banks_dels);die;
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function change_primary_bank()
    {
        try {
            $userid = $this->uid;
            $type = $_POST['type'];
            $bankid = $_POST['bankref'];
            $where = array('user_id' => $userid);
            $unset_update = $this->common_model->update_data('bank_details', array('is_default' => 0), $where);
            $primaryset = $this->common_model->update_data('bank_details', array('is_default' => 1), array('user_id' => $userid, 'type' => $type, 'id' => $bankid));
            if ($primaryset > 0) {
                echo json_encode(array('status' => 1, 'ref' => $bankid));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    public function add_newfaq()
    {
        try {
            $data = $this->input->post();
            //print_r($data);die;
            if (isset($data) && !empty($data)) {
                if (isset($data['faq_ref']) && !empty($data['faq_ref'])) {
                    $faq_id = $data['faq_ref'];
                    unset($data['faq_ref']);
                    $faq_update = $this->common_model->update_data('faq', $data, array('id' => $faq_id));
                    if ($faq_update > 0) {
                        $this->session->set_flashdata('success', "FAQ Updated successfully");
                        redirect(base_url('admin/faq'));
                    } else {
                        $this->session->set_flashdata('error', "Something went wrong.");
                        redirect(base_url('admin/faq'));
                    }
                } else {
                    $faq = $this->user_model->insert_data('faq', $data);
                    if ($faq > 0) {
                        $this->session->set_flashdata('success', "FAQ added successfully");
                        redirect(base_url('admin/faq'));
                    } else {
                        $this->session->set_flashdata('error', "Something went wrong.");
                        redirect(base_url('admin/faq'));
                    }
                }
            } else {
                $this->session->set_flashdata('error', "Something went wrong.");
                redirect(base_url('admin/faq'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function change_faq_status()
    {
        try {
            $rowvalue = $_POST['values'];
            $status = $_POST['ref'];
            $msg = '';
            $faq_update = $this->common_model->update_status('faq', $rowvalue, array('isactive' => $status));
            if ($faq_update > 0) {
                if ($status == 1) {
                    $msg = 'Activate';
                } elseif ($status == 0) {
                    $msg = 'Deactivate';
                } else {
                    $msg = '';
                }
                echo json_encode(array('status' => 1, 'message' => "FAQ " . $msg . " Successfully"));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function delete_faq()
    {
        try {
            $rowvalue = $_POST['values'];
            $required = 'and id=' . $rowvalue . '';
            $deletefaq = $this->common_model->delete_data('faq', $required);
            if ($deletefaq > 0) {
                echo json_encode(array('status' => 1));
                $this->session->set_flashdata('success', "FAQ Delete successfully");
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function show_notification()
    {
        try {
            if (!empty($_POST['ref'])) {
                $newview = '';
                $alert_details = $this->common_model->get_data('notification nf', 'and nf.id=' . $_POST['ref'] . '', 'nf.user_id,nf.image as upimage,nf.subject,nf.notification_message,nf.view_user_id,me.image,me.path', '1', 'left join media as me on nf.image = me.id');
                $alertview = $alert_details['view_user_id'];
                if (!empty($alertview) && $alertview != '') {
                    if (strpos($alertview, $this->uid) === false) {
                        $newview = $alertview . ',' . $this->uid;
                        $this->common_model->update_data('notification', array('view_user_id' => $newview), array('id' => $_POST['ref']));
                    }
                } else {
                    $newview = $this->uid;
                    $this->common_model->update_data('notification', array('view_user_id' => $newview), array('id' => $_POST['ref']));
                }
                $unread = count($this->user_model->get_alertdata($this->uid, '', '', '', 1));
                echo json_encode(array('status' => 1, 'data' => $alert_details, 'unread' => $unread));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function delete_notification()
    {
        try {
            if (!empty($_POST['ref'])) {
                $newview = '';
                $alert_details = $this->common_model->get_data('notification nf', 'and nf.id=' . $_POST['ref'] . '', 'nf.user_id,nf.image as upimage,nf.subject,nf.notification_message,nf.view_user_id,nf.delete_user_id,me.image,me.path', '1', 'left join media as me on nf.image = me.id');
                $alertview = $alert_details['delete_user_id'];
                if (!empty($alertview) && $alertview != '') {
                    if (strpos($alertview, $this->uid) === false) {
                        $newview = $alertview . ',' . $this->uid;
                        $this->common_model->update_data('notification', array('delete_user_id' => $newview), array('id' => $_POST['ref']));
                    }
                } else {
                    $newview = $this->uid;
                    $this->common_model->update_data('notification', array('delete_user_id' => $newview), array('id' => $_POST['ref']));
                }
                $this->session->set_flashdata('success', "Notification Delete Successfully.");
                echo json_encode(array('status' => 1, 'url' => base_url() . 'user/alerts', 'message' => 'Notification Deleted Successfully.'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    
    // vikash delete notification by admin
    
    public function delete_notification_admin()
    {
        try {
            if (!empty($_POST['ref'])) {
                
                $this->common_model->update_data('notification', array('status' => 3), array('id' => $_POST['ref']));
               
                $this->session->set_flashdata('success', "Notification Delete Successfully.");
                echo json_encode(array('status' => 1, 'url' => base_url() . 'apcompundpower/notificationlist', 'message' => 'Notification Deleted Successfully.'));
            } else {
                echo json_encode(array('status' => 0, 'message' => 'Something went wrong.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    
    
    
    
    // vikash for bank update otp 
    
    public function send_bank_update_otp()
    {
        $otpToken = random_string('numeric', 6);
        $userid = $this->encryption->decrypt($this->session->userdata('u_id'));
        $getphone = $this->user_model->user_details('members', 'phone,email', $userid);
        if ($getphone) {
            //$sms          = $this->sendsms($getphone[0]->phone,$otpToken);
            $subject = 'bank_update_token OTP Email';
            $data['otp'] = $otpToken;
        //    $body = $this->load->view('templates/otp.php', $data, true);
        //   $mail = $this->mailsend($getphone[0]->email, 'User', $subject, $body, "no-reply" . host, "easyplay11.com");
            
            $mobile = $getphone[0]->phone;
            
            $welcome_msg="Dear Player, Your OTP for Update Bank Deatils is ". $otpToken ." Thanks! ";
            $sms = $this->sendsms($mobile, $welcome_msg);
            if ($sms) {
                $dpupdate = $this->user_model->updateInfor('members', array('bank_update_token' => $otpToken), 'id', $userid);
                if ($dpupdate) {
                    echo json_encode(array('status' => '1', 'message' => 'OTP Send Successfully at Your registered Mobile Number.'));
                } else {
                    echo json_encode(array('status' => '0', 'message' => 'There is some issue in Update OTP.'));
                }
            } else {
                echo json_encode(array('status' => '0', 'message' => 'There is some issue in Send OTP.'));
            }
        } else {
            echo json_encode(array('status' => '0', 'message' => 'There is some issue in User Details OTP.'));
        }
    }
    public function check_bank_update_otp()
    {
        //echo '<pre>';print_r($_POST['wallet_otp']);die;
        if (isset($_POST['bank_update_token'])) {
            $rqbank_otp = trim($_POST['bank_update_token']);
            $userid = $this->encryption->decrypt($this->session->userdata('u_id'));
            $getotp = $this->user_model->user_details('members', 'phone,email,bank_update_token', $userid);
            $dbbank_otp = $getotp[0]->bank_update_token;
            if ($rqbank_otp === $dbbank_otp) {
                echo json_encode(array('status' => '1'));
            } else {
                echo json_encode(array('status' => '400', 'message' => 'OTP is Not Valid.'));
            }
        } else {
            echo json_encode(array('status' => '0', 'message' => 'OTP is Not allowed to empty.'));
        }
    }
    
    
    
    // vikash for bank update opt end
    
    
     public function sendsms($number = "", $otp = "")
    {
        $resp = '';
        $curl_handle = curl_init();
        $text = urlencode($otp);
        //$url = 'http://103.27.87.89/send.php?usr=1026&pwd=Pixel@153&ph=' . trim($number) . '&sndr=Cpower&text=' . $text;
        
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        if (empty($buffer)) {
            //print "Nothing returned from url.<p>";
            $resp = false;
        } else {
            //print $buffer;
            $resp = true;
        }
        return $resp;
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
    //close class
    
    
    // pincode data fetch from api 
    public function pincode_data(){
        $name_city = rawurlencode($_POST['pincode']);
        $url = "https://api.postalpincode.in/pincode/".$name_city;
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,"$url");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        $postoffice_data = curl_exec($curl_handle);
        curl_close($curl_handle); 
        $postoffice_data = json_decode($postoffice_data);
        echo json_encode($postoffice_data);
        exit;
            
    } 
    
     // ifsc data fetch from api 
    public function ifsc_data(){
        $name_city = rawurlencode($_POST['ifsc']);
        $url = "https://ifsc.razorpay.com/".$name_city;
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,"$url");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        $postoffice_data = curl_exec($curl_handle);
        curl_close($curl_handle); 
        $postoffice_data = json_decode($postoffice_data);
        echo json_encode($postoffice_data);
        exit;
            
    } 
    
}
