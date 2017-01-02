<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main extends CI_Controller{
    function __construct()
    {
        parent::__construct();
//        $this->load->helper(array('form', 'url'));
        $this->load->model('admin/main_model');
        $this->login_catch();
    }

    public function index(){
        $username = $this->input->post_get('uname');

        $isLoggedin =  $this->session->userdata('isLoggedIn');
        $username =  $this->session->userdata('username');
        // $this->load->model('admin/main_model');
        $data["results"] = $this->main_model->get_user_info($username);

        $data['level'] = $this->get_level();
        $data['alerts'] = $this->main_model->get_announcements();
        if($isLoggedin){
            $this->load->view('admin/main',$data);
        } else {
            redirect('admin','refresh');
        }

    }

    public function login_catch(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->load->view('admin/ajax_login');
        }
    }

    public function get_level(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            $username =  $this->session->userdata('username');
            // $this->load->model('admin/main_model');
            $data["results"] = $this->main_model->get_level($username);

            return $data["results"][0]->level;
        }

    }

    public function get_dept(){

        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            return $this->main_model->get_all_department();
        }

    }

    public function get_dept_office($office){
        $office = '1';
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            return $this->main_model->get_office_department($office);
        }

    }

    public function get_pools(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            // $this->load->model('admin/main_model');

            return $this->main_model->get_all_pools();
        }

    }

    public function get_month_name($date){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            // $this->load->model('admin/main_model');

            return $this->main_model->get_month($date);
        }
    }

    public function load_dashboard(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            redirect('/admin/', 'refresh');
        } else {
            // $this->load->model('admin/main_model');
            $data["filter_department"] = $this->main_model->get_all_department();
            $data["summary"] = $this->main_model->load_summary();
            $this->load->view('admin/dashboard', $data);
        }
    }

    public function load_ajax_login(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            // $this->load->model('admin/main_model');
            $data["results"] = $this->main_model->get_all_login();
            $this->load->view('admin/ajax_login', $data);
        }

    }

    public function load_ajax_login_dept(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            $dept = $this->input->post('dept');
            // $this->load->model('admin/main_model');
            $data["results"] = $this->main_model->get_all_login_filtered($dept);
            $this->load->view('admin/ajax_login', $data);
        }
    }

//    Logging
    public function logging($empid, $action){

        $this->main_model->logged_action($empid, $action);
    }

//    IP Addresses Controller
    public function load_ipaddress(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            // $this->load->model('admin/main_model');
            $data['ipaddresses'] = $this->main_model->get_ip_addresses();
            $this->load->view('admin/ipaddress', $data);
//        print_r($data);
        }
    }

    public function add_ip(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            $this->load->view('admin/ajax_add_ip');
        }
    }

    public function edit_ip(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            $id = $this->input->post('id');
            // $this->load->model('admin/main_model');
            $data['result'] = $this->main_model->get_ip_specific($id);
            $this->load->view('admin/ajax_edit_ip', $data);
        }
    }

    public function delete_ip(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            $id = $this->input->post('id');
            // $this->load->model('admin/main_model');
            $data['result'] = $this->main_model->delete_ip($id);
            $this->load->view('admin/ajax_edit_ip', $data);
        }
    }

    public function upload_file(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            $ip = $this->input->post_get('ip');
            $location = $this->input->post_get('location');
            // $this->load->model('admin/main_model');
            $this->main_model->save_ip($ip, $location);
        }
    }

// EMPLOYEE Controllers
    public function load_employee(){
        if($this->session->userdata('isLoggedIn') == FALSE){
            $this->logOut();
        } else {
            // $this->load->model('admin/main_model');
            $data['employee'] = $this->main_model->get_emp_info();
            $this->load->view('admin/employee', $data);
        }
    }

    public function add_emp(){


        $data['dept'] = $this->main_model->get_department();
        $this->load->view('admin/ajax_add_emp',$data);
    }

    public function upload_file_emp(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added new employee.');

        $params = $_GET;
        $empid = $this->input->post_get('empid');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->add_emp($params);
        $this->main_model->add_user($empid);

        print_r($data);
    }

    public function update_emp(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated employee.');

        $params = $_GET;
        $id = $this->input->post_get('id');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->update_emp($params,$id);

        print_r($data);
    }

    public function edit_emp(){
        $id = $this->input->post('id');
        $data['dept_get'] = $this->input->post('dept');
        // $this->load->model('admin/main_model');
        $data['result'] = $this->main_model->get_emp_specific($id);
        $data['dept'] = $this->get_dept();
        $this->load->view('admin/ajax_edit_emp',$data);

    }

    public function delete_emp(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted an employee.');

        $id = $this->input->post('id');
        $uname = $this->input->post('uname');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->delete_emp($id,$uname);
        $this->load->view('admin/ajax_edit_ip',$data);
    }

    public function mark_resign(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Marked as a resigned employee.');

        $id = $this->input->post('id');

        $data = $this->main_model->mark_resign($id);
        print_r($data);
    }

    public function load_users(){
        // $this->load->model('admin/main_model');
        $data['users'] = $this->main_model->get_users_info();
        $this->load->view('admin/users',$data);
    }

    public function add_users(){
        $this->load->view('admin/ajax_add_users');
    }

    public function delete_users(){
        $id = $this->input->post('id');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->delete_user($id);
        print_r($data);
    }

    public function update_timein_info(){

        $id = $this->input->post('id');
        $timein = $this->input->post('timein');
        $timeout = $this->input->post('timeout');

        $data = $this->main_model->update_timein_info($id,$timein,$timeout);
        print_r($data);
    }

//    Attendance Controllers

    public function load_attendance(){

        $username = $this->input->post('username');
        $office = $this->get_office($username);
        $data['dept'] = $this->main_model->get_dept_office($office);
        $this->load->view('admin/attendance_monitor',$data);
    }

    public function load_attendance_table(){
        $data['results'] = $this->main_model->get_attendance_info();
        $this->load->view('admin/attendance',$data);
    }

    public function load_scheduling(){
        // $this->load->model('admin/main_model');
        $username = $this->input->post('username');
        $office = $this->get_office($username);
        $data['dept'] = $this->main_model->get_dept_office($office);
        $data["lastday"] = $this->main_model->get_last_day();
//        $data["dept"] = $this->main_model->get_all_department();
        $lastday = $data["lastday"];
        $data["lastday"] = $lastday[0]->LASTDAY;



        $this->load->view('admin/scheduling',$data);
    }

    public function get_attendance_data(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Get attendance data.');

        $dept = $this->input->post('dept');
        $month = $this->input->post('month');

        $date = substr($month, 3,6)."-".substr($month,0,2).'-01';
        // $this->load->model('admin/main_model');

        $this->main_model->create_schedule_template($dept,$date);
        $data["emp_info"] = $this->main_model->get_emp_schedule($dept,$date);
        $data["lastday"] = $this->main_model->get_month_info($date);
        $data["sched_template"] = $this->main_model->get_sched_template($dept);
//        $cnt = $this->main_model->get_emp_rows($dept,$date);


        $lastday = $data["lastday"];
        $data["lastday"] = $lastday[0]->LASTDAY;
        $data["dayname"] = $lastday[0]->DAY_NAME;
        $this->load->view('admin/schedule_setup',$data);


    }

    public function reset_schedule(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Reset schedule.');

        $dept = $this->input->post('dept');
        $month = $this->input->post('month');

        $date = substr($month, 3,6)."-".substr($month,0,2).'-01';
        // $this->load->model('admin/main_model');

        $data = $this->main_model->reset_schedule($dept,$date);

        print_r($data);


    }

    public function get_attendance_dept_month(){
        $dept = $this->input->post('dept');
        $date = $this->input->post('date')."-01";
        $data["results"] = $this->main_model->get_attendance_dept_month($dept,$date);

        $this->load->view('admin/attendance',$data);


    }

    public function getJSONData(){
        $dept = $this->input->get('dept');
        // $this->load->model('admin/main_model');

        $data["sched_template"] = $this->main_model->get_sched_template($dept);

        $arrayData = [];
        foreach($data["sched_template"] as $row){

            $arrayData[$row->code] =  $row->code;

        }



        print json_encode($arrayData);

    }

    public function updateSched(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated schedule.');

         $id = $this->input->post('id');
         $dayNo = $this->input->post('dayNo');
         $value = $this->input->post('value');
        // $this->load->model('admin/main_model');
        $this->main_model->updateSched($id,$value,$dayNo);

        echo $value;
    }

    public function logOut() {
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Logout.');
        $this->session->sess_destroy();
        $newdata = array(
            'id' => 0,
            'msg'  => "You have been logout."
        );
        $this->session->set_userdata($newdata);
        redirect('client/admin','refresh');

    }

//    Scheduling Template

    public function load_scheduling_template(){
//            $dept = $this->input->post('dept');
            // $this->load->model('admin/main_model');
            $data['templates'] = $this->main_model->get_schedule_template_all();
            $this->load->view('admin/scheduling_template',$data);

    }

    public function load_template(){
        $data['dept'] = $this->get_dept();
        $this->load->view('admin/ajax_add_template',$data);
    }

    public function add_template(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added new template.');
        $ip = $this->input->post_get('code');
        $dsc = $this->input->post_get('dsc');
        $timein = $this->input->post_get('timein');
        $timeout = $this->input->post_get('timeout');
        $dept = $this->input->post_get('dept');
        $color = $this->input->post_get('color');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->save_template($ip,$dsc,$timein,$timeout,$dept,$color);
        print_r($data);
    }

    public function delete_template(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted template.');
        $id = $this->input->post('id');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->delete_template($id);
        print_r($data);
    }

    public function edit_template(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Modified template.');
        $id = $this->input->post('id');
        $data["dept_get"] = $this->input->post_get('dept');
        $data["dept"] = $this->get_dept();
        // $this->load->model('admin/main_model');
        $data['result'] = $this->main_model->edit_template($id);
        $this->load->view('admin/ajax_edit_template',$data);
    }

    public function update_template(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated template.');
        $id = $this->input->post_get('id');
        $code = $this->input->post_get('code');
        $dsc = $this->input->post_get('dsc');
        $timein = $this->input->post_get('timein');
        $timeout = $this->input->post_get('timeout');
        $dept = $this->input->post_get('dept');
        $color = $this->input->post_get('color');

        // $this->load->model('admin/main_model');
        $data = $this->main_model->update_template($id,$code,$dsc,$timein,$timeout,$dept,$color);

        print_r($data);

    }

    public function show_legend(){
        $dept = $this->input->post('dept');
        // $this->load->model('admin/main_model');
        $data['result'] = $this->main_model->get_schedule_template($dept);
        $this->load->view('admin/ajax_legend',$data);
    }

//    User leveling controllers

    public function make_admin(){
        $id = $this->input->post_get('id');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->make_admin($id);
        print_r($data);
    }

    public function make_supervisor(){
        $id = $this->input->post_get('id');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->make_supermake_super($id);
        print_r($data);
    }

    public function do_upload(){


        $config = array(
            'upload_path' => "./uploads/",
            'allowed_types' => "csv",
            'overwrite' => FALSE,
            'max_size' => "2048000"
        );
         $this->load->library('upload', $config);
        if($this->upload->do_upload())
        {
            $data = array('upload_data' => $this->upload->data());

        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            echo "Error uploading. Please try again.";
        }

        $file = ($this->upload->data());

        $filename = $file['file_name'];

       $username =  $this->session->userdata('username');


        // $this->load->model('admin/main_model');
        $this->main_model->save_file_bank($this->input->post('txtFName'),$filename,$username,$this->input->post('txtDate'),$this->input->post('selType'),$this->input->post('selDept'));

//        var_dump($_POST);
    }

    public function do_upload2(){

        if($this->input->post('txtFName')){
        $config = array(
            'upload_path' => "./uploads/",
            'allowed_types' => "csv",
            'overwrite' => FALSE,
            'max_size' => "2048000"
        );
        $this->load->library('upload', $config);
        if($this->upload->do_upload())
        {
            $data = array('upload_data' => $this->upload->data());

        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
//            echo "Error uploading. Please try again.";
        }

        $file = ($this->upload->data());
        $filename2 = $file['file_name'];

        // $this->load->model('admin/main_model');
            if($filename2 != null){
                $this->main_model->save_file_admin($this->input->post('txtFName'),$filename2);
                echo "Uploaded successfully.";
            }
            else {
                $this->main_model->delete_file($this->input->post('txtFName'));
                echo "Unsuccessful. Please try again.";
            }
        }



    }

