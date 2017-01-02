<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main_model extends CI_Model{

//    Usable functions

    public function get_bank(){
        $query = "SELECT bank_name FROM bank";
        $query = $this->db->query($query);
        return $query->result();

    }

    public function load_summary(){
        $query = <<<EOD
        SELECT
B.dept, count(dept) as count_dept
FROM time_in AS A, emp_info AS B
WHERE
date(A.timein) BETWEEN DATE_SUB(CURDATE(),interval 1 day) AND DATE_ADD(CURDATE(),interval 1 day)
AND date(A.timeout) is null
AND A.empid = B.empid
GROUP BY B.Dept
EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_department(){
        $query = "SELECT dsc FROM department";
        $query = $this->db->query($query);
        return $query->result();

    }

    public function get_office_all(){
        $query = "SELECT * FROM office";
        $query = $this->db->query($query);
        return $query->result();

    }

    public function update_timein_info($id,$timein,$timeout){
        $query = "UPDATE time_in SET timein = '$timein', timeout= '$timeout' WHERE id = '$id'";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function delete_timein($id){
        $query = "DELETE FROM time_in WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Deleted!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;
    }

    public function get_dept_office($office){

        $query = "SELECT * FROM department WHERE office = $office";
        $query = $this->db->query($query);
        return $query->result();

    }

    public function get_office($username){
        $query = "SELECT B.office FROM emp_info AS A LEFT JOIN users AS B ON A.empid = B.emp_no WHERE A.empid = '$username' LIMIT 1";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_level($uname){
        $query = "SELECT level FROM users WHERE username = '$uname'";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_month($month){
        $query = "SELECT MONTHNAME('$month') as month";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_all_pools(){
        $query = "SELECT dsc,code FROM pools";
        $query = $this->db->query($query);
        return $query->result();
    }

//    IP Address
    public function get_ip_addresses(){
        $query = "SELECT * FROM ip_pool";
        $query = $this->db->query($query);
        return $query->result();

    }

    public function save_ip($ip,$dsc,$logo){
        $query = "INSERT INTO ip_pool (ip_address, dsc, logo) VALUES ('$ip','$dsc','$logo')";

        $this->db->query($query);


    }

    public function get_ip_specific($id){
        $query = "SELECT * FROM ip_pool WHERE id='$id'";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function delete_ip($id){
        $query = "DELETE FROM ip_pool WHERE id = $id";

        $this->db->query($query);

    }

    public function get_emp_info(){
        $query = <<<EOD
        SELECT id, empid, fname, lname, dept, DATEDIFF(date(now()),date(COALESCE(join_date,'0000-00-00')))/365 as years,
DATEDIFF(e_visa, NOW()) as visa_exp, e_visa
FROM
emp_info AS A
WHERE status is null
EOD;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function add_emp($params){

        if($this->db->insert('emp_info',$params)){
            $msg = true;
        }else{
            $msg = false;
        }


        return $msg;

//        $this->db->insert('users',$params);
    }

    public function update_emp($params,$id){
        $this->db->where('id', $id);
        if($this->db->update('emp_info',$params)){
            $msg = true;
        }else{
            $msg = false;
        }


        return $msg;

//        $this->db->insert('users',$params);
    }

    public function get_emp_specific($id){
        $query = "SELECT * FROM emp_info WHERE id = $id";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function delete_emp($id,$uname){
        if($this->db->delete('emp_info', array('id' => $id))){
            $this->db->delete('users', array('username' => $uname));
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function mark_resign($id){
        $query = "UPDATE emp_info SET status = 'Resigned' WHERE id = $id";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function add_user($empid, $office){
        $query = "INSERT INTO users (emp_no, username, passkey,level,office) VALUES ('$empid', '$empid', 'pass1234',0, $office)";
        $this->db->query($query);

    }

    public function get_users_info(){
        $query = "SELECT A.id AS ID, A.emp_no AS EMP_NO, B.fname AS FNAME, B.lname AS LNAME, A.username AS USERNAME, A.level AS RIGHTS FROM users AS A LEFT JOIN emp_info AS B ON A.emp_no = B.empid";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_all_login(){
        $query = "CALL `dash_login`()";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_all_department(){
        $query = "SELECT dsc FROM department";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_office_department($office){
        $query = "SELECT dsc FROM department WHERE office = '$office'";
        $query = $this->db->query($query);
        return $query->result();
    }


    public function get_all_login_filtered($dept){
        $query = <<<EOD
        SELECT B.id AS ID, CONCAT(C.fname," ",C.lname) AS FULLNAME, B.timein as TIMEIN, C.dept AS DEPT
        FROM time_in AS B
        LEFT JOIN
        users AS A
        ON
        A.username = B.empid
        LEFT JOIN
        emp_info AS C
        ON
        A.emp_no = C.empid
        LEFT JOIN
        user_images AS D
        ON
        D.empid = A.username
        WHERE
        B.timeout is null
        AND timein >= DATE_SUB(curdate(), interval 1 day) and timein <= DATE_ADD(curdate(), interval 1 day)
        AND C.dept = '$dept'
        ORDER BY B.id DESC
EOD;




        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_attendance_info($office){
        $query = <<<EOD
        SELECT
A.id, B.username , C.fname, C.lname, A.timein, A.timeout, TIMEDIFF(A.timeout,A.timein) AS SubTotal
FROM
time_in AS A
LEFT JOIN
users AS B
ON A.empid = B.username
LEFT JOIN
emp_info AS C
ON C.empid = B.username
WHERE
B.office = $office AND
C.status is null AND
MONTH(A.timein) = MONTH(NOW())
AND
YEAR(A.timein) = YEAR(NOW())
ORDER BY A.timein
EOD;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_last_day(){
        $query = "SELECT DAY(LAST_DAY(CURDATE())) AS LASTDAY";
        $query = $this->db->query($query);
        return $query->result();
    }


    public function get_emp_schedule($dept,$month){

        $query = "SELECT A.* FROM emp_schedule as A, emp_info as B WHERE A.username = B.empid and department = '$dept' and month = '$month' ";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_emp_dept_sample(){
        $query = "SELECT empid, fname, lname FROM emp_info WHERE status IS NULL";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_month_info($date){
        $query = "SELECT DAY(LAST_DAY('$date')) AS LASTDAY, DAYNAME(date_add('$date',interval -DAY('$date')+1 DAY)) AS DAY_NAME, MONTHNAME('$date') as MONTHNOW, MONTHNAME(DATE_ADD('$date',INTERVAL 1 MONTH)) as MONTHNEXT, MONTHNAME(DATE_SUB('$date',INTERVAL 1 MONTH)) as MONTHPREV";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_month_info_next($date){

        $query = "SELECT DAY(LAST_DAY(DATE_ADD('$date', INTERVAL 1 MONTH))) AS LASTDAY, DAYNAME(date_add(date_add('$date',interval 1 month),interval -DAY(date_add('$date',interval 1 month))+1 DAY)) AS DAY_NAME,  MONTHNAME('$date') as MONTHNOW, MONTHNAME(DATE_ADD('$date',INTERVAL 1 MONTH)) as MONTHNEXT, MONTHNAME(DATE_SUB('$date',INTERVAL 1 MONTH)) as MONTHPREV FROM emp_schedule WHERE MONTH(month) = MONTH(DATE_ADD('$date',INTERVAL 1 MONTH))";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_month_info_prev($date){
        $query = "SELECT DAY(LAST_DAY(DATE_SUB('$date', INTERVAL 1 MONTH))) AS LASTDAY, DAYNAME(DATE_SUB('$date', INTERVAL 1 MONTH)) AS DAY_NAME, MONTHNAME('$date') as MONTHNOW, MONTHNAME(DATE_ADD('$date',INTERVAL 1 MONTH)) as MONTHNEXT, MONTHNAME(DATE_SUB('$date',INTERVAL 1 MONTH)) as MONTHPREV FROM emp_schedule WHERE MONTH(month) = MONTH(DATE_SUB('$date',INTERVAL 1 MONTH))";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_sched_template($dept_call){
//        var_dump($dept_call);
        $query = "SELECT * FROM sched_template WHERE by_dept = '$dept_call'";
        $query = $this->db->query($query);
        return $query->result();
    }

//    public function get_emp_rows(){
//        $query = "SELECT * FROM emp_schedule WHERE department = '$dept' AND month = '$date'";
//        $query = $this->db->query($query);
//        return $query->num_rows();
//    }

    public function create_schedule_template($dept,$date){

        $query = "SELECT * FROM emp_schedule AS A, emp_info AS B WHERE A.username = B.empid and department = '$dept' AND month = '$date'";
        $query = $this->db->query($query);
        $query = $query->num_rows();

        if ($query <= 0){
            $query = "SELECT * FROM emp_info WHERE dept = '$dept' and status is null";
            $query = $this->db->query($query);
            $query = $query->result();
            $emp_data['result'] = $query;

            foreach($emp_data['result'] as $row){
                $username = $row->empid;
                $query = "INSERT INTO emp_schedule (username, department, month) VALUES ('$username','$dept','$date')";

                $this->db->query($query);

            }
        }



    }

    public function reset_schedule($dept,$date){
        $query = "DELETE FROM emp_schedule WHERE department = '$dept' and month = '$date'";


        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function updateSched($id,$value, $dayNo){
        $query = "UPDATE emp_schedule SET $dayNo = '$value' WHERE id = $id";
        $this->db->query($query);


    }

    public function get_user_info($uname){
        $query = "SELECT * FROM users WHERE username = '$uname'";
        $query = $this->db->query($query);
        return $query->result();
    }

//    public function get_office_specific($uname){
//        $query = "SELECT office FROM users WHERE username = '$uname'";
//        $query = $this->db->query($query);
//        return $query->result();
//    }

    public function get_schedule_template($dept){
        $query = "SELECT * FROM sched_template WHERE by_dept = '$dept'";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_schedule_template_all($office){

        $query = "SELECT * FROM sched_template WHERE office = $office";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function save_template($code,$dsc,$timein,$timeout,$dept,$color,$office){
        $query = "INSERT INTO sched_template (code, dsc, start_time, end_time, by_dept, color,office) VALUES ('$code','$dsc','$timein','$timeout','$dept','$color',$office)";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;


    }

    public function delete_template($id){
        $query = "DELETE FROM sched_template WHERE id = $id";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;

    }

    public function edit_template($id){
        $query = "SELECT * FROM sched_template WHERE id = $id";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function update_template($id,$code,$dsc,$timein,$timeout,$dept,$color){
        $query = "UPDATE sched_template SET code = '$code', dsc = '$dsc', start_time = '$timein', end_time = '$timeout', by_dept = '$dept', color='$color' WHERE id = $id";
        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }
        return $msg;
    }

    public function make_admin($id){
        $query = "UPDATE users SET level = 1 WHERE id = $id";
        if($this->db->query($query)){
            $msg = "Granted Administrator Rights";

        }
        else {
            $msg = "Error granting permission";
        }

        return $msg;
    }

    public function make_super($id){
        $query = "UPDATE users SET level = 2 WHERE id = $id";
        if($this->db->query($query)){
            $msg = "Granted Supervisor Rights";

        }
        else {
            $msg = "Error granting permission";
        }

        return $msg;
    }

    public function delete_user($id){
        $query = "DELETE FROM users WHERE id = $id";
        if($this->db->query($query)){
            $msg = "User deleted.";

        }
        else {
            $msg = "Error on deleting user.";
        }

        return $msg;
    }

    public function upload_bca_csv($fileName){
        $query = <<<EOD
        LOAD DATA INFILE '$fileName' INTO TABLE bank_records
          FIELDS TERMINATED BY ',' ENCLOSED BY ''
          LINES TERMINATED BY '\r\n'
          IGNORE 1 LINES;
EOD;
        if($this->db->query($query)){
            $msg = "Uploaded successfully";
        }
        else {
            $msg = "Fail to upload";
        }

        return $msg;


    }

    public function save_file_bank($post,$filename,$username,$date,$type,$dept){
        $query = "SELECT * FROM bank_filename WHERE filename = '$post'";
        $query = $this->db->query($query);

        if(count($query->result()) <= 0){

//        var_dump($post);
        $query = "INSERT INTO bank_filename (file_bank,filename,date_uploaded,updated_by,type,dept) VALUES ('$filename','$post','$date','$username','$type','$dept')";
        $this->db->query($query);
        }
        else{
            $query = "UPDATE bank_filename file_bank='$filename',date_uploaded=NOW(),updated_by='$username',type='$type' WHERE filename='$post'";
            $this->db->query($query);

        }
    }

    public function save_file_admin($post,$filename){


        $query = "UPDATE bank_filename SET file_admin = '$filename' WHERE filename = '$post'";
        $this->db->query($query);
    }

    public function delete_file($filename){

        $query = "DELETE FROM bank_filename WHERE filename = '$filename'";
        $this->db->query($query);
        $query = "DELETE FROM bca_raw WHERE filename = '$filename'";
        $this->db->query($query);
        $query = "DELETE FROM bca_admin WHERE filename = '$filename'";
        $this->db->query($query);
    }

    public function get_filenames($fname){
        $query = "SELECT * FROM bank_filename WHERE filename = '$fname' LIMIT 1";
        $query = $this->db->query($query);
        return $query->result();

    }

//    BCA MODELS

    public function insert_name($name,$fname,$nId){
        $query = "INSERT INTO bca_raw (name,status,docno,date_created,id_level) VALUES ('$name',0,'$fname',NOW(),$nId)";
        $this->db->query($query);
    }

    public function insert_batch_name($list){
        $this->db->insert_batch('bca_raw', $list);

    }

    public function insert_batch_admin($list){
        $this->db->insert_batch('bca_admin', $list);

    }

    public function insert_bca_admin($name,$fname,$nId,$amount,$accno){
        $query = "INSERT INTO bca_admin (name,status,docno,date_created,id_level,amount,acc_no) VALUES ('$name',0,'$fname',NOW(),$nId,'$amount','$accno')";
        $this->db->query($query);
    }

    public function truncate_bca_records($fname){
        $query = "DELETE FROM bca_raw WHERE docno = '$fname'";
        $this->db->query($query);
    }

    public function truncate_bca_admin($fname){
        $query = "DELETE FROM bca_admin WHERE docno = '$fname'";
        $this->db->query($query);
    }

    public function update_amount($id,$amount,$fname){
        $query = "UPDATE bca_raw SET amount = '$amount' WHERE id_level = $id AND docno = '$fname'";
        $this->db->query($query);
    }

    public function update_charge($id,$amount,$fname){
        $query = "UPDATE bca_raw SET amount = '$amount', status = '4' WHERE id_level = $id AND docno = '$fname'";
        $this->db->query($query);
    }

    public function update_status_bca($nMatchId){

        $query = "UPDATE bca_raw SET status = '1' WHERE id = $nMatchId";
        $this->db->query($query);
    }

    public function get_bca($fname){
        $query = "SELECT * FROM bca_raw WHERE docno = '$fname' ORDER by status, name ASC";
        $query = $this->db->query($query);

        return $query->result();

    }

    public function get_bca_admin($fname){
        $query = "SELECT * FROM bca_admin WHERE docno = '$fname' ORDER by status, name ASC";
        $query = $this->db->query($query);

        return $query->result();

    }

    public function get_bca_admin_id_match($fname){
    $query = <<<EOD
        SELECT
        *
        FROM
        bca_admin AS A
        WHERE
        a.docno = '$fname'


EOD;
    $query = $this->db->query($query);
    $query = $query->result();


    foreach($query as $row){
        $this->get_bca_admin_update_match($row->name,$row->amount,$fname,$row->id);

    }



}

    public function get_bca_admin_update_match($name,$amount,$fname, $id){
        $query = "SELECT id FROM bca_raw WHERE name = '$name' AND amount = '$amount' AND docno = '$fname' AND admin_match IS NULL LIMIT 1";

        $query = $this->db->query($query);

        $query = $query->result();

        if($query){
            $id = intval($query[0]->id);
            $query = "UPDATE bca_raw SET status = 1, admin_match = '1' WHERE id=$id";
            if($this->db->query($query)) {
                $isFound = $this->get_bca_bank_id_match($name,$amount,$fname);

                if($isFound > 0){
//                    $this->match_bca_bank_raw($id);
                    $this->bca_update_admin_match_raw($name,$amount,$fname);
                }
            }
        }


    }

    public function get_bca_bank_id_match($name,$amount,$fname){
        $query = <<<EOD
        SELECT
        *
        FROM
        bca_raw AS A
        WHERE
        A.name = '$name'
        AND a.amount = '$amount'
        AND a.docno = '$fname'
        AND a.status = '1'
        AND a.admin_match IS NOT NULL
        LIMIT 1


EOD;
        $query = $this->db->query($query);

        return $query->num_rows();


    }


    public function bca_update_admin_match_raw($name,$amount,$fname){
        $query = "SELECT id FROM bca_admin WHERE name = '$name' AND amount = '$amount' AND docno = '$fname' AND (match_raw IS NULL or match_raw = '') LIMIT 1";

        $query = $this->db->query($query);
        $query = $query->result();
        if($query){
            $id = intval($query[0]->id);
            $query = "UPDATE bca_admin SET match_raw = '1', status='1' WHERE id = $id and status =  '0'";
            $this->db->query($query);
        }
    }

//    BCA REPORT

    public function get_bca_report($username, $fname, $type){
//        var_dump($type);
        if($type == "Deposit"){
            $query = "SELECT SUM(amount) AS amount, count(amount) as no FROM bca_admin WHERE (status = '1' or status = '2' or status = '5' or status = '7') AND docno = '$fname' GROUP BY docno";
        }else {
            $query = "SELECT SUM(amount) AS amount, count(amount) as no FROM bca_admin WHERE (status = '1' or status = '2' or status = '5' or status = '8') AND docno = '$fname' GROUP BY docno";
        }
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bca_report_unmatch($username, $fname, $type){
        $query = "SELECT SUM(amount) AS amount, count(amount) as no FROM bca_admin WHERE status = '0' AND docno = '$fname' GROUP BY docno";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bca_report_bank($username, $fname, $type){
        if($type == "Deposit") {
            $query = "SELECT SUM(amount) AS amount, count(amount) as no FROM bca_raw WHERE (status = '1' or status = '2' or status = '5' or status = '7') AND docno = '$fname' GROUP BY docno";
        }
        else {
            $query = "SELECT SUM(amount) AS amount, count(amount) as no FROM bca_raw WHERE (status = '1' or status = '2' or status = '5' or status = '8') AND docno = '$fname' GROUP BY docno";
        }
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bca_report_unmatch_bank($username, $fname, $type){
        $query = "SELECT SUM(amount) AS amount, count(amount) as no FROM bca_raw WHERE status = '0' AND docno = '$fname' GROUP BY docno";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bca_total_bank($username, $fname, $type){
        if($type == "Deposit") {
            $query = "SELECT sum(amount) as amount, count(id) as no FROM bca_raw WHERE (status = '0' or status = '1' or status = '2' or status = '5' or status = '7') AND docno = '$fname' GROUP BY docno";
        }
        else{
            $query = "SELECT sum(amount) as amount, count(id) as no FROM bca_raw WHERE (status = '0' or status = '1' or status = '2' or status = '5' or status = '8') AND docno = '$fname' GROUP BY docno";
        }
            $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bca_total_admin($username, $fname, $type){
        if($type == "Deposit") {
            $query = "SELECT sum(amount) as amount, count(id) as no FROM bca_admin WHERE (status = '0' or status = '1' or status = '2' or status = '5' or status = '7') AND docno = '$fname' GROUP BY docno";
        }else {
            $query = "SELECT sum(amount) as amount, count(id) as no FROM bca_admin WHERE (status = '0' or status = '1' or status = '2' or status = '5' or status = '8') AND docno = '$fname' GROUP BY docno";
        }
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bca_total_wd_transfer($username, $fname, $type){
        $query = "SELECT sum(amount) as amount, count(id) as no FROM bca_raw WHERE status = '3' AND dsc = 'PB KE REK WD' AND docno = '$fname' GROUP BY docno";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bca_total_tp_transfer($username, $fname, $type){
        $query = "SELECT sum(amount) as amount, count(id) as no FROM bca_raw WHERE status = '3' AND dsc = 'PB KE REK TP' AND docno = '$fname' GROUP BY docno";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bca_total_past_bank($username, $fname, $type){
        $query = "SELECT sum(amount) as amount, count(id) as no FROM bca_raw WHERE status = '5' AND docno = '$fname' GROUP BY docno";
        $query = $this->db->query($query);

        return $query->result();
    }
    public function get_bca_total_past_admin($username, $fname, $type){
        $query = "SELECT sum(amount) as amount, count(id) as no FROM bca_admin WHERE status = '5' AND docno = '$fname' GROUP BY docno";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function match_bca_bank_raw($id){

        $query = "UPDATE bca_admin SET status=1 WHERE id = $id AND status = '0'";
        $this->db->query($query);
    }

    public function match_bca_bank($id,$dsc, $fname, $accName, $status){

        $query = "UPDATE bca_raw SET dsc = '$dsc', status=$status, name='$accName' WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Updated successfully";
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }


    public function match_bca_admin($id, $dsc, $fname, $accName, $status){

        $query = "UPDATE bca_admin SET dsc = '$dsc', status='$status', name='$accName' WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Updated successfully";
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

    public function rename_bca($id,$accName){

        $query = "UPDATE bca_raw SET name = '$accName', status = '0' WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Updated successfully";
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

    public function update_bca_status_match($bankID,$adminID,$dscBank,$dscAdmin){
        $query = "UPDATE bca_raw SET status=2, dsc='$dscBank' WHERE id = $bankID";

        if($this->db->query($query)){
            $query = "UPDATE bca_admin SET status=2, dsc='$dscAdmin' WHERE id = $adminID";
            if($this->db->query($query)) {
                $msg = "Updated successfully";

            }
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

    public function update_bca_status_unmatch($bankID,$adminID){
    $query = "UPDATE bca_raw SET status=0, dsc = '' WHERE id = $bankID";

    if($this->db->query($query)){
        $query = "UPDATE bca_admin SET status=0, dsc = '' WHERE id = $adminID";
        if($this->db->query($query)) {
            $msg = "Updated successfully";

        }
    }
    else
    {
        $msg = "Update error";
    }
    return $msg;
}

    public function update_bca_status_wid($bankID,$dsc){
        $query = "UPDATE bca_raw SET status='3', dsc = '$dsc' WHERE id = $bankID";

        if($this->db->query($query)){

                $msg = "Updated successfully";

        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

    public function update_bca_status_save($fname){
        $query = "UPDATE bank_filename SET save=1 WHERE filename = '$fname'";

        if($this->db->query($query)){

                $msg = "Save successfully.";

        }
        else
        {
            $msg = "Saving error.";
        }
        return $msg;
    }

    public function get_save_bca($bank,$date,$username,$type,$dept){
        $query = "DELETE FROM bank_filename WHERE file_admin IS NULL";

        $this->db->query($query);
        if($username == 'mnicdao01' || $username == 'ida'){
            $query = <<<EOD
            SELECT
                * FROM bank_filename
                WHERE filename LIKE '%$bank%' and date_uploaded = '$date' AND type = '$type' AND dept = '$dept' ORDER BY filename DESC

EOD;
        }else {
            $query = <<<EOD
            SELECT
                * FROM bank_filename
                WHERE filename LIKE '%$bank%' and date_uploaded = '$date' and updated_by = '$username' AND type = '$type' AND dept = '$dept' ORDER BY filename DESC

EOD;
        }


        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_past_unmatch_bca($username, $fname, $type, $dept){
        $fname = substr($fname,0,3);
        $query = <<<EOD

        SELECT
a.id, a.name, a.dsc, b.date_uploaded, a.docno, a.amount,
a.id_level
FROM
bca_raw AS A
LEFT JOIN
bank_filename AS B
ON
A.docno = b.filename
WHERE
a.status = '0'
AND b.updated_by = '$username'
AND a.docno LIKE '%$fname%'
AND b.type LIKE '$type'
AND b.filename = a.docno
AND b.date_uploaded <> DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))
AND b.date_uploaded <> DATE(NOW())
AND b.dept = '$dept'
GROUP BY a.id
order by date_uploaded DESC

EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_past_unmatch_bca_admin($username,$fname, $type, $dept){
        $fname = substr($fname,0,3);
        $query = <<<EOD

        SELECT
a.id, a.name, a.dsc, b.date_uploaded, a.docno, a.amount,
a.id_level
FROM
bca_admin AS A
LEFT JOIN
bank_filename AS B
ON
A.docno = b.filename
WHERE
a.status = '0'
AND b.updated_by = '$username'
AND a.docno LIKE '%$fname%'
AND b.type = '$type'
AND b.filename = a.docno
AND b.date_uploaded <> DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))
AND b.date_uploaded <> DATE(NOW())
AND b.dept = '$dept'
GROUP BY a.id
order by date_uploaded DESC

EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

    public function delete_all_save_bca($docno,$username){
        if($username=='mnicdao01'){
            $query = "DELETE FROM bank_filename WHERE filename = '$docno'";
        }else{
        $query = "DELETE FROM bank_filename WHERE filename = '$docno' and updated_by = '$username'";
        }
        if($this->db->query($query)){
            $query = "DELETE FROM bca_raw WHERE docno = '$docno'";
            $this->db->query($query);
            $query = "DELETE FROM bca_admin WHERE docno = '$docno'";
            $this->db->query($query);
        };

    }

    public function update_bca_status_match_with_past_banktopastadmin($bankID,$PastAdminID,$PastAdminDate){
        $dscBank = "Match with BID-".$bankID." to AID-".$PastAdminID." Date: ".$PastAdminDate;
        $dscAdmin = "Match with AID-".$PastAdminID." to BID-".$bankID;
        $query = "UPDATE bca_raw SET status=5, dsc = '$dscBank' WHERE id = $bankID";

        if($this->db->query($query)){
            $query = "UPDATE bca_admin SET status=5, dsc='$dscAdmin' WHERE id = $PastAdminID";
            if($this->db->query($query)) {
                $msg = "Updated successfully";

            }
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

    public function update_bca_status_match_with_past_admintopastbank($adminID,$PastBankID,$pastBankDate){
        $dscBank = "Match with BID-".$PastBankID." to AID-".$adminID;
        $dscAdmin = "Match with AID-".$adminID." to BID-".$PastBankID." Date: ".$pastBankDate;
        $query = "UPDATE bca_raw SET status=5,dsc = '$dscBank' WHERE id = $PastBankID";

        if($this->db->query($query)){
            $query = "UPDATE bca_admin SET status=5, dsc = '$dscAdmin' WHERE id = $adminID";
            if($this->db->query($query)) {
                $msg = "Updated successfully";

            }
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

//    Special Process for CIMB

    public function get_bca_admin_id_match_cimb($fname){
        $query = <<<EOD
        SELECT
        *
        FROM
        bca_admin AS A
        WHERE
        a.docno = '$fname'
EOD;
        $query = $this->db->query($query);
        $query = $query->result();

        foreach($query as $row){
            $this->get_bca_admin_update_match_cimb($row->acc_no,$row->amount,$fname,$row->id);

        }


    }

    public function get_bca_admin_update_match_cimb($accno,$amount,$fname, $id){
        $query = "UPDATE bca_raw SET status = 1 WHERE name = '$accno' AND amount = '$amount' and docno = '$fname' and status='0'";
        if($this->db->query($query)){
            $isFound = $this->get_bca_bank_id_match_cimb($accno,$amount,$fname);

            if($isFound > 0){
                $this->match_bca_bank_raw_cimb($id);
                $this->bca_update_admin_match_raw_cimb($accno,$amount,$fname);
            }
        };
    }

    public function get_bca_bank_id_match_cimb($accno,$amount,$fname){
        $query = <<<EOD
        SELECT
        *
        FROM
        bca_raw AS A
        WHERE
        A.name LIKE '%$accno%'
        AND a.amount = '$amount'
        AND a.docno = '$fname'
        AND a.status = '1'
        AND a.admin_match IS NULL
        LIMIT 1


EOD;
        $query = $this->db->query($query);

        return $query->num_rows();


    }

    public function bca_update_admin_match_raw_cimb($accno,$amount,$fname){
        $query = "SELECT id FROM bca_raw WHERE name LIKE '%$accno%' AND amount = '$amount' AND docno = '$fname' AND admin_match IS NULL LIMIT 1";

        $query = $this->db->query($query);
        $query = $query->result();
        if($query){
            $id = intval($query[0]->id);
            $query = "UPDATE bca_raw SET admin_match = '1' WHERE id = $id";
            $this->db->query($query);
        }
    }

    public function match_bca_bank_raw_cimb($id){

        $query = "UPDATE bca_admin SET status=1 WHERE id = $id AND status = '0'";

        $this->db->query($query);
    }
    // MANDIRI MODELS

    public function insert_name_mandiri($name,$fname,$nId){
        $query = "INSERT INTO mandiri_raw (name,status,date_created,docno,id_level) VALUES ('$name',0,NOW(),'$fname',$nId)";
        $this->db->query($query);
    }

    public function insert_mandiri_admin($name,$fname,$nId,$amount){
        $query = "INSERT INTO mandiri_admin (name,status,docno,date_created,id_level,amount) VALUES ('$name',0,'$fname',NOW(),$nId,'$amount')";
        $this->db->query($query);
    }

    public function truncate_mandiri_records($fname){
        $query = "DELETE FROM mandiri_raw where docno = '$fname'";
        $this->db->query($query);
    }

    public function truncate_mandiri_admin($fname){
        $query = "DELETE FROM mandiri_admin WHERE docno = '$fname'";
        $this->db->query($query);
    }

    public function get_mandiri_admin_id_match($fname){
        $query = <<<EOD
        SELECT
        a.id
        FROM mandiri_admin AS A
        LEFT JOIN
        mandiri_raw AS B
        ON
        A.name = B.name
        AND A.amount = B.amount

        WHERE A.docno = '$fname'
        AND B.docno = '$fname'
        GROUP BY b.id
        ORDER BY a.name

EOD;
        $query = $this->db->query($query);

        return $query->result();


    }

    public function get_mandiri_admin_update_match($matchID){
        $query = "UPDATE mandiri_admin SET status = 1 WHERE id = $matchID";

        if($this->db->query($query)){
            $msg = "Updated successfully";
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

    public function update_amount_mandiri($id,$amount){
        $query = "UPDATE mandiri_raw SET amount = '$amount' WHERE id_level = $id";
        $this->db->query($query);
    }

    public function update_status_mandiri($nId,$nDetails,$nDeposit){
        $nDetails = trim($nDetails);
        $nDeposit = trim($nDeposit);

//        echo $nDetails;
        $query = "UPDATE mandiri_raw SET status = $nId WHERE name LIKE '%$nDetails%' AND amount LIKE '%$nDeposit%' and status = 0";
        $this->db->query($query);

//        return $nDetails.">".$sFound."<br/>";
    }

    public function get_mandiri($fname){
//        $query = "UPDATE bca_raw SET status = '0'";
//        $query = $this->db->query($query);
        $query = "SELECT * FROM mandiri_raw WHERE docno='$fname' ORDER BY status, name ASC";
        $query = $this->db->query($query);

        return $query->result();

    }

    public function get_mandiri_admin($fname){
        $query = "SELECT * FROM mandiri_admin WHERE docno = '$fname' ORDER by status, name ASC";
        $query = $this->db->query($query);

        return $query->result();

    }

    public function update_mandiri_status_match($bankID,$adminID){
        var_dump($bankID);
        $query = "UPDATE mandiri_raw SET status='2' WHERE id = $bankID";

        if($this->db->query($query)){
            $query = "UPDATE mandiri_admin SET status='2' WHERE id = $adminID";
            if($this->db->query($query)) {
                $msg = "Updated successfully";

            }
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

    public function get_save_mandiri($bank,$date,$username){
        $query = <<<EOD
        SELECT
            * FROM bank_filename
            WHERE filename LIKE '%$bank%' and date_uploaded = '$date' AND save = '1' and updated_by = '$username' ORDER BY filename DESC

EOD;
        $query = $this->db->query($query);

        return $query->result();
    }

    public function match_mandiri_bank($id, $dsc, $fname){

        $query = "UPDATE mandiri_raw SET dsc = '$dsc', status=2 WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Updated successfully";
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }

    public function match_mandiri($id, $dsc, $fname){

        $query = "UPDATE mandiri_raw SET dsc = '$dsc', status=1 WHERE id = $id";

        if($this->db->query($query)){
            $query = "SELECT * FROM mandiri_raw WHERE docno = '$fname'";
            $query = $this->db->query($query);
        }
        else
        {
            $msg = "Update error";
        }
        return $query->result();
    }

    public function update_mandiri_status_save($fname){
        $query = "UPDATE bank_filename SET save=1 WHERE filename = '$fname'";

        if($this->db->query($query)){

            $msg = "Save successfully.";

        }
        else
        {
            $msg = "Saving error.";
        }
        return $msg;
    }

    public function match_mandiri_admin($id, $dsc, $fname){

        $query = "UPDATE mandiri_admin SET dsc = '$dsc', status=2 WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Updated successfully";
        }
        else
        {
            $msg = "Update error";
        }
        return $msg;
    }


//    BNI MODELS

    public function insert_name_bni($name,$fname,$nId){
        $query = "INSERT INTO bni_raw (name,status,docno,date_created,id_level) VALUES ('$name',0,'$fname',NOW(),$nId)";
        $this->db->query($query);
    }

    public function truncate_bni_records($nId){
        $query = "DELETE FROM bni_raw WHERE docno = '$nId'";
        $this->db->query($query);
    }

    public function update_amount_bni($id,$amount){
        $query = "UPDATE bni_raw SET amount = '$amount' WHERE id_level = $id";
        $this->db->query($query);
    }

    public function update_status_bni($nStatus,$nDetails,$nDeposit){
        $nDetails = trim($nDetails);
        $nDeposit = trim($nDeposit);

//        echo $nDetails;
        $query = "UPDATE bni_raw SET status = $nStatus WHERE name LIKE '%$nDetails%' AND amount LIKE '%$nDeposit%' and status = 0";
        $this->db->query($query);

//        return $nDetails.">".$sFound."<br/>";
    }

    public function get_bni($fname){
//        $query = "UPDATE bca_raw SET status = '0'";
//        $query = $this->db->query($query);
        $query = "SELECT * FROM bni_raw WHERE docno = '$fname'";
        $query = $this->db->query($query);

        return $query->result();

    }

    public function match_bni($id, $dsc, $fname){

        $query = "UPDATE bni_raw SET dsc = '$dsc', status=1 WHERE id = $id";

        if($this->db->query($query)){
            $query = "SELECT * FROM bni_raw WHERE docno = '$fname'";
            $query = $this->db->query($query);
        }
        else
        {
            $msg = "Update error";
        }
        return $query->result();
    }


//    BRI MODELS

    public function insert_name_bri($name,$fname,$nId){
        $query = "INSERT INTO bri_raw (name,status,date_created,docno,id_level) VALUES ('$name',0,NOW(),'$fname',$nId)";
        $this->db->query($query);
    }

    public function truncate_bri_records($fname){
        $query = "DELETE FROM bri_raw WHERE docno='$fname'";
        $this->db->query($query);
    }

    public function update_amount_bri($id,$amount){
        $query = "UPDATE bri_raw SET amount = '$amount' WHERE id_level = $id";
        $this->db->query($query);
    }

    public function update_status_bri($nId,$nDetails,$nDeposit){
        $nDetails = trim($nDetails);
        $nDeposit = trim($nDeposit);

//        echo $nDetails;
        $query = "UPDATE bri_raw SET status = $nId WHERE name LIKE '%$nDetails%' AND amount LIKE '%$nDeposit%' and status = 0";
        $this->db->query($query);

//        return $nDetails.">".$sFound."<br/>";
    }

    public function get_bri($fname){
//        $query = "UPDATE bca_raw SET status = '0'";
//        $query = $this->db->query($query);
        $query = "SELECT * FROM bri_raw WHERE docno='$fname'";
        $query = $this->db->query($query);

        return $query->result();

    }

    public function match_bri($id, $dsc, $fname){

        $query = "UPDATE bri_raw SET dsc = '$dsc', status=1 WHERE id = $id";

        if($this->db->query($query)){
            $query = "SELECT * FROM bri_raw WHERE docno = '$fname'";
            $query = $this->db->query($query);
        }
        else
        {
            $msg = "Update error";
        }
        return $query->result();
    }




//    PERMATA MODELS

    public function insert_name_permata($name,$fname,$nid){
        $query = "INSERT INTO permata_raw (name,status,docno,date_created,id_level) VALUES ('$name',0,'$fname',NOW(),$nid)";
        $this->db->query($query);
    }

    public function truncate_permata_records($fname){
        $query = "DELETE FROM permata_raw WHERE docno = '$fname'";
        $this->db->query($query);
    }

    public function update_amount_permata($id,$amount){
        $query = "UPDATE permata_raw SET amount = '$amount' WHERE id = $id";
        $this->db->query($query);
    }

    public function update_status_permata($nId,$nDetails,$nDeposit){
        $nDetails = trim($nDetails);
        $nDeposit = trim($nDeposit);

//        echo $nDetails;
        $query = "UPDATE permata_raw SET status = $nId WHERE name LIKE '%$nDetails%' AND amount LIKE '%$nDeposit%' and status = 0";
        $this->db->query($query);

//        return $nDetails.">".$sFound."<br/>";
    }

    public function get_permata($fname){
//        $query = "UPDATE bca_raw SET status = '0'";
//        $query = $this->db->query($query);
        $query = "SELECT * FROM permata_raw WHERE docno= '$fname'";
        $query = $this->db->query($query);

        return $query->result();

    }

    public function match_permata($id, $dsc, $fname){

        $query = "UPDATE permata_raw SET dsc = '$dsc', status=1 WHERE id = $id";

        if($this->db->query($query)){
            $query = "SELECT * FROM bri_raw WHERE docno = '$fname'";
            $query = $this->db->query($query);
        }
        else
        {
            $msg = "Update error";
        }
        return $query->result();
    }

    public function insert_bank_info($bankname, $dsc, $cno){
        $query = "INSERT INTO bank (bank_name, dsc, contact_no, date_updated) VALUES ('$bankname', '$dsc', '$cno', NOW())";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;

    }

    public function get_bank_info(){
        $query = $this->db->get('bank');
        return $query->result();

    }

    public function delete_bank_info($id){
        $query = "DELETE FROM bank WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Deleted!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;

    }

    public function delete_file_info($id,$code,$dsc,$cno){
        $query = "UPDATE bank SET bank_name = '$code', dsc = '$dsc', contact_no='$cno' WHERE id = $id";
        if($this->db->query($query)){
            $msg = true;
        }
        else{
            $msg = false;
        }

        return $msg;


    }

// Accounts Models


    public function get_accounts(){
        $query = "SELECT * FROM accounts";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function insert_accounts_info($accname,$accno,$cno,$bank,$dept,$username){
        $query = "INSERT INTO accounts (name, acc_no, contact_no, bank, dept, date_updated, updated_by, status) VALUES ('$accname', '$accno', '$cno','$bank','$dept', NOW(),'$username','1')";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;

    }

    public function delete_account_info($id){
        $query = "UPDATE accounts SET status = '0' WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Changed to inactive account!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;

    }

//    Withdrawal Models

    public function get_accounts_wd($bank,$dept){
        $query = <<<EOD
        SELECT
        A.id, A.name, A.acc_no, A.bank, A.dept, SUM(B.amount) AS total_year
        FROM
        accounts AS A
        LEFT JOIN
        wd_info AS B
        ON A.acc_no = B.accno
        WHERE
        dept = '$dept'
        and bank = '$bank'
        and A.status = 1
        GROUP BY A.acc_no
EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

    public function insert_wd_info($accname,$accno,$amount,$date,$username){
        $query = "INSERT INTO wd_info (accno, amount, date, date_updated, updated_by, status) VALUES('$accno','$amount','$date',NOW(),'$username','1')";
        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function get_wd_daily($accno,$date){

        $query = "SELECT * FROM wd_info WHERE accno = '$accno' and date = '$date'";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_wd_daily_all($bank,$dept,$date){

        $query = <<<EOD
        SELECT  A.name, A.acc_no, B.amount, B.amount * 1000000 as x_real
        FROM
        accounts AS A
        LEFT JOIN
        wd_info AS B
        ON A.acc_no = B.accno
        WHERE
        bank = '$bank'
        and dept='$dept'
        and date= '$date'
        and A.status = 1
EOD;

        $query = $this->db->query($query);

        return $query->result();
    }


    public function update_wd_daily($accno,$amount,$id,$username){

        $query = "UPDATE wd_info SET amount = $amount, date_updated = NOW(), updated_by = '$username' WHERE id=$id";
        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function get_wd_month($accno,$date){

        $query = "SELECT * FROM wd_info WHERE accno = '$accno' and MONTH(date) = MONTH('$date') and YEAR(date) = YEAR('$date')";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_wd_month_all($bank,$dept,$date){

        $query = <<<EOD
        SELECT  B.id, A.name, A.acc_no, B.amount, B.amount * 1000000 as x_real, date, monthname('$date') as month, B.status
        FROM
        accounts AS A
        LEFT JOIN
        wd_info AS B
        ON A.acc_no = B.accno
        WHERE
        bank = '$bank'
        and dept='$dept'
        and MONTH(date)= MONTH('$date')
        and YEAR(date)= YEAR('$date')
        and A.status = 1
        ;
EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_year($date,$bank,$dept){
        $query = <<<EOD
SELECT month_name, sum(amount) as amount_month FROM
( SELECT id, accno, amount, date, date_updated, updated_by, MONTHNAME(date) as month_name FROM wd_info
WHERE YEAR(date) = YEAR('$date')) AS A GROUP BY month_name
EOD;
        $query = $this->db->query($query);
        return $query->result();

    }


    public function get_my_attendance($empid,$date,$date2){
        $query = <<<EOD
SELECT id,timein, timeout, TIMEDIFF(timeout,timein) as no_hours,
IF(TIMEDIFF(timeout,timein) >= '15:00:00','User logged out in next shift.','') as remarks
FROM time_in WHERE empid = '$empid' and timein BETWEEN '$date' and '$date2' ORDER BY timein ASC

EOD;
        $query = $this->db->query($query);
//        $query['result'] = $query->result();


        return $query->result();
    }

    public function get_emp_schedule_individual($empid,$date){
        $query = "SELECT * FROM emp_schedule WHERE username='$empid' and MONTHNAME(month) = MONTHNAME('$date') AND YEAR(month) = YEAR('$date')";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_emp_schedule_individual_next($empid,$date){
        $query = "SELECT * FROM emp_schedule WHERE username='$empid' and MONTHNAME(month) = MONTHNAME(DATE_ADD('$date',INTERVAL 1 MONTH))";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_emp_schedule_individual_prev($empid){
        $query = "SELECT * FROM emp_schedule WHERE username='$empid' and MONTHNAME(month) = MONTHNAME(DATE_SUB(NOW(),INTERVAL 1 MONTH))";
        $query = $this->db->query($query);
        return $query->result();
    }

//    Approver

    public function approved_wd($id,$empid){
        $query = "UPDATE wd_info SET status = 'Approved' WHERE id = $id";
        if($this->db->query($query)){
            $msg = true;
        }else{
            $msg = false;
        }
        return $msg;
    }

    public function get_pools_info(){
        $query = "SELECT * FROM pools";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function insert_pool_info($empid, $poolcode,$dsc){
        $query = "INSERT INTO pools (code, dsc, updated_by, date_updated) VALUES ('$poolcode', '$dsc','$empid',NOW())";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;

    }

    public function update_pool_info($id,$code,$dsc,$empid){
        $query = "UPDATE pools SET code = '$code', dsc = '$dsc', updated_by='$empid', date_updated = NOW() WHERE id = $id";
        if($this->db->query($query)){
            $msg = true;
        }
        else{
            $msg = false;
        }

        return $msg;


    }

    public function delete_pool_info($id){
        $query = "DELETE FROM pools WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Deleted!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;

    }

    public function get_market_info(){
        $query = "SELECT id, dept, pool, date, gross, dc, kei, gift, referral, (gross-dc)+kei as omset, ((gross-dc)+kei)-gift-referral as total FROM globalmarket ORDER BY date ASC";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function insert_market($empid, $dept,$pool,$date,$gross,$dc,$kei,$gift,$referral){
        $query = "INSERT INTO globalmarket (dept, pool, date, gross, dc, kei, gift, referral, updated_by, date_updated) VALUES ('$dept', '$pool','$date','$gross','$dc','$kei','$gift','$referral','$empid',NOW())";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function get_market_dept($dept){
        $query = "SELECT id, dept, pool, date, gross, dc, kei, gift, referral, gross-dc-kei as omset, (gross-dc-kei)-gift-referral as total FROM globalmarket WHERE dept = '$dept' ORDER BY date ASC";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_market_dept_pool($dept,$pool){
        $query = "SELECT id, dept, pool, date, gross, dc, kei, gift, referral, gross-dc-kei as omset, (gross-dc-kei)-gift-referral as total FROM globalmarket WHERE dept = '$dept' and pool = '$pool' ORDER BY date ASC";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_market_dept_pool_date($dept,$pool,$date){
        $query = "SELECT id, dept, pool, date, gross, dc, kei, gift, referral, gross-dc-kei as omset, (gross-dc-kei)-gift-referral as total FROM globalmarket WHERE dept = '$dept' and pool = '$pool' and MONTH(date) = MONTH('$date') AND YEAR(date) = YEAR('$date') ORDER BY date ASC";
        $query = $this->db->query($query);
        return $query->result();
    }

    public function update_market($id, $empid, $dept,$pool,$date,$gross,$dc,$kei,$gift,$referral){
        $query = "UPDATE globalmarket SET date='$date', gross='$gross', dc='$dc', kei='$kei', gift='$gift', referral='$referral', updated_by='$empid', date_updated=NOW() WHERE id = $id";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function delete_market_info($id){
        $query = "DELETE FROM globalmarket WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Deleted!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;
    }

    public function get_total_market($dept,$pool,$date){
        $query = <<<EOD
           SELECT id, dept, pool, date, gross, dc, kei, gift, referral, omset, omset-gift-referral as total FROM (
            SELECT id, dept, pool, date, gross, dc, kei, gift, referral,
            gross-dc-kei as omset
            FROM (
            SELECT id, dept, pool, date, sum(gross) as gross, sum(dc) as dc, sum(kei) as kei, sum(gift) as gift, sum(referral) as referral
            FROM `globalmarket` WHERE dept='$dept' and pool='$pool' and MONTH(date) = MONTH('$date') and YEAR(date) = YEAR('$date') GROUP BY MONTH('$date')) AS A)AS FINAL
EOD;
        $query = $this->db->query($query);

        return $query->result();

    }

//    DEPOSIT AND WITHDRAW

    public function get_depowid($dept, $date){

        $query = "SELECT id,date,deposit,withdraw,dept,deposit-withdraw as total FROM depowid WHERE dept = '$dept' and MONTH(date) = MONTH('$date') and YEAR(date) = YEAR('$date')";

        $query = $this->db->query($query);
        return $query->result();

    }

    public function get_depowid_total($dept, $date){

        $query = <<<EOD
            SELECT id,date,sum(deposit) as deposit,sum(withdraw) as withdraw,dept,sum(deposit)-sum(withdraw) as total
            FROM depowid
            WHERE dept = '$dept' and MONTH(date) = MONTH('$date') and YEAR(date) = YEAR('$date')
            GROUP BY YEAR(date), MONTH(date)
EOD;


        $query = $this->db->query($query);
        return $query->result();
    }

    public function insert_depowid($empid,$dept,$date,$wid,$depo){

        $query = "INSERT INTO depowid (date, deposit, withdraw, dept, updated_by, date_updated) VALUES ('$date', '$depo','$wid','$dept','$empid',NOW())";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function update_depowid($id,$empid, $date,$depo,$wid){
        $query = "UPDATE depowid SET date='$date', deposit='$depo', withdraw='$wid', updated_by='$empid', date_updated=NOW() WHERE id = $id";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function delete_depowid($id){
        $query = "DELETE FROM depowid WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Deleted!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;
    }

//    EXPENSES

    public function get_expenses(){

        $query = "SELECT id, date, amount, dept, account_from, account_to, remarks, date_updated, updated_by FROM expenses";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function delete_expenses($id){
        $query = "DELETE FROM expenses WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Deleted!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;

    }

    public function insert_expenses($date,$amount,$from,$to,$department,$remarks,$username){

        $query = "INSERT INTO expenses (date, amount, account_from, account_to, dept, remarks, date_updated, updated_by) VALUES ('$date', '$amount', '$from','$to','$department','$remarks', NOW(),'$username')";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;

    }

    public function update_expenses($id,$date,$amount,$from,$to,$remarks,$username){
        $query = "UPDATE expenses SET date = '$date', amount = '$amount', account_from='$from', account_to = '$to', remarks = '$remarks', updated_by = '$username' WHERE id = $id";
        if($this->db->query($query)){
            $msg = true;
        }
        else{
            $msg = false;
        }

        return $msg;


    }

//    Announcements
    public function get_all_announcements(){
        $query = "SELECT id, title, dsc, date, updated_by, (SELECT dept from emp_info where empid = updated_by) as dept FROM announcements";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function insert_announcements($empid, $title,$dsc){
        $query = "INSERT INTO announcements (title, dsc, date, updated_by) VALUES ('$title', '$dsc', NOW(), '$empid')";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function update_announcements($id, $empid, $title,$dsc){
        $query = "UPDATE announcements SET title='$title', dsc='$dsc', date = NOW(), updated_by='$empid' WHERE id = $id";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function delete_announcement($id){
        $query = "DELETE FROM announcements WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Deleted!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;
    }

    public function get_announcements(){
        $query = "SELECT id, title, dsc, date, updated_by, (SELECT dept from emp_info where empid = updated_by) as dept FROM announcements ORDER BY date DESC LIMIT 5";
        $query = $this->db->query($query);

        return $query->result();
    }

//    Department

    public function get_all_departments(){
        $query = "SELECT * from department";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function insert_department($dname){
        $query = "INSERT INTO department (dsc, office) VALUES ('$dname', '1')";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function delete_dept($id){
        $query = "DELETE FROM department WHERE id = $id";

        if($this->db->query($query)){
            $msg = "Deleted!";
        }
        else {
            $msg = "Failed";
        }

        return $msg;
    }


    public function get_profile($empid){
        $query = "SELECT * FROM emp_info WHERE empid = '$empid' LIMIT 1";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_bank_lock_date($empid){
        $query = <<<EOD
        SELECT lock_date, DATE_ADD(lock_date, INTERVAL 3 MONTH) as until, date(now()) as today,
            CASE
                WHEN date(now()) < DATE_ADD(lock_date, INTERVAL 3 MONTH) THEN "1"
                WHEN date(now()) > DATE_ADD(lock_date, INTERVAL 3 MONTH) THEN "0"
                WHEN lock_date is NULL THEN "0"
            END AS lock_value
        FROM emp_info WHERE empid = '$empid' LIMIT 1
EOD;


        $query = $this->db->query($query);

        return $query->result();
    }

    public function lock_bank($empid){
        $query = "UPDATE emp_info SET lock_date=DATE(NOW()) WHERE empid = '$empid'";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function update_profile($params, $empid){
        $this->db->where('empid', $empid);
        if($this->db->update('emp_info', $params)){
            $msg = true;
        }
        else{
            $msg = false;
        }
        return $msg;


    }

    public function get_attendance_dept_month($dept, $month){
        $query = <<<EOD
        SELECT A.id, A.empid, A.timein, A.timeout, TIMEDIFF(A.timeout, A.timein) as SubTotal, B.dept, B.id as emporder, b.fname, b.lname, a.empid as username FROM
time_in AS A
LEFT JOIN
emp_info as B
ON a.empid = b.empid
WHERE B.dept = '$dept'
AND YEAR(timein) = YEAR('$month')
AND MONTH(timein) = MONTH('$month')
ORDER BY b.id, a.timein
EOD;
        $query = $this->db->query($query);
        return $query->result();
    }

    public function insert_it($empid, $title,$dsc,$status){


        $query = "INSERT INTO it_report (title, dsc, date_updated, updated_by, status) VALUES ('$title', '$dsc', NOW(), '$empid', '$status')";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function get_it_report($empid){
        $query = <<<EOD
        SELECT
         A.id, A.title, A.dsc, A.status, A.updated_by, A.last_touch, A.date_updated, B.read_status
         FROM it_report AS A
LEFT JOIN
it_monitor_read_status AS B
ON
A.id = B.it_report_id
AND
B.empid = '$empid'
order by B.read_status, FIELD(A.status, 'For Checking', 'For Continuation', 'Fixed'), A.id DESC

EOD;
        $query = $this->db->query($query);

        return $query->result();
    }



    public function read_it_log($logid, $empid){
        $query = "DELETE FROM it_monitor_read_status WHERE it_report_id = '$logid' and empid = '$empid'";
        $this->db->query($query);
        $query = <<<EOD

       INSERT INTO it_monitor_read_status (it_report_id, read_status, empid, read_ts) VALUES('$logid',"Read",'$empid', NOW());
EOD;
        $this->db->query($query);

    }


    public function update_it($id, $empid, $title,$dsc, $status){

        $query = <<<EOD

       DELETE FROM it_monitor_read_status WHERE it_report_id = '$id';
EOD;
        $this->db->query($query);

        $query = <<<EOD

       INSERT INTO it_monitor_read_status (it_report_id, read_status, empid, read_ts) VALUES('$id',"Read",'$empid', NOW());
EOD;
        $this->db->query($query);


        $query = "UPDATE it_report SET title='$title', dsc='$dsc', date_updated = NOW(), last_touch='$empid', status='$status' WHERE id = $id";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }


    public function get_it_cloudflare(){
        $query = "SELECT * from it_cloudflare_info";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_it_cloudflare_accounts(){
        $query = "SELECT * from it_cf_accounts";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_it_cloudflare_accounts_api($email){
        $query = "SELECT api_key from it_cf_accounts WHERE email = '$email' LIMIT 1";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function delete_cf_accounts_credentials($email){
        $query = "DELETE from it_cloudflare_info WHERE email = '$email'";

        $query = $this->db->query($query);
    }

//    Godaddy Models

    public function get_it_godaddy(){
        $query = "SELECT * from it_godaddy_accounts";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_it_godaddy_domains(){
        $query = "SELECT id, account, domainId, domain, status, expires, privacy, renewAuto, locked, DATEDIFF(expires, NOW()) AS remdays from it_godaddy_domains WHERE status != 'UPDATED_OWNERSHIP' AND status != 'CANCELLED' ORDER BY expires ASC";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function get_it_godaddy_accounts_api($account){
        $query = "SELECT * from it_godaddy_accounts WHERE account = '$account' LIMIT 1";

        $query = $this->db->query($query);
        return $query->result();
    }

    public function delete_gd_accounts_credentials($account){
        $query = "DELETE from it_godaddy_domains WHERE account = '$account'";

        $query = $this->db->query($query);
    }

//    SERVER ACCESS

    public function get_it_server($serverid){
        $query = "SELECT * from it_server WHERE id = $serverid";

        $query = $this->db->query($query);
        return $query->result();
    }




//    Salary

    public function get_salary(){

        $query = <<<EOD
        SELECT
A.id, B.fname, B.lname, A.salary, b.dept, B.bank ,B.bank_name, B.bank_accno, B.bank_accadd
FROM
emp_info AS B
LEFT JOIN
salary AS A
ON A.empid = B.empid
ORDER BY
B.dept, B.fname


EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

    public function insert_salary($empid, $salary, $updateby){

        $query = "INSERT INTO salary(empid,salary,updated_by,date_updated) VALUES ('$empid','$salary','$updateby',NOW()) ON duplicate KEY UPDATE salary = '$salary'";

        if($this->db->query($query)){
            $msg = true;
        }
        else {
            $msg = false;
        }

        return $msg;
    }

    public function get_salary_report($month){

        $query = <<<EOD
        SELECT empid, salary ,grand_total as total_attendance_deductions,
        CASE
            WHEN grand_total > 0 THEN (salary-grand_total)+amount_considered
            WHEN grand_total <= 0 THEN salary
        END AS total_salary,
        grace_period, amount_considered
FROM (
SELECT
empid, salary, per_min, "150" as grace_period, (per_min*150) as amount_considered, sum(late) as total_late, sum(undertime) as total_undertime, sum(COALESCE(late_deduction,0)) as total_late_deduction,
sum(COALESCE(undertime_deduction,0)) as total_undertime_deduction,
SUM(COALESCE(late_deduction,0) + COALESCE(undertime_deduction,0)) AS grand_total
FROM (
SELECT empid, salary, date, code, dsc, timein, timeout, ROUND(per_min,2) AS per_min, ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(late)/60)) * 60))*1)/100)) as late, ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(undertime)/60)) * 60))*1)/100)) AS undertime,
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(late)/60)) * 60))*1)/100) * ROUND(per_min,2),2) AS late_deduction,
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(undertime)/60)) * 60))*1)/100) * ROUND(per_min,2),2) AS undertime_deduction
FROM
(SELECT
            A.id, A.empid, A.date, A.code , B.dsc, B.start_time, B.end_time, C.timein, C.timeout, D.salary, ((D.salary/30)/12)/60 AS per_min,
            TIMEDIFF(B.start_time, TIME(C.timein)) AS start_diff,
            TIMEDIFF(B.end_time, TIME(C.timeout)) AS end_diff,
            CASE
              WHEN TIMEDIFF(B.start_time, TIME(C.timein)) < 0 THEN TIMEDIFF(B.start_time, TIME(C.timein))
            END AS late,
            CASE
              WHEN TIMEDIFF(B.end_time, TIME(C.timeout)) > 0 THEN SUBTIME(B.end_time, TIME(C.timeout))
            END AS undertime
            FROM schedule AS A
            LEFT JOIN sched_template AS B
            ON A.code = B.code
            AND B.by_dept = (SELECT dept FROM emp_info AS D WHERE D.empid = A.empid)
            AND MONTH(A.date) = MONTH('$month')
            AND YEAR(A.date) = YEAR('$month')
            LEFT JOIN time_in AS C
            ON A.empid = C.empid
            AND A.date = DATE(C.timein)
            LEFT JOIN salary AS D
            ON A.empid = D.empid
            WHERE
            MONTH(A.date) = MONTH('$month')
            AND YEAR(A.date) = YEAR('$month')
            ORDER BY A.date ASC) AS A ) AS A
GROUP BY
empid, MONTH(date)
)AS A


EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

//  ATTENDANCE

    public function get_att_sched($date, $username){
        $query = "SELECT * FROM emp_schedule WHERE month = '$date' and username = '$username'";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_att_timein($date, $username){
        $query = "SELECT * FROM time_in WHERE MONTH(timein) = MONTH('$date') AND YEAR(timein) = YEAR('$date') AND empid = '$username'";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function insert_to_att_view($date, $code,$username){
        $query = "INSERT INTO schedule (empid, date, code, updated_by, date_updated) VALUES ('$username','$date','$code','$username',NOW())";
        $this->db->query($query);
    }

    public function delete_data_first($date,$username){
        $query = "DELETE FROM schedule WHERE empid ='$username' AND MONTH(date) = MONTH('$date') AND YEAR(date) = YEAR('$date')";
        $this->db->query($query);

    }

    public function calculated_attendance($date,$username){

        $query = <<<EOD
        SELECT
date, code, dsc,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN timein
END AS timein,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN timeout
END AS timeout,
per_min,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN late
END AS late,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN undertime
END AS undertime,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN COALESCE(late_deduction,0)
END AS late_deduction,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN COALESCE(undertime_deduction,0)
END AS undertime_deduction,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN COALESCE(late_deduction,0) + COALESCE(undertime_deduction,0)
END AS sub_total
FROM (
SELECT date, code, dsc, timein, timeout, start_time, end_time, ROUND(per_min,2) AS per_min,

CASE
WHEN timein > '00:00:00' AND start_time = '00:00:00' THEN null
ELSE
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(late)/60)) * 60))*1)/100))
END as late,

CASE
WHEN timein > '00:00:00' AND start_time = '00:00:00' THEN null
ELSE
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(undertime)/60)) * 60))*1)/100))
END as undertime,

CASE
WHEN timein > '00:00:00' AND start_time = '00:00:00' THEN null
ELSE
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(late)/60)) * 60))*1)/100) * ROUND(per_min,2),2)
END as late_deduction,

CASE
WHEN timein > '00:00:00' AND start_time = '00:00:00' THEN null
ELSE
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(undertime)/60)) * 60))*1)/100) * ROUND(per_min,2),2)
END as undertime_deduction

FROM
(SELECT
            A.id, A.empid, A.date, A.code , B.dsc, B.start_time, B.end_time,
            CASE
            WHEN C.timein IS NULL AND B.start_time = '00:00:00' THEN "OFF DAY"
            WHEN C.timein IS NULL AND B.start_time > '00:00:00' THEN "ABSENT"
            WHEN C.timein > '00:00:00' AND B.start_time = '00:00:00' THEN C.timein
            ELSE
            C.timein
            END AS timein,

            CASE
            WHEN C.timein IS NULL AND C.timeout IS NULL AND B.end_time = '00:00:00' THEN "OFF DAY"
            WHEN C.timein IS NULL AND C.timeout IS NULL AND B.end_time > '00:00:00' THEN "ABSENT"
            WHEN C.timeout > '00:00:00' AND B.end_time = '00:00:00' THEN C.timeout
            ELSE
            C.timeout
            END AS timeout,
            D.salary, ((D.salary/30)/12)/60 AS per_min,
            TIMEDIFF(B.start_time, TIME(C.timein)) AS start_diff,
            TIMEDIFF(B.end_time, TIME(C.timeout)) AS end_diff,
            CASE
              WHEN TIMEDIFF(B.start_time, TIME(C.timein)) < 0 THEN TIMEDIFF(B.start_time, TIME(C.timein))
            END AS late,
            CASE
              WHEN TIMEDIFF(B.end_time, TIME(C.timeout)) > 0 THEN SUBTIME(B.end_time, TIME(C.timeout))
              WHEN C.timein IS NULL AND C.timeout IS NULL AND B.start_time > '00:00:00' AND B.end_time > '00:00:00' THEN TIMEDIFF(B.start_time, B.end_time)
            END AS undertime
            FROM schedule AS A
            LEFT JOIN sched_template AS B
            ON A.code = B.code
            AND B.by_dept = (SELECT dept FROM emp_info AS D WHERE D.empid = A.empid)
            AND A.empid = '$username'
            AND MONTH(A.date) = MONTH('$date')
            AND YEAR(A.date) = YEAR('$date')
            LEFT JOIN time_in AS C
            ON A.empid = C.empid
            AND A.date = DATE(C.timein)
            LEFT JOIN salary AS D
            ON A.empid = D.empid
            WHERE
            A.empid = '$username'
            AND MONTH(A.date) = MONTH('$date')
            AND YEAR(A.date) = YEAR('$date')
            ORDER BY A.date ASC) AS A ) AS A

EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

    public function calculated_attendance_total($date,$username){
        $query = <<<EOD
        SELECT
per_min, sum(late) as total_late, sum(undertime) as total_undertime, sum(COALESCE(late_deduction,0)) as total_late_deduction,
sum(COALESCE(undertime_deduction,0)) as total_undertime_deduction,
SUM(COALESCE(late_deduction,0) + COALESCE(undertime_deduction,0)) AS grand_total
FROM (SELECT
date, code, dsc,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN timein
END AS timein,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN timeout
END AS timeout,
per_min,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN late
END AS late,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN undertime
END AS undertime,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN COALESCE(late_deduction,0)
END AS late_deduction,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN COALESCE(undertime_deduction,0)
END AS undertime_deduction,
CASE
WHEN DATEDIFF(NOW(), date) > -1 THEN COALESCE(late_deduction,0) + COALESCE(undertime_deduction,0)
END AS sub_total
FROM (
SELECT date, code, dsc, timein, timeout, start_time, end_time, ROUND(per_min,2) AS per_min,

CASE
WHEN timein > '00:00:00' AND start_time = '00:00:00' THEN null
ELSE
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(late)/60)) * 60))*1)/100))
END as late,

CASE
WHEN timein > '00:00:00' AND start_time = '00:00:00' THEN null
ELSE
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(undertime)/60)) * 60))*1)/100))
END as undertime,

CASE
WHEN timein > '00:00:00' AND start_time = '00:00:00' THEN null
ELSE
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(late)/60)) * 60))*1)/100) * ROUND(per_min,2),2)
END as late_deduction,

CASE
WHEN timein > '00:00:00' AND start_time = '00:00:00' THEN null
ELSE
ROUND(ABS(((SEC_TO_TIME((ROUND(TIME_TO_SEC(undertime)/60)) * 60))*1)/100) * ROUND(per_min,2),2)
END as undertime_deduction

FROM
(SELECT
            A.id, A.empid, A.date, A.code , B.dsc, B.start_time, B.end_time,
            CASE
            WHEN C.timein IS NULL AND B.start_time = '00:00:00' THEN "OFF DAY"
            WHEN C.timein IS NULL AND B.start_time > '00:00:00' THEN "ABSENT"
            WHEN C.timein > '00:00:00' AND B.start_time = '00:00:00' THEN C.timein
            ELSE
            C.timein
            END AS timein,

            CASE
            WHEN C.timein IS NULL AND C.timeout IS NULL AND B.end_time = '00:00:00' THEN "OFF DAY"
            WHEN C.timein IS NULL AND C.timeout IS NULL AND B.end_time > '00:00:00' THEN "ABSENT"
            WHEN C.timeout > '00:00:00' AND B.end_time = '00:00:00' THEN C.timeout
            ELSE
            C.timeout
            END AS timeout,
            D.salary, ((D.salary/30)/12)/60 AS per_min,
            TIMEDIFF(B.start_time, TIME(C.timein)) AS start_diff,
            TIMEDIFF(B.end_time, TIME(C.timeout)) AS end_diff,
            CASE
              WHEN TIMEDIFF(B.start_time, TIME(C.timein)) < 0 THEN TIMEDIFF(B.start_time, TIME(C.timein))
            END AS late,
            CASE
              WHEN TIMEDIFF(B.end_time, TIME(C.timeout)) > 0 THEN SUBTIME(B.end_time, TIME(C.timeout))
              WHEN C.timein IS NULL AND C.timeout IS NULL AND B.start_time > '00:00:00' AND B.end_time > '00:00:00' THEN TIMEDIFF(B.start_time, B.end_time)
            END AS undertime
            FROM schedule AS A
            LEFT JOIN sched_template AS B
            ON A.code = B.code
            AND B.by_dept = (SELECT dept FROM emp_info AS D WHERE D.empid = A.empid)
            AND A.empid = '$username'
            AND MONTH(A.date) = MONTH('$date')
            AND YEAR(A.date) = YEAR('$date')
            LEFT JOIN time_in AS C
            ON A.empid = C.empid
            AND A.date = DATE(C.timein)
            LEFT JOIN salary AS D
            ON A.empid = D.empid
            WHERE
            A.empid = '$username'
            AND MONTH(A.date) = MONTH('$date')
            AND YEAR(A.date) = YEAR('$date')
            ORDER BY A.date ASC) AS A ) AS A) AS A GROUP BY YEAR('$date'), MONTH('$date')
EOD;

        $query = $this->db->query($query);

        return $query->result();
    }

//Logging
    public function logged_action($empid, $action){
        $query = "INSERT INTO logs (empid, actions, date_updated) VALUES ('$empid','$action',NOW())";
        $this->db->query($query);
    }
}


