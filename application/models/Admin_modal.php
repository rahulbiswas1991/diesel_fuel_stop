<?php
class admin_modal extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        //$this->DB1 = $this->load->database('default', TRUE);
    }
    public function check_id($username, $password)
    {
        $query = $this->db->get_where('admin', array('username' => $username, 'password' => md5($password)));
        return $query->row_array();
    }
    public function get_fuel_lead_data($search) {
        // print_r($search);die;
        $this->db->select('a.*,');
        $this->db->join('leads b','a.acct = b.acct','left');
        $this->db->join('users c','b.user_id = c.id','left');
        // $this->db->ORDER_BY('a.carrier_name', 'ASC');
        // $this->db->get('diesel_fuel_records a')->result_array();
        // $this->db->select('*');
        $this->db->from('diesel_fuel_records a');
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
            
            // if (!empty($search['condition'])) {
            //     $this->db->where('a.type =', $search['condition']);
            // }
            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(a.carrier_name LIKE '" . $search['query'] . "%')";
                    $this->db->where($where);
                    $this->db->ORDER_BY('carrier_name','ASC');
                    return $this->db->get()->result_array();    
                } 
            } else {
                if (!empty($search['query'])) {
                    $where = " a.carrier_name LIKE '" . $search['query'] . "%'";
                    $this->db->where($where);
                }
            }
        }
        $this->db->ORDER_BY('a.created_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
	public function fuel_management($search){
        $this->db->select('*');
        $this->db->from('diesel_fuel_records a');
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
            
            // if (!empty($search['condition'])) {
            //     $this->db->where('a.type =', $search['condition']);
            // }
            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(a.carrier_name LIKE '" . $search['query'] . "%')";
                    $this->db->where($where);
                    $this->db->ORDER_BY('carrier_name','ASC');
                    return $this->db->get()->result_array();    
                } 
            } else {
                if (!empty($search['query'])) {
                    $where = " a.carrier_name LIKE '" . $search['query'] . "%'";
                    $this->db->where($where);
                }
            }
        }
        $this->db->ORDER_BY('a.created_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    //All data for admin manage user listing..
    public function countManageUserListing($search)
    {
        $query_string = '';
        $this->db->select('*');
        $this->db->from('users m');
        $this->db->join('user_information ui', 'm.id=ui.user_id', 'LEFT');
    //    $this->db->where(array('m.id!=' => 1, 'm.email_status' => 1));
        if (!empty($search)) {
            if (!empty($search['condition'])) {
                if($search['condition'] ==2) {
                    $this->db->where('m.isactive =', 0);
                } else {
                    $this->db->where('m.isactive =', $search['condition']);
                }
            } else {
                #$this->db->where('m.isactive >=', 1);
            }

            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $this->db->like('ui.first_name', $search['query']);
                    $this->db->or_like('ui.last_name', $search['query']);
                } elseif ($search['search_by'] == 'emp_id') {
                    $this->db->like('m.emp_id', $search['query']);
                } elseif ($search['search_by'] == 'email') {
                    $this->db->like('m.email', $search['query']);
                } elseif ($search['search_by'] == 'mobile') {
                    $this->db->like('m.phone', $search['query']);
                } else {

                }
            } else {
                if (!empty($search['query'])) {
                    $this->db->like('ui.first_name', $search['query']);
                    $this->db->or_like('ui.last_name', $search['query']);
                    $this->db->or_like('m.emp_id', $search['query']);
                    $this->db->or_like('m.email', $search['query']);
                    $this->db->or_like('m.phone', $search['query']);
                }
            }
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function get_all_users() {
        $this->db->select('*');
        $this->db->select('CONCAT(first_name,last_name) user_name');
        return $this->db->get('users')->result_array();
    }
         public function ManageUserListing($search)
    {

        $this->db->select('a.id as lead_id,a.created_date,a.complete_date as updated_date,a.contact_name as lead_name,a.company_name,a.phone_no as lead_phone,a.email as lead_mail, a.city as lead_city,a.state as lead_state, a.street as lead_street,a.no_of_trucks as lead_total_trucks,a.DOT_number as lead_dot_number,a.zip_code as lead_zip_code,a.potential_gallons as lead_potential_gallons,a.description_field as lead_description_field,a.status as lead_status,a.month,a.year, m.id as user_id,m.emp_id,m.email as user_mail,m.phone as user_phone,CONCAT_WS(" ", ui.first_name, ui.last_name) as user_name');
        $this->db->join('users m', 'm.id=a.user_id', 'left');
        $this->db->join('user_information ui', 'a.user_id=ui.user_id', 'left');
        $this->db->from('leads a');
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
            
            // if (!empty($search['condition'])) {
            //     $this->db->where('a.type =', $search['condition']);
            // }
            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(a.contact_name LIKE '" . $search['query'] . "%')";
                    $this->db->where($where);
                    $this->db->ORDER_BY('contact_name','ASC');
                    return $this->db->get()->result_array();    
                } 
            } else {
                if (!empty($search['query'])) {
                    // echo "test";die;
                    $where = " CONCAT_WS(\" \", `ui`.`first_name`, ui.last_name) LIKE '" . $search['query'] . "%'";
                    $this->db->where($where);
                }
            }
        }
        $this->db->ORDER_BY('a.created_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
         public function get_user_lead_data_by_id($id)
    {
        // print_r($id);die;
        $this->db->select('a.id as lead_id,a.created_date,a.complete_date as updated_date,a.contact_name as lead_name,a.company_name,a.phone_no as lead_phone,a.email as lead_mail, a.city as lead_city,a.state as lead_state, a.street as lead_street,a.no_of_trucks as lead_total_trucks,a.DOT_number as lead_dot_number,a.zip_code as lead_zip_code,a.potential_gallons as lead_potential_gallons,a.description_field as lead_description_field,a.status as lead_status, m.id as user_id,m.emp_id,m.email as user_mail,m.phone as user_phone,CONCAT_WS(" ", ui.first_name, ui.last_name) as user_name');
        $this->db->join('users m', 'm.id=a.user_id', 'left');
        $this->db->join('user_information ui', 'a.user_id=ui.user_id', 'left');
        return $this->db->get_where('leads a',array('a.id'=>$id))->row_array();
    }
    public function get_lead_by_id($id) {
        $this->db->select('a.id as lead_id,a.created_date,a.complete_date as updated_date,a.contact_name as lead_name,a.company_name,a.phone_no as lead_phone,a.email as lead_mail, a.city as lead_city,a.state as lead_state, a.street as lead_street,a.no_of_trucks as lead_total_trucks,a.DOT_number as lead_dot_number,a.zip_code as lead_zip_code,a.potential_gallons as lead_potential_gallons,a.description_field as lead_description_field,a.status as lead_status, m.id as user_id,m.emp_id,m.email as user_mail,m.phone as user_phone,CONCAT_WS(" ", ui.first_name, ui.last_name) as user_name');
        $this->db->join('users m', 'm.id=a.user_id', 'left');
        $this->db->join('user_information ui', 'a.user_id=ui.user_id', 'left');
        return $this->db->get_where('leads a',array('a.id' => $id));
    }
     public function Allleads($count = "", $rowno = "", $rowperpage = "", $search = "")
    {
        $this->db->select('a.id as lead_id,a.created_date,a.complete_date as updated_date,a.contact_name as lead_name,a.company_name,a.phone_no as lead_phone,a.email as lead_mail, a.city as lead_city,a.state as lead_state, a.street as lead_street,a.no_of_trucks as lead_total_trucks,a.DOT_number as lead_dot_number,a.zip_code as lead_zip_code,a.potential_gallons as lead_potential_gallons,a.description_field as lead_description_field,a.status as lead_status,a.acct, m.id,m.emp_id,m.email as user_mail,m.phone as user_phone,CONCAT_WS(" ", ui.first_name, ui.last_name) as user_name');
        $this->db->from('leads a');
        $this->db->join('users m', 'm.id=a.user_id', 'left');
        $this->db->join('user_information ui', 'a.user_id=ui.user_id', 'left');
        // $this->db->where(array('a.isactive' => 1, 'a.created_by' => 0, 'a.txn_type' => 1,'a.mode' => 1));
    //     $this->db->where(array('a.isactive' => 1, 'a.profit_type' => 7,'a.mode' => 1));
    
    //echo "<pre>"; print_r($search); die(); 
    
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
            
            if (!empty($search['condition'])) {
                $this->db->where('a.type =', $search['condition']);
            }
            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'username') {
                    $this->db->like('m.emp_id', $search['query']);
                } elseif ($search['search_by'] == 'email') {
                    $this->db->like('m.email', $search['query']);
                } elseif ($search['search_by'] == 'mobile') {
                    $this->db->like('m.phone', $search['query']);
                } else {

                }
            } else {
                if (!empty($search['query'])) {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%' OR m.phone LIKE '%" . $search['query'] . "%' OR m.emp_id LIKE '%" . $search['query'] . "%' OR m.email LIKE '%" . $search['query'] . "%' OR a.name LIKE '%" . $search['query'] . "%' OR a.company_name LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                }
            }
        }
        $this->db->ORDER_BY('a.created_date', 'DESC');
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
	
	
	
	
	
	
	

    public function UserBanks($user_id)
    {
        $this->db->select('name_in_bank,bank_name,branch_name,account_number,ifsc_code,created_date,status,is_default');
        $this->db->from('bank_details');
        $this->db->where('user_id=', $userid);
        $query = $this->db->get();
        return $query->result();
    }
    public function UserKYC($user_id = '')
    {
        $this->db->select('m.image as address_proof,md.image as national_proof,kyc.address_id_status,kyc.national_id_status');
        $this->db->from('kyc');
        $this->db->join('media m', 'kyc.address_id=m.id', 'LEFT');
        $this->db->join('media md', 'kyc.national_id=md.id', 'LEFT');
        if ($user_id != '') {
            $this->db->where('kyc.user_id=', $userid);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function UsersTicketsListing()
    {
        $this->db->select('t.subject,t.body,t.status,t.assigned_to,m.image as attachment,t.created_date');
        $this->db->from('tickets t');
        $this->db->join('media m', 't.image_id =m.id', 'LEFT');
        $query = $this->db->get();
        return $query->result();
    }
    public function UserListing()
    {
        $this->db->select('m.id,m.username,CONCAT_WS(" ", ui.first_name, ui.last_name) as name');
        $this->db->from('users m');
        $this->db->join('user_information ui', 'm.id=ui.user_id', 'left');
    //    $this->db->where(array('m.isactive' => 1, 'm.id!=' => 1));
        $this->db->ORDER_BY('m.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function CreditHistory($count = "", $rowno = "", $rowperpage = "", $search = "")
    {
        $this->db->select('a.created_date,amount,a.type,a.remarks,m.id,m.username,m.email,m.phone,CONCAT_WS(" ", ui.first_name, ui.last_name) as name');
        $this->db->from('accounts a');
        $this->db->join('members m', 'm.id=a.user_id', 'left');
        $this->db->join('user_information ui', 'a.user_id=ui.user_id', 'left');
        // $this->db->where(array('a.isactive' => 1, 'a.created_by' => 0, 'a.txn_type' => 1,'a.mode' => 1));
         $this->db->where(array('a.isactive' => 1, 'a.profit_type' => 7,'a.mode' => 1));
        if (!empty($search)) {
            if (!empty($search['condition'])) {
                $this->db->where('a.type =', $search['condition']);
            }
            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'username') {
                    $this->db->like('m.username', $search['query']);
                } elseif ($search['search_by'] == 'email') {
                    $this->db->like('m.email', $search['query']);
                } elseif ($search['search_by'] == 'mobile') {
                    $this->db->like('m.phone', $search['query']);
                } else {

                }
            } else {
                if (!empty($search['query'])) {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%' OR m.phone LIKE '%" . $search['query'] . "%' OR m.username LIKE '%" . $search['query'] . "%' OR m.email LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                }
            }
        }
        $this->db->ORDER_BY('a.created_date', 'DESC');
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

    public function PurchaseListing($count = "", $rowno = "", $rowperpage = "", $search = "")
    {
        $this->db->select('m.id as user_id,m.username,m.email,m.phone,a.mode,a.id,a.created_date,a.amount,a.invoice_number,CONCAT_WS(" ", ui.first_name, ui.last_name) as name');
        $this->db->from('accounts a');
        $this->db->join('user_information ui', 'a.user_id = ui.user_id');
        $this->db->join('members m', 'a.user_id = m.id');
        $this->db->where(array('a.txn_type' => 2, 'a.type' => 2, 'a.isactive' => 1));
        if (!empty($search)) {
            if (!empty($search['condition'])) {
                $this->db->where('a.mode =', $search['condition']);
            }

            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'username') {
                    $this->db->like('m.username', $search['query']);
                } elseif ($search['search_by'] == 'email') {
                    $this->db->like('m.email', $search['query']);
                } elseif ($search['search_by'] == 'mobile') {
                    $this->db->like('m.phone', $search['query']);
                } else {

                }
            } else {
                if (!empty($search['query'])) {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%' OR m.phone LIKE '%" . $search['query'] . "%' OR m.username LIKE '%" . $search['query'] . "%' OR m.email LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                }
            }
        }
        $this->db->ORDER_BY('a.created_date', 'DESC');
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
    public function department_data($type = "")
    {
        if ($type == 'user') {
            $this->db->select('a.id, a.title');
            $this->db->from('department a');
            $this->db->join('faq b', 'a.id=b.department_id', 'inner');
            $this->db->where(array('a.isactive' => 1, 'b.isactive' => 1));
            $this->db->group_by('a.id');
        } else {
            $this->db->select('id,title');
            $this->db->from('department');
            //$where = "(title LIKE '%".$term."%')";
            $this->db->where(array('isactive' => 1));
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function faq_data($count = "", $rowno = "", $rowperpage = "", $search = "")
    {
        $this->db->select('fq.id,fq.question,fq.answer,fq.created_date,fq.isactive,dp.title,dp.id as dep_id');
        $this->db->from('faq fq');
        $this->db->join('department dp', 'fq.department_id = dp.id');
        $this->db->where(array('dp.isactive' => 1));

        if (!empty($search)) {
            if (!empty($search['condition'])) {
                $this->db->where('fq.isactive =', $search['condition'] == 2 ? 0 : 1);
            }

            if (!empty($search['search_by'])) {
                $this->db->where('fq.department_id =', $search['search_by']);
            } else {
                if (!empty($search['query'])) {
                    $where = "(fq.question LIKE '%" . $search['query'] . "%' OR fq.answer LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                }
            }
        }

        $this->db->ORDER_BY('fq.id', 'DESC');
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
    public function oldgetTeam($count = "", $rowno = "", $rowperpage = "", $search = "")
    {
        #$this->db->select("m.id as refid,m.phone as username,m.ref_by,m.level,m.created_date as register_date,SUM(a.amount) as total_purchase,ui.first_name as name, d.title as designation,u.f_name as referdby,b.phone as refusername");
        #$this->db->from('members m');

        #$this->db->join('accounts a', 'm.id = a.front_user_id AND a.txn_type=2 AND a.type = 1 AND a.isactive=2', 'LEFT');
        #$this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
        #$this->db->join('designation d', 'd.id=m.designation', 'LEFT');
        #$this->db->join('user_information u', 'm.ref_by = u.user_id', 'LEFT');
        #$this->db->join('members b', 'm.ref_by = b.id', 'LEFT');

        $this->db->select("m.id as refid,m.username as username,m.ref_by,m.level,m.created_date as register_date, m.full_name as name, m.email, m.phone, m.paid_status, b.full_name as referdby,b.username as refusername, SUM(pp.price) as total_purchase");
        $this->db->from('members m');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
        $this->db->join('packages_purchase pp', 'pp.user_id = m.id', 'LEFT');
        $this->db->join('members b', 'm.ref_by = b.id', 'LEFT');
        $this->db->where(array('m.isactive' => 1, 'm.id!=' => 1));
        if (!empty($search)) {
            if(!empty($search['username'])) {
                $this->db->where('m.ref_by='.$search['username']);
            }

            if (!empty($search['condition'])) {
                if ($search['condition'] == 2) {
                    $this->db->where('a.amount IS NULL');
                } elseif ($search['condition'] == 1) {
                    $this->db->where('a.amount IS NOT NULL');
                } else {

                }
            }

            if (!empty($search['level'])) {
                $this->db->where('m.level =', $search['level']);
            }

            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'username') {
                    $this->db->like('m.username', $search['query']);
                } elseif ($search['search_by'] == 'email') {
                    $this->db->like('m.email', $search['query']);
                } elseif ($search['search_by'] == 'mobile') {
                    $this->db->like('m.phone', $search['query']);
                } else {

                }
            } else {
                if (!empty($search['query'])) {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%' OR m.phone LIKE '%" . $search['query'] . "%' OR m.username LIKE '%" . $search['query'] . "%' OR m.email LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                }
            }
        }
        $this->db->group_by('m.id');
        $this->db->ORDER_BY('m.id', 'DESC');
        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            $res = $query->num_rows();
        } else {
            $res = $query->result_array();
        }
        return $res;
    }
     public function getTeam($count = "", $rowno = "", $rowperpage = "", $search = "")
    {
        #echo '<pre>';print_r($search); //die;
        #$this->db->select("m.id as refid,m.phone as username,m.ref_by,m.level,m.created_date as register_date,SUM(a.amount) as total_purchase,ui.first_name as name, d.title as designation,u.f_name as referdby,b.phone as refusername");
        #$this->db->from('members m');

        #$this->db->join('accounts a', 'm.id = a.front_user_id AND a.txn_type=2 AND a.type = 1 AND a.isactive=2', 'LEFT');
        #$this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
        #$this->db->join('designation d', 'd.id=m.designation', 'LEFT');
        #$this->db->join('user_information u', 'm.ref_by = u.user_id', 'LEFT');
        #$this->db->join('members b', 'm.ref_by = b.id', 'LEFT');

        $this->db->select("m.id as refid,m.username as username,m.ref_by,m.level,m.created_date as register_date, m.full_name as name, m.email, m.phone, m.paid_status, b.full_name as referdby,b.username as refusername,m.parent_id, SUM(pp.price) as total_purchase");
        $this->db->from('members m');
        $this->db->join('user_information ui', 'ui.user_id = m.id', 'LEFT');
        $this->db->join('packages_purchase pp', 'pp.user_id = m.id', 'LEFT');
        $this->db->join('members b', 'm.ref_by = b.id', 'LEFT');
        $this->db->where(array('m.isactive' => 1, 'm.id!=' => 1));
        if(!empty($search['user_id'])) {
                $this->db->where('m.ref_by='.$search['user_id']);
            }

        if (!empty($search)) {
            if(!empty($search['username'])) {
                $this->db->where('m.ref_by='.$search['username']);
            }
            

            if (!empty($search['condition'])) {
                if ($search['condition'] == 2) {
                    #$this->db->where('a.amount IS NULL');
                     $this->db->where(array('m.paid_status' => 0));
                } elseif ($search['condition'] == 1) {
                    #$this->db->where('a.amount IS NOT NULL');
                    $this->db->where(array('m.paid_status' => 1));
                } else {

                }
            }

            if (!empty($search['level'])) {
                $this->db->where('m.level =', $search['level']);
            }

            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'username') {
                    $this->db->like('m.username', $search['query']);
                } elseif ($search['search_by'] == 'email') {
                    $this->db->like('m.email', $search['query']);
                } elseif ($search['search_by'] == 'mobile') {
                    $this->db->like('m.phone', $search['query']);
                } else {

                }
            } else {
                if (!empty($search['query'])) {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%' OR m.phone LIKE '%" . $search['query'] . "%' OR m.username LIKE '%" . $search['query'] . "%' OR m.email LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                }
            }
        }
        $this->db->group_by('m.id');
        $this->db->ORDER_BY('m.id', 'DESC');
        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        if ($count) {
            $res = $query->num_rows();
        } else {
            $res = $query->result_array();
        }
        #echo $this->db->last_query();
        #die;
        return $res;
    }

    public function binary_profit($rowno = "", $rowperpage = "", $search = "")
    {
        $this->db->select('me.id,me.email,me.username,ui.first_name,ui.last_name,m.phone,SUM(pf.amount) as total_Bprofit,bs.currentbusinessL,bs.currentbusinessR,bs.carryL,bs.carryR,bs.totalbusinessL,bs.totalbusinessR');
        $this->db->from('profit pf');
        $this->db->join('members me', 'me.id = pf.user_id', 'LEFT');
        $this->db->join('user_information ui', 'me.id = ui.user_id', 'LEFT');
        $this->db->join('binary_statas bs', 'bs.userId = me.id', 'LEFT');
        $this->db->where(array('pf.type' => 9));

        if (!empty($search)) {
            if (!empty($search['search_by'])) {
                if ($search['search_by'] == 'name') {
                    //$where = "(ui.first_name LIKE '%".$search['query']."%' OR ui.last_name LIKE '%".$search['query']."%')";
                    $where = "(strcmp(soundex(CONCAT(ui.first_name,' ', ui.last_name)), soundex('" . $search['query'] . "'))=0)";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'username') {
                    //$this->db->like('me.username', $search['query']);
                    $where = "(strcmp(soundex(me.username), soundex('" . $search['query'] . "'))=0)";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'email') {
                    //$this->db->like('me.email', $search['query']);
                    $where = "(strcmp(soundex(me.email), soundex('" . $search['query'] . "'))=0)";
                    $this->db->where($where);
                } elseif ($search['search_by'] == 'mobile') {
                    //$this->db->like('m.phone', $search['query']);
                    $where = "(strcmp(soundex(m.phone), soundex('" . $search['query'] . "'))=0)";
                    $this->db->where($where);
                } else {

                }
            } else {
                if (!empty($search['query'])) {
                    $where = "(ui.first_name LIKE '%" . $search['query'] . "%' OR ui.last_name LIKE '%" . $search['query'] . "%' OR m.phone LIKE '%" . $search['query'] . "%' OR me.username LIKE '%" . $search['query'] . "%' OR me.email LIKE '%" . $search['query'] . "%')";
                    $this->db->where($where);
                }
            }
        }

        $this->db->group_by('pf.user_id');
        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        return $query->result_array();
        /*$bnprof = $this->db->query("SELECT me.id,me.email,me.username,ui.first_name,ui.last_name,m.phone,SUM(pf.amount) as total_Bprofit,bs.currentbusinessL,bs.currentbusinessR,bs.carryL,bs.carryR FROM `profit` as pf
    LEFT JOIN members as me on me.id = pf.user_id
    LEFT JOIN user_information as ui on me.id = ui.user_id
    LEFT JOIN binary_statas as bs on bs.userId = me.id
    WHERE `type`= 9 GROUP BY pf.user_id");
    $bnprof = $bnprof->result_array();
    return $bnprof;*/
    }

    public function recent_updates()
    {
        $query = 'SELECT * FROM (
		(SELECT CONCAT(ui2.f_name," Send help to ",ui.first_name," of Amount ",a.amount) as news,a.created_date
		FROM accounts a
		LEFT JOIN payment_method pm ON a.mode = pm.id
		LEFT JOIN user_information ui ON a.user_id=ui.user_id
		LEFT JOIN user_information ui2 ON a.front_user_id=ui2.user_id
		WHERE a.txn_type=2 AND a.type=1
		ORDER BY a.created_date DESC)
		UNION ALL
		(SELECT CONCAT(ui.first_name,"(",m.username,")"," is new registration ") as news,m.created_date
		FROM members m
		LEFT JOIN user_information ui ON m.id=ui.user_id
		WHERE m.email_status=1 AND m.isactive=1
		ORDER BY m.created_date DESC)
		) results
		ORDER BY created_date DESC LIMIT 10';
        $query = $this->db->query($query);
        return $query->result_array();
    }
    ############################
    #
    #
    ############################
    /*public function purchaseManagement($rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'pp.id,pp.user_id,pp.price as amount, pp.status, pp.weekly_percentage, pp.created_date,pp.payment_via, pp.title, m.full_name as name, m.username,m.email,m.phone, rm.username as ref_username, rm.full_name as ref_name, rm.email as ref_email, (CASE WHEN pp.payment_via = 1 THEN "Bitcoin" ELSE "Wallet" END) as pay_mode';
        // $where_array = array('a.profit_type'=>$profit_type);

        $this->db->select($colums);
        $this->db->from('packages_purchase pp');
        $this->db->join('members m', 'm.id = pp.user_id', 'LEFT');
        $this->db->join('members rm', 'rm.id = m.ref_by', 'LEFT');

        $this->db->where(['pp.package_id!='=>'7']);

        if (!empty($search)) {

            if (!empty($search['startdate']) && empty($search['enddate'])) {
                $array = array('DATE(pp.created_date) >=' => $search['startdate']);
                $this->db->where($array);
            }
            if (!empty($search['enddate']) && empty($search['startdate'])) {
                $array = array('DATE(pp.created_date) <=' => $search['enddate']);
                $this->db->where($array);
            }
            if (!empty($search['startdate']) && !empty($search['enddate'])) {
                $array = array('DATE(pp.created_date) >=' => $search['startdate'], 'DATE(pp.created_date) <=' => $search['enddate']);
                $this->db->where($array);
            }

            if (!empty($search['search_by'])) {
                if (!empty($search['query'])) {
                    if ($search['search_by'] == 'name') {
                        $where = "(m.full_name LIKE '%" . trim($search['query']) . "%')";
                        $this->db->where($where);
                    } elseif ($search['search_by'] == 'username') {
                        $this->db->like('m.username', trim($search['query']));
                    } elseif ($search['search_by'] == 'email') {
                        $this->db->like('m.email', trim($search['query']));
                    } elseif ($search['search_by'] == 'mobile') {
                        $this->db->like('m.phone', trim($search['query']));
                    } else {

                    }
                }
            } else {
                if (!empty($search['query'])) { 
                    $where = "(m.full_name LIKE '%" . trim($search['query']) . "%' OR m.phone LIKE '%" . trim($search['query']) . "%' OR m.username LIKE '%" . trim($search['query']) . "%' OR m.email LIKE '%" . trim($search['query']) . "%')";
                    $this->db->where($where);
                }
            }
        }

        $this->db->order_by('pp.created_date', 'DESC');

        if ($rowperpage != '') {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        $res = $query->result_array();
        #echo $this->db->last_query();
        return $res;
    }*/

    public function reward_pointManagement($rowno = "", $rowperpage = "", $search = "")
    {
        $colums = 'rp.id,rp.user_id,rp.profit_type ,rp.reward_point as amount, rp.isactive, rp.created_date, CONCAT_WS(" ", m.first_name, m.last_name) as name, m.emp_id,m.email,m.phone';
        // $where_array = array('a.profit_type'=>$profit_type);
      //echo '<pre>'; print_r($search);
       //echo $rowperpage;
        $this->db->select($colums);
        $this->db->from('rewards rp');
        $this->db->join('users m', 'm.id = rp.user_id', 'LEFT');
   //     $this->db->join('members rm', 'rm.id = m.ref_by', 'LEFT');
        
    //    $this->db->join('staking_duration sd', 'sd.id = pp.duration', 'LEFT');        #monika
        
    //    $this->db->join('members acm', 'acm.id = m.paid_by', 'LEFT');   #vikash
        
    //    $this->db->join('accounts ac', 'ac.id = pp.package_id', 'LEFT');

        #$this->db->where(['pp.package_id!='=>'7']);
        if (!empty($search)) {

            if (!empty($search['startdate']) && empty($search['enddate'])) {
                $array = array('DATE(rp.created_date) >=' => $search['startdate']);
                $this->db->where($array);
            }
            if (!empty($search['enddate']) && empty($search['startdate'])) {
                $array = array('DATE(rp.created_date) <=' => $search['enddate']);
                $this->db->where($array);
            }
            if (!empty($search['startdate']) && !empty($search['enddate'])) {
                $array = array('DATE(rp.created_date) >=' => $search['startdate'], 'DATE(rp.created_date) <=' => $search['enddate']);
                $this->db->where($array);
            }

            if (!empty($search['search_by'])) {
                if (!empty($search['query'])) {
                    if ($search['search_by'] == 'name') {
                        $where = "(m.first_name LIKE '%" . trim($search['query']) . "%')";
                        $this->db->where($where);
                    } elseif ($search['search_by'] == 'username') {
                        $this->db->like('m.emp_id', trim($search['query']));
                    } elseif ($search['search_by'] == 'email') {
                        $this->db->like('m.email', trim($search['query']));
                    } elseif ($search['search_by'] == 'mobile') {
                        $this->db->like('m.phone', trim($search['query']));
                    } else {

                    }
                }
            } else {
                if (!empty($search['query'])) {
                    $where = "(m.first_name LIKE '%" . trim($search['query']) . "%' OR m.phone LIKE '%" . trim($search['query']) . "%' OR m.emp_id LIKE '%" . trim($search['query']) . "%' OR m.email LIKE '%" . trim($search['query']) . "%')";
                    $this->db->where($where);
                }
            }
        }
        #$this->db->group_by('ac.invoice_number', 'DESC');
        $this->db->order_by('rp.created_date', 'DESC');
        
        if ($rowperpage >0) {
            $this->db->limit($rowperpage, $rowno);
        }
        $query = $this->db->get();
        $res = $query->result_array();
     #echo $this->db->last_query();
     #die;
        return $res;
    }

    /*--------------------------------------------------------------------------------------------------*/
    public function Getlevel($user_id="")
    { 
        
        $where_array = array('ds.user_id' => $user_id,'ds.user_id>' => 0);
        $this->db->select('ds.parent_id,ds.user_id,ds.level,pp.price');
        $this->db->from('members m');
       
        $this->db->join('dstat ds', '' . $user_id . '=ds.user_id and m.id=ds.user_id', 'LEFT');
         $this->db->join('packages_purchase pp', 'pp.user_id = ds.user_id', 'LEFT');
        $this->db->where($where_array);
        //$this->db->IN(35,36);
        $query = $this->db->get();
        $res = $query->result_array();
    //echo $this->db->last_query();
        //echo "<pre>";print_r($res);
      return $res;
      //die;
    }



    public function get_level_Amount($user_id="")
    {
         $where_array = array('ds.parent_id' => $user_id,'ds.parent_id>' => 0,'ds.level'=>1,'td.status!='=>2);
        $this->db->select('ds.parent_id,ds.user_id,ds.level,SUM(td.total_business) as total_business,td.days,td.status');
        $this->db->from('dstat ds');
       
        //$this->db->join('dstat ds', '' . $user_id . '=ds.parent_id and m.id=ds.user_id', 'LEFT');
        $this->db->join('t_dstat td','td.parent_id=ds.parent_id', 'LEFT');
        $this->db->where($where_array);
        $this->db->group_by('ds.user_id');
        //$this->db->limit(1); 
        //$this->db->IN(35,36);
        $query = $this->db->get();
        $res = $query->result_array();
    //echo $this->db->last_query();
        //echo "<pre>";print_r($res);
      return $res;
     //die;
    }


    public function parent_amount($userid="")
    {
        $this->db->select('*,DATEDIFF(CURDATE(), createdate) AS days');
        $this->db->from('t_dstat');
        $this->db->where(array('parent_id' => $userid));
        $query = $this->db->get();
        return $query->result();
         //echo $this->db->last_query();
         //die;

    }


    public function rewards_t($id="")
    {
        $this->db->select('*');
        $this->db->from('manage_rewards');
        if($id>0)
        {
        $this->db->where(array('id' => $id));   
        }
        $query = $this->db->get();
        return $query->result_array();
         //echo $this->db->last_query();
         //die;

    }
public function members_data($orderby = "", $orderpattern = "")
    {
        $this->db->select('id,username,full_name,email,phone,isactive');
        $this->db->from('members');
        //$this->db->where(array('isactive' => 1));
        if (!empty($orderby)) {
            $this->db->order_by($orderby, $orderpattern);
        }
        $query = $this->db->get();
        return $query->result_array();
    }


#vikash 
public function get_data($table = "", $and = "", $columns = "*", $return_arr = "full", $join = "")
	{
		$columns = ($columns == "" ? "*" : $columns);
		$sql     = "SELECT " . $columns . " FROM " . $table . " " . $join . " WHERE 1=1" . " " . $and;

		$query = $this->db->query($sql);
		// print_r($this->db->last_query());die;
		if ($return_arr == "full") {
			return $query->result_array();
		} else {
			return $query->row_array();
		}
	}

	public function userDepartmnet($data)
	{
		// print_r($data);die;
		$this->db->insert('admin', $data);
		$insert_id = $this->db->insert_id();		
		return $insert_id;
	}

	public function adminDepartmnet($data)
	{

		$this->db->insert('admin_department', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
    #monika(10-02-2021)
    public function tranferdetail(){
        #echo "ysss"; die();
        $this->db->select('aa.id,aa.user_id,aa.type,aa.amount,aa.txn_type,aa.front_user_id,aa.profit_type,aa.created_date,m.username as username_wga,mm.username as username_wta,CONCAT_WS(" ", ui.first_name, ui.last_name) as name_wga,CONCAT_WS(" ", uui.first_name, uui.last_name) as name_wta');
        $this->db->from('accounts aa');
        $this->db->join('members m', 'aa.user_id=m.id', 'left');
      $this->db->join('members mm', 'aa.front_user_id=mm.id', 'left');
         $this->db->join('user_information ui', 'aa.user_id=ui.user_id', 'left');
      $this->db->join('user_information uui', 'aa.front_user_id=uui.user_id', 'left');
        $this->db->where(array('aa.profit_type' => 7, 'aa.txn_type' => 3, 'aa.front_user_id !=' => 0));
        $this->db->ORDER_BY('aa.created_date', 'DESC');
        $query = $this->db->get();
     #print_r($this->db->last_query());die;
        return $query->result_array();
    }
    public function delete_lead($id){
        $this->db->where('id',$id);
        $this->db->delete('leads');
    }
}