//    BCA FUNCTIONS
    public function get_office($username){

        $data = $this->main_model->get_office($username);
        return $data[0]->office;

    }

    public function load_bca(){
        $this->load->helper('form');
        $username = $this->input->post('username');
        $office = $this->get_office($username);

        if($username == 'mnicdao01'){
            $data['dept'] = $this->get_dept();
        }else {
            $data['dept'] = $this->main_model->get_dept_office($office);
        }
        $data['bank'] = $this->main_model->get_bank();
        $this->load->view('admin/bca', $data);
    }

    public function process_bca(){
        $fname = $this->input->post('fname');
        $date = $this->input->post('date');
        $bank = $this->input->post('bank');
        $type = $this->input->post('type');
        $dept = $this->input->post('dept');

        if($fname){
        // $this->load->model('admin/main_model');
        $this->load->library('csvreader');
        $data['filename'] = $this->main_model->get_filenames($fname);
        $listAdmin = [];
            if($data['filename']){

                $fileBank = ($data['filename'][0]->file_bank);
                $fileAdmin = ($data['filename'][0]->file_admin);


                $filePathBank = base_url().'uploads/'.$fileBank;
                $filePathAdmin = base_url().'uploads/'.$fileAdmin;


                if($filePathBank && $filePathAdmin){
                        $dataBank['csvDataBank'] = $this->csvreader->parse_file($filePathBank);
                        $dataAdmin['csvDataAdmin'] = $this->csvreader->parse_file($filePathAdmin);

                        $nCntTotal = null;
                        $nDetails = null;
                        $nDeposit = null;

                        $nCnt = 1;
                        $nId = 1;
                        $nId2 = 1;

                        $dataBankC = $dataBank['csvDataBank'];
                        $dataAdminC =  $dataAdmin['csvDataAdmin'];

            if($type == "Deposit"){
                //For EACH admin
                $this->main_model->truncate_bca_admin($fname);

                foreach($dataAdminC as $admin){
                    if($admin['Nama Rekening Member']){

//                        $adminName = strtoupper($admin['Nama Rekening Member']);
//                        $adminName = trim($adminName);
//                        $query = "INSERT INTO bca_admin (name,status,docno,date_created,id_level,amount,acc_no) VALUES ('$name',0,'$fname',NOW(),$nId,'$amount','$accno')";
                        $listAdmin [] = [
                            "name" => strtoupper($admin['Nama Rekening Member']),
                            "status" => 0,
                            "docno" => $fname,
                            "date_created" => date('Y-m-d'),
                            "id_level" => $nId2,
                            "amount" => $admin['Nominal'],
                            "acc_no" => $admin['No Rekening Member']
                        ];
//                        $this->main_model->insert_bca_admin(strtoupper($admin['Nama Rekening Member']),$fname,$nId2,$admin['Nominal'],$admin['No Rekening Member'] );
                        $nId2 = $nId2 + 1;

                    }

                    if($dept == 'Shionaga' || $dept == "Duniamimpi" || "4dewa" || "Sakura 1" || "Sakura 2") {
                        if ($admin['Nama Rek Member']) {
                            $listAdmin [] = [
                                "name" => strtoupper($admin['Nama Rek Member']),
                                "status" => 0,
                                "docno" => $fname,
                                "date_created" => date('Y-m-d'),
                                "id_level" => $nId2,
                                "amount" => $admin['Nominal'],
                                "acc_no" => $admin['No Rekening Member']
                            ];
//                            $this->main_model->insert_bca_admin(strtoupper($admin['Nama Rek Member']), $fname, $nId2, $admin['Nominal'], $admin['No Rek Member']);
                            $nId2 = $nId2 + 1;
                        }
                    }
                    if($dept == 'Lotus 1' || $dept == 'Lotus 2' || $dept == 'Lotus 3') {
                        if ($admin['account_name']) {
                            $listAdmin [] = [
                                "name" => strtoupper($admin['account_name']),
                                "status" => 0,
                                "docno" => $fname,
                                "date_created" => date('Y-m-d'),
                                "id_level" => $nId2,
                                "amount" => $admin['jumlah_uang'],
                                "acc_no" => $admin['account_number']
                            ];
//                            $this->main_model->insert_bca_admin(strtoupper($admin['account_name']), $fname, $nId2, $admin['jumlah_uang'], $admin['account_number']);
                            $nId2 = $nId2 + 1;
                        }
                    }
                }
//                print_r($listAdmin);
                $this->main_model->insert_batch_admin($listAdmin);


                //TRUNCATE RECORD VIA FILENAME
                $this->main_model->truncate_bca_records($fname);

            //PROCESS OF BCA
                        if($bank == "BCA"){
                            foreach($dataBankC as $row){
                                if($row['Tgl.'] != ''){
                                $nCnt = 1;
                                    if($nCnt == 1 && $nDetails != ''){

                                        $noQuestion = trim(str_replace("?","",$nDetails));
                                        $noQuestion = str_replace(' ', '-', $noQuestion);
                                        $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                        $noQuestion = str_replace('-', ' ', $noQuestion);
                                        $noQuestion = str_replace('TANGGAL', '', $noQuestion);
                                        $noQuestion = str_replace('WSID', '', $noQuestion);
                                        $noQuestion = str_replace('IDR', '', $noQuestion);
                                        $noQuestion = str_replace('TRANSFER DR', '', $noQuestion);
                                        $noQuestion = str_replace('RESKUIAR', '', $noQuestion);

                                        $arr = explode(' ',trim($noQuestion));
//                                        echo $arr[0]."<br/>"; // will print Test

                                        if(strlen($arr[0]) <= 2){
                                            $noQuestion = explode(' ',trim($noQuestion));
                                            $noQuestion = $noQuestion[1] ." ". $noQuestion[2];
//                                            echo $noQuestion. "<br/>";
                                        }



//                                        print_r($noQuestion. " >>> ".substr_count($noQuestion, ' ')."<br>");
//                                        $this->main_model->insert_name($noQuestion,$fname,$nId);
//
//                                        $this->main_model->update_amount($nId,$nDeposit,$fname);

                                        $listArray[] = [
                                            "name" => $noQuestion,
                                            "status" => 0,
                                            "docno" => $fname,
                                            "date_created" => date("Y-m-d"),
                                            "id_level" => $nId,
                                            "amount" => $nDeposit

                                        ];

                                        $nId += 1;

                                    }
                                }
                                else {
                                        $nCnt = $nCnt + 1;
                                        $nCntTotal = $nCnt -1;
                                        $nDetails = $row['Keterangan'];

    //                                    echo $nDetails."<br/>";
    //                                    echo count($dataBankC)."<br/>";

                                }
                                if($row['Mutasi'] != 0){
                                    $nDeposit = $row['Mutasi'];
                                }
                            }
                            $this->main_model->insert_batch_name($listArray);
                            $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                        }
            //PROCESS MANDIRI
                        if($bank == "MANDIRI"){
                            $countME = 1;
                            $nRowCnt = 1;
                            $nId = 1;
                            $nLastItem = "";
                            $isEmpty = null;
                            $listArray = [];

                            foreach($dataBankC as $row){


                                if($row['Tanggal'] != ''){

                                    $nRowCnt = 1;

                                }
                                else {

                                    $nDetails = $row['Keterangan Transaksi'];

                                    $noQuestion = trim(str_replace("??","",$nDetails));
                                    $noQuestion = str_replace(' ', '-', $noQuestion);
                                    $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                    $noQuestion = str_replace('-', ' ', $noQuestion);
                                    $noQuestion = str_replace('DARI ', '', $noQuestion);

                                    $nStart = stripos($noQuestion," ATM PB ",0);
                                    if($nStart >= 1){
                                        $noQuestion = substr($noQuestion,0,$nStart);

                                    }

                                    if($nRowCnt == 1){


                                        if($noQuestion == "" || $noQuestion == "E"){
                                            $isEmpty = true;
                                            $nLastItem = $nDeposit;

                                        }else {

//                                            $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                            $this->main_model->update_amount($nId,$nDeposit,$fname);
//                                            $query = "INSERT INTO bca_raw (name,status,docno,date_created,id_level) VALUES ('$name',0,'$fname',NOW(),$nId)";
                                            $listArray[] = [
                                                "name" => $noQuestion,
                                                "status" => 0,
                                                "docno" => $fname,
                                                "date_created" => date("Y-m-d"),
                                                "id_level" => $nId,
                                                "amount" => $nDeposit

                                            ];


                                            $nId += 1;
                                            $isEmpty = false;

                                        }




                                    }



                                    if($nRowCnt == 2 && $isEmpty == true){

//                                        $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                        $this->main_model->update_amount($nId,$nLastItem,$fname);

                                        $listArray[] = [
                                            "name" => $noQuestion,
                                            "status" => 0,
                                            "docno" => $fname,
                                            "date_created" => date("Y-m-d"),
                                            "id_level" => $nId,
                                            "amount" => $nLastItem

                                        ];
                                        $nId += 1;
                                        $nLastItem = 0;
                                    }




                                    $nRowCnt += 1;
                                }

                                if($row['Kredit'] != null){
                                    $nDeposit = $row['Kredit'];

                                }

                                if($row['Kredit'] == 0){
                                    $nDeposit = $row['Debet'];

                                }

                            }
                            $this->main_model->insert_batch_name($listArray);
                            $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                        }
            //PROCESS BNI
                        if($bank == "BNI"){
                            foreach($dataBankC as $row){
                                if($row['Tanggal Transaksi'] != ''){
                                    $nDetails = $row['Uraian Transaksi'];
                                    $nDeposit = $row['Jumlah Pembayaran'];

                                    $nCnt = 1;



                                    if($row['Tanggal Transaksi']){
                                        $noQuestion = trim(str_replace("?","",$nDetails));

                                        $noQuestion = str_replace("TRF PAY TOP-UP","",$noQuestion);
                                        $noQuestion = str_replace("TRF PAY TOP UP","",$noQuestion);
                                        $noQuestion = str_replace("TRANSFER DARI Bpk ","",$noQuestion);
                                        $noQuestion = str_replace("TRANSFER KE Bpk ","",$noQuestion);
                                        $noQuestion = str_replace("ECHANNEL Sdri ","",$noQuestion);
                                        $noQuestion = str_replace("ECHANNEL Bpk ","",$noQuestion);
                                        $noQuestion = str_replace("ECHANNEL Sdr ","",$noQuestion);
                                        $noQuestion = str_replace("TRANSFER DARI Ibu ","",$noQuestion);
                                        $noQuestion = str_replace("TRANSFER DARI Sdr ","",$noQuestion);
                                        $noQuestion = str_replace("ECHANNEL","",$noQuestion);
//                            $noQuestion = str_replace("TRF PAY TOP-UP","",$noQuestion);

                                        $noQuestion = str_replace("DARI Sdri ","",$noQuestion);
                                        $noQuestion = str_replace(' ', '-', $noQuestion);
                                        $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                        $noQuestion = str_replace('-', ' ', $noQuestion);
                                        $noQuestion = str_replace('TRFPAYTOP UP ', '', $noQuestion);

                                        //                    echo $noQuestion."<br/>";

                                        $listArray[] = [
                                            "name" => $noQuestion,
                                            "status" => 0,
                                            "docno" => $fname,
                                            "date_created" => date("Y-m-d"),
                                            "id_level" => $nId,
                                            "amount" => $nDeposit

                                        ];
//                                        $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                        $this->main_model->update_amount($nId,$nDeposit,$fname);

//                                        $check = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
//                                        //                    $check2 = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
//                                        //
////                                                echo $check;
//                                        if($check >= 1){
//                                            //                        echo $noQuestion." > ".$nDeposit." > ".$check."<br/>";
//                                            $this->main_model->update_status_bni($check,$noQuestion,$nDeposit);
//                                        }


                                        $nId += 1;


                                    }

                                }

                            }
                            $this->main_model->insert_batch_name($listArray);
                            $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                        }
            //PROCESS BRI
                        if($bank == "BRI"){
                            foreach($dataBankC as $row){
                                if($row['tanggal'] != ''){
                                    $nDetails = $row['transaksi'];
//                                    $nDeposit = substr($row['Kredit'],2,strlen($row['Kredit']));
                                    $nDeposit = $row['kredit'];

                                    if($nDeposit == ''){
                                        $nDeposit = $row['debet'];

                                    }
//                        echo $nDeposit;
                                    $nTanggal = $row['tanggal'];
                                    if($nTanggal){
//                            var_dump($nTanggal);
                                        $noQuestion = trim(str_replace("??","",$nDetails));
                                        $noQuestion = trim(str_replace("?","",$noQuestion));
                                        $noQuestion = str_replace("TRANSFER IBNK ","",$noQuestion);
                                        $noQuestion = str_replace("TRANSFER ATM ","",$noQuestion);
                                        $noQuestion = str_replace("TRANSFER SMS ","",$noQuestion);
                                        $noQuestion = str_replace("TRANSAKSI KREDIT ","",$noQuestion);
                                        $noQuestion = str_replace("TRANSFER EDC ","",$noQuestion);
//                            echo $nDeposit."<br/>";
                                        $noQuestion = str_replace(' ', '-', $noQuestion);
                                        $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                        $noQuestion = str_replace('-', ' ', $noQuestion);




                                        $nStart = stripos($noQuestion," TO ",0);
                                        if($nStart >= 1){
                                            $noQuestion = substr($noQuestion,0,$nStart);

                                        }

                                        $listArray[] = [
                                            "name" => $noQuestion,
                                            "status" => 0,
                                            "docno" => $fname,
                                            "date_created" => date("Y-m-d"),
                                            "id_level" => $nId,
                                            "amount" => $nDeposit

                                        ];
//                                        $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                        $this->main_model->update_amount($nId,$nDeposit,$fname);

//                                        $check = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
//                                        if($check >= 1){
//                                            $this->main_model->update_status_bri($check,$noQuestion,$nDeposit);
//                                        }


                                        $nId += 1;

                                    }
                                }

                            }
                            $this->main_model->insert_batch_name($listArray);
                            $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                        }
            //PROCESS PERMATA
                        if($bank == "PERMATA"){
                            foreach($dataBankC as $row){
                                if($row['Tanggal'] != ''){
                                    $nDetails = $row['Deskripsi'];
                                    $nDeposit = $row['Kredit (+)'];
                                    if($nDeposit == 0){
                                        $nDeposit = $row['Debit (-)'];

                                    }
                                    $nTanggal = $row['Tanggal'];
                                    if($nTanggal){

//                            var_dump($nTanggal);
                                        $noQuestion = trim(str_replace("??","",$nDetails));
                                        $noQuestion = trim(str_replace("?","",$noQuestion));
                                        $noQuestion = str_replace("PB DARI ","",$noQuestion);
                                        $noQuestion = str_replace("PB KE ","",$noQuestion);
                                        $noQuestion = str_replace(" PermataMobile","",$noQuestion);
                                        $noQuestion = str_replace(" PermataNet","",$noQuestion);
                                        $noQuestion = str_replace(" NEW","",$noQuestion);
                                        $noQuestion = str_replace(' ', '-', $noQuestion);
                                        $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                        $noQuestion = str_replace('-', ' ', $noQuestion);
                                        $nDeposit = str_replace('.00Rp', ' ', $nDeposit);
                                        $nStart = stripos($noQuestion," ATM PB ",0);
                                        if($nStart >= 1){
                                            $noQuestion = substr($noQuestion,0,$nStart);

                                        }

                                        $listArray[] = [
                                            "name" => $noQuestion,
                                            "status" => 0,
                                            "docno" => $fname,
                                            "date_created" => date("Y-m-d"),
                                            "id_level" => $nId,
                                            "amount" => $nDeposit

                                        ];

//                                        $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                        $this->main_model->update_amount($nId,$nDeposit,$fname);


                                        $nId += 1;

                                    }
                                }

                            }
                            $this->main_model->insert_batch_name($listArray);
                            $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                        }
            //PROCESS CIMB NIAGA
                        if($bank == "CIMB NIAGA"){
                            $nRowCnt = 1;
                            $nId = 1;

                            foreach($dataBankC as $row){


                                if($row['Tanggal'] != ''){

                                    $nRowCnt = 1;

                                }
                                else {

                                    $nDetails = $row['Keterangan'];

                                    if($nRowCnt == 1){

                                        $noQuestion = trim(str_replace("??","",$nDetails));
                                        $noQuestion = trim(str_replace("?","",$nDetails));
                                        $noQuestion = substr($noQuestion,0,17);
                                        $noQuestion = trim(str_replace("DR","",$noQuestion));
                                        $listArray[] = [
                                            "name" => $noQuestion,
                                            "status" => 0,
                                            "docno" => $fname,
                                            "date_created" => date("Y-m-d"),
                                            "id_level" => $nId,
                                            "amount" => $nDeposit

                                        ];

//                                        $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                        $this->main_model->update_amount($nId,$nDeposit,$fname);
                                        $nId += 1;

                                    }

                                    $nRowCnt += 1;
                                }

                                if($row['Kredit (IDR)'] != null){
                                    $nDeposit = $row['Kredit (IDR)'];

                                }

                                if($row['Kredit (IDR)'] == 0){
                                    $nDeposit = $row['Debet (IDR)'];

                                }

                            }
                            $this->main_model->insert_batch_name($listArray);
                            $this->main_model->get_bca_admin_id_match_cimb($fname);
                        }
            }
//                    ELSE OF DEPOSIT
            else {

                $this->main_model->truncate_bca_admin($fname);
                foreach($dataAdminC as $admin) {
                    if ($admin['Nama Rekening Member']) {
                        $accName = $admin['Nama Rekening Member'];
                        $accName = strtoupper($accName);
                        $accNo = $admin['No Rekening Member'];

                        $listAdmin [] = [
                            "name" => strtoupper($admin['Nama Rekening Member']),
                            "status" => 0,
                            "docno" => $fname,
                            "date_created" => date('Y-m-d'),
                            "id_level" => $nId2,
                            "amount" => $admin['Nominal'],
                            "acc_no" => $admin['No Rekening Member']
                        ];
//                        $this->main_model->insert_bca_admin($accName, $fname, $nId2, $admin['Nominal'], $accNo);
                        $nId2 = $nId2 + 1;
                    }

                    if ($dept == "Shionaga" || $dept == "Duniamimpi" || "4dewa" || "Sakura 1" || "Sakura 2") {
                        if ($admin['Nama Rek Member']) {
                            $accName = $admin['Nama Rek Member'];
                            $accName = strtoupper($accName);
                            $accNo = $admin['No Rek Member'];
                            $listAdmin [] = [
                                "name" => strtoupper($admin['Nama Rek Member']),
                                "status" => 0,
                                "docno" => $fname,
                                "date_created" => date('Y-m-d'),
                                "id_level" => $nId2,
                                "amount" => $admin['Nominal'],
                                "acc_no" => $admin['No Rekening Member']
                            ];
//                            $this->main_model->insert_bca_admin($accName, $fname, $nId2, $admin['Nominal'], $accNo);
                            $nId2 = $nId2 + 1;
                        }
                    }
                    if ($dept == 'Lotus 1' || $dept == 'Lotus 2' || $dept == 'Lotus 3') {
                        if ($admin['account_name']) {
                            $accName = $admin['account_name'];
                            $accName = strtoupper($accName);
                            $accNo = $admin['account_number'];
                            $listAdmin [] = [
                                "name" => strtoupper($admin['account_name']),
                                "status" => 0,
                                "docno" => $fname,
                                "date_created" => date('Y-m-d'),
                                "id_level" => $nId2,
                                "amount" => $admin['jumlah_uang'],
                                "acc_no" => $admin['account_number']
                            ];
//                            $this->main_model->insert_bca_admin($accName, $fname, $nId2, $admin['jumlah_uang'], $accNo);
                            $nId2 = $nId2 + 1;
                        }
                    }
                }
                $this->main_model->insert_batch_admin($listAdmin);

                $this->main_model->truncate_bca_records($fname);
//            PROCESS BCA WITHDRAW

                if($bank == "BCA"){
                    foreach($dataBankC as $row){
                        if($row['Tgl.'] != ''){
                            $nCnt = 1;
                            if($nCnt == 1 && $nDetails != ''){

                                $noQuestion = trim(str_replace("?","",$nDetails));
                                $noQuestion = str_replace(' ', '-', $noQuestion);
                                $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                $noQuestion = str_replace('-', ' ', $noQuestion);
                                $noQuestion = str_replace('TANGGAL', '', $noQuestion);
                                $noQuestion = str_replace('WSID', '', $noQuestion);
                                $noQuestion = str_replace('IDR', '', $noQuestion);
                                $noQuestion = str_replace('TRANSFER DR', '', $noQuestion);
                                $noQuestion = str_replace('RESKUIAR', '', $noQuestion);

                                $arr = explode(' ',trim($noQuestion));

                                if(strlen($arr[0]) <= 2){
                                    $noQuestion = explode(' ',trim($noQuestion));
                                    $noQuestion = $noQuestion[1] ." ". $noQuestion[2];
                                }





                                $listArray[] = [
                                    "name" => $noQuestion,
                                    "status" => 0,
                                    "docno" => $fname,
                                    "date_created" => date("Y-m-d"),
                                    "id_level" => $nId,
                                    "amount" => $nDeposit

                                ];

//                                $this->main_model->insert_name($noQuestion,$fname,$nId);
//
//                                $this->main_model->update_amount($nId,$nDeposit,$fname);


                                $nId += 1;

                            }
                        }
                        else {
                            $nCnt = $nCnt + 1;
                            $nCntTotal = $nCnt -1;
                            $nDetails = $row['Keterangan'];

                            //                                    echo $nDetails."<br/>";
                            //                                    echo count($dataBankC)."<br/>";

                        }
                        if($row['Mutasi'] != 0){
                            $nDeposit = $row['Mutasi'];
                        }
                    }
                    $this->main_model->insert_batch_name($listArray);
                    $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                }
                //PROCESS MANDIRI
                if($bank == "MANDIRI"){

                    $nRowCnt = 1;
                    $nId = 1;

                    foreach($dataBankC as $row){


                        if($row['Tanggal'] != ''){

                            $nRowCnt = 1;

                        }
                        else {

                            $nDetails = $row['Keterangan Transaksi'];

                            if($nRowCnt == 1){

                                $noQuestion = trim(str_replace("??","",$nDetails));
                                $noQuestion = str_replace(' ', '-', $noQuestion);
                                $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                $noQuestion = str_replace('-', ' ', $noQuestion);
                                $noQuestion = str_replace('DARI ', '', $noQuestion);
                                $noQuestion = str_replace('KE ', '', $noQuestion);

                                $nStart = stripos($noQuestion," ATM PB ",0);
                                if($nStart >= 1){
                                    $noQuestion = substr($noQuestion,0,$nStart);

                                }
                                if($nRowCnt == 1){


                                    if($noQuestion == "" || $noQuestion == "E"){
                                        $isEmpty = true;
                                        $nLastItem = $nDeposit;

                                    }else {

//                                            $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                            $this->main_model->update_amount($nId,$nDeposit,$fname);
//                                            $query = "INSERT INTO bca_raw (name,status,docno,date_created,id_level) VALUES ('$name',0,'$fname',NOW(),$nId)";
                                        $listArray[] = [
                                            "name" => $noQuestion,
                                            "status" => 0,
                                            "docno" => $fname,
                                            "date_created" => date("Y-m-d"),
                                            "id_level" => $nId,
                                            "amount" => $nDeposit

                                        ];


                                        $nId += 1;
                                        $isEmpty = false;

                                    }




                                }



                                if($nRowCnt == 2 && $isEmpty == true){

//                                        $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                        $this->main_model->update_amount($nId,$nLastItem,$fname);

                                    $listArray[] = [
                                        "name" => $noQuestion,
                                        "status" => 0,
                                        "docno" => $fname,
                                        "date_created" => date("Y-m-d"),
                                        "id_level" => $nId,
                                        "amount" => $nLastItem

                                    ];
                                    $nId += 1;
                                    $nLastItem = 0;
                                }


//                                $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                $this->main_model->update_amount($nId,$nDeposit,$fname);
                                $nId += 1;

                            }

                            $nRowCnt += 1;
                        }

                        if($row['Kredit'] != null){
                            $nDeposit = $row['Kredit'];

                        }

                        if($row['Kredit'] == 0){
                            $nDeposit = $row['Debet'];

                        }

                    }
                    $this->main_model->insert_batch_name($listArray);
                    $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                }
                //PROCESS BNI
                if($bank == "BNI"){
                    foreach($dataBankC as $row){
                        if($row['Tanggal Transaksi'] != ''){
                            $nDetails = $row['Uraian Transaksi'];
                            $nDeposit = $row['Jumlah Pembayaran'];

                            $nCnt = 1;



                            if($row['Tanggal Transaksi']){
                                $noQuestion = trim(str_replace("?","",$nDetails));

                                $noQuestion = str_replace("TRF PAY TOP-UP","",$noQuestion);
                                $noQuestion = str_replace("TRF PAY TOP UP","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER DARI Bpk ","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER KE Bpk ","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER KE Ibu ","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER KE Sdr ","",$noQuestion);
                                $noQuestion = str_replace("ECHANNEL Sdri ","",$noQuestion);
                                $noQuestion = str_replace("ECHANNEL Bpk ","",$noQuestion);
                                $noQuestion = str_replace("ECHANNEL Sdr ","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER DARI Ibu ","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER DARI Sdr ","",$noQuestion);
                                $noQuestion = str_replace("ECHANNEL","",$noQuestion);
//                            $noQuestion = str_replace("TRF PAY TOP-UP","",$noQuestion);

                                $noQuestion = str_replace("DARI Sdri ","",$noQuestion);
                                $noQuestion = str_replace(' ', '-', $noQuestion);
                                $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                $noQuestion = str_replace('-', ' ', $noQuestion);
                                $noQuestion = str_replace('TRFPAYTOP UP ', '', $noQuestion);

                                //                    echo $noQuestion."<br/>";
//                                $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                $this->main_model->update_amount($nId,$nDeposit,$fname);

//                                        $check = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
//                                        //                    $check2 = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
//                                        //
////                                                echo $check;
//                                        if($check >= 1){
//                                            //                        echo $noQuestion." > ".$nDeposit." > ".$check."<br/>";
//                                            $this->main_model->update_status_bni($check,$noQuestion,$nDeposit);
//                                        }
                                $listArray[] = [
                                    "name" => $noQuestion,
                                    "status" => 0,
                                    "docno" => $fname,
                                    "date_created" => date("Y-m-d"),
                                    "id_level" => $nId,
                                    "amount" => $nDeposit

                                ];

                                $nId += 1;


                            }

                        }

                    }
                    $this->main_model->insert_batch_name($listArray);
                    $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                }
                //PROCESS BRI
                if($bank == "BRI"){
                    foreach($dataBankC as $row){
                        if($row['Tanggal'] != ''){
                            $nDetails = $row['Transaksi'];
//                                    $nDeposit = substr($row['Kredit'],2,strlen($row['Kredit']));
                            $nDeposit = $row['Debet'];

                            if($nDeposit == ''){
                                $nDeposit = $row['Kredit'];

                            }


//                        echo $nDeposit."<br/>";
                            $nTanggal = $row['Tanggal'];
                            if($nTanggal){
//                            var_dump($nTanggal);
                                $noQuestion = trim(str_replace("??","",$nDetails));
                                $noQuestion = trim(str_replace("?","",$noQuestion));
                                $noQuestion = str_replace("TRANSFER IBNK ","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER ATM ","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER SMS ","",$noQuestion);
                                $noQuestion = str_replace("TRANSAKSI KREDIT ","",$noQuestion);
                                $noQuestion = str_replace("TRANSFER EDC ","",$noQuestion);
//                            echo $nDeposit."<br/>";
                                $noQuestion = str_replace(' ', '-', $noQuestion);
                                $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                $noQuestion = str_replace('-', ' ', $noQuestion);


                                $nStart = stripos($noQuestion," TO ",0);

                                if($nStart >= 1){

                                    $noQuestion = substr($noQuestion,$nStart + 3);

                                }
                                $noQuestion = trim($noQuestion);

                                $listArray[] = [
                                    "name" => $noQuestion,
                                    "status" => 0,
                                    "docno" => $fname,
                                    "date_created" => date("Y-m-d"),
                                    "id_level" => $nId,
                                    "amount" => $nDeposit

                                ];

//                                $this->main_model->insert_name($noQuestion,$fname,$nId);
//                                $this->main_model->update_amount($nId,$nDeposit,$fname);
                                if($nDeposit == '250'){
                                    $this->main_model->update_charge($nId,$nDeposit,$fname);
                                }

//                                        $check = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
//                                        if($check >= 1){
//                                            $this->main_model->update_status_bri($check,$noQuestion,$nDeposit);
//                                        }


                                $nId += 1;

                            }
                        }

                    }
                    $this->main_model->insert_batch_name($listArray);
                    $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                }
                //PROCESS PERMATA
                if($bank == "PERMATA"){
                    foreach($dataBankC as $row){
                        if($row['Tanggal'] != ''){
                            $nDetails = $row['Deskripsi'];
                            $nDeposit = $row['Kredit (+)'];
                            if($nDeposit == 0){
                                $nDeposit = $row['Debit (-)'];

                            }
                            $nTanggal = $row['Tanggal'];
                            if($nTanggal){

//                            var_dump($nTanggal);
                                $noQuestion = trim(str_replace("??","",$nDetails));
                                $noQuestion = trim(str_replace("?","",$noQuestion));
                                $noQuestion = str_replace("PB DARI ","",$noQuestion);
                                $noQuestion = str_replace("PB KE ","",$noQuestion);
                                $noQuestion = str_replace(" PermataMobile","",$noQuestion);
                                $noQuestion = str_replace(" PermataNet","",$noQuestion);
                                $noQuestion = str_replace(" NEW","",$noQuestion);
                                $noQuestion = str_replace(' ', '-', $noQuestion);
                                $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                                $noQuestion = str_replace('-', ' ', $noQuestion);
                                $nDeposit = str_replace('.00Rp', ' ', $nDeposit);
                                $nStart = stripos($noQuestion," ATM PB ",0);
                                if($nStart >= 1){
                                    $noQuestion = substr($noQuestion,0,$nStart);

                                }

                                $this->main_model->insert_name($noQuestion,$fname,$nId);
                                $this->main_model->update_amount($nId,$nDeposit,$fname);


                                $nId += 1;

                            }
                        }

                    }
                    $match['id'] = $this->main_model->get_bca_admin_id_match($fname);
                }
                //PROCESS CIMB NIAGA
                if($bank == "CIMB NIAGA"){
                    $nRowCnt = 1;
                    $nId = 1;

                    foreach($dataBankC as $row){


                        if($row['Tanggal'] != ''){

                            $nRowCnt = 1;

                        }
                        else {

                            $nDetails = $row['Keterangan'];

                            if($nRowCnt == 1){

                                $noQuestion = trim(str_replace("??","",$nDetails));
                                $noQuestion = trim(str_replace("?","",$nDetails));
                                $noQuestion = substr($noQuestion,0,17);
                                $noQuestion = trim(str_replace("DR","",$noQuestion));
                                $this->main_model->insert_name($noQuestion,$fname,$nId);
                                $this->main_model->update_amount($nId,$nDeposit,$fname);
                                $nId += 1;

                            }

                            $nRowCnt += 1;
                        }

                        if($row['Kredit (IDR)'] != null){
                            $nDeposit = $row['Kredit (IDR)'];

                        }

                        if($row['Kredit (IDR)'] == 0){
                            $nDeposit = $row['Debet (IDR)'];

                        }

                    }
                    $this->main_model->get_bca_admin_id_match_cimb($fname);
                }
            }



                        $dataFinal['results'] = $this->main_model->get_bca($fname);
                        $dataFinal['resultsAdmin'] = $this->main_model->get_bca_admin($fname);
                        $this->load->view('admin/ajax_bca',$dataFinal);
                        }
                else {
                    echo "Cannot process data. Please click upload button again.";
                }
            }
            else{ // ELSE NO
                echo "No data";
            }
        }
        else { //else NO FILENAME $data['filename']
            echo "Cannot process empty";
        }
    }

    public function match_bca_bank(){
        // $this->load->model('admin/main_model');
        $id = $this->input->post('id');
        $dsc = $this->input->post('dsc');
        $fname = $this->input->post('fname');
        $status = $this->input->post('status');
        $bankName = $this->input->post('bankName');
        $data = $this->main_model->match_bca_bank($id,$dsc,$fname,$bankName,$status);
        print_r($data);
    }

    public function match_bca_admin(){
        // $this->load->model('admin/main_model');
        $id = $this->input->post('id');
        $dsc = $this->input->post('dsc');
        $fname = $this->input->post('fname');
        $status = $this->input->post('status');
        $bankName = $this->input->post('bankName');
        $data = $this->main_model->match_bca_admin($id,$dsc,$fname,$bankName,$status);
        print_r($data);
    }

    public function rename_bca(){
        $id = $this->input->post('id');
        $bankName = $this->input->post('bankName');

        $data = $this->main_model->rename_bca($id,$bankName);
        print_r($data);
    }

    public function upload_bank_bca($filename){
        $file = $this->input->post('fileName');

        $this->load->library('csvreader');
        echo $file;
        $filePath = 'C:/xampp/htdocs/ers/uploads/'.$filename;

        $data['csvDataBank'] = $this->csvreader->parse_file($filePath);

        $this->load->view('admin/ajax_bca', $data);
//        var_dump($data);

    }

    public function refresh_bca(){
        $fname = $this->input->post('fname');
        // $this->load->model('admin/main_model');
        $dataFinal['results'] = $this->main_model->get_bca($fname);
        $dataFinal['resultsAdmin'] = $this->main_model->get_bca_admin($fname);
        $this->load->view('admin/ajax_bca',$dataFinal);
    }

    public function update_bca_status_match(){
        $bankID = $this->input->post('bankID');
        $adminID = $this->input->post('adminID');
        $dscBank = $this->input->post('dscBank');
        $dscAdmin = $this->input->post('dscAdmin');
        if($bankID && $adminID){
            $data = $this->main_model->update_bca_status_match($bankID,$adminID,$dscBank,$dscAdmin);
            print_r($data);
        }else {
            echo "Cannot match one name only. Use Descriptive Match instead.";
        }

    }

    public function update_bca_status_unmatch(){
        $bankID = $this->input->post('bankID');
        $adminID = $this->input->post('adminID');
        if($bankID && $adminID){
            $data = $this->main_model->update_bca_status_unmatch($bankID,$adminID);
            print_r($data);
        }else {
            if($bankID){
                $data = $this->main_model->update_bca_status_unmatch($bankID,'0');
                print_r($data);
            }
            else{
                $data = $this->main_model->update_bca_status_unmatch('0',$adminID);
                print_r($data);
            }
        }

    }

    public function update_bca_status_wid(){
        $bankID = $this->input->post('bankID');
        $dsc = $this->input->post('dsc');

        $data = $this->main_model->update_bca_status_wid($bankID,$dsc);
        print_r($data);

    }

    public function save_bca_final(){
        $fname = $this->input->post('fname');

        $data = $this->main_model->update_bca_status_save($fname);

        print_r($data);
    }

    public function load_search_save_bca(){
        $username =  $this->session->userdata('username');
        $bank = $this->input->post('bank');
        $date = $this->input->post('date');
        $type = $this->input->post('type');
        $dept = $this->input->post('dept');

        $data['results'] = $this->main_model->get_save_bca($bank,$date,$username,$type,$dept);
        $this->load->view('admin/ajax_search_save_bca',$data);
    }

    public function get_bca_past(){
        $username =  $this->session->userdata('username');
        $fname = $this->input->post('fname');
        $type = $this->input->post('type');
        $dept = $this->input->post('dept');



        $data['results'] = $this->main_model->get_past_unmatch_bca($username, $fname, $type, $dept);
        $data['results2'] = $this->main_model->get_past_unmatch_bca_admin($username, $fname, $type, $dept);
        $this->load->view('admin/ajax_bca_past',$data);
    }

    public function delete_all_save_bca(){
        $username =  $this->session->userdata('username');
        $docno = $this->input->post('docno');
        $data = $this->main_model->delete_all_save_bca($docno,$username);
        print_r($data);
    }

    public function update_bca_status_match_with_past_banktopastadmin(){

        $bankID = $this->input->post('bankID');
        $PastAdminID = $this->input->post('PastAdminID');
        $PastAdminDate = $this->input->post('adminDate');

        $data = $this->main_model->update_bca_status_match_with_past_banktopastadmin($bankID,$PastAdminID,$PastAdminDate);

        print_r($data);
    }

    public function update_bca_status_match_with_past_admintopastbank(){
        $adminID = $this->input->post('adminID');
        $PastBankID = $this->input->post('PastBankID');
        $PastBankDate = $this->input->post('bankDate');

        $data = $this->main_model->update_bca_status_match_with_past_admintopastbank($adminID,$PastBankID,$PastBankDate);

        print_r($data);
    }

    public function load_d_match(){
        if($this->input->post('bankName')){
            $data['accountName'] = $this->input->post('bankName');
        }else{
            $data['accountName'] = $this->input->post('adminName');
        }


        $this->load->view('admin/ajax_d_match', $data);
    }

    public function report_bca(){
        $username =  $this->session->userdata('username');
        $fname = $this->input->post('fname');
        $type = $this->input->post('type');

        $data['match_raw'] = $this->main_model->get_bca_report($username, $fname, $type);
        $data['match_raw'] = $data['match_raw'] ? $data['match_raw'] :[0];
        $data['match'] =  $data['match_raw'][0]->amount ? $data['match_raw'][0]->amount : 0;
        $data['no_match'] =  $data['match_raw'][0]->no ? $data['match_raw'][0]->no : 0;

        $data['unmatch_raw'] = $this->main_model->get_bca_report_unmatch($username, $fname, $type);
//        $data['unmatch_raw'] = $data['unmatch_raw'] ? $data['unmatch_raw'] : [0];
        $data['unmatch'] =  $data['unmatch_raw'] ? $data['unmatch_raw'][0]->amount : 0;
        $data['no_unmatch'] =  $data['unmatch_raw'] ? $data['unmatch_raw'][0]->no : 0;


        $data['match_raw_bank'] = $this->main_model->get_bca_report_bank($username, $fname, $type);
        $data['match_raw_bank'] = $data['match_raw_bank']  ?$data['match_raw_bank'] :[0];
        $data['match_bank'] =  $data['match_raw_bank'][0]->amount ? $data['match_raw_bank'][0]->amount : 0;
        $data['no_match_bank'] =  $data['match_raw_bank'][0]->no ? $data['match_raw_bank'][0]->no :0;
//
        $data['unmatch_raw_bank'] = $this->main_model->get_bca_report_unmatch_bank($username, $fname, $type);
        $data['unmatch_raw_bank'] = $data['unmatch_raw_bank'] ? $data['unmatch_raw_bank'] : [0];
        $data['unmatch_bank'] =  $data['unmatch_raw_bank'][0]->amount ? $data['unmatch_raw_bank'][0]->amount :0;
        $data['no_unmatch_bank'] =  $data['unmatch_raw_bank'][0]->no ? $data['unmatch_raw_bank'][0]->no : 0;

        $data['total_bank'] = $this->main_model->get_bca_total_bank($username, $fname, $type);
        $data['total_bank_amount'] = $data['total_bank'] ? $data['total_bank'][0]->amount : [0];
        $data['total_bank_no'] = $data['total_bank'] ? $data['total_bank'][0]->no : [0];

        $data['total_transfer_wd'] = $this->main_model->get_bca_total_wd_transfer($username, $fname, $type);
        $data['total_transfer_wd'] = $data['total_transfer_wd'] ? $data['total_transfer_wd'][0]->amount : [0];

        $data['total_transfer_tp'] = $this->main_model->get_bca_total_tp_transfer($username, $fname, $type);
        $data['total_transfer_tp'] = $data['total_transfer_tp'] ? $data['total_transfer_tp'][0]->amount : [0];

        $data['total_admin'] = $this->main_model->get_bca_total_admin($username, $fname, $type);
        $data['total_admin_amount'] = $data['total_admin'] ? $data['total_admin'][0]->amount : [0];
        $data['total_admin_no'] = $data['total_admin'] ? $data['total_admin'][0]->no : [0];

        $data['total_bank_past'] = $this->main_model->get_bca_total_past_bank($username, $fname, $type);
        $data['total_bank_past_amount'] = $data['total_bank_past'] ? $data['total_bank_past'][0]->amount : [0];
        $data['total_bank_past_no'] = $data['total_bank_past'] ? $data['total_bank_past'][0]->no : [0];

        $data['total_admin_past'] = $this->main_model->get_bca_total_past_admin($username, $fname, $type);
        $data['total_admin_past_amount'] = $data['total_admin_past'] ? $data['total_admin_past'][0]->amount : [0];
        $data['total_admin_past_no'] = $data['total_admin_past'] ? $data['total_admin_past'][0]->no : [0];

        $this->load->view('admin/ajax_report_bca',$data);
    }

    //    FUNCTIONS MANDIRI

    public function load_mandiri(){
        $this->load->helper('form');
        $this->load->view('admin/mandiri');
    }

    public function process_mandiri(){
        $fname = $this->input->post('fname');

        if($fname){
            // $this->load->model('admin/main_model');
            $this->load->library('csvreader');
            $data['filename'] = $this->main_model->get_filenames($fname);

            if($data['filename']){

                $fileBank = ($data['filename'][0]->file_bank);
                $fileAdmin = ($data['filename'][0]->file_admin);


                $filePathBank = 'C:/xampp/htdocs/ers/uploads/'.$fileBank;
                $filePathAdmin = 'C:/xampp/htdocs/ers/uploads/'.$fileAdmin;

                $dataBank['csvDataBank'] = $this->csvreader->parse_file($filePathBank);
                $dataAdmin['csvDataAdmin'] = $this->csvreader->parse_file($filePathAdmin);

                $nId2 = 1;

                $dataBankC = $dataBank['csvDataBank'];
                $dataAdminC =  $dataAdmin['csvDataAdmin'];

                //For EACH admin
                $this->main_model->truncate_mandiri_admin($fname);
                //$nDetails = $row['Keterangan'];
                foreach($dataAdminC as $admin){

                    if($admin['Nama Rekening Member']){
                        $this->main_model->insert_mandiri_admin(strtoupper($admin['Nama Rekening Member']),$fname,$nId2,$admin['Nominal']);


                        $nId2 = $nId2 + 1;
                    }
                }

                $match['id'] = $this->main_model->get_mandiri_admin_id_match($fname);

                foreach($match['id'] as $matchAdmin){
                    $matchID = $matchAdmin->id;
                    $this->main_model->get_mandiri_admin_update_match($matchID);

                }

                $nCntTotal = null;
                $nDetails = null;
                $nDeposit = null;

                $nCnt = 1;
                $nId = 1;
                $nRowCnt = 1;

                $dataBankC = $dataBank['csvDataBank'];
                $dataAdminC =  $dataAdmin['csvDataAdmin'];



                //For EACH
                $this->main_model->truncate_mandiri_records($fname);

                foreach($dataBankC as $row){


                    if($row['Tanggal'] != ''){
//                        echo $row['Keterangan Transaksi']."<br/>";
                        $nRowCnt = 1;

                    }
                    else {

                        $nDetails = $row['Keterangan Transaksi'];
//
                        if($nRowCnt == 1){
//                            echo $nId."<br/>";
//                            echo $nDetails."=>".$nDeposit.">".$nRowCnt."<br/>";
                            $noQuestion = trim(str_replace("??","",$nDetails));
                            $noQuestion = str_replace(' ', '-', $noQuestion);
                            $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                            $noQuestion = str_replace('-', ' ', $noQuestion);
                            $noQuestion = str_replace('DARI ', '', $noQuestion);

                            $nStart = stripos($noQuestion," ATM PB ",0);
                            if($nStart >= 1){
                                $noQuestion = substr($noQuestion,0,$nStart);

                            }


                            $this->main_model->insert_name_mandiri($noQuestion,$fname,$nId);
                            $this->main_model->update_amount_mandiri($nId,$nDeposit);

                            $check = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
                            if($check >= 1){
                                $this->main_model->update_status_mandiri($check,$noQuestion,$nDeposit);
                            }
                            $nId += 1;
                        }

                        $nRowCnt += 1;
                    }

                    if($row['Kredit'] != 0){
                        $nDeposit = $row['Kredit'];

                    }

                }


                $dataFinal['resultsAdmin'] = $this->main_model->get_mandiri_admin($fname);
                $dataFinal['results'] = $this->main_model->get_mandiri($fname);
                $this->load->view('admin/ajax_mandiri',$dataFinal);
            }
            else{
                echo "No data";
            }
        }
        else {
            echo "Cannot process empty";
        }
    }

    public function match_mandiri(){
        // $this->load->model('admin/main_model');
        $id = $this->input->post('id');
        $dsc = $this->input->post('dsc');
        $fname = $this->input->post('fname');
        $data = $this->main_model->match_mandiri($id,$dsc,$fname);
        print_r($data);
    }

    public function match_mandiri_admin(){
        // $this->load->model('admin/main_model');
        $id = $this->input->post('id');
        $dsc = $this->input->post('dsc');
        $fname = $this->input->post('fname');
        $data = $this->main_model->match_mandiri_admin($id,$dsc,$fname);
        print_r($data);
    }

    public function upload_bank_mandiri($filename){
        $file = $this->input->post('fileName');

        $this->load->library('csvreader');
        echo $file;
        $filePath = 'C:/xampp/htdocs/ers/uploads/'.$filename;

        $data['csvDataBank'] = $this->csvreader->parse_file($filePath);

        $this->load->view('admin/ajax_mandiri', $data);
//        var_dump($data);

    }

    public function refresh_mandiri(){
        $fname = $this->input->post('fname');
        // $this->load->model('admin/main_model');
        $dataFinal['resultsAdmin'] = $this->main_model->get_mandiri_admin($fname);
        $dataFinal['results'] = $this->main_model->get_mandiri($fname);
        $this->load->view('admin/ajax_mandiri',$dataFinal);
    }

    public function update_mandiri_status_match(){
        $bankID = $this->input->post('bankID');
        $adminID = $this->input->post('adminID');

        if($bankID && $adminID){
            $data = $this->main_model->update_mandiri_status_match($bankID,$adminID);
            print_r($data);
        }else {
            echo "Cannot match one name only. Use Descriptive Match instead.";
        }

    }

    public function match_mandiri_bank(){
        // $this->load->model('admin/main_model');
        $id = $this->input->post('id');
        $dsc = $this->input->post('dsc');
        $fname = $this->input->post('fname');
        $data = $this->main_model->match_mandiri_bank($id,$dsc,$fname);
        print_r($data);
    }

    public function save_mandiri_final(){
        $fname = $this->input->post('fname');

        $data = $this->main_model->update_mandiri_status_save($fname);

        print_r($data);
    }

    public function load_search_save_mandiri(){
        $username =  $this->session->userdata('username');
        $bank = $this->input->post('bank');
        $date = $this->input->post('date');

        $data['results'] = $this->main_model->get_save_mandiri($bank,$date,$username);
        $this->load->view('admin/ajax_search_save_bca',$data);
    }

