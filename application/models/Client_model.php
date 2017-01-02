<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model {


    public function insert_time_in($username,$ippool)
    {
        $username = $this->db->escape_str($username);
        $ippool = $this->db->escape_str($ippool);

        $query = "INSERT INTO time_in (empid, timein, computer_dsc) values ('$username',NOW(),'$ippool')";
//        $query = $this->db->query($query);


        if ($this->db->query($query))
        {
            $message = "You are now <strong>LOGGED IN.</strong>";
        }
        else
        {
            $message = "Failed!";
        }

        return $message;

    }

    public function insert_time_out($username,$ippool)
    {
        $username = $this->db->escape_str($username);
        $ippool = $this->db->escape_str($ippool);
        $query = "UPDATE time_in SET timeout = NOW() WHERE empid = '$username' and timeout is NULL and timein >= DATE_SUB(curdate(), interval 1 day) and timein <= DATE_ADD(curdate(), interval 1 day)";
//        $query = $this->db->query($query);


        if ($this->db->query($query))
        {
            $message = "You are now <strong>LOGGED OUT!</strong>";
        }
        else
        {
            $message = "Failed!";
        }

        return $message;

    }


    public function get_user_data($username,$password){
        $username = $this->db->escape_str($username);
        $password = $this->db->escape_str($password);

        $query = "SELECT * FROM users WHERE username = '$username' and passkey = md5('$password')";
        $query = $this->db->query($query);

        return $query->result();
    }
    public function get_datetime(){
        $query = "SELECT NOW() AS DB_DATE";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function check_ip($ipaddress){
        $ipaddress = $this->db->escape_str($ipaddress);

        $query = "SELECT * FROM ip_pool WHERE ip_address = '$ipaddress' LIMIT 1";
        $query = $this->db->query($query);

        return $query->num_rows();
    }

    public function insert_ip($ipaddress){
        $query = "INSERT INTO ip_accessing (ip_address, date_time) VALUES('$ipaddress', NOW() )";
        $this->db->query($query);
    }

    public function get_last_login(){
        $query = "CALL `last_login`()";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_user_login($username){
        $query = "SELECT * FROM time_in WHERE empid = '$username' and timeout is null and timein >= DATE_SUB(curdate(), interval 1 day) and timein <= DATE_ADD(curdate(), interval 1 day)";
        $query = $this->db->query($query);

        return $query->num_rows();
    }

    public function get_logo($ipaddress){
        $query = "SELECT logo FROM ip_pool WHERE ip_address = '$ipaddress' LIMIT 1";
        $query = $this->db->query($query);

        return $query->result();
    }

    public function get_pass($eid){
        $query = "SELECT passkey FROM users WHERE username = '$eid' AND passkey='pass1234' LIMIT 1 ";
        $query = $this->db->query($query);

        return $query->num_rows();
    }

    public function change_pass($empid, $passkey){
        $query = "UPDATE users SET passkey = MD5('$passkey') WHERE username = '$empid'";
        if($this->db->query($query)){
            $message = "Updated password successfully";

        }
        else {
            $message = "Error in updating your password";

        }

        return $message;
    }


    public function get_login($uname, $pass){
        $uname =  $this->db->escape_str($uname);
        $pass = $this->db->escape_str($pass);

        $query = "SELECT * FROM users WHERE username = '$uname' and passkey = md5('$pass') LIMIT 1";
//        var_dump($query);
        $query = $this->db->query($query);
//        var_dump($query->result());

        return $query->num_rows();
    }

    public function get_login_level($uname, $pass){
        $query = "SELECT level FROM users WHERE username = '$uname' and passkey = md5('$pass') LIMIT 1";
//        var_dump($query);
        $query = $this->db->query($query);


        return $query->result();
    }

    public function get_announcements(){
        $query = "SELECT id, title, dsc, date, updated_by, (SELECT dept from emp_info where empid = updated_by) as dept FROM announcements ORDER BY date DESC LIMIT 3";
        $query = $this->db->query($query);

        return $query->result();
    }



}
