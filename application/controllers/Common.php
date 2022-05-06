<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common extends CI_Controller
{
    public $uid;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model', 'common_model', 'admin_modal', 'notificationmodel'));
        $this->load->helper(array('url', 'date', 'form', 'string', 'comman_helper'));
        $this->load->library(array('email', 'javascript', 'session', 'upload', 'My_PHPMailer', 'encryption'));

        date_default_timezone_set('Asia/Kolkata');

        if (!empty($this->session->userdata('admin_logged_in')) && $this->session->userdata('admin_logged_in') == true) {
            $user_id = 0;
        } else if (!empty($this->session->userdata['u_id'])) {
            $user_id = $this->encryption->decrypt($this->session->userdata['u_id']);
        } else {
            redirect(base_url('diesel-master'));
        }
    }

    public function index()
    { }
    
    public function MyWallet($user_id)
    {
        $amount = $this->user_model->amountWalletOnly($user_id);
        if (!empty($amount)) {
            // return $data->amount;
            return $amount;
        } else {
            //$wallet = $this->user_model->MyWallet ($user_id)->m_wallet;
            $this->common_model->add_data('my_wallet', array('user_id' => $user_id, 'amount' => '0.00'));
            return $this->MyWallet($user_id);
        }
    }
   

    public function searchusername()
    {
        ini_set('memory_limit', '-1');
        $html = '';
        $username = trim($_POST['username']);
        $and = "";
        if (!empty($this->session->userdata['u_id'])) {
            $and = " AND m.id !=" . $this->encryption->decrypt($this->session->userdata['u_id']);
        }
        $query = "SELECT m.id,m.username,ui.f_name as name
        		FROM users m
        		left join user_information ui on m.id = ui.user_id
        		where m.isactive=1 AND (m.username LIKE '$username%' OR ui.f_name LIKE '$username%')" . $and;

        $result = $this->common_model->exec_query($query, 'full');
        if (!empty($result)) {
            $html = '<optgroup><option></option>';
            foreach ($result as $rec) {
                $html .= '<option value="' . $rec['id'] . '">' . $rec['name'] . '( ' . $rec['username'] . ' )</option>';
            }
            $html .= '</optgroup>';
        } else {
            $html = '<option value="">No Record Found</option>';
        }
        echo $html;
        die;
    }

   

    public function updatekyc()
    {
        try {
           // echo '<pre>';print_r($_POST);die;
            $kycarr = array();
            $message = '';
            if ($_POST['type'] == '1') {
                $kdata['doc'] = 'National ID';
                $kycarr['national_id_status'] = $_POST["val"];
                if ($_POST["val"] == 2) {
                    $message = 'National ID Accepted Successfully.';
                  //  $body = $this->load->view('templates/kyc_accept.php', $kdata, true);
                } else {
                    $message = 'National ID Rejected Successfully.';
                 //   $body = $this->load->view('templates/kyc_reject.php', $kdata, true);
                    if (isset($_POST["reject_remark"])) {
                        $kycarr['nid_remarks'] = trim($_POST["reject_remark"]);
                    }
                }
                $kycupdate = $this->user_model->updateInforkyc('kyc', $kycarr, 'user_id', $_POST['ref']);
            }
            if ($_POST['type'] == '2') {
                $kdata['doc'] = 'Address Proof';
                $kycarr['address_id_status'] = $_POST["val"];
                if ($_POST["val"] == 2) {
                    $message = 'Address Proof Accepted Successfully.';
                  //  $body = $this->load->view('templates/kyc_accept.php', $kdata, true);
                } else {
                    $message = 'Address Proof Rejected Successfully.';
                  //  $body = $this->load->view('templates/kyc_reject.php', $kdata, true);
                    if (isset($_POST["reject_remark"])) {
                        $kycarr['ap_remarks'] = trim($_POST["reject_remark"]);
                    }
                }
                $kycupdate = $this->user_model->updateInforkyc('kyc', $kycarr, 'user_id', $_POST['ref']);
            }
            if ($_POST['type'] == '3') {
                $kdata['doc'] = 'National ID';
             //   $kycarr['isactive'] = $_POST["val"];
                
                $kycarr['national_id_status'] = $_POST["val"];
                if ($_POST["val"] == 2) {
                    $message = 'National ID Accepted Successfully.';
                    //$body = $this->load->view('templates/kyc_accept.php', $kdata, true);
                } else {
                    $message = 'National ID Rejected Successfully.';
                   // $body = $this->load->view('templates/kyc_reject.php', $kdata, true);
                    if (isset($_POST["reject_remark"])) {
                        $kycarr['nid_remarks'] = trim($_POST["reject_remark"]);
                    }
                }
             //   $kycupdate = $this->user_model->updateInfor('bank_details', $kycarr, 'user_id', $_POST['ref']);
                $kycupdate = $this->user_model->updateInforkyc('kyc', $kycarr, 'user_id', $_POST['ref']);
            }

            if ($_POST['type'] == '4') {
                $kdata['doc'] = 'Pancard';
                $kycarr['pancard_status'] = $_POST["val"];
                if ($_POST["val"] == 2) {
                    $message = 'Pancard Details Accepted Successfully.';
                  //  $body = $this->load->view('templates/kyc_accept.php', $kdata, true);
                } else {
                    $message = 'Pancard Details Rejected Successfully.';
                  //  $body = $this->load->view('templates/kyc_reject.php', $kdata, true);
                    if (isset($_POST["reject_remark"])) {
                        $kycarr['pan_remarks'] = trim($_POST["reject_remark"]);
                    }
                }
                $kycupdate = $this->user_model->updateInforkyc('kyc', $kycarr, 'user_id', $_POST['ref']);
            }

            if ($_POST['type'] == '5') {
                $kdata['doc'] = 'Bank Proof';
                $kycarr['isactive'] = $_POST["val"];
                if ($_POST["val"] == 2) {
                    $message = 'Bank Proof Accepted Successfully.';
                  //  $body = $this->load->view('templates/kyc_accept.php', $kdata, true);
                } else {
                    $message = 'Bank Proof Rejected Successfully.';
                  //  $body = $this->load->view('templates/kyc_reject.php', $kdata, true);
                    if (isset($_POST["reject_remark"])) {
                        $kycarr['nid_remarks'] = trim($_POST["reject_remark"]);
                    }
                }
                   $kycupdate = $this->user_model->updateInforkyc('bank_details', $kycarr, 'user_id', $_POST['ref']);
            }

            if ($kycupdate > 0) {
                $subject = 'KYC Status Email';
                $user = $this->common_model->get_data("users", " AND id='" . $_POST['ref'] . "' and isactive=1", "email", "1");
          
                echo json_encode(array('status' => '1', 'message' => $message, 'type' => $_POST['type'], 'action' => $_POST['val']));
            } else {
                echo json_encode(array('status' => '0', 'message' => 'There is some issue to update KYC details.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function updateusrprofile()
    {
        try {
            $detailsarr = array('first_name' => $_POST['ufname'],'last_name' => $_POST['ulname'], 'address' => $_POST['uaddress'], 'city' => $_POST['ucity']);

            // $member_table = array(/*'username' => $_POST['username'],*/'email' => $_POST['email'], 'phone' => $_POST['phone']);
            $member_table = array('first_name' => $_POST['ufname'],'last_name' => $_POST['ulname'],  'password_text' => $_POST['upassword_text'], 'password' => md5($_POST['upassword_text']),'email' => $_POST['email'], 'phone' => $_POST['phone']);
            
            $profileupdate = $this->user_model->updateInfor('user_information', $detailsarr, 'user_id', $_POST['ref']);

            $member_table = $this->user_model->updateInfor('users', $member_table, 'id', $_POST['ref']);

            if ($profileupdate > 0) {
                echo json_encode(array('status' => '1', 'message' => 'User Information update Successfully.'));
            } else {
                echo json_encode(array('status' => '0', 'message' => 'There is some issue to update User Information.'));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
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
                redirect('apcompundpower/notificationlist');
            } else {
                $error_msg = 'Some thing went wrong!!';
                $this->session->set_flashdata('error', 'Something went wrong.');
                redirect('apcompundpower/notifications');
                //echo "<script>window.history.back();</script>";
            }
        } else {
            $this->session->set_flashdata('error', 'Bad request.');
            redirect('apcompundpower/notifications');
        }
    }

   

    // class closing..
}