//    BNI FUNCTIONS

    public function load_bni(){
        $this->load->helper('form');
        $this->load->view('admin/bni');
    }

    public function process_bni(){
        $fname = $this->input->post('fname');

        if($fname){
            // $this->load->model('admin/main_model');
            $this->load->library('csvreader');
            $data['filename'] = $this->main_model->get_filenames($fname);

            if($data['filename']){

                $fileBank = ($data['filename'][0]->file_bank);
                $fileAdmin = ($data['filename'][0]->file_admin);


                $filePathBank = 'C:/xampp/htdocs/ers/uploads/'.$fileBank;
                $filePathAdmin = 'C:/xampp/htdocs/ers/uploads/'.$fileAdmin;

                $dataBank['csvDataBank'] = $this->csvreader->parse_file($filePathBank);
                $dataAdmin['csvDataAdmin'] = $this->csvreader->parse_file($filePathAdmin);


                $nCntTotal = null;
                $nDetails = null;
                $nDeposit = null;

                $nCnt = 1;
                $nId = 1;

                $dataBankC = $dataBank['csvDataBank'];
                $dataAdminC =  $dataAdmin['csvDataAdmin'];


//                var_dump($filePathAdmin);
                //For EACH
                $this->main_model->truncate_bni_records($fname);
                foreach($dataBankC as $row){
                    if($row['Tanggal Transaksi'] != ''){
                        $nDetails = $row['Uraian Transaksi'];
                        $nDeposit = $row['Jumlah Pembayaran'];

                        $nCnt = 1;
                        if($row['Tanggal Transaksi']){
                            $noQuestion = trim(str_replace("?","",$nDetails));

                            $noQuestion = str_replace("TRF PAY TOP-UP","",$noQuestion);
                            $noQuestion = str_replace("TRF PAY TOP UP","",$noQuestion);
                            $noQuestion = str_replace("TRANSFER DARI Bpk ","",$noQuestion);
                            $noQuestion = str_replace("TRANSFER KE Bpk ","",$noQuestion);
                            $noQuestion = str_replace("ECHANNEL Sdri ","",$noQuestion);
                            $noQuestion = str_replace("ECHANNEL Bpk ","",$noQuestion);
                            $noQuestion = str_replace("ECHANNEL Sdr ","",$noQuestion);
                            $noQuestion = str_replace("TRANSFER DARI Ibu ","",$noQuestion);
                            $noQuestion = str_replace("TRANSFER DARI Sdr ","",$noQuestion);
                            $noQuestion = str_replace("ECHANNEL","",$noQuestion);
//                            $noQuestion = str_replace("TRF PAY TOP-UP","",$noQuestion);

                            $noQuestion = str_replace("DARI Sdri ","",$noQuestion);
                            $noQuestion = str_replace(' ', '-', $noQuestion);
                            $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                            $noQuestion = str_replace('-', ' ', $noQuestion);

                            //                    echo $noQuestion."<br/>";
                            $this->main_model->insert_name_bni($noQuestion,$fname,$nId);
                            $this->main_model->update_amount_bni($nId,$nDeposit);

                            $check = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
                            //                    $check2 = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
                            //
//                                                echo $check;
                                if($check >= 1){
                                    //                        echo $noQuestion." > ".$nDeposit." > ".$check."<br/>";
                                    $this->main_model->update_status_bni($check,$noQuestion,$nDeposit);
                                }


                            $nId += 1;

                        }
                    }

                }

                $dataFinal['results'] = $this->main_model->get_bni($fname);
                $this->load->view('admin/ajax_bni',$dataFinal);
            }
            else{
                echo "No data";
            }
        }
        else {
            echo "Cannot process empty";
        }
    }

    public function match_bni(){
        // $this->load->model('admin/main_model');
        $id = $this->input->post('id');
        $dsc = $this->input->post('dsc');
        $fname = $this->input->post('fname');
        $data['results'] = $this->main_model->match_bni($id,$dsc,$fname);
        $this->load->view('admin/ajax_bni',$data);
    }

    public function refresh_bni(){
        $fname = $this->input->post('fname');
        // $this->load->model('admin/main_model');
        $dataFinal['results'] = $this->main_model->get_bni($fname);
        $this->load->view('admin/ajax_bni',$dataFinal);
    }

