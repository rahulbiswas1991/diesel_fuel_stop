<?php
class common_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->model(array('user_model', 'admin_modal'));
    }

    public function testme()
    {
        //test any query..
    }
    public function exec_query($sql, $return_arr = "full")
    {
        $query = $this->db->query($sql);
        if ($return_arr == "full") {
            return $query->result_array();
        } else {
            return $query->row_array();
        }
    }

    public function get_data($table = "", $and = "", $columns = "*", $return_arr = "full", $join = "", $groupby = "", $orderby = "", $limit = "")
    {
        // $orderby = "DESC";
        $columns = ($columns == "" ? "*" : $columns);
        $sql = "SELECT " . $columns . " FROM " . $table . " " . $join . " WHERE 1=1" . " " . $and . " " . $groupby . " " . $orderby . " " . $limit;

        $query = $this->db->query($sql);
        if ($return_arr == "full") {
            return $query->result_array();
        } else {
            return $query->row_array();
        }
    }
    public function countAll() {
        return $this->db->count_all("diesel_fuel_records");
    }
    public function get_fuel_data($limit, $start=0) {
        $this->db->limit($limit,$start);
        $where = 'carrier_name IS NOT NULL';
        $data = $this->db->get_where("diesel_fuel_records", $where);
        // print_r($this->db->last_query());die;
        return $data->result_array();
    }
    public function MetherWalletStatement($user_id)
    {
        $sql = 'SELECT a.id,a.mode,a.created_date,CONCAT_WS(" ",m.currency,a.amount) as amount,a.type, @b := round(@b + IF(a.type=1,a.amount,0) - IF(a.type=2,a.amount,0),2) AS balance, a.remarks,
        IF(a.txn_type=1,"By Admin",ui.f_name) user_name,
        m.email,m.phone,m.currency,m.username,a.invoice_number,a.txn_type
            FROM (SELECT @b := 0.0) AS dummy
            CROSS JOIN accounts a
            LEFT JOIN members m ON m.id = a.user_id
            LEFT JOIN user_information ui ON a.user_id = ui.user_id
            WHERE a.user_id = ' . $user_id . ' AND a.mode=1
            ORDER BY a.created_date ASC';
        $query = $this->db->query($sql);
        $res = $query->result_array();
        #echo $this->db->last_query();die;
        return $res;
    }


    public function my_profitnew($user_id = "",$level, $profit_type = "1", $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.mode,a.status,m.username,m.email,m.level,m.currency,m.phone,m.full_name as name,a.created_date,pm.name as mode, rm.username as ref_username, rm.full_name as ref_name, rm.email as ref_email, a.week_of_year,(SELECT SUM(packages_purchase.price) as a FROM packages_purchase WHERE packages_purchase.user_id = a.front_user_id  AND packages_purchase.package_id =  a.lvl_pkg_id) as eamount';

        if($profit_type==3 || $profit_type==2) {
            #$colums.=', SUM(a.amount) as p_amount, SUBDATE(a.created_date, weekday(a.created_date)) as created_date';
            $colums.=', SUM(a.amount) as p_amount, DATE_ADD((DATE(a.created_date + INTERVAL (6 - WEEKDAY(a.created_date)) DAY)), INTERVAL 1 DAY) as created_date';
        }  else {
            // $colums.=', a.amount as p_amount,sum(pp.total_price) as invested_amount, a.created_date';
			$colums.=', a.amount as p_amount, a.created_date';
        }

        if($user_id) {
            $colums.=', ds.level as ref_level';
        } else {
            $colums.=', m.level as ref_level';
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

        $this->db->select($colums);
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id', 'LEFT');

        $this->db->join('members rm', 'rm.id = a.front_user_id', 'LEFT');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
		  // $this->db->join('packages_purchase pp', 'pp.user_id = a.user_id', 'LEFT');
        $this->db->join('payment_method pm', 'a.mode = pm.id', 'LEFT');
        if ($user_id) {
            $this->db->join('dstat ds', '' . $user_id . '=ds.parent_id and rm.id=ds.user_id', 'LEFT');
        }
        if ($user_id == "") {
            $this->db->join('members m_u', 'm_u.id = a.user_id', 'LEFT');
            $this->db->join('user_information ui_u', 'ui_u.user_id = m_u.id', 'LEFT');
        }
		$where_array = array('ds.level' => $level,'a.user_id' => $user_id,'a.profit_type' => 1);
        $this->db->where($where_array);
 // $this->db->group_by('a.user_id');
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
                    } else {

                    }
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

        if ($user_id=='' && ($profit_type == 3 || $profit_type==2)) {
            $this->db->group_by('m.id, a.week_of_year');
        } else if ($user_id!='' && ($profit_type == 3 || $profit_type==2)) {
            $this->db->group_by('a.week_of_year');
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
       // echo $this->db->last_query();die;
        return $res;
    }
    

    public function my_profit_team($user_id = "", $profit_type = "2", $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'CONCAT_WS(" ",m.currency,sum(a.amount)) as total_earning , a.user_id as user_id,count(a.user_id) as total_users,m.currency as currency,ds.level';
		
		// $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.mode,a.status,m.username,m.email,m.level,m.currency,m.phone,m.full_name as name,a.created_date,pm.name as mode, rm.username as ref_username, rm.full_name as ref_name, rm.email as ref_email, a.week_of_year';
		

        if($profit_type==3 || $profit_type==2) {
            #$colums.=', SUM(a.amount) as p_amount, SUBDATE(a.created_date, weekday(a.created_date)) as created_date';
            $colums.=', SUM(a.amount) as p_amount, DATE_ADD((DATE(a.created_date + INTERVAL (6 - WEEKDAY(a.created_date)) DAY)), INTERVAL 1 DAY) as created_date';
        }  else {
            // $colums.=', a.amount as p_amount, a.created_date,';
			 $colums.=', a.created_date,';
        }

        // if($user_id) {
            // $colums.=', ds.level as ref_level';
        // } else {
            // $colums.=', m.level as ref_level';
        // }
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

        $this->db->select($colums);
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id', 'LEFT');

        $this->db->join('members rm', 'rm.id = a.front_user_id', 'LEFT');
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
		$this->db->group_by('ds.level');
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
                    } else {

                    }
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

        if ($user_id=='' && ($profit_type == 3 || $profit_type==2)) {
            // $this->db->group_by('m.id, a.week_of_year');
        } else if ($user_id!='' && ($profit_type == 3 || $profit_type==2)) {
            // $this->db->group_by('a.week_of_year');
        }

        // $this->db->order_by('a.created_date', 'DESC');
		 $this->db->order_by('ds.level', 'ASC');

        if ($rowperpage != '') {
            #$this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            $res = $query->num_rows();
        } else {
            $res = $query->result_array();
        }
        // echo $this->db->last_query();die;
        return $res;
    }


    public function my_profit_team_l($user_id = "",$level, $profit_type = "2", $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.mode,a.status,m.level,m.currency,a.created_date,pm.name as mode, rm.id as ref_id,rm.username as ref_username, rm.full_name as ref_name,ds.level as r_level,rm.email as ref_email, a.week_of_year';
		 // $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.mode,a.status,m.username,m.email,m.level,m.currency,m.phone,m.full_name as name,a.created_date,pm.name as mode, rm.username as ref_username, rm.full_name as ref_name, rm.email as ref_email, a.week_of_year';

        if($profit_type==3 || $profit_type==2) {
            #$colums.=', SUM(a.amount) as p_amount, SUBDATE(a.created_date, weekday(a.created_date)) as created_date';
            $colums.=', SUM(a.amount) as p_amount, DATE_ADD((DATE(a.created_date + INTERVAL (6 - WEEKDAY(a.created_date)) DAY)), INTERVAL 1 DAY) as created_date,a.a as invested_amount,';
        }  else {
            // $colums.=', a.amount as p_amount,sum(pp.total_price) as invested_amount, a.created_date';
			$colums.=', a.amount as p_amount, a.a as invested_amount, a.created_date';
        }

        // if($user_id) {
            // $colums.=', ds.level as ref_level';
        // } else {
            // $colums.=', m.level as ref_level';
        // }
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

        $this->db->select($colums);
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id', 'LEFT');

        $this->db->join('members rm', 'rm.id = a.front_user_id', 'LEFT');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
		  // $this->db->join('packages_purchase pp', 'pp.user_id = a.user_id', 'LEFT');
        $this->db->join('payment_method pm', 'a.mode = pm.id', 'LEFT');
        if ($user_id) {
            $this->db->join('dstat ds', '' . $user_id . '=ds.parent_id and rm.id=ds.user_id', 'LEFT');
        }
        if ($user_id == "") {
            $this->db->join('members m_u', 'm_u.id = a.user_id', 'LEFT');
            $this->db->join('user_information ui_u', 'ui_u.user_id = m_u.id', 'LEFT');
        }
		$where_array = array('ds.level' => $level,'a.user_id' => $user_id,'a.profit_type' =>2);
        $this->db->where($where_array);
 $this->db->group_by('a.id');
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
                    } else {

                    }
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

        if ($user_id=='' && ($profit_type == 3 || $profit_type==2)) {
            // $this->db->group_by('m.id, a.week_of_year');
        } else if ($user_id!='' && ($profit_type == 3 || $profit_type==2)) {
            // $this->db->group_by('a.week_of_year');
        }

        // $this->db->order_by('a.created_date', 'DESC');

        if ($rowperpage != '') {
            #$this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            $res = $query->num_rows();
        } else {
            $res = $query->result_array();
        }
        // echo $this->db->last_query();die;
        return $res;
    }
	
	 public function my_profit_team_l_u($user_id = "",$level, $profit_type = "2", $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.mode,a.status,m.level,m.currency,a.created_date,pm.name as mode,  a.week_of_year';

        if($profit_type==3 || $profit_type==2) {
            #$colums.=', SUM(a.amount) as p_amount, SUBDATE(a.created_date, weekday(a.created_date)) as created_date';
            $colums.=', SUM(a.amount) as p_amount, DATE_ADD((DATE(a.created_date + INTERVAL (6 - WEEKDAY(a.created_date)) DAY)), INTERVAL 1 DAY) as created_date';
        }  else {
            // $colums.=', a.amount as p_amount,sum(pp.total_price) as invested_amount, a.created_date';
			$colums.=', a.amount as p_amount, a.a as invested_amount, a.created_date';
        }

        // if($user_id) {
            // $colums.=', ds.level as ref_level';
        // } else {
            // $colums.=', m.level as ref_level';
        // }
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

        $this->db->select($colums);
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id', 'LEFT');

        $this->db->join('members rm', 'rm.id = a.front_user_id', 'LEFT');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
		  // $this->db->join('packages_purchase pp', 'pp.user_id = a.user_id', 'LEFT');
        $this->db->join('payment_method pm', 'a.mode = pm.id', 'LEFT');
        if ($user_id) {
            $this->db->join('dstat ds', '' . $user_id . '=ds.parent_id and rm.id=ds.user_id', 'LEFT');
        }
        if ($user_id == "") {
            $this->db->join('members m_u', 'm_u.id = a.user_id', 'LEFT');
            $this->db->join('user_information ui_u', 'ui_u.user_id = m_u.id', 'LEFT');
        }
		$where_array = array('ds.level' => $level,'a.user_id' => $user_id,'a.profit_type' =>2);
        $this->db->where($where_array);
 $this->db->group_by('a.id');
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
                    } else {

                    }
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

        if ($user_id=='' && ($profit_type == 3 || $profit_type==2)) {
            // $this->db->group_by('m.id, a.week_of_year');
        } else if ($user_id!='' && ($profit_type == 3 || $profit_type==2)) {
            // $this->db->group_by('a.week_of_year');
        }

        // $this->db->order_by('a.created_date', 'DESC');

        if ($rowperpage != '') {
            #$this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            $res = $query->num_rows();
        } else {
            $res = $query->result_array();
        }
        // echo $this->db->last_query();die;
        return $res;
    }
	

    public function my_profitsimple($user_id = "", $profit_type = "1", $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'CONCAT_WS(" ",m.currency,sum(a.amount)) as total_earning , a.user_id as user_id,count(a.user_id) as total_users,m.currency as currency,ds.level';

        // $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.mode,a.status,m.username,m.email,m.level,m.currency,m.phone,m.full_name as name,a.created_date,pm.name as mode, rm.username as ref_username, rm.full_name as ref_name, rm.email as ref_email, a.week_of_year';


        if ($profit_type == 3 || $profit_type == 2) {
            #$colums.=', SUM(a.amount) as p_amount, SUBDATE(a.created_date, weekday(a.created_date)) as created_date';
            $colums .= ', SUM(a.amount) as p_amount, DATE_ADD((DATE(a.created_date + INTERVAL (6 - WEEKDAY(a.created_date)) DAY)), INTERVAL 1 DAY) as created_date';
        } else {
            // $colums.=', a.amount as p_amount, a.created_date,';
            $colums .= ', a.created_date,';
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

        $this->db->select($colums);
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id', 'LEFT');

        $this->db->join('members rm', 'rm.id = a.front_user_id', 'LEFT');
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
        $this->db->group_by('ds.level');
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

        if ($user_id == '' && ($profit_type == 3 || $profit_type == 2)) {
            $this->db->group_by('m.id, a.week_of_year');
        } else if ($user_id != '' && ($profit_type == 3 || $profit_type == 2)) {
            $this->db->group_by('a.week_of_year');
        }

        $this->db->order_by('a.created_date', 'DESC');
        $this->db->order_by('ds.level', 'ASC');

        if ($rowperpage != '') {
            #$this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            $res = $query->num_rows();
        } else {
            $res = $query->result_array();
        }
        // echo $this->db->last_query();die;
        return $res;
    }

    public function my_profit($user_id = "", $level = "" ,$profit_type = "1", $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.mode,a.status,m.username,m.email,m.level,m.currency,m.phone,m.full_name as name,a.created_date,pm.name as mode, rm.username as ref_username, rm.full_name as ref_name, rm.email as ref_email, a.week_of_year';

        if($profit_type==3 || $profit_type==2) {
            #$colums.=', SUM(a.amount) as p_amount, SUBDATE(a.created_date, weekday(a.created_date)) as created_date';
            $colums.=', SUM(a.amount) as p_amount, DATE_ADD((DATE(a.created_date + INTERVAL (6 - WEEKDAY(a.created_date)) DAY)), INTERVAL 1 DAY) as created_date';
        }  else {
            $colums.=', a.amount as p_amount, a.created_date';
        }

        if($user_id) {
            $colums.=', ds.level as ref_level';
        } else {
            $colums.=', m.level as ref_level';
        }
        // $where_array = array('a.profit_type'=>$profit_type);
        if ($profit_type) {
            $where_array = array('a.profit_type' => $profit_type,'ds.level' => $level );
        } else {
            $where_array = array('a.txn_type' => 2, 'a.type' => 1,'ds.level' => $level);
        }
        if ($user_id) {
           $where_array = array('a.user_id' => $user_id, 'ds.level' => $level);
             // $where_array['a.user_id'] = $user_id;
        } else {
            $colums .= ',m_u.id as u_id,m_u.username as u_username,m_u.level,m_u.currency,m_u.email as u_email,CONCAT_WS(" ", ui_u.f_name, ui_u.l_name) as u_name,m_u.phone as u_phone';
        }

        $this->db->select($colums);
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id', 'LEFT');

        $this->db->join('members rm', 'rm.id = a.front_user_id', 'LEFT');
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
                    } else {

                    }
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

        if ($user_id=='' && ($profit_type == 3 || $profit_type==2)) {
            $this->db->group_by('m.id, a.week_of_year');
        } else if ($user_id!='' && ($profit_type == 3 || $profit_type==2)) {
            $this->db->group_by('a.week_of_year');
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
        #echo $this->db->last_query();die;
        return $res;
    }
    
    
public function level_earning($id)
    {
        $this->db->select('CONCAT_WS(" ",m.currency,sum(a.amount)) as total_earning , count(a.user_id) as total_users,m.currency as currency,m.level as level');
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id');
        // $this->db->join('dstat ds', 'm.id = ds.user_id');
         // $this->db->group_by('a.user_id');
          $this->db->group_by('m.level');
         // $this->db->order_by('order by m.level ASC');
         $this->db->order_by('m.level', 'ASC');
         
          $u_data   = array('a.profit_type' => 1,'m.level!=' => 0);
           
        $this->db->where($u_data);
        // $this->db->where('a.profit_type=', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function earningTotal($user_id)
    {
       $this->db->select('a.id,a.user_id,sum(a.amount) as amount, bd.name_in_bank, bd.bank_name, bd.branch_address, bd.account_number, bd.ifsc_code');
            $this->db->from('accounts a');
            $this->db->join('bank_details bd', 'bd.user_id=a.user_id', 'LEFT');
            // $array = array('a.profit_type' => 1, 'a.profit_type' => 2, 'a.profit_type' => 3);
            #$this->db->where(['a.user_id' => $this->id, 'a.status' => 0, 'a.profit_type'=>1 ]);
            $this->db->where('a.user_id='.$user_id.' AND a.status=0 AND (a.profit_type=1 OR a.profit_type=2 OR a.profit_type=3)');
            $user = $this->db->get()->result();
            $user = $user[0];
            #echo "<pre>";print_r($user);#die;
            $amount = $user->amount;
        return $amount;
    }



    public function my_profit1($user_id = "", $profit_type = "1", $count = 0, $rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'a.id,a.front_user_id,a.user_id,a.profit_type,a.mode,count(a.created_by) as total_users,a.status,m.username,m.email,m.level,m.currency,m.phone,m.full_name as name,a.created_date,pm.name as mode, rm.username as ref_username, rm.full_name as ref_name, rm.email as ref_email, a.week_of_year';

        if($profit_type==3 || $profit_type==2) {
            #$colums.=', SUM(a.amount) as p_amount, SUBDATE(a.created_date, weekday(a.created_date)) as created_date';
            $colums.=', SUM(a.amount) as earning_amount,pp.price as invested_amount, DATE_ADD((DATE(a.created_date + INTERVAL (6 - WEEKDAY(a.created_date)) DAY)), INTERVAL 1 DAY) as created_date';
        }  else {
            $colums.=', a.amount as p_amount, a.created_date';
        }

        if($user_id) {
            $colums.=', ds.level as ref_level';
        } else {
            $colums.=', m.level as ref_level';
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

        $this->db->select($colums);
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id = a.user_id', 'LEFT');
        $this->db->join('members rm', 'rm.id = a.front_user_id', 'LEFT');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
        $this->db->join('packages_purchase pp', 'pp.user_id = m.id', 'LEFT');
        $this->db->join('payment_method pm', 'a.mode = pm.id', 'LEFT');
        if ($user_id) {
            $this->db->join('dstat ds', '' . $user_id . '=ds.parent_id and rm.id=ds.user_id', 'LEFT');
        }
        if ($user_id == "") {
            $this->db->join('members m_u', 'm_u.id = a.user_id', 'LEFT');
            $this->db->join('user_information ui_u', 'ui_u.user_id = m_u.id', 'LEFT');
        }
        $this->db->where($where_array);
 $this->db->group_by('m.level');
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
                    } else {

                    }
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

        if ($user_id=='' && ($profit_type == 3 || $profit_type==2)) {
            $this->db->group_by('m.id, a.week_of_year');
        } else if ($user_id!='' && ($profit_type == 3 || $profit_type==2)) {
            $this->db->group_by('a.week_of_year');
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
        #echo $this->db->last_query();die;
        return $res;
    }
    
    
    public function MyWalletBalance1($user_id)
    {
        $this->db->select('CONCAT_WS(" ",members.currency,IFNULL(my_wallet.amount,0.00)) as amount,IFNULL(my_wallet.amount,0.00) as a');
        // $this->db->select('my_wallet.id,IFNULL(my_wallet.amount,0.00) as amount,my_wallet.e_wallet');
        $this->db->from('my_wallet');
        $this->db->join('members', 'my_wallet.user_id = members.id', 'right');
        $this->db->where(array('members.id' => $user_id));
        $quqery = $this->db->get();
       $result = $quqery->row_array();
        
        
           // $result = $sql->result_array();
        return $result;
    }
    public function add_data($table, $data)
    {
        $this->db->insert($table, $data);
        $InsId = $this->db->insert_id();

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            return $InsId;
        }
    }
    public function update_data($table, $data, $where_array)
    {
        $this->db->where($where_array);
        return $this->db->update($table, $data);
    }
    public function delete_data($table, $and = "", $alias = "", $join = "")
    {
        $sql = "DELETE " . $alias . " FROM " . $table . " " . $join . " WHERE 1=1" . " " . $and;
        return $this->db->query($sql);
    }
    public function MyParentDetails($user_id)
    {
        $sql = 'SELECT @user_id := ' . $user_id . ' as user_id,@p_id := p.id as p_id,p.email,p.designation,m.designation as mydesignation,p.username,p.created_date,
            IFNULL((SELECT id from packages_purchase where user_id = @p_id and package_id = 6 AND isactive=1 GROUP by user_id),0) as starter,
            IFNULL((SELECT id from packages_purchase where user_id = @user_id and package_id = 6 AND isactive=1 GROUP by user_id),0) as my_starter,
            IFNULL((SELECT id from packages_purchase where user_id = @p_id and package_id <6 AND isactive=1 group by user_id),0) as standard
            FROM `members` m
            LEFT JOIN members p ON m.ref_by = p.id
            LEFT JOIN packages_purchase pp ON p.id = pp.user_id
            WHERE m.id = ' . $user_id . '
            group by p.id';
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    public function getTeamprofit($userid, $level, $data, $appraisallstdt)
    {
        //echo  "SELECT id,designation,ref_by,ref_id,username from members where ref_by = '".$userid."' AND email_status = '1' AND isactive ='1'<br><br>";
        $sql = $this->db->query("SELECT id,designation,ref_by,ref_id,username from members where ref_by = '" . $userid . "' AND email_status = '1' AND isactive ='1'");
        $result = $sql->result_array();
        if ($sql->num_rows() > 0) {
            foreach ($result as $key => $obj) {
                $user_purchase = $this->db->query("SELECT id FROM `packages_purchase` WHERE isactive=1 AND user_id = " . $obj['id'] . "");
                if ($user_purchase->num_rows() > 0) {
                    $profit = $this->db->query("SELECT IFNULL(SUM(amount),0) as profit FROM `profit` WHERE created_date >= " . $appraisallstdt . " and `user_id` = " . $obj['id'] . " and (`type`=1 || `type`=2 || `type`=3)");
                    $profit = $profit->result_array();
                    //echo $profit[0]['profit'].'  ';
                    if ($profit[0]['profit'] > 0) {
                        $apprailcent = $this->db->query("SELECT percentage FROM `level_profit` WHERE level = " . $level . "");
                        $apprailcent = $apprailcent->result_array();
                        $totalapp_profit = ($profit[0]['profit'] * $apprailcent[0]['percentage']) / 100;
                        array_push($data, array('id' => $obj['id'], 'level' => $level, 'username' => $obj['username'], 'designation' => $obj['designation'], 'profit' => $totalapp_profit, 'profit_percent' => $apprailcent[0]['percentage'], 'profit_amount' => $profit[0]['profit']));
                    }
                }
                $data = $this->getTeamprofit($obj['id'], $level + 1, $data, $appraisallstdt);
            }
        }
        return $data;
    }
    public function CronAGP()
    {
        if (date('D') != 'Sat' || date('D') != 'Sun') {
            $sql = $this->db->query("SELECT p.id,p.user_id,p.daily_percentage,p.price,
                            (CASE WHEN r.percentage != 'NULL' THEN sum(r.percentage) ELSE 0 END ) as total_percentage,
                            (CASE WHEN r.created_date != 'NULL' THEN r.created_date ELSE 0 END ) as last_date
                            FROM `packages_purchase` p
                            LEFT JOIN roi r ON p.id = r.package_purchase_id
                            WHERE p.isactive = 1 AND p.package_id !=6 AND curdate() > DATE_ADD(p.created_date,INTERVAL 14 DAY)
                            GROUP BY p.id
                            HAVING total_percentage < 210 AND max(last_date) NOT LIKE '%" . date('Y-m-d') . "%'
                            ORDER BY p.id,p.user_id ASC");

            $result = $sql->result_array();
            foreach ($result as $users) {
                $amount = ($users['price'] * $users['daily_percentage']) / 100;
                $insert_data = array(
                    'user_id' => $users['user_id'],
                    'package_purchase_id' => $users['id'],
                    'percentage' => $users['daily_percentage'],
                    'amount' => $amount,
                    'package_amount' => $users['price'],
                    'txn_no' => time(),
                );
                $this->add_data('roi', $insert_data);
            }
        }
    }
    public function update_status($table, $id, $update)
    {
        $this->db->where_in('id', $id);
        return $this->db->update($table, $update);
    }
    public function faq($dept = "x")
    {
        $this->db->select('f.department_id,d.title as department,f.question,f.answer');
        $this->db->from('faq f');
        $this->db->join('department d', 'f.department_id = d.id', 'LEFT');
        if ($dept != "x") {
            $this->db->where(array('f.department_id' => $dept));
        }
        $this->db->where(array('f.isactive' => 1));
        $this->db->order_by('f.department_id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    ###########################
    #
    #
    #
    ###########################
    public function insertBatch($table, $data, $returnID = false)
    {
        $return = $this->db->insert_batch($table, $data);
        if ($returnID == true) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
    }
}