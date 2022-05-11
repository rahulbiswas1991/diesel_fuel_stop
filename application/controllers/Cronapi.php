<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once dirname(__FILE__) . "/Common.php";
class Cronapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();      
        $this->load->library('email');  
    }

    public function index(){
        $data['heading'] = '404 Error';
        $data['message'] = 'This is Broken, Please Contact Administrator';
        $this->load->view('errors/html/error_404', $data);
    }

    public function fivepm_report() {
        
        $this->load->model("admin_modal");
        $query =$this->admin_modal->get_all_data();
  
        $query = $query->result_array();

        // $filename = "fuel-records-" . date("YmdGis") . ".csv";
        // $now = gmdate("D, d M Y H:i:s");
        // header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        // header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        // header("Last-Modified: {$now} GMT");

        // // force download  
        // header("Content-Type: application/force-download");
        // header("Content-Type: application/octet-stream");
        // header("Content-Type: application/download");

        // // disposition / encoding on response body
        // header("Content-Disposition: attachment;filename={$filename}");
        // header("Content-Transfer-Encoding: binary");

        if (count($query) == 0) {
            return null;
        }

        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($query)));
        foreach ($query as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        $buffer = ob_get_clean();

        // Config
        $config = array();
        $config['useragent'] = "Diesel Fuel Stop";
        $config['mailpath'] = "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "mail.dieselfuelstop.com";
        $config['smtp_port'] = 26;
        $config['smtp_crypto'] = "ssl";
        $config['smtp_user'] = "no-reply@dieselfuelstop.com";
        $config['smtp_pass'] = 'noreplydieselfuelstop';
        $config['priority'] = "1";
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        // Initilize email config settings 
        $this->email->initialize($config);
       
        // prepare email
        $this->email
            ->from('no-reply@dieselfuelstop.com', 'Diesel Fuel Stop')
            ->to('aarbiswas1991@gmail.com', 'Rahul Biswas')            
            ->subject('Five PM Report email'.date("Y-m-d-s"))
            ->message('This is report message'.date("Y-m-d-s"))
            ->set_mailtype('html')
            ->attach($buffer, 'attachment', "fuel-records-" . date("Y-m-d-s") . ".csv", 'application/octet-stream');

        // send email
        $status = $this->email->send();
        
        if ($status) {
            print_r('email sent'); die();
        } else {
            print_r ($status); die();
        }

      
        

    } 
}