//    FUNCTION BRI

    public function load_bri(){
        $this->load->helper('form');
        $this->load->view('admin/bri');
    }

    public function process_bri(){
//        var_dump($_POST);
        $fname = $this->input->post('fname');
        if($fname){
            // $this->load->model('admin/main_model');
            $this->load->library('csvreader');
            $data['filename'] = $this->main_model->get_filenames($fname);

            if($data['filename']){

                $fileBank = ($data['filename'][0]->file_bank);
                $fileAdmin = ($data['filename'][0]->file_admin);


                $filePathBank = 'C:/xampp/htdocs/ers/uploads/'.$fileBank;
                $filePathAdmin = 'C:/xampp/htdocs/ers/uploads/'.$fileAdmin;

                $dataBank['csvDataBank'] = $this->csvreader->parse_file($filePathBank);
                $dataAdmin['csvDataAdmin'] = $this->csvreader->parse_file($filePathAdmin);


                $nCntTotal = null;
                $nDetails = null;
                $nDeposit = null;

                $nCnt = 1;
                $nId = 1;

                $dataBankC = $dataBank['csvDataBank'];
                $dataAdminC =  $dataAdmin['csvDataAdmin'];


//                var_dump($filePathAdmin);
                //For EACH
                $this->main_model->truncate_bri_records($fname);
                foreach($dataBankC as $row){
                    if($row['Tanggal'] != ''){
                        $nDetails = $row['Transaksi'];
                        $nDeposit = substr($row['Kredit'],2,strlen($row['Kredit']));
//                        echo $nDeposit;
                        $nTanggal = trim(substr($row['Tanggal'],0,strlen($row['Tanggal'])-1));
                        if($nTanggal){
//                            var_dump($nTanggal);
                            $noQuestion = trim(str_replace("??","",$nDetails));
                            $noQuestion = trim(str_replace("?","",$noQuestion));
                            $noQuestion = str_replace("TRANSFER IBNK ","",$noQuestion);
                            $noQuestion = str_replace("TRANSFER ATM ","",$noQuestion);
                            $noQuestion = str_replace("TRANSFER SMS ","",$noQuestion);
                            $noQuestion = str_replace("TRANSAKSI KREDIT ","",$noQuestion);
                            $noQuestion = str_replace("TRANSFER EDC ","",$noQuestion);
//                            echo $nDeposit."<br/>";
                            $noQuestion = str_replace(' ', '-', $noQuestion);
                            $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                            $noQuestion = str_replace('-', ' ', $noQuestion);

                            $nStart = stripos($noQuestion," TO ",0);
                            if($nStart >= 1){
                                $noQuestion = substr($noQuestion,0,$nStart);

                            }


                            $this->main_model->insert_name_bri($noQuestion,$fname,$nId);
                            $this->main_model->update_amount_bri($nId,$nDeposit);

                            $check = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
                                if($check >= 1){
                                    $this->main_model->update_status_bri($check,$noQuestion,$nDeposit);
                                }


                            $nId += 1;

                        }
                    }

                }

                $dataFinal['results'] = $this->main_model->get_bri($fname);
                $this->load->view('admin/ajax_bri',$dataFinal);
            }
            else{
                echo "No data";
            }
        }
        else {
            echo "Cannot process empty";
        }

    }

    public function match_bri(){
        // $this->load->model('admin/main_model');
        $id = $this->input->post('id');
        $dsc = $this->input->post('dsc');
        $fname = $this->input->post('fname');
        $data['results'] = $this->main_model->match_bri($id,$dsc,$fname);
        $this->load->view('admin/ajax_bri',$data);
    }

    public function refresh_bri(){
        $fname = $this->input->post('fname');
        // $this->load->model('admin/main_model');
        $dataFinal['results'] = $this->main_model->get_bri($fname);
        $this->load->view('admin/ajax_bri',$dataFinal);
    }


