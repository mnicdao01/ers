<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {


    public function index()
    {
        $this->load->model('client_model');
        $data['results'] = $this->client_model->get_announcements();
        $this->load->view('c_main',$data);

    }

    public function index_new()
    {
        $this->load->view('c_main2');

    }

    public function load_last_login(){
        $this->load->model("client_model");
        $data['last_login'] = $this->client_model->get_last_login();
        $this->load->view('last_login', $data);
    }

    public function get_user(){
        $username = $this->input->post('username');
        $this->load->model("client_model");

    }

    public function insert_time_in(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $ippool = $this->input->post('ippool');
        $this->load->model("client_model");
        $data['results'] = $this->client_model->get_user_data($username,$password);
//        $data['results'] = $this->client_model->get_ip_pool($username);



        if($data['results']){
            if($data["results"]){
                $message = $data['results'] = $this->client_model->insert_time_in($username,$ippool);
            }else{
                $message = "Access Denied";
            }

        }
        else{
            $message = "Cannot find Employee ID";
        }


//        $message = $this->client_model->insert_time_in($username,$password);

        print_r($message);

    }
    public function insert_time_out(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $ippool = $this->input->post('ippool');
        $this->load->model("client_model");
        $data['results'] = $this->client_model->get_user_data($username,$password);
//        $data['results'] = $this->client_model->get_ip_pool($username);



        if($data['results']){
            if($data["results"]){
                $message = $data['results'] = $this->client_model->insert_time_out($username,$ippool);
            }else{
                $message = "Access Denied";
            }

        }
        else{
            $message = "Cannot find Employee ID";
        }


//        $message = $this->client_model->insert_time_in($username,$password);

        print_r($message);

    }

    public function change_pass(){
        $username = $this->input->post_get('empid');
        $this->load->model("client_model");
        $data = $this->client_model->get_pass($username);

        echo($data);
    }

    public function pass_forms(){
        $data['empid'] = $this->input->post('empid');

        $this->load->view('change_pass', $data);


    }

    public function update_pass(){
        $eid = $this->input->post_get('empid');
        $password = $this->input->post_get('passkey');
        $this->load->model("client_model");
        $data = $this->client_model->change_pass($eid,$password);

        print_r($data);
    }

    public function get_datetime(){
        $this->load->model("client_model");
        $data = $this->client_model->get_datetime();
        print_r($data[0]->DB_DATE);
    }

    public function check_ip(){
        $this->load->model("client_model");
        $ipaddress = $this->input->post('ipaddress');
        $this->client_model->insert_ip($ipaddress);
        $data['results'] = $this->client_model->check_ip($ipaddress);
        print_r($data['results']);
    }

    public function get_login_user(){
        $this->load->model("client_model");
        $username = $this->input->post('username');
        $data = $this->client_model->get_user_login($username);

        print_r($data);

    }

    public function get_logo(){
        $this->load->model("client_model");
        $ipaddress = $this->input->post('ipaddress');
        $data['results'] = $this->client_model->get_logo($ipaddress);
        print_r($data['results'][0]->logo);
    }

    public function loginView(){
        $isLoggedin =  $this->session->userdata('isLoggedIn');

        if($isLoggedin){
            $this->load->view('admin/main');
        } else {
            $this->load->view('login');
        }

    }
    public function login(){

        $uname = $this->input->post_get('uname');
        $pass = $this->input->post_get('pass');

        $this->load->model("client_model");
        $data = $this->client_model->get_login($uname,$pass);

        if($uname && $pass){
            if($uname){
                if($pass){
                    if($data == 1){
                        $newdata = array(
                            'username'  => $uname,
                            'isLoggedIn' => TRUE
                        );

                        $this->session->set_userdata($newdata);
                        redirect('admin/main','refresh');
                    }
                    else {
                        $this->session->sess_destroy();
                        $newdata = array(
                            'id' => 1,
                            'msg'  => "Username and password incorrect."
                        );
                        $this->session->set_userdata($newdata);

                        $this->admin();

                    }
                }
                else
                {
                    $this->session->sess_destroy();
                    $newdata = array(
                        'id' => 1,
                        'msg'  => "Please fill password!"
                    );
                    $this->session->set_userdata($newdata);
                    $this->admin();
                }
            }
            else {
                $this->session->sess_destroy();
                $newdata = array(
                    'id' => 1,
                    'msg'  => "Please fill username!"
                );
                $this->session->set_userdata($newdata);
                $this->admin();
            }
        }
        else
        {
            $this->session->sess_destroy();
            $this->admin();
        }

    }

    public function admin(){
        $this->load->view('login');
    }



}
