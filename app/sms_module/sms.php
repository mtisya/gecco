<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load any necessary models or libraries
    }

    public function index() {
        // Your default SMS functionality goes here
        // For example, sending an SMS
        $this->sendSms();
    }

    public function sendSms() {
        // Replace with your actual API credentials
        $username = 'YOUR_USERNAME';
        $apiKey = 'YOUR_API_KEY';

        // Recipient phone number and SMS content
        $recipient = '+2XXYYYOOO'; // Replace with recipient's number
        $message = 'Hello World!'; // Your SMS content

        // Initialize Africa's Talking SDK
        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();

        // Send SMS
        $result = $sms->send([
            'to' => $recipient,
            'message' => $message
        ]);

        // Handle response (you can customize this)
        if ($result['status'] === 'success') {
            echo 'SMS sent successfully!';
        } else {
            echo 'Error sending SMS: ' . $result['message'];
        }
    }
}