//    FUNCTION PERMATA

    public function load_permata(){
        $this->load->helper('form');
        $this->load->view('admin/permata');
    }

    public function process_permata(){
//        var_dump($_POST);
        $fname = $this->input->post('fname');
        if($fname){
            // $this->load->model('admin/main_model');
            $this->load->library('csvreader');
            $data['filename'] = $this->main_model->get_filenames($fname);

            if($data['filename']){

                $fileBank = ($data['filename'][0]->file_bank);
                $fileAdmin = ($data['filename'][0]->file_admin);


                $filePathBank = 'C:/xampp/htdocs/ers/uploads/'.$fileBank;
                $filePathAdmin = 'C:/xampp/htdocs/ers/uploads/'.$fileAdmin;

                $dataBank['csvDataBank'] = $this->csvreader->parse_file($filePathBank);
                $dataAdmin['csvDataAdmin'] = $this->csvreader->parse_file($filePathAdmin);


                $nCntTotal = null;
                $nDetails = null;
                $nDeposit = null;

                $nCnt = 1;
                $nId = 1;

                $dataBankC = $dataBank['csvDataBank'];
                $dataAdminC =  $dataAdmin['csvDataAdmin'];


//                var_dump($filePathAdmin);
                //For EACH
                $this->main_model->truncate_permata_records($fname);
                foreach($dataBankC as $row){
                    if($row['Tanggal'] != ''){
                        $nDetails = $row['Deskripsi'];
                        $nDeposit = $row['Kredit (+)'];

                        $nTanggal = $row['Tanggal'];
                        if($nTanggal){
//                            var_dump($nTanggal);
                            $noQuestion = trim(str_replace("??","",$nDetails));
                            $noQuestion = trim(str_replace("?","",$noQuestion));
                            $noQuestion = str_replace("PB DARI ","",$noQuestion);
                            $noQuestion = str_replace("PB KE ","",$noQuestion);
                            $noQuestion = str_replace(" PermataMobile","",$noQuestion);
                            $noQuestion = str_replace(" PermataNet","",$noQuestion);
//                            $noQuestion = str_replace(" ATM PB SPMOFFICEPARK JKT","",$noQuestion);
                            $noQuestion = str_replace(" NEW","",$noQuestion);
                            $noQuestion = str_replace(' ', '-', $noQuestion);
                            $noQuestion = preg_replace('/[^A-Za-z\-]/', '', $noQuestion);
                            $noQuestion = str_replace('-', ' ', $noQuestion);
                            $nDeposit = str_replace('.00Rp', ' ', $nDeposit);
                            $nStart = stripos($noQuestion," ATM PB ",0);
                            if($nStart >= 1){
                                $noQuestion = substr($noQuestion,0,$nStart);

                            }


                            $this->main_model->insert_name_permata($noQuestion,$fname,$nId);
                            $this->main_model->update_amount_permata($nId,$nDeposit);

                            $check = $this->validateBanktoAdmin($noQuestion,$nDeposit,$dataAdminC);
                            if($check >= 1){
                                $this->main_model->update_status_permata($check,$noQuestion,$nDeposit);
                            }


                            $nId += 1;

                        }
                    }

                }

                $dataFinal['results'] = $this->main_model->get_permata($fname);
                $this->load->view('admin/ajax_permata',$dataFinal);
            }
            else{
                echo "No data";
            }
        }
        else {
            echo "Cannot process empty";
        }

    }

    public function match_permata(){
        // $this->load->model('admin/main_model');
        $id = $this->input->post('id');
        $dsc = $this->input->post('dsc');
        $fname = $this->input->post('fname');
        $data['results'] = $this->main_model->match_permata($id,$dsc,$fname);
        $this->load->view('admin/ajax_permata',$data);
    }

    public function refresh_permata(){
        $fname = $this->input->post('fname');
        // $this->load->model('admin/main_model');
        $dataFinal['results'] = $this->main_model->get_permata($fname);
        $this->load->view('admin/ajax_permata',$dataFinal);
    }



