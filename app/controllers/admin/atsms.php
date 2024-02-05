<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use AfricasTalking\SDK\AfricasTalking;

class atsms extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load any necessary models or libraries
        $this->lang->admin_load('sms', $this->Settings->language);
        $this->load->library('parser');
        $this->load->library('africastalking','sms');

        // Set your API credentials
        //$this->africastalking->authKey = "a9ec3b849107a547801ee252841f7b0c0f3c310829cf62b289153787c4edcfb7";
        //$this->africastalking->username = "sandbox";
        }

    public function index() {
        // Your default SMS functionality goes here
        // For example, sending an SMS
        $this->sendSms();
        // echo "Am reaching this method";
    }

    public function sendSms() {

        $this->load->library('africastalking');
        // echo 'Debug: Inside sendSms method'; // Add this line
        // Replace with your actual API credentials
        
        $username = 'wetlab';
        $apiKey = '1d5594052e2423ca585a8d7c378806db98b445dc2d68537a1b602ab303b8cff5';

        // Check SMS balance
        $balance = $this->africastalking->checkSMSBalance();
        if ($balance >= 1) {
            // SMS balance is sufficient, proceed with sending the SMS
            // ...
        } else {
            // SMS balance is insufficient
            echo 'Insufficient SMS balance';
        }

        // Recipient phone number and SMS content
        $recipient = $this->input->post('sendTo'); // Recipient phone number
        //$message = $this->input->post('message'); // SMS content
        $message = $this->input->post('message', true);
        $sanitized_message = $this->security->xss_clean(strip_tags($message));

        // Initialize Africa's Talking SDK
        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();

        // Send SMS
        $result = $sms->send([
            'to' => $recipient,
            'message' => $sanitized_message
        ]);

        // Handle response (you can customize this)
        if ($result['status'] === 'success') {
            echo 'SMS sent successfully!';
        } else {
            echo 'Error sending SMS: ' . $result['message'];
        }

        // Set a success flash message
        $this->session->set_flashdata('success_message', 'SMS sent successfully!');

        // Redirect back to the form page
        redirect('http://localhost/gecco/admin/system_settings/send_sms'); // Replace with your actual form page URL
        }
}
