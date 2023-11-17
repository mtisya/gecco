<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mpesa extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        show_404();
    }
    public function mcus2b2()
    {
        // $post = json_decode($this->input->raw_input_stream);
        // // $post2= json_encode($post);
        // log_message('debug', "post worked");
        // // $post = json_decode($post2);
        // // $this->db->insert('mpesatrans', $post);
        // $post->status = "pending";
        $this->sma->send_json(["ResultCode" => "0", "ResultDesc"=> "Accepted"]);

    }
  
}