//USABLE FUNCTIONS
    public function validateBanktoAdmin($name, $amount,$array) {
//        var_dump($array);
    foreach ($array as $key => $val) {
        $rekening = trim($val['Nama Rekening Member']);
        $name = trim($name);
        $nominal = $val['Nominal'];

//            echo $nominal ." > ". $amount. "<br/>";
//            echo strtoupper($rekening) ." > ". $name. "<br/>";
        if (strtoupper($rekening) == $name && $nominal == trim($amount)) {
//                echo strtoupper($rekening) ." > ". $name. "<br/>";
            return  1;
        }



    }
    return null;
}

    public function validateAdmintoBank($name, $amount,$arrayBank) {
//        var_dump($array);
        foreach ($arrayBank as $key => $val) {
            $rekening = substr(trim($val['Nama Rekening Member']),0,18);
            $name = substr(trim($name),0,18);
            $nominal = $val['Nominal'];

//            echo $nominal ." > ". $amount. "<br/>";
//            echo strtoupper($rekening) ." > ". $name. "<br/>";
            if (strtoupper($rekening) == $name && $nominal == trim($amount)) {
//                echo strtoupper($rekening) ." > ". $name. "<br/>";
                return  1;
            }elseif(substr(strtoupper($rekening),0,17) == $name && $nominal == trim($amount)){
                return  1;
            }


        }
        return null;
    }

//    Bank Information Controllers

    public function load_bank_info(){
        // $this->load->model('admin/main_model');
        $data['results'] = $this->main_model->get_bank_info();

        $this->load->view('admin/bank_info', $data);
    }

    public function add_bank_info(){
        $this->load->view('admin/ajax_add_bank_info');
    }

    public function insert_bank_info(){
        $bankname = $this->input->post_get('bankname');
        $dsc = $this->input->post_get('dsc');
        $cno = $this->input->post_get('cno');

        // $this->load->model('admin/main_model');
        $data = $this->main_model->insert_bank_info($bankname,$dsc,$cno);
        print_r($data);
    }

    public function delete_bank_info(){
        $id = $this->input->post_get('id');

        // $this->load->model('admin/main_model');
        $data = $this->main_model->delete_bank_info($id);
        print_r($data);
    }

    public function update_bank_info(){
        $id = $this->input->post_get('id');
        $code = $this->input->post_get('bankname');
        $dsc = $this->input->post_get('dsc');
        $cno = $this->input->post_get('cno');

        // $this->load->model('admin/main_model');
        $data = $this->main_model->update_bank_info($id,$code,$dsc,$cno);
        print_r($data);
    }

    public function load_edit_bank_info(){
        $data['id'] = $this->input->post_get('id');
        $data['code'] = $this->input->post_get('code');
        $data['dsc'] = $this->input->post_get('dsc');
        $data['cno'] = $this->input->post_get('cno');

        $this->load->view('admin/ajax_edit_bank_info',$data);
    }

//    Bank Accounts

    public function load_accounts_info(){
        // $this->load->model('admin/main_model');
        $data['results'] = $this->main_model->get_accounts();
        $this->load->view('admin/bank_account',$data);
    }

    public function add_accounts_info(){
        // $this->load->model('admin/main_model');
        $data['bank'] = $this->main_model->get_bank();
        $data['dept'] = $this->main_model->get_department();
        $this->load->view('admin/ajax_add_accounts_info',$data);
    }

    public function insert_accounts_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added account info.');

        $username =  $this->session->userdata('username');
        $accname = $this->input->post_get('accname');
        $accno = $this->input->post_get('accno');
        $cno = $this->input->post_get('cno');
        $bank = $this->input->post_get('bank');
        $dept = $this->input->post_get('dept');

        // $this->load->model('admin/main_model');
        $data = $this->main_model->insert_accounts_info($accname,$accno,$cno,$bank,$dept,$username);

        print_r($data);
    }

    public function delete_account_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted account info.');
        $id = $this->input->post_get('id');

        // $this->load->model('admin/main_model');
        $data = $this->main_model->delete_account_info($id);
        print_r($data);
    }

    public function load_edit_accounts_info(){
        // $this->load->model('admin/main_model');
        $data['id'] = $this->input->post_get('id');
        $data['name'] = $this->input->post_get('name');
        $data['accno'] = $this->input->post_get('accno');
        $data['cno'] = $this->input->post_get('cno');
        $data['bank_get'] = $this->input->post_get('bank');
        $data['dept_get'] = $this->input->post_get('dept');
        $data['bank'] = $this->main_model->get_bank();
        $data['dept'] = $this->main_model->get_department();
        $this->load->view('admin/ajax_edit_accounts_info',$data);
    }

//    Widrawals Controllers

    public function load_withdraw_info(){
        // $this->load->model('admin/main_model');
        $data['bank'] = $this->main_model->get_bank();

        $username = $this->input->post('username');
        $office = $this->get_office($username);
        $data['dept'] = $this->main_model->get_dept_office($office);
//        $data['dept'] = $this->main_model->get_department();
        $this->load->view('admin/withdraw',$data);
    }

    public function get_wd_dept(){
        $bank = $this->input->post_get('bank');
        $dept = $this->input->post_get('dept');

        // $this->load->model('admin/main_model');
        $data['results'] = $this->main_model->get_accounts_wd($bank,$dept);

        if(count($data['results']) > 0){
            $this->load->view('admin/ajax_wd_info',$data);
        }else {
            print "No data received";
        }
    }

    public function load_add_wd_info(){
        $name = $this->input->post_get('name');
        $accno = $this->input->post_get('accno');

        $data['name'] = $this->input->post_get('name');
        $data['accno'] = $this->input->post_get('accno');

//        // $this->load->model('admin/main_model');
//        $data['results'] = $this->main_model->get_wd_daily($accno);

        $this->load->view('admin/ajax_add_wd_info',$data);
    }

    public function insert_wd_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added withdraw info.');

        $username =  $this->session->userdata('username');
        $accname = $this->input->post_get('accname');
        $accno = $this->input->post_get('accno');
        $amount = $this->input->post_get('amount');
        $date = $this->input->post_get('date');


        // $this->load->model('admin/main_model');
        $data = $this->main_model->insert_wd_info($accname,$accno,$amount,$date,$username);

        print_r($data);
    }

    public function get_daily(){
        $data['name'] = $this->input->post_get('name');
        $data['accno'] = $this->input->post_get('accno');
        $data['year'] = $this->input->post_get('year');
        $data['month'] = $this->input->post_get('month');
        $data['day'] = $this->input->post_get('day');

        $accname = $this->input->post_get('accname');
        $accno = $this->input->post_get('accno');
        $year = $this->input->post_get('year');
        $month = $this->input->post_get('month');
        $day = $this->input->post_get('day');
        $date = trim($year)."-".trim($month)."-".trim($day);
        $data['date'] = $date;
        // $this->load->model('admin/main_model');
        $data['results'] = $this->main_model->get_wd_daily($accno,$date);

        $data['level'] = $this->get_level();

        $this->load->view('admin/summary_day',$data);


    }

    public function get_daily_all(){
        $data['year'] = $this->input->post_get('year');
        $data['month'] = $this->input->post_get('month');
        $data['day'] = $this->input->post_get('day');
        $data['bank'] = $this->input->post_get('bank');
        $data['dept'] = $this->input->post_get('dept');


        $bank = $this->input->post_get('bank');
        $dept = $this->input->post_get('dept');
        $year = $this->input->post_get('year');
        $month = $this->input->post_get('month');
        $day = $this->input->post_get('day');
        $date = trim($year)."-".trim($month)."-".trim($day);
        $data['date'] = $date;
        // $this->load->model('admin/main_model');
        $data['results'] = $this->main_model->get_wd_daily_all($bank,$dept,$date);

        $this->load->view('admin/summary_day_all',$data);
    }

    public function update_wd_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated withdrawal info.');

        $username =  $this->session->userdata('username');
        $id = $this->input->post_get('id');
        $accno = $this->input->post_get('accno');
        $amount = $this->input->post_get('amount');
        // $this->load->model('admin/main_model');
        $data = $this->main_model->update_wd_daily($accno,$amount,$id,$username);

    }

//Monthly Summary

    public function get_month(){
        $data['name'] = $this->input->post_get('name');
        $data['accno'] = $this->input->post_get('accno');
        $data['year'] = $this->input->post_get('year');
        $data['month'] = $this->input->post_get('month');
        $data['day'] = $this->input->post_get('day');

        $accname = $this->input->post_get('accname');
        $accno = $this->input->post_get('accno');
        $year = $this->input->post_get('year');
        $month = $this->input->post_get('month');
        $day = $this->input->post_get('day');
        $date = trim($year)."-".trim($month)."-".trim($day);
        $data['date'] = $date;
        // $this->load->model('admin/main_model');
        $data['results'] = $this->main_model->get_wd_month($accno,$date);

        $data['level'] = $this->get_level();

        $this->load->view('admin/summary_month',$data);


    }

    public function get_month_all(){
        $data['level'] = $this->get_level();
        $data['year'] = $this->input->post_get('year');
        $data['month'] = $this->input->post_get('month');
        $data['day'] = $this->input->post_get('day');
        $data['bank'] = $this->input->post_get('bank');
        $data['dept'] = $this->input->post_get('dept');


        $bank = $this->input->post_get('bank');
        $dept = $this->input->post_get('dept');
        $year = $this->input->post_get('year');
        $month = $this->input->post_get('month');
        $day = $this->input->post_get('day');
        $date = trim($year)."-".trim($month)."-".trim($day);
        $data['date'] = $date;
        $data['month'] = $this->get_month_name($date);
        // $this->load->model('admin/main_model');
        $data['results'] = $this->main_model->get_wd_month_all($bank,$dept,$date);

        $this->load->view('admin/summary_month_all',$data);
    }

    public function get_year_all(){
        $data['bank'] = $this->input->post_get('bank');
        $data['dept'] = $this->input->post_get('dept');


        $bank = $this->input->post_get('bank');
        $dept = $this->input->post_get('dept');
        $year = $this->input->post_get('year');
        $month = $this->input->post_get('month');
        $day = $this->input->post_get('day');
        $date = trim($year)."-".trim($month)."-".trim($day);

        $data['date'] = $date;

        $data['year'] = $year;
        // $this->load->model('admin/main_model');
        $data['results'] = $this->main_model->get_year($date,$bank,$dept);

        $this->load->view('admin/summary_year',$data);
    }

