<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mpesa_model extends CI_Model
{
    protected $request_headers;
    public function __construct()
    {
        parent::__construct();
        $this->config->load('mpesa');
        $this->request_headers = array(
			'Content-Type:application/json',
			'Authorization:Bearer '.$this->_get_access_token()
		);
    
    }
    private function _curl_setup($url,$headers=NULL)
	{
		// Curl
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		$headers = !isset($headers) ? $this->request_headers : $headers;

		// If headers have been provided ~ add them to the request
		if(is_array($headers))
		{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);	
		}
				
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		return $curl;
	}
    public function get_request($url,$headers=NULL)
	{		
		$curl = $this->_curl_setup($url,$headers);
		$curl_response = curl_exec($curl);

		return $curl_response;
	}
    public function post_request($url,$data=NULL,$headers=NULL)
    {		
		
		$curl = $this->_curl_setup($url,$headers);

		curl_setopt($curl, CURLOPT_POST, TRUE);

		$data_string = json_encode($data);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		
		$curl_response = curl_exec($curl);

		return $curl_response;
    }
    // Generate a valid mpesa timestamp
	public function get_timestamp()
	{
        return date('YmdHis');
	}
    // Generate access token
	private function _get_access_token()
	{
        $this->db->order_by('ID', 'desc');
        $q = $this->db->get('mpesaauth');
		$last_access = $q->first_row()->time;
		$hours = (strtotime('now') - strtotime($last_access))/3600;
		$token = $q->first_row()->key;
		if ($hours > 1 )
		{
			$consumer_key = $this->config->item('consumer_key');
			$consumer_secret = $this->config->item('consumer_secret');
	
			$credentials = base64_encode($consumer_key.':'.$consumer_secret);
			
			$token_response = $this->get_request($this->config->item('url_generate_token'),array(
				'Authorization: Basic '.$credentials
			));
			log_message('debug', $token_response);
			$token_response = json_decode($token_response);
        	$this->db->insert('mpesaauth', ['key' => $token_response->access_token]);
			$token = $token_response->access_token;
		}
		return $token;
	}

    #endregion REST REQUESTS

	// Generate lipa na mpesa
	protected function get_lipa_na_mpesa_password($short_code,$pass_key,$timestamp)
	{
		return base64_encode($short_code.$pass_key.$timestamp);
	}
    private function _get_lipa_na_mpesa_data($phone=NULL,$amount=1,$account_reference=NULL,$description=NULL)
	{
		$timestamp = $this->get_timestamp();
		$password = $this->get_lipa_na_mpesa_password(
			$this->config->item('lipa_na_mpesa_online_shortcode'),
			$this->config->item('lipa_na_mpesa_online_passkey'),
			$timestamp
		);

		// Set defaults ~ use dev version if param is not available
		$phone = empty($phone) ? $this->config->item('test_msisdn') : $phone;
		$amount = empty($amount) ? $this->config->item('min_send_amount') : (float)$amount;
		$description = empty($description) ? $this->config->item('default_lipa_na_mpesa_description') : $description;
		$account_reference = empty($account_reference) ? $this->config->item('default_account_reference') : $account_reference;

		$request_data = array(
			//Fill in the request parameters with valid values
			'BusinessShortCode' => $this->config->item('lipa_na_mpesa_online_shortcode'),
			'Password' => $password,
			'Timestamp' => $timestamp,
			'TransactionType' => 'CustomerPayBillOnline',
			'Amount' => $amount,
			'PartyA' => $phone,
			'PartyB' => $this->config->item('lipa_na_mpesa_online_shortcode'),
			'PhoneNumber' => $phone,
			'CallBackURL' => $this->config->item('url_lipa_na_mpesa_callback_confirmation'),
			'AccountReference' => $account_reference,
			'TransactionDesc' => $description
		);
		return $request_data;
	}
	//valid phone number
    protected function get_valid_phone($phone)
	{
		$phone = trim($phone);
		$response_phone = $phone;
		// If the phone number has 10 digits, replace the first one with 254
		if(strlen($response_phone) == 10)
		{
			$response_phone = str_split($phone);
			$response_phone[0] = '254';
			
			$response_phone = join($response_phone,'');
		}
		return $response_phone;
	}
    public function lipa_na_mpesa($phone=NULL,$amount=10,$account_reference='',$description='')
    {
		$phone = $this->get_valid_phone($phone);
		$request_data = $this->_get_lipa_na_mpesa_data($phone,$amount,$account_reference,$description);

		$response = $this->post_request(
			$this->config->item('url_c2b_simulate_transaction'),
			$request_data,
			$this->request_headers
		);
		
		// Return the response object ~ API handler should handle parsing this back to JSON if ajax
		return json_decode($response);
    }

}