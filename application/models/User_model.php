<?php
set_time_limit(3000);
error_reporting(0);
ini_set('display_errors', 0);
class user_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->model(array('common_model', 'admin_modal'));
    }
    public function testme()
    {
        //test any query..
    }
    public function get_data($table = "", $and = "", $columns = "*", $return_arr = "full", $join = "")
    {
        $columns = ($columns == "" ? "*" : $columns);
        $sql = "SELECT " . $columns . " FROM " . $table . " " . $join . " WHERE 1=1" . " " . $and;
        $query = $this->db->query($sql);
        if ($return_arr == "full") {
            return $query->result_array();
        } else {
            return $query->row_array();
        }
    }
	
	
	
	public function User_profile($id)
    {                                                                                                                                                                              //  IFNULL(CONCAT("'. base_url().'",CONCAT("uploads/profile-pic/",ui.profile_pic)),"")
        $this->db->select('m.id,m.email,m.emp_id,m.phone,ui.first_name as first_name,ui.last_name as last_name,CONCAT_WS(" ", ui.first_name, ui.last_name) as name,ui.dob, (CASE WHEN ui.profile_pic =" " THEN "" ELSE CONCAT("'. base_url().'",CONCAT("uploads/profile-pic/",ui.profile_pic)) END ) as profile_pic,ui.address,ui.city,ui.hobbies,ui.family_information');
        $this->db->from('users m');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'left');

    //    $this->db->join('kyc', 'm.id = kyc.user_id', 'left');
      
        $this->db->where('m.id=', $id);
        $query = $this->db->get();
        return $query->row();
    }
	
	 public function UserInfo($user_id)
    {
        $this->db->select('m.id,m.ref_id,m.email,m.bit_address,m.username,m.designation,ui.f_name,CONCAT_WS(" ", ui.f_name, ui.l_name) as name,m.phone,ui.address,ui.city');
        $this->db->from('members m');
        $this->db->join('user_information ui', 'm.id = ui.user_id', 'LEFT');
        $this->db->where(array('m.id' => $user_id));
        $query = $this->db->get();
        return $query->row_array();
    }
    public function UserDetail($user_id)
    {
        $this->db->select('m.id,m.email,m.emp_id,m.password_text,ui.first_name,ui.last_name,ui.dob,CONCAT_WS(" ", ui.first_name, ui.last_name) as name,m.phone,ui.address,ui.city');
        $this->db->from('users m');
        $this->db->join('user_information ui', 'm.id = ui.user_id', 'LEFT');
     //   $this->db->join('countries', 'ui.country_id = countries.id', 'LEFT');
     //   $this->db->join('kyc', 'm.id = kyc.user_id', 'LEFT');
     //   $this->db->join('designation dd', 'm.designation = dd.id', 'LEFT');
     //   $this->db->join('media md', 'md.id = kyc.address_id', 'LEFT');
     //   $this->db->join('media md1', 'md1.id = kyc.national_id', 'LEFT');
     //   $this->db->join('media md2', 'md2.id = m.profile_pic', 'LEFT');
     //   $this->db->join('media md3', 'md3.id = kyc.pancard', 'LEFT');
        $this->db->join('bank_details bd', 'bd.user_id = m.id', 'LEFT');
        $this->db->where(array('m.id' => $user_id));
        $query = $this->db->get();
        return $query->row_array();
    }
	
	
	
	 public function leads_tilldate($user_id = 0)
    {
        $credit = $this->db->select('*')->from('leads')->where('user_id="' . $user_id . '" AND isactive=1')->get()->result_array();
        return $credit;
    }
	
	 public function leads_inprocess($user_id = 0)
    {
        $credit = $this->db->select('*')->from('leads')->where('user_id="' . $user_id . '" AND status=0 AND isactive=1')->get()->result_array();
        
        return $credit;
    }
	
		 public function leads_success($user_id = 0)
    {
        $credit = $this->db->select('*')->from('leads')->where('user_id="' . $user_id . '" AND status=1 AND isactive=1')->get()->result_array();
       return $credit;
    }
    
    	 public function leads_cancelled($user_id = 0)
    {
        $credit = $this->db->select('*')->from('leads')->where('user_id="' . $user_id . '" AND status=2 AND isactive=1')->get()->result_array();
        return $credit;
    }
	
	
	
	 public function reward_earned($user_id = 0)
    {
        $credit = $this->db->select('sum(reward_point) as totalCredit')->from('rewards')->where('user_id="' . $user_id . '" AND profit_type=1 AND isactive=1')->get()->result();
        #$debit = $this->db->select('sum(amount) as totalDebit')->from('accounts')->where('user_id="' . $user_id . '" AND type=2 AND mode=2 AND profit_type=2 AND status=0 AND isactive=1')->get()->result();
        #$walletBalance = $credit[0]->totalCredit - $debit[0]->totalDebit;
        $walletBalance = $credit[0]->totalCredit;
        $walletBalance = number_format($walletBalance, 2, '.', '');
        return $walletBalance;
    }
	
	 public function reward_transferred($user_id = 0)
    {
        $credit = $this->db->select('sum(reward_point) as totalCredit')->from('rewards')->where('user_id="' . $user_id . '" AND profit_type=2 AND isactive=1')->get()->result();
        #$debit = $this->db->select('sum(amount) as totalDebit')->from('accounts')->where('user_id="' . $user_id . '" AND type=2 AND mode=2 AND profit_type=2 AND status=0 AND isactive=1')->get()->result();
        #$walletBalance = $credit[0]->totalCredit - $debit[0]->totalDebit;
        $walletBalance = $credit[0]->totalCredit;
        $walletBalance = number_format($walletBalance, 2, '.', '');
        return $walletBalance;
    }
	
		 public function reward_pending($user_id = 0)
    {
        $credit = $this->db->select('sum(reward_point) as totalCredit')->from('rewards')->where('user_id="' . $user_id . '" AND profit_type=3 AND isactive=1')->get()->result();
        #$debit = $this->db->select('sum(amount) as totalDebit')->from('accounts')->where('user_id="' . $user_id . '" AND type=2 AND mode=2 AND profit_type=2 AND status=0 AND isactive=1')->get()->result();
        #$walletBalance = $credit[0]->totalCredit - $debit[0]->totalDebit;
        $walletBalance = $credit[0]->totalCredit;
        $walletBalance = number_format($walletBalance, 2, '.', '');
        return $walletBalance;
    }
    
    	 public function reward_inprocess($user_id = 0)
    {
        $credit = $this->db->select('sum(reward_point) as totalCredit')->from('rewards')->where('user_id="' . $user_id . '" AND profit_type=4 AND isactive=1')->get()->result();
        #$debit = $this->db->select('sum(amount) as totalDebit')->from('accounts')->where('user_id="' . $user_id . '" AND type=2 AND mode=2 AND profit_type=2 AND status=0 AND isactive=1')->get()->result();
        #$walletBalance = $credit[0]->totalCredit - $debit[0]->totalDebit;
        $walletBalance = $credit[0]->totalCredit;
        $walletBalance = number_format($walletBalance, 2, '.', '');
        return $walletBalance;
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/////////////////
	
	
	
	public function earningTotalEarnedOnlyBal($user_id = 0)
    {
        // $this->db->select('a.id,a.user_id,sum(a.amount) as amount, bd.name_in_bank, bd.bank_name, bd.branch_address, bd.account_number, bd.ifsc_code');
        // $this->db->from('accounts a');
        // $this->db->join('bank_details bd', 'bd.user_id=a.user_id', 'LEFT');
        // // $array = array('a.profit_type' => 1, 'a.profit_type' => 2, 'a.profit_type' => 3);
        // #$this->db->where(['a.user_id' => $this->id, 'a.status' => 0, 'a.profit_type'=>1 ]);
        // $this->db->where('a.user_id=' . $this->id . ' AND a.status=0 AND a.profit_type IN (1,2,3,9,10)');
        // $user = $this->db->get()->result();
        // $user = $user[0];
        // #echo "<pre>";print_r($user);#die;
        // $amount = $user->amount;
        // return $amount;
        #$colums = 'SUM( IF(a.payment_via !=1, round(IF(a.type = 1 AND a.status = 0, a.amount, 0) - IF(a.type = 2 AND a.status != 0, a.amount, 0), 2), 0) ) AS balance';
        $colums = 'SUM( round(IF(a.type = 1 AND a.status = 0 AND profit_type IN (1,2,3,9,10,21,19,32), a.amount, 0) - IF(a.type = 2 AND a.status != 0 AND profit_type IN (0), a.amount, 0), 5) ) AS balance';
        $this->db->select($colums);
        $this->db->from('(SELECT @b := 0.0) AS dummy CROSS JOIN accounts a');
        $this->db->where(['a.user_id' => $user_id]);
        $this->db->where(['a.status!=' => 1]);
        #$this->db->where(['a.payment_via!=' => 1]); # 1 bitcoin
        $this->db->order_by('a.created_date', 'ASC');
        $query = $this->db->get();
        $res = $query->row_array();
        #echo $this->db->last_query();die;
        $walletBalance = isset($res['balance']) ? $res['balance'] : 0;
        #$walletBalance = number_format($walletBalance, 2, '.', '');
        return $walletBalance;
    }
	
	
	/////////////////////////////////////
	
	
	
	
	
	
	
	
    public function purchase()
    {
        $this->db->select('*');
        $this->db->from('packages_purchase');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function register_user($data)
    {
        $this->db->insert('members', $data);
        return $this->db->insert_id();
    }
    public function update_my_data($table, $data, $where_array)
    {
        $this->db->where($where_array);
        return $this->db->update($table, $data);
    }
    public function insert_data($table = '', $datarr = '')
    {
        $this->db->trans_start();
        $this->db->insert($table, $datarr);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function user_login($username, $required)
    {
        $this->db->select($required);
        $this->db->from('members');
        //$this->db->where(array('email' => $email OR 'phone' => $email ));
        //$this->db->where("(email = '" . $email . "' OR phone = '" . $email . "')");
        $this->db->where('username', $username);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // die();
        return $query->row_array();
    }
    public function insert_data_mul($table = "", $data = "", $type = "")
    {
        if ($type == "multiple") {
            $this->db->insert_batch($table, $data);
        } else {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }
    }
    public function update_data($table = "", $data = "", $where_array = "", $type = "", $field = "")
    {
        if ($type == "multiple") {
            return $this->db->update_batch($table, $data, $field);
        } else {
            $this->db->where($where_array);
            return $this->db->update($table, $data);
        }
    }
    public function updateInfo($table = '', $updateinfo = '', $userId = '', $updatedate = '')
    {
        if (!empty($updatedate)) {
            #$this->db->set('created_date', 'NOW()', FALSE);
            $this->db->set('modified_date', 'NOW()', false);
        }
        if ($userId != '') {
            $this->db->where('id', $userId);
        }
        $this->db->update($table, $updateinfo);
        return 1 ;
    }
    public function updateInfor($table = '', $updateinfo = '', $columnname = '', $columnval = '')
    {
        $this->db->where($columnname, $columnval);
        $this->db->update($table, $updateinfo);
        return true;
    }
    
    // vikash
    
    public function updateInforkyc($table = '', $updateinfo = '', $columnname = '', $columnval = '')
    {
        $this->db->where($columnname, $columnval);
        $this->db->order_by('id', 'DESC');
        $this->db->limit('1');
        $this->db->update($table, $updateinfo);
        return true;
    }
    
    public function updateInfor1($table = '', $updateinfo = '')
    {
        $this->db->update($table, $updateinfo);
        return true;
    }
    public function updateUserInfo($table = '', $updateinfo = '', $where_array = "")
    {
        $this->db->where($where_array);
        $this->db->update($table, $updateinfo);
        return true;
    }
    // public function update_data($table = "", $data = "", $where_array = "", $type = "", $field = "")
    // {
    // if ($type == "multiple") {
    // return $this->db->update_batch($table, $data, $field);
    // } else {
    // $this->db->where($where_array);
    // return $this->db->update($table, $data);
    // }
    // }
    public function checkDuplicate_dels($table = '', $selectfld = '', $email = '', $username = '', $token = '', $userid = '', $password = '', $refferal = '', $phone = '')
    {
        //print_r($email.'  '.$password);
        $this->db->select($selectfld);
        $this->db->from($table);
        if ($username != '') {
            $this->db->where('members.username=', $username);
        }
        if ($token != '') {
            $this->db->where('members.email_token=', $token);
        }
        if ($userid != '') {
            $this->db->where('members.id=', $userid);
            $this->db->where('members.isactive=', 0);
        }
        if ($password != '') {
            $this->db->join('user_information', 'user_information.user_id = ' . $table . '.id', 'left');
            $this->db->where('password=', $password);
        }
        if ($email != '') {
            $this->db->where('members.email=', $email);
        }
        if ($refferal != '') {
            #$this->db->where('members.phone=', $refferal);
            $this->db->where('members.username=', $refferal);
            //$this->db->or_where('username=', $refferal);
            #$this->db->where('members.paid_status=', 1);
        }
        if ($phone != '') {
            $this->db->where('members.phone=', $phone);
        }
        //print_r( $this->db );die;
        $query = $this->db->get();
        $res = $query->result();
        #echo $this->db->last_query();die();
        return $res;
    }
    
    #monika(working)
    public function checkDuplicate_dels_paid($table = '', $selectfld = '', $email = '', $username = '', $token = '', $userid = '', $password = '', $refferal = '', $phone = '')
    {
        //print_r($email.'  '.$password);
        $this->db->select($selectfld);
        $this->db->from($table);
        if ($username != '') {
            $this->db->where('members.username=', $username);
        }
        if ($token != '') {
            $this->db->where('members.email_token=', $token);
        }
        if ($userid != '') {
            $this->db->where('members.id=', $userid);
            $this->db->where('members.isactive=', 0);
        }
        if ($password != '') {
            $this->db->join('user_information', 'user_information.user_id = ' . $table . '.id', 'left');
            $this->db->where('password=', $password);
        }
        if ($email != '') {
            $this->db->where('members.email=', $email);
        }
        if ($refferal != '') {
            #$this->db->where('members.phone=', $refferal);
            $this->db->where('members.username=', $refferal);
            //$this->db->or_where('username=', $refferal);
             $this->db->where('members.paid_status=', 1);                                                        #monika(comment)
        }
        if ($phone != '') {
            $this->db->where('members.phone=', $phone);
        }
        //print_r( $this->db );die;
        $query = $this->db->get();
        $res = $query->result();
        #echo $this->db->last_query();die();
        return $res;
    }
    
    public function get_countries($table = '', $selectfld = '', $isactive = '')
    {
        $this->db->select($selectfld);
        $this->db->from($table);
        if ($isactive != '') {
            $this->db->where('isactive=', $isactive);
        }
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function chkDuplicat_account($table = '', $selectfld = '', $account = '')
    {
        $this->db->select($selectfld);
        $this->db->from($table);
        if ($account != '') {
            $this->db->where('account_number=', $account);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function chkDuplicat_ecash_request($table = '', $selectfld = '', $account = '')
    {
        $this->db->select($selectfld);
        $this->db->from($table);
        if ($account != '') {
            $this->db->where('txn_no=', $account);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function user_details($table = '', $selectfld = '', $userid = '')
    {
        $this->db->select($selectfld);
        $this->db->from($table);
        if ($userid != '') {
            $this->db->where('id=', $userid);
        }
        $query = $this->db->get();
        $this->db->order_by('id', 'ASC');
        return $query->result();
    }
    public function get_kyc($table = '', $selectfld = '', $userid = '')
    {
        $this->db->select($selectfld);
        $this->db->from($table);
        if ($userid != '') {
            $this->db->where('user_id=', $userid);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function UserProfile($id)
    {
        $this->db->select('m.id,m.bit_address,m.ref_id,CONCAT(imgdp.path,imgdp.image) as profile_pic,CONCAT(imgdp.path,imgdp.img_thumb) as profile_pic_thumb,imgdp.path as profile_pic_path,m.email,m.username,m.default_payment_mode,ui.gender,m.role,m.phone,m.country_code,ui.f_name as first_name,ui.l_name as last_name,CONCAT_WS(" ", ui.f_name, ui.l_name) as name,ui.f_name,ui.country_id,ui.l_name,ui.dob,ui.address,ui.city,ui.state,ui.district,ui.aadhar_no,ui.zip_code,ui.pancard_no,c.title as country,c.std_code as phonecode,img.image as address_id,img.path as address_id_path,img.img_thumb as address_thumb,im.image as national_id,im.img_thumb as national_thumb,im.path as national_id_path,kyc.address_id_status,kyc.national_id_status,IFNULL(w.amount,0.00) as wallet, pp.active_date');
        $this->db->from('members m');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'left');
        $this->db->join('countries c', 'ui.country_id = c.id', 'left');
        $this->db->join('kyc', 'm.id = kyc.user_id', 'left');
        $this->db->join('media imgdp', 'm.profile_pic = imgdp.id', 'left');
        $this->db->join('media img', 'kyc.address_id = img.id', 'left');
        $this->db->join('media im', 'kyc.national_id = im.id', 'left');
        $this->db->join('my_wallet w', 'm.id = w.user_id', 'left');
        $this->db->join('packages_purchase pp', 'm.id = pp.user_id', 'left');
        $this->db->where('m.id=', $id);
        $query = $this->db->get();
        return $query->row();
    }
    // public function cool_period($id)
    // {
    // $this->db->select('nf.id,nf.user_id,nf.subject,nf.view_user_id,nf.delete_user_id,LEFT(notification_message, 40) as body,nf.create_date,CONCAT(me.path,me.image) as image');
    // $this->db->from('notification nf');
    // $this->db->join('members m', 'm.id = a.user_id');
    // $this->db->group_by('a.user_id');
    // $this->db->where('a.profit_type=', 1);
    // $query = $this->db->get();
    // return $query->result_array();
    // }
    public function level_earning($id)
    {
        $this->db->select('sum(a.amount) as total_earning , count(a.user_id) as total_users,m.level as level');
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id');
        $this->db->group_by('a.user_id');
        $this->db->where('a.profit_type=', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
   
    public function CheckBankCount($user_id)
    {
        $this->db->select('(CASE WHEN COUNT(id) >=3 THEN 0 ELSE 1 END) as bank');
        $this->db->from('bank_details');
        $this->db->where('user_id=', $user_id);
        $query = $this->db->get();
        return $query->row();
        //SELECT (CASE WHEN COUNT(id) >=3 THEN 0 ELSE 1 END) as bank FROM `bank_details` WHERE user_id = 8
    }
    public function MyTickets($user_id = '', $count = "", $rowno = "", $rowperpage = "", $search = "", $status = "")
    {
        $this->db->select('t.id, LEFT(t.subject, 40)  as subject,t.status,t.created_date,t.modified_date,t.isactive,t.ticket_no,CONCAT_WS(" ", ui.first_name, ui.last_name) as name,u.email,u.emp_id as username,LEFT(t.body, 150) as msg,u.phone');
        $this->db->from('tickets t');
        $this->db->join('users u', 't.user_id = u.id', 'LEFT');
        $this->db->join('user_information ui', 't.user_id = ui.user_id', 'left');
    //    $this->db->join('department  d', 't.department = d.id', 'left');
        if ($user_id != '') {
            $this->db->where('t.user_id=', $user_id);
            if ($status == 'active') {
                //$this->db->where('t.status<>', 2);
                $this->db->where('t.isactive=', 1);
            } elseif ($status == 'resolved') {
                $this->db->where('t.status=', 2);
                $this->db->where('t.isactive=', 0);
            } else { }
        }
        $this->db->where('t.ref_id=', 0);
        if (!empty($search)) {
            if (!empty($search['condition'])) {
                $search['condition'] = $search['condition'] == 3 ? 0 : $search['condition'];
                $this->db->where('t.status =', $search['condition']);
            }
            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'username') {
                    $this->db->like('u.emp_id', $search['query']);
                } elseif ($search['search_by'] == 'email') {
                    $this->db->like('u.email', $search['query']);
                } elseif ($search['search_by'] == 'mobile') {
                    $this->db->like('u.phone', $search['query']);
                } else { }
            } else {
                if (!empty($search['query'])) {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%' OR u.phone LIKE '%" . $search['query'] . "%' OR u.emp_id LIKE '%" . $search['query'] . "%' OR u.email LIKE '%" . $search['query'] . "%' OR t.ticket_no = '" . $search['query'] . "')";
                    $this->db->where($where);
                }
            }
        }
        $this->db->order_by('t.created_date', 'DESC');
        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }
   
    public function MyTicketsDetail($ticket_id, $user_id)
    {
        $and = (($user_id == 0) ? '' : ' AND t.user_id = ' . $user_id);
        $query = "SELECT `t`.`id`, `t`.`subject`, `t`.`body`, `t`.`status`, `t`.`created_date`, `t`.`modified_date`, `t`.`isactive`, `t`.`ticket_no`, `m`.`image`, `m`.`path`, CONCAT_WS(' ', `ui`.`first_name`, ui.last_name) as name, `u`.`email` ,GROUP_CONCAT(m.image) as attachment
            FROM `tickets` `t`
            LEFT JOIN `media` `m` ON FIND_IN_SET(m.id, t.image_id)
            LEFT JOIN `users` `u` ON `t`.`user_id` = `u`.`id`
            LEFT JOIN `user_information` `ui` ON `t`.`user_id` = `ui`.`user_id`
            WHERE `t`.`id` = " . $ticket_id . $and . "
            GROUP BY t.id";
        $query = $this->db->query($query);
        return $query->row();
    }
   
    public function MyTicketsConv($ticket_id, $user_id)
    {
        $and = (($user_id == 0) ? '' : ' AND t.user_id = ' . $user_id);
        $query = "SELECT `t`.`id`, `t`.`body`, `t`.`status`, `t`.`created_date`, (CASE WHEN t.created_by=0 THEN 'Admin' ELSE CONCAT_WS( ' ', `ui`.`first_name`, ui.last_name) END) as name, `t`.`created_by` as `usertype`,m.image,GROUP_CONCAT(concat(m.path,m.image)) as attachment,m.path
            FROM `tickets` `t`
            LEFT JOIN `media` `m` ON FIND_IN_SET(m.id, t.image_id)
            LEFT JOIN `user_information` `ui` ON `t`.`created_by` = `ui`.`user_id`
            WHERE (t.id=" . $ticket_id . " or `t`.`ref_id` = " . $ticket_id . ")" . $and . "
            GROUP BY t.id
            ORDER BY `t`.`created_date` ASC";
        $query = $this->db->query($query);
        return $query->result_array();
    }
   
    #monika(login through email)
     public function userLogin($table = '', $selectfld = '', $lnstrng = '', $password = '')
    {
        //$where = "(members.phone='".$lnstrng."')";
        if (!empty($password)) {
            $array = array('members.email' => $lnstrng, 'members.password' => $password);
        } else {
            $array = array('members.email' => $lnstrng);
        }
        $this->db->select($selectfld);
        $this->db->from($table);
        $this->db->join('user_information', 'user_information.user_id = ' . $table . '.id', 'left');
        $this->db->join('designation d', 'd.id = ' . $table . '.designation', 'left');
        $this->db->join('countries c', 'user_information.country_id = c.id', 'left');
        $this->db->join('kyc',   $table . '.id = kyc.user_id', 'left');
        $this->db->join('media imgdp',   $table . '.profile_pic = imgdp.id', 'left');
        $this->db->join('media img', 'kyc.address_id = img.id', 'left');
        $this->db->join('media im', 'kyc.national_id = im.id', 'left');
        $this->db->join('my_wallet w',   $table . '.id = w.user_id', 'left');
        $this->db->join('packages_purchase pp',   $table . '.id = pp.user_id', 'left');
        $this->db->where($array);
        // $this->db->where('members.password_text=', $password);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // die();
        return $query->result();
    }
    
    
    
    
    
    
    public function userLoginapi($table = '', $selectfld = '', $lnstrng = '', $password)
    {
        //$where = "(members.phone='".$lnstrng."')";
        print_r($table);die;
        $where = "(members.username='" . $lnstrng . "')";
        $this->db->select($selectfld);
        $this->db->from($table);
        $this->db->join('user_information', 'user_information.user_id = ' . $table . '.id', 'left');
        $this->db->join('designation d', 'd.id = ' . $table . '.designation', 'left');
        $this->db->join('countries c', 'user_information.country_id = c.id', 'left');
        $this->db->join('kyc',   $table . '.id = kyc.user_id', 'left');
        $this->db->join('media imgdp',   $table . '.profile_pic = imgdp.id', 'left');
        $this->db->join('media img', 'kyc.address_id = img.id', 'left');
        $this->db->join('media im', 'kyc.national_id = im.id', 'left');
        $this->db->join('my_wallet w',   $table . '.id = w.user_id', 'left');
        $this->db->join('packages_purchase pp',   $table . '.id = pp.user_id', 'left');
        $this->db->where($where);
        // $this->db->where('members.password_text=', $password);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // die();
        return $query->result();
    }
    // public function UserProfile($id)
    // {
    // $this->db->select('m.id,m.ref_id,CONCAT(imgdp.path,imgdp.image) as profile_pic,CONCAT(imgdp.path,imgdp.img_thumb) as profile_pic_thumb,imgdp.path as profile_pic_path,m.email,m.username,m.default_payment_mode,ui.gender,m.role,m.phone,ui.f_name as first_name,ui.l_name as last_name,CONCAT_WS(" ", ui.f_name, ui.l_name) as name,ui.f_name,ui.l_name,ui.dob,ui.address,ui.city,ui.state,ui.zip_code,c.title as country,c.std_code as phonecode,img.image as address_id,img.path as address_id_path,img.img_thumb as address_thumb,im.image as national_id,im.img_thumb as national_thumb,im.path as national_id_path,kyc.address_id_status,kyc.national_id_status,IFNULL(w.amount,0.00) as wallet, pp.active_date');
    // $this->db->from('members m');
    // $this->db->join('user_information ui', 'ui.user_id = m.id', 'left');
    // $this->db->join('countries c', 'ui.country_id = c.id', 'left');
    // $this->db->join('kyc', 'm.id = kyc.user_id', 'left');
    // $this->db->join('media imgdp', 'm.profile_pic = imgdp.id', 'left');
    // $this->db->join('media img', 'kyc.address_id = img.id', 'left');
    // $this->db->join('media im', 'kyc.national_id = im.id', 'left');
    // $this->db->join('my_wallet w', 'm.id = w.user_id', 'left');
    // $this->db->join('packages_purchase pp', 'm.id = pp.user_id', 'left');
    // $this->db->where('m.id=', $id);
    // $query = $this->db->get();
    // return $query->row();
    // }
    
    
   
    public function InvoiceSummary($user_id)
    {
        $this->db->select('m.username,a.id,a.payment_via,a.created_date,a.amount,a.invoice_number,CONCAT_WS(" ", ui.f_name, ui.l_name) as name');
        $this->db->from('accounts a');
        $this->db->join('user_information ui', 'a.user_id = ui.user_id');
        $this->db->join('members m', 'a.user_id = m.id');
        //$this->db->where(array('a.txn_type' => 2, 'a.type' => 2, 'a.isactive' => 1, 'a.user_id' => $user_id));
        #$this->db->where(array('a.type' => 2,'mode' => 1 , 'txn_type' => 1, 'a.isactive' => 1, 'a.user_id' => $user_id));
        $this->db->where(array('a.mode' => 1, 'txn_type' => 1, 'a.user_id' => $user_id));
        $this->db->where(array('a.profit_type !=' => 7, 'a.profit_type !=' => 6));
        $this->db->where('a.type IN (0,2)');
        $this->db->order_by('a.created_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
  
    //end function
    public function MyRewards($user_id)
    {
        $this->db->select('r.isactive,r.id,r.amount,r.created_date,m.username,m.email,m.phone,d.title,CONCAT_WS(" ", ui.f_name, ui.l_name) as name');
        $this->db->from('profit r');
        $this->db->join('members m', 'm.id = r.user_id', 'LEFT');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
        $this->db->join('designation d', 'd.id = r.designation', 'LEFT');
        $this->db->where(array('r.user_id' => $user_id, 'r.type' => 6));
        $this->db->order_by('r.created_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    /*PUBLIC FUNCTION MyProfits($user_id="")
    {
    }*/
    public function MyProfits($user_id = "", $type, $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'm.id as user_id,CONCAT_WS(" ", ui.f_name, ui.l_name) as name,m.username,m.email,m.phone,p.id,p.type as profit_type,m.created_date,a.created_date as purchased_on,sum(a.amount) as p_amount,sum(p.amount) as amount,d.title as designation,p.user_id_from,p.level,p.profit_percent,p.amount_of';
        $where_array = array(
            'p.type' => $type,
        );
        if ($user_id != "") {
            $where_array['p.user_id'] = $user_id;
        } else {
            $colums .= ',m_u.id as u_id,m_u.username as u_username,m_u.email as u_email,CONCAT_WS(" ", ui_u.f_name, ui_u.l_name) as u_name,ui_u.phone as u_phone';
        }
        $this->db->select($colums);
        $this->db->from('profit p');
        $this->db->join('members m', 'm.id = p.user_id_from', 'LEFT');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
        $this->db->join('designation d', 'd.id = m.designation', 'LEFT');
        $this->db->join('accounts a', 'p.ref_id = a.id', 'LEFT');
        if ($user_id == "") {
            $this->db->join('members m_u', 'm_u.id = p.user_id', 'LEFT');
            $this->db->join('user_information ui_u', 'ui_u.user_id = m_u.id', 'LEFT');
        }
        $this->db->where($where_array);
        if (!empty($search)) {
            if (!empty($search['startdate']) && empty($search['enddate'])) {
                $array = array('DATE(p.created_date) >=' => $search['startdate']);
                $this->db->where($array);
            }
            if (!empty($search['enddate']) && empty($search['startdate'])) {
                $array = array('DATE(p.created_date) <=' => $search['enddate']);
                $this->db->where($array);
            }
            if (!empty($search['startdate']) && !empty($search['enddate'])) {
                $array = array('DATE(p.created_date) >=' => $search['startdate'], 'DATE(p.created_date) <=' => $search['enddate']);
                $this->db->where($array);
            }
            if (!empty($search['search_by'])) {
                if (!empty($search['query'])) {
                    if ($search['search_by'] == 'name') {
                        $where = "(ui_u.f_name LIKE '%" . $search['query'] . "%' OR ui_u.l_name LIKE '%" . $search['query'] . "%')";
                        $this->db->where($where);
                    } elseif ($search['search_by'] == 'username') {
                        $this->db->like('m_u.username', $search['query']);
                    } elseif ($search['search_by'] == 'email') {
                        $this->db->like('m_u.email', $search['query']);
                    } elseif ($search['search_by'] == 'mobile') {
                        $this->db->like('ui_u.phone', $search['query']);
                    } else { }
                }
            } else {
                if (!empty($search['query'])) {
                    if ($user_id != "") {
                        $where = "(ui.f_name LIKE '%" . $search['query'] . "%' OR ui.l_name LIKE '%" . $search['query'] . "%' OR m.phone LIKE '%" . $search['query'] . "%' OR m.username LIKE '%" . $search['query'] . "%' OR m.email LIKE '%" . $search['query'] . "%')";
                    } else {
                        $where = "(ui_u.f_name LIKE '%" . $search['query'] . "%' OR ui_u.l_name LIKE '%" . $search['query'] . "%' OR ui_u.phone LIKE '%" . $search['query'] . "%' OR m_u.username LIKE '%" . $search['query'] . "%' OR m_u.email LIKE '%" . $search['query'] . "%')";
                    }
                    $this->db->where($where);
                }
            }
        }
        $this->db->order_by('p.created_date', 'DESC');
        $this->db->group_by('m.id');
        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }
    
    public function my_profit($user_id = "", $profit_type = "1", $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        //pp.price as famount,
        $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.from_level, a.mode,a.status,m.username,m.email,m.level,m.currency,m.phone,m.full_name as name,a.created_date,pm.name as mode,  rm.username as ref_username, rm.full_name as ref_name, rm.email as ref_email, a.week_of_year,(SELECT SUM(packages_purchase.price) as a FROM packages_purchase WHERE packages_purchase.user_id = a.front_user_id  AND packages_purchase.package_id =  a.lvl_pkg_id) as eamount';
        if ($profit_type == 3) {
            $colums .= ', SUM(a.amount) as p_amount';
        } elseif ($profit_type == 2) {
            $colums .= ', SUM(a.amount) as p_amount';
        } elseif ($profit_type == 21) {
            $colums .= ', SUM(a.amount) as p_amount';
        } else {
            $colums .= ', a.amount as p_amount';
        }
        if ($user_id) {
            $colums .= ', ds.level as ref_level';
        } else {
            $colums .= ', m.level as ref_level';
        }
        // $where_array = array('a.profit_type'=>$profit_type);
        if ($profit_type) {
            $where_array = array('a.profit_type' => $profit_type);
        } else {
            $where_array = array('a.txn_type' => 2, 'a.type' => 1);
        }
        if ($user_id) {
            $where_array['a.user_id'] = $user_id;
        } else {
            $colums .= ',m_u.id as u_id,m_u.username as u_username,m_u.level,m_u.currency,m_u.email as u_email,CONCAT_WS(" ", ui_u.f_name, ui_u.l_name) as u_name,m_u.phone as u_phone';
        }

        if($profit_type == 1){

            // $this->db->join('packages_purchase pp', 'pp.user_id = rm.id', 'LEFT');

            $colums .= ', (SELECT (price) as a FROM packages_purchase WHERE packages_purchase.user_id = a.front_user_id and packages_purchase.ref_id = a.id LIMIT 1) as famount';

        }
        $this->db->select($colums);
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id', 'LEFT');
        $this->db->join('members rm', 'rm.id = a.front_user_id', 'LEFT');
        
        // $this->db->join('packages_purchase pp', 'pp.user_id = rm.id', 'LEFT');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
        $this->db->join('payment_method pm', 'a.mode = pm.id', 'LEFT');
        if ($user_id) {
            $this->db->join('dstat ds', '' . $user_id . '=ds.parent_id and rm.id=ds.user_id', 'LEFT');
        }
        if ($user_id == "") {
            $this->db->join('members m_u', 'm_u.id = a.user_id', 'LEFT');
            $this->db->join('user_information ui_u', 'ui_u.user_id = m_u.id', 'LEFT');
        }
        $this->db->where($where_array);
        
        if (!empty($search)) {
            if (!empty($search['startdate']) && empty($search['enddate'])) {
                $array = array('DATE(a.created_date) >=' => $search['startdate']);
                $this->db->where($array);
            }
            if (!empty($search['enddate']) && empty($search['startdate'])) {
                $array = array('DATE(a.created_date) <=' => $search['enddate']);
                $this->db->where($array);
            }
            if (!empty($search['startdate']) && !empty($search['enddate'])) {
                $array = array('DATE(a.created_date) >=' => $search['startdate'], 'DATE(a.created_date) <=' => $search['enddate']);
                $this->db->where($array);
            }
            if (!empty($search['search_by'])) {
                if (!empty($search['query'])) {
                    if ($search['search_by'] == 'name') {
                        $where = "(ui_u.f_name LIKE '%" . $search['query'] . "%' OR ui_u.l_name LIKE '%" . $search['query'] . "%')";
                        $this->db->where($where);
                    } elseif ($search['search_by'] == 'username') {
                        $this->db->like('m_u.username', $search['query']);
                    } elseif ($search['search_by'] == 'email') {
                        $this->db->like('m_u.email', $search['query']);
                    } elseif ($search['search_by'] == 'mobile') {
                        $this->db->like('ui_u.phone', $search['query']);
                    } else { }
                }
            } else {
                if (!empty($search['query'])) {
                    if ($user_id != "") {
                        $where = "(ui.f_name LIKE '%" . $search['query'] . "%' OR ui.l_name LIKE '%" . $search['query'] . "%' OR m.phone LIKE '%" . $search['query'] . "%' OR m.username LIKE '%" . $search['query'] . "%' OR m.email LIKE '%" . $search['query'] . "%')";
                    } else {
                        $where = "(ui_u.f_name LIKE '%" . $search['query'] . "%' OR ui_u.l_name LIKE '%" . $search['query'] . "%' OR ui_u.phone LIKE '%" . $search['query'] . "%' OR m_u.username LIKE '%" . $search['query'] . "%' OR m_u.email LIKE '%" . $search['query'] . "%')";
                    }
                    $this->db->where($where);
                }
            }
        }
        if ($user_id == '' && ($profit_type == 3 || $profit_type == 2 || $profit_type == 21)) {
            $this->db->group_by('m.id, a.created_date');
        } else if ($user_id != '' && ($profit_type == 3)) {
            $this->db->group_by('a.user_id');
            $this->db->group_by('m.id, a.created_date');
        } else if ($user_id != '' && ($profit_type == 10)) {
            $this->db->group_by('a.user_id');
            $this->db->group_by('m.id, a.created_date');
        } elseif ($profit_type == 2) {
            $this->db->group_by('a.user_id');
        } elseif ($profit_type == 1) {
            //$this->db->group_by('a.front_user_id');
        } else {
            $this->db->group_by('a.id');
        }
        $this->db->order_by('a.created_date', 'DESC');
        if ($rowperpage != '') {
            #$this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            $res = $query->num_rows();
        } else {
            $res = $query->result_array();
        }
        #echo $this->db->last_query(); die;
        return $res;
    }
   
   
    public function KycStatus($user_id)
    {
        $this->db->select('(CASE WHEN (address_id_status =2 AND national_id_status =2 AND pancard_status =2) THEN 1 ELSE 0 END ) as kyc');
        $this->db->from('kyc');
        $this->db->where(array('user_id' => $user_id));
        $query = $this->db->get();
        return $query->row_array();
    }
    
    
    
    
    
    
    public function user_data($term, $user_id = "")
    {
        $this->db->select('CONCAT(ui.first_name, " ","(",m.emp_id,")") AS text, m.id, m.emp_id');
        $this->db->from('users m');
        $this->db->join('user_information ui', 'm.id = ui.user_id', 'LEFT');
        if ($user_id != '') {
            $this->db->where(array('m.isactive' => 1));
            $this->db->group_start();
            $this->db->where('m.id!=', $user_id)->where('m.id!=', 1);
            $this->db->group_end();
        } else {
            $this->db->where(array('m.id!=' => 0, 'm.isactive' => 1));
        }
        $where = "(ui.first_name LIKE '%" . $term . "%' OR ui.last_name LIKE '%" . $term . "%' OR m.emp_id LIKE '%" . $term . "%')";
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    // public function user_datax($term, $user_id = "")
    // {
    //     $this->db->select('CONCAT(ui.first_name, " ","(",m.emp_id,")") AS text, m.id, m.emp_id');
    //     $this->db->from('dstat ds');
    //     $this->db->join('members m', 'm.id = ds.user_id', 'LEFT');
    //     $this->db->join('user_information ui', 'm.id = ui.user_id', 'LEFT');
    //     //$this->db->join('packages_purchase pp', 'm.id = pp.user_id', 'LEFT');
    //     if ($user_id != '') {
    //         $this->db->where(array('m.email_status' => 1, 'm.isactive' => 1, 'ds.parent_id' => $user_id));
    //         $this->db->group_start();
    //         $this->db->where('m.id!=', $user_id)->where('m.id!=', 1);
    //         $this->db->group_end();
    //     } else {
    //         $this->db->where(array('m.id!=' => 1, 'm.email_status' => 1, 'm.isactive' => 1));
    //     }
    //     /*$where = "(pp.id is null AND m.username LIKE '%" . $term . "%')";*/
    //     $where = "(m.username LIKE '%" . $term . "%')";
    //     $this->db->where($where);
    //     $this->db->group_by('m.id');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }
    public function delete_notification($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('notification');
    }
    public function get_alertdata($user_id = "", $count = "", $rowno = "", $rowperpage = "", $unread_count = "", $request = "", $search = "")
    {
        if ($request != '') {
            $this->db->select('nf.id,nf.user_id,nf.subject,nf.view_user_id,nf.delete_user_id,LEFT(notification_message, 40) as body,nf.notification_message, nf.create_date,CONCAT(me.path,me.image) as image');
        } else {
            $this->db->select('nf.id,nf.user_id,nf.view_user_id,nf.delete_user_id,nf.image as upimage,nf.subject,LEFT(notification_message, 40) as body,nf.notification_message,nf.create_date,CONCAT(me.path,me.image) as image');
        }
        // CONCAT(imgdp.path,imgdp.image) as profile_pic
        $this->db->from('notification nf');
        $this->db->join('media me', 'nf.image = me.id', 'left');
        //$this->where_not_in($user_id, 'delete_user_id');
        if (isset($search['search_by']) && $search['search_by'] > 0) {
            $this->db->where(['nf.id' => $search['search_by']]);
        }
        $where = "NOT FIND_IN_SET(" . $user_id . ",nf.delete_user_id) AND (nf.user_id LIKE '%" . $user_id . "%' OR FIND_IN_SET(0,nf.user_id) ) ";
        $this->db->where($where);
        if ($unread_count != '') {
            $where = "NOT FIND_IN_SET(" . $user_id . ",nf.view_user_id)";
            $this->db->where($where);
        }
        $where = "(FIND_IN_SET(" . $user_id . ",nf.user_id) OR nf.user_id =0)";
        $this->db->where($where);
        $this->db->where(['nf.status !=' => 3]);
        $this->db->order_by('nf.id', 'DESC');
        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }
    public function get_alertdata1($user_id = "", $count = "", $rowno = "", $rowperpage = "", $unread_count = "", $request = "", $search = "")
    {
        if ($request != '') {
            $this->db->select('nf.id,nf.user_id,nf.subject,nf.type,nf.view_user_id, LEFT(notification_message, 40) as body,IFNULL(nf.create_date,"") as create_date ,nf.image,CONCAT(me.path,me.image) as image');
        } else {
            $this->db->select('nf.id,nf.user_id,nf.type,nf.image as upimage,nf.view_user_id,nf.subject,LEFT(notification_message, 40) as body,IFNULL(nf.create_date,"") as create_date ,CONCAT(me.path,me.image) as image');
        }
        // CONCAT(imgdp.path,imgdp.image) as profile_pic
        $this->db->from('notification nf');
        $this->db->join('media me', 'nf.image = me.id', 'left');
        //$this->where_not_in($user_id, 'delete_user_id');
        if (isset($search['search_by']) && $search['search_by'] > 0) {
            $this->db->where(['nf.id' => $search['search_by']]);
        }
        $where = "NOT FIND_IN_SET(" . $user_id . ",nf.delete_user_id) AND (nf.user_id LIKE '%" . $user_id . "%' OR FIND_IN_SET(0,nf.user_id) ) ";
        $this->db->where($where);
        if ($unread_count != '') {
            $where = "NOT FIND_IN_SET(" . $user_id . ",nf.view_user_id)";
            $this->db->where($where);
        }
        $where = "(FIND_IN_SET(" . $user_id . ",nf.user_id) OR nf.user_id =0)";
        $this->db->where($where);
        $this->db->order_by('nf.id', 'DESC');
        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }
   
    
    public function demousr_details($id = "")
    {
        $userInfo = $this->db->query("SELECT me.parent_id as closet_parent, me.designation,me.phone,me.password_text,me.leg,me.ref_by,me.id,me.username as user,me.email,me.full_name,me.bit_otp,prnt.username as parent,ui.f_name,ui.l_name,ef.name as title, ef.amount as price,ui.address,ui.address_line2,ui.city,ui.state,ui.zip_code,ui.country_id
            from members as me
            LEFT JOIN user_information as ui on me.id = ui.user_id
            LEFT JOIN enroll_fee as ef on me.enroll_feeId = ef.id
            LEFT JOIN members as prnt on me.ref_by = prnt.id
            where me.id = " . $id . "");
        $userInfo = $userInfo->row_array();
        return $userInfo;
    }
    public function demousrDetails($id = "")
    {
        $userInfo = $this->db->query("SELECT me.parent_id as closet_parent, me.designation,me.phone,me.leg,me.ref_by,me.id,me.username as user,me.email,me.full_name,prnt.username as parent,ui.f_name,ui.l_name,ef.name as title, ef.amount as price,ui.address,ui.address_line2,ui.city,ui.state,ui.zip_code,ui.country_id
            from members as me
            LEFT JOIN user_information as ui on me.id = ui.user_id
            LEFT JOIN enroll_fee as ef on me.enroll_feeId = ef.id
            LEFT JOIN members as prnt on me.ref_by = prnt.id
            where me.username = " . $id . "");
        $userInfo = $userInfo->row_array();
        return $userInfo;
    }
   
   
    public function UserRewards($userid = "")
    {
        $this->db->select('*');
        $this->db->from('t_dstat');
        $this->db->where(array('parent_id' => $userid));
        $query = $this->db->get();
        return $query->result();
        //echo $this->db->last_query();
        //die;
    }
   
    
}