// Member Portal Controllers

    public function load_member_portal(){
        $this->load->view('admin/member_portal');
    }

    public function show_my_attendance(){
        $username = $this->input->post('empid');
        $year = $this->input->post_get('year');
        $month = $this->input->post_get('month');

        $date = trim($year)."-".trim($month)."-01";
        $this->main_model->delete_data_first($date,$username);
        $data['attendance'] = $this->main_model->get_att_sched($date,$username);

        foreach($data['attendance'] as $row){

            for($x = 1; $x <= 31; $x++){

                $num = $x;
                $y = 'd'.substr($num,0,2);
                $str_date = strtotime($row->month);
                $c_date  =date("Y-m",$str_date)."-".$x;
                if($row->$y){
                    $this->main_model->insert_to_att_view($c_date,$row->$y,$username);
//                    echo "<tr><td>$c_date</td><td>".$row->$y."</td></tr>";
                }
            }
        }

        $data['timein'] = $this->main_model->get_att_timein($date,$username);

        $data['results'] = $this->main_model->calculated_attendance($date,$username);
        $data['grand_total'] = $this->main_model->calculated_attendance_total($date,$username);
        $this->load->view('admin/ajax_view_my_attendance',$data);

    }

    public function calendar_timein(){
//        echo round(microtime(true) * 1000);
        echo strtotime('2015-05-01 19:00:07');
    }

    public function load_my_schedule(){
        $this->load->view('admin/my_schedule');
    }

    public function load_member_schedules(){
        $empid =  $this->session->userdata('username');
        // $this->load->model('admin/main_model');

        $date = $this->input->post('date');

        $data["emp_info"] = $this->main_model->get_emp_schedule_individual($empid,$date);
        $data["lastday"] = $this->main_model->get_month_info($date);
        $dept = ($data["emp_info"][0]->department);
        $data["sched_template"] = $this->main_model->get_sched_template($dept);
//        $cnt = $this->main_model->get_emp_rows($dept,$date);


        $lastday = $data["lastday"];
        $data["lastday"] = $lastday[0]->LASTDAY;
        $data["dayname"] = $lastday[0]->DAY_NAME;
        $data["monthnow"] = $lastday[0]->MONTHNOW;
        $data["monthnext"] = $lastday[0]->MONTHNEXT;
        $data["monthprev"] = $lastday[0]->MONTHPREV;

//        $this->load->view('admin/schedule_setup',$data);
        $this->load->view('admin/member_schedule',$data);
    }

    public function load_member_schedules_next(){
        $empid =  $this->session->userdata('username');
        // $this->load->model('admin/main_model');

        $date = $this->input->post('date');

        $data["emp_info"] = $this->main_model->get_emp_schedule_individual_next($empid,$date);
        $data["lastday"] = $this->main_model->get_month_info_next($date);
        $dept = ($data["emp_info"][0]->department);
        $data["sched_template"] = $this->main_model->get_sched_template($dept);
//        $cnt = $this->main_model->get_emp_rows($dept,$date);


        $lastday = $data["lastday"];
        $data["lastday"] = $lastday[0]->LASTDAY;
        $data["dayname"] = $lastday[0]->DAY_NAME;
        $data["monthnow"] = $lastday[0]->MONTHNOW;
        $data["monthnext"] = $lastday[0]->MONTHNEXT;
        $data["monthprev"] = $lastday[0]->MONTHPREV;


//        $this->load->view('admin/schedule_setup',$data);
        $this->load->view('admin/member_schedule',$data);
    }

    public function load_member_schedules_prev(){
        $empid =  $this->session->userdata('username');
        // $this->load->model('admin/main_model');

        $date = $this->input->post('date');

        $data["emp_info"] = $this->main_model->get_emp_schedule_individual_prev($empid);
        $data["lastday"] = $this->main_model->get_month_info_prev($date);
        $dept = ($data["emp_info"][0]->department);
        $data["sched_template"] = $this->main_model->get_sched_template($dept);
//        $cnt = $this->main_model->get_emp_rows($dept,$date);


        $lastday = $data["lastday"];
        $data["lastday"] = $lastday[0]->LASTDAY;
        $data["dayname"] = $lastday[0]->DAY_NAME;
        $data["monthnow"] = $lastday[0]->MONTHNOW;
        $data["monthnext"] = $lastday[0]->MONTHNEXT;
        $data["monthprev"] = $lastday[0]->MONTHPREV;

//        $this->load->view('admin/schedule_setup',$data);
        $this->load->view('admin/member_schedule',$data);
    }

    public function approve_monthly_wd(){
        $id = $this->input->post('id');
        $empid =  $this->session->userdata('username');
        $data = $this->main_model->approved_wd($id,$empid);
        print_r($data);
    }

//    Pools Controller

    public function load_pools(){
        $data['results'] = $this->main_model->get_pools_info();
        $this->load->view('admin/pools',$data);
    }

    public function add_pools_info(){
        $this->load->view('admin/add_pools');
    }

    public function insert_pool_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added pools info.');

        $poolcode = $this->input->post_get('poolcode');
        $dsc = $this->input->post_get('dsc');
        $empid =  $this->session->userdata('username');
        $data = $this->main_model->insert_pool_info($empid, $poolcode,$dsc);
        print_r($data);
    }

    public function update_pool_info(){

        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated pools info.');

        $id = $this->input->post_get('id');
        $code = $this->input->post_get('code');
        $dsc = $this->input->post_get('dsc');
        $empid =  $this->session->userdata('username');

        $data = $this->main_model->update_pool_info($id,$code,$dsc,$empid);
        print_r($data);
    }

    public function load_edit_pools_info(){
        $data['id'] = $this->input->post_get('id');
        $data['code'] = $this->input->post_get('code');
        $data['dsc'] = $this->input->post_get('dsc');

        $this->load->view('admin/edit_pools',$data);
    }

    public function delete_pools_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted pools info.');

        $id = $this->input->post_get('id');
        $data = $this->main_model->delete_pool_info($id);
        print_r($data);
    }

//    Global Market

    public function load_global_market(){
        $username = $this->input->post('username');
        $office = $this->get_office($username);
        $data['dept'] = $this->main_model->get_dept_office($office);
        $data['pools'] = $this->get_pools();
        $data['results'] = $this->main_model->get_market_info();
        $this->load->view('admin/global_market',$data);
    }

    public function add_market_info(){
        $this->load->view('admin/add_market');
    }

    public function insert_market(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added market info.');

        $empid =  $this->session->userdata('username');
        $dept = $this->input->post_get('dept');
        $pool = $this->input->post_get('pool');
        $date = $this->input->post_get('date');
        $gross = $this->input->post_get('gross');
        $dc = $this->input->post_get('dc');
        $kei = $this->input->post_get('kei');
        $gift = $this->input->post_get('gift');
        $referral = $this->input->post_get('referral');

        $data = $this->main_model->insert_market($empid, $dept,$pool,$date,$gross,$dc,$kei,$gift,$referral);

        print_r($data);

    }

    public function load_market_dept(){
        $dept = $this->input->post_get('dept');
        $date = new Date();
        $pool = '%';
        $data['results'] = $this->main_model->get_market_dept($dept);
        $data['totals'] = $this->main_model->get_total_market($dept,$pool,$date);
        $this->load->view('admin/table_market',$data);
    }

    public function load_market_dept_pool(){
        $dept = $this->input->post_get('dept');
        $pool = $this->input->post_get('pool');
        $data['totals'] = $this->main_model->get_total_market($dept,$pool,$date);
        $data['results'] = $this->main_model->get_market_dept_pool($dept,$pool);
        $this->load->view('admin/table_market',$data);
    }

    public function load_market_dept_pool_date(){
        $dept = $this->input->post_get('dept');
        $pool = $this->input->post_get('pool');
        $date = $this->input->post_get('date').'-01';

        $data['results'] = $this->main_model->get_market_dept_pool_date($dept,$pool,$date);
        $data['totals'] = $this->main_model->get_total_market($dept,$pool,$date);
        $this->load->view('admin/table_market',$data);
    }

    public function load_edit_market_info(){

        $data['id'] = $this->input->post_get('id');
        $data['dept'] = $this->input->post_get('dept');
        $data['pool'] = $this->input->post_get('pool');
        $data['date'] = $this->input->post_get('date');
        $data['gross'] = $this->input->post_get('gross');
        $data['dc'] = $this->input->post_get('dc');
        $data['kei'] = $this->input->post_get('kei');
        $data['gift'] = $this->input->post_get('gift');
        $data['referral'] = $this->input->post_get('referral');

        $this->load->view('admin/edit_market',$data);
    }

    public function update_market(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated market info.');

        $empid =  $this->session->userdata('username');
        $id = $this->input->post_get('id');
        $dept = $this->input->post_get('dept');
        $pool = $this->input->post_get('pool');
        $date = $this->input->post_get('date');
        $gross = str_replace(',','',$this->input->post_get('gross'));
        $dc = str_replace(',','',$this->input->post_get('dc'));
        $kei = str_replace(',','',$this->input->post_get('kei'));
        $gift = str_replace(',','',$this->input->post_get('gift'));
        $referral = str_replace(',','',$this->input->post_get('referral'));

        $data = $this->main_model->update_market($id,$empid, $dept,$pool,$date,$gross,$dc,$kei,$gift,$referral);

        print_r($data);
    }

    public function delete_market_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted market info.');

        $id = $this->input->post_get('id');

        $data = $this->main_model->delete_market_info($id);
        print_r($data);
    }

    public function load_global_report(){
//        $data['referral'] = $this->input->post_get('referral');

        $this->load->view('admin/ajax_report_global');
    }

//    DEPO WID

    public function load_depowid(){
        $username = $this->input->post('username');
        $office = $this->get_office($username);
        $data['dept'] = $this->main_model->get_dept_office($office);
        $this->load->view('admin/dpwd',$data);
    }

    public function load_depowid_table(){
        $dept = $this->input->post_get('dept');
        $year = $this->input->post_get('year');
        $month = $this->input->post_get('month');
        $date = trim($year)."-".trim($month)."-"."01";
        $data['results'] = $this->main_model->get_depowid($dept, $date);
        $data['total'] = $this->main_model->get_depowid_total($dept, $date);

        $this->load->view('admin/table_depowid',$data);

    }

    public function load_add_depowid(){
        $this->load->view('admin/ajax_add_depowid');
    }

    public function insert_depowid(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added deposit and withdraw info.');

        $empid =  $this->session->userdata('username');
        $dept = $this->input->post_get('dept');
        $date = $this->input->post_get('date');

        $wid = $this->input->post_get('wid');
        $depo = $this->input->post_get('depo');

        $data = $this->main_model->insert_depowid($empid, $dept,$date,$wid,$depo);

        print_r($data);
    }

    public function load_edit_depowid(){
        $data['id'] = $this->input->post('id');
        $data['date'] = $this->input->post('date');
        $data['depo'] = $this->input->post('depo');
        $data['wid'] = $this->input->post('wid');
        $this->load->view('admin/ajax_edit_depowid',$data);
    }

    public function update_depowid(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated deposit and withdraw info.');
        $empid =  $this->session->userdata('username');
        $id = $this->input->post_get('id');
        $date = $this->input->post_get('date');
        $depo = str_replace(',','',$this->input->post_get('depo'));
        $wid = str_replace(',','',$this->input->post_get('wid'));

        $data = $this->main_model->update_depowid($id,$empid, $date,$depo,$wid);

        print_r($data);
    }

    public function delete_depowid(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted deposit and withdraw info.');
        $id = $this->input->post_get('id');

        $data = $this->main_model->delete_depowid($id);
        print_r($data);
    }

//    Expenses

    public function load_expenses(){
        // $this->load->model('admin/main_model');
        $data['dept'] = $this->get_dept();

        $this->load->view('admin/expenses', $data);
    }

    public function json_expenses(){

        $result = [];
        $data['results'] = $this->main_model->get_expenses();

            foreach($data['results'] as $row){
                    $result[] =  array(
                        $row->id,
                        $row->date,
                        $row->amount,
                        $row->dept,
                        $row->account_from,
                        $row->account_to,
                        $row->remarks,
                        $row->updated_by,
                        $row->date_updated

                        );
            }

        $dataFormat = array(
            "data" => $result ? $result : []
        );

        $jsonResults = json_encode($dataFormat);
        print($jsonResults ? $jsonResults : []);

    }

    public function delete_expenses(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted expenses info.');
        $id = $this->input->post_get('id');

        // $this->load->model('admin/main_model');
        $data = $this->main_model->delete_expenses($id);
        print_r($data);
    }

    public function add_expenses(){
        $data['dept'] = $this->get_dept();

        $this->load->view('admin/ajax_add_expenses',$data);
    }

    public function insert_expenses(){
        $username = $this->session->userdata('username');
        $date = $this->input->post_get('date');
        $amount = $this->input->post_get('amount');
        $from = $this->input->post_get('from');
        $to = $this->input->post_get('to');
        $department = $this->input->post_get('department');
        $remarks = $this->input->post_get('remarks');

        // $this->load->model('admin/main_model');
        $data = $this->main_model->insert_expenses($date,$amount,$from,$to,$department,$remarks,$username);
        print_r($data);
    }

    public function load_edit_expenses(){

        $data['id'] = $this->input->post_get('id');
        $data['date'] = $this->input->post_get('date');
        $data['amount'] = $this->input->post_get('amount');
        $data['from'] = $this->input->post_get('from');
        $data['to'] = $this->input->post_get('to');
        $data['remarks'] = $this->input->post_get('remarks');

        $this->load->view('admin/ajax_edit_expenses',$data);

    }

    public function update_expenses(){
        $username = $this->session->userdata('username');
        $id = $this->input->post_get('id');
        $date = $this->input->post_get('date');
        $amount = $this->input->post_get('amount');
        $from = $this->input->post_get('from');
        $to = $this->input->post_get('to');
        $remarks = $this->input->post_get('remarks');
        $amount = str_replace(',','',$amount);
        // $this->load->model('admin/main_model');
        $data = $this->main_model->update_expenses($id,$date,$amount,$from,$to,$remarks,$username);
        print_r($data);
    }

