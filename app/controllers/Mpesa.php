<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mpesa extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    private function __mc2()
    {
        $post = json_decode($this->input->raw_input_stream);
        // // $post2= json_encode($post);
        // log_message('debug', "post worked");
        // // $post = json_decode($post2);
        // // $this->db->insert('mpesatrans', $post);
        // $post->status = "pending";
        $this->sma->send_json(["ResultCode" => "0", "ResultDesc"=> "Accepted"]);
        // echo "Success";

    }
    public function index()
    {
        // $post = json_decode($this->input->raw_input_stream);
        // // $post2= json_encode($post);
        // log_message('debug', "post worked");
        // // $post = json_decode($post2);
        // // $this->db->insert('mpesatrans', $post);
        // $post->status = "pending";
        // $this->sma->send_json(["ResultCode" => "0", "ResultDesc"=> "Accepted"]);
        echo 'Hello World';

    }

    private function __mcus2b()
    {
        $post = json_decode($this->security->xss_clean($this->input->raw_input_stream));
        // $post2= json_encode($post);
        // $post = json_decode($post2);
        // $this->db->insert('mpesatrans', $post);
        log_message('debug', $post->TransID);
        $post->status = "pending";
        $this->db->insert('mpesatrans', $post);
        $this->sma->send_json(["ResultCode" => "0", "ResultDesc"=> "Accepted"]);

    }
    private function __mcus2b1()
    {
        $post = json_decode($this->security->xss_clean($this->input->raw_input_stream));
        // $post2= json_encode($post);
        // $post = json_decode($post2);
        // $this->db->insert('mpesatrans', $post);
        log_message('debug', $post->TransID);
        // $post->status = "pending";
        // $this->db->insert('mpesatrans', $post);
        $this->sma->send_json(["ResultCode" => "0", "ResultDesc"=> "Accepted"]);

    }
  
}