//    Announcements

    public function load_announcements(){
        $data['results'] = $this->main_model->get_all_announcements();
        $this->load->view('admin/announcement',$data);
    }

    public function add_announcement_info(){

        $this->load->view('admin/ajax_add_announcements');
    }

    public function insert_announcements_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added announcement info.');

        $empid =  $this->session->userdata('username');
        $title = $this->input->post_get('title');
        $dsc = $this->input->post_get('dsc');

        $data = $this->main_model->insert_announcements($empid, $title,$dsc);

        print_r($data);
    }

    public function load_edit_announcements(){
        $data["id"] = $this->input->post('id');
        $data["title"] = $this->input->post('title');
        $data["dsc"] = $this->input->post('dsc');

        $this->load->view('admin/ajax_edit_announcement',$data);

    }

    public function update_announcements_info(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated an announcement.');

        $empid =  $this->session->userdata('username');
        $id = $this->input->post_get('id');
        $title = $this->input->post_get('title');
        $dsc = $this->input->post_get('dsc');

        $data = $this->main_model->update_announcements($id, $empid, $title,$dsc);

        print_r($data);
    }

    public function delete_announcements(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted an announcement.');
        $id = $this->input->post_get('id');

        $data = $this->main_model->delete_announcement($id);
        print_r($data);
    }

    public function load_profile(){
        $empid = $this->session->userdata('username');
        $data['dept'] = $this->get_dept();
        $data['lock_details'] = $this->main_model->get_bank_lock_date($empid);
        $data['results'] = $this->main_model->get_profile($empid);
        $data['dept_get'] = $data['results'][0]->dept;
        $this->load->view('admin/profile',$data);
    }

//    Department

    public function load_department(){
        $data['results'] = $this->main_model->get_all_departments();
        $this->load->view('admin/department',$data);
    }

    public function add_department_info(){
        $this->load->view('admin/ajax_add_dept');
    }

    public function insert_department(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Added department info.');

        $empid =  $this->session->userdata('username');
        $dname = $this->input->post_get('dname');

        $data = $this->main_model->insert_department($dname);

        print_r($data);
    }

    public function load_edit_dept(){
        $data["id"] = $this->input->post('id');
        $data["dsc"] = $this->input->post('dsc');
        $this->load->view('admin/ajax_edit_dept',$data);

    }

    public function delete_dept(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Deleted an announcement.');
        $id = $this->input->post_get('id');

        $data = $this->main_model->delete_dept($id);
        print_r($data);
    }


    public function update_profile(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated a profile.');

        $params = $_GET;
        $empid = $_GET['empid'];
        $data = $this->main_model->update_profile($params,$empid);

        print_r($data);
    }

    public function lock_bank(){
        $empid = $this->input->post('empid');
        $data = $this->main_model->lock_bank($empid);
        print_r($data);
    }

    public function lock_date(){
        $empid = $this->input->post('empid');
        $data = $this->main_model->get_bank_lock_date($empid);
        print_r($data);
    }

    public function load_profile_specific(){
        $empid = $this->input->post('empid');
        $data['dept'] = $this->get_dept();
        $data['results'] = $this->main_model->get_profile($empid);
        $data['dept_get'] = $data['results'][0]->dept;
        $this->load->view('admin/profile',$data);
    }

    public function load_edit_timein(){
        $data["id"] = $this->input->post('id');
        $data["timein"] = $this->input->post('timein');
        $data["timeout"] = $this->input->post('timeout');
        $this->load->view('admin/ajax_edit_timein',$data);
    }

    public function delete_timein(){
        $id = $this->input->post('id');
        $data = $this->main_model->delete_timein($id);
        print_r($data);
    }

    public function change_pass(){
        $data['empid'] = $this->input->post('empid');
        $this->load->view('admin/change_pass',$data);
    }

    public function change_pass_force(){
        $data['empid'] = $this->session->userdata('username');
        $this->load->view('admin/change_pass',$data);
    }

//IT Controllers

    public function load_it(){
        $empid =  $this->session->userdata('username');
        $data['results'] = $this->main_model->get_it_report($empid);
//        $data['read_status'] = $this->main_model->get_it_report_read_status($empid);
        $this->load->view('admin/it', $data);
    }

    public function insert_it(){
        $empid =  $this->session->userdata('username');
        $title = strtoupper($this->input->post_get('title'));
        $dsc = $this->input->post_get('dsc');
        $status = $this->input->post_get('status');
        $url = 'http://admin-sfx.com/ers/admin/main/';
        $imgurl = "http://admin-sfx.com/ers/public/img/sfx-logo.png";

        $api = 'f3430775964a5f93f0a128d06c12926b';

        $headers = [
            'Authorization:key='.$api
        ];

        $data = "title=".$title."&message=".substr($dsc,58,250)."&url=".$url."&image_url=".$imgurl;

//        $data = json_encode($data);

        $ch = curl_init("https://pushcrew.com/api/v1/send/all");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);


        $data = $this->main_model->insert_it($empid, $title,$dsc,$status);

        print_r($data);
    }

    public function add_it_info(){
        $this->load->view('admin/ajax_add_it');
    }

    public function load_edit_it(){
        $empid =  $this->session->userdata('username');
        $data["id"] = $this->input->post('id');
        $data["title"] = $this->input->post('title');
        $data["dsc"] = $this->input->post('dsc');


        $data["status"] = $this->input->post('status');

        $this->main_model->read_it_log($data["id"],$empid);
        $this->load->view('admin/ajax_edit_it',$data);

    }

    public function update_it_info(){
        $empid =  $this->session->userdata('username');
        $id = $this->input->post_get('id');
        $title = strtoupper($this->input->post_get('title'));
        $dsc = $this->input->post_get('dsc');
        $status = $this->input->post_get('status');

        $url = 'http://admin-sfx.com/ers/admin/main/';
        $imgurl = "http://admin-sfx.com/ers/public/img/sfx-logo.png";
        $api = 'f3430775964a5f93f0a128d06c12926b';

        $headers = [
            'Authorization:key='.$api
        ];

        $data = "title=UPDATE:".$title."&message=".substr($dsc,58,200)."&url=".$url."&image_url=".$imgurl;

//        $data = json_encode($data);

        $ch = curl_init("https://pushcrew.com/api/v1/send/all");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = $this->main_model->update_it($id, $empid, $title,$dsc, $status);

        print_r($data);
    }

//Finance Head Controllers

    public function load_salary(){
        $level = $this->input->post('level');
            if($level == '1' || $level == '3'){
            $data['dept'] = $this->get_dept();
            $data['results'] = $this->main_model->get_salary();
            $this->load->view('admin/salary',$data);
        }
    }

    public function load_edit_salary(){
        $data["empid"] = $this->input->post('empid');
        $data["fname"] = $this->input->post('fname');
        $data["lname"] = $this->input->post('lname');
        $data["salary"] = $this->input->post('salary');

        $data["salary"] = str_replace(".","",$data["salary"]);
        $data["salary"] = str_replace(",",".",$data["salary"]);

        $this->load->view('admin/ajax_salary_edit',$data);

    }

    public function insert_salary(){
        $empid =  $this->session->userdata('username');
        $this->logging($empid, 'Updated salary info.');

        $empid = $this->input->post('empid');
        $salary = $this->input->post('salary');
        $updateby =  $this->session->userdata('username');

        $data = $this->main_model->insert_salary($empid, $salary,$updateby);

        print_r($data);
    }

    public function load_salary_report(){
        $level = $this->input->post('level');
        if($level == '1' || $level == '3') {

            $this->load->view('admin/report/salary_report');
        }

    }

    public function load_ajax_salary_report(){
        $month = $this->input->post('month').'-01';
        $data['results'] = $this->main_model->get_salary_report($month);
        $this->load->view('admin/report/ajax_salary_report',$data);
    }


//Finance Info Controllers

    public function add_finance_info(){
        $this->load->view('admin/ajax_add_it');
    }

    public function update_finance_info(){
        $empid =  $this->session->userdata('username');
        $id = $this->input->post_get('id');
        $title = strtoupper($this->input->post_get('title'));
        $dsc = $this->input->post_get('dsc');
        $status = $this->input->post_get('status');

        $data = $this->main_model->update_it($id, $empid, $title,$dsc, $status);

        print_r($data);
    }

//    Attendance

    public function compute_attendance(){

        $date = "2015-07-01";
        $username = "wmurni";
        $this->main_model->delete_data_first($date,$username);
        $data['attendance'] = $this->main_model->get_att_sched($date,$username);

        foreach($data['attendance'] as $row){

            for($x = 1; $x <= 31; $x++){

                $num = $x;
                $y = 'd'.substr($num,0,2);
                $str_date = strtotime($row->month);
                $c_date  =date("Y-m",$str_date)."-".$x;
                if($row->$y){
                    $this->main_model->insert_to_att_view($c_date,$row->$y,$username);
//                    echo "<tr><td>$c_date</td><td>".$row->$y."</td></tr>";
                }
            }
        }

        $data['timein'] = $this->main_model->get_att_timein($date,$username);

        $data['summary'] = $this->main_model->calculated_attendance($date,$username);
//        print_r($date['summary']);
//        $this->load->view('admin/att_compute', $data);

        return $data;
    }

    public function it_monitor(){
        $this->load->view('admin/it_monitor');


    }

    public function jsonPush(){
        $arrayPush = [
            "token" => "a5n9o13gzct653ji2zyybujy8ar9ks",
            "user" => "ufrit964d5wtwemxiucm735qrh4nom",
            "message" => "Sample Push"
        ];

        $jsonPush = json_encode($arrayPush);
        print_r($jsonPush);
    }

//    Cloudflare Controllers

    public function load_it_cloudflare(){
        $empid =  $this->session->userdata('username');
        $data['accounts'] = $this->main_model->get_it_cloudflare_accounts();
        $data['results'] = $this->main_model->get_it_cloudflare();
//        $data['read_status'] = $this->main_model->get_it_report_read_status($empid);
        $this->load->view('admin/it_cloudflare', $data);
    }

    public function getCFAccountInfo(){
        $email = $this->input->post_get('email');
        $api_key = $this->main_model->get_it_cloudflare_accounts_api($email);
        $api_key = $api_key[0]->api_key;

        $this->main_model->delete_cf_accounts_credentials($email);

        $headers = [
            'X-Auth-Key:'.$api_key,
            'X-Auth-Email:'.$email,
            'Content-Type:application/json'

        ];

        $zone_id = '9257fffe9d5caca5cae8a9bd507cfa0e';

        $ch = curl_init("https://api.cloudflare.com/client/v4/zones?status=active&page=1&per_page=150&order=name&direction=asc&match=all");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);


        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);


        $arrayList = [];

        foreach($result->result as $row){
            $ip = $this->getCFIPDetails($email, $api_key, $row->id);

            $arrayList = array(

                "email" => $email,
                "api_key" => $api_key,
                "domain" => $row->name,
                "zone_id" => $row->id,
                "ip_address" => $ip
            );
            $this->db->insert('it_cloudflare_info',$arrayList );
        }


        print_r($result);

    }

    public function setDevMode(){

//        $domain = $this->input->post_get('domain');
        $email = $this->input->post_get('email');
        $api = $this->input->post_get('api');
        $zone_id = $this->input->post_get('zone');



        $headers = [
            'X-Auth-Key:'.$api,
            'X-Auth-Email:'.$email,
            'Content-Type:application/json'

        ];

        $data = [
            "value" => "on"
        ];

        $data = json_encode($data);

        $ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zone_id."/settings/development_mode");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        print_r($result);

//        $dateadd = date_add(date('Y-m-d h:i:sa'),date_interval_create_from_date_string("3 hours"));
//
//        $this->db->set('dev_mode', 1);
//        $this->db->set('dev_start', date("Y-m-d h:i:sa"));
//
//        $this->db->set('dev_end', 'DATE_ADD(dev_start, INTERVAL 3 HOUR)');
//        $this->db->where('zone_id', $zone_id);
//        $this->db->update('it_cloudflare_info');


    }

    public function setPurgeCache(){

//        $domain = $this->input->post_get('domain');
        $email = $this->input->post_get('email');
        $api = $this->input->post_get('api');
        $zone_id = $this->input->post_get('zone');


        $headers = [
            'X-Auth-Key:'.$api,
            'X-Auth-Email:'.$email,
            'Content-Type:application/json'

        ];

        $data = [
            "purge_everything" => true
        ];

        $data = json_encode($data);

        $ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zone_id."/purge_cache");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        print_r($result);


//        $this->output->enable_profiler(TRUE);


    }

    public function getCFIPDetails($email, $api_key, $id) {


        $email = $email;
        $api = $api_key;
        $zone_id = $id;

        $headers = [
            'X-Auth-Key:'.$api,
            'X-Auth-Email:'.$email,
            'Content-Type:application/json'

        ];

        $data = [
            "type" => "A"
        ];

        $data = json_encode($data);

        $ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zone_id."/dns_records");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
//        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);

        return $result->result[0]->content;
    }

    public function sendEmail(){

        $this->load->library('email');

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mailtrap.io',
            'smtp_port' => 2525,
            'smtp_user' => 'ab301c220713ad',
            'smtp_pass' => '078de306d87bb8',
            'crlf' => "\r\n",
            'newline' => "\r\n"
        );



        $this->email->initialize($config);

        $this->email->to('lorrynibblestone@gmail.com');
        $this->email->message('Sample Email');

        $this->email->send();

        $this->email->print_debugger();
    }
}
