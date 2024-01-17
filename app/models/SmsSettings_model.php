<?php
class SmsSettings_model extends CI_Model
{
    public function insert_sms_settings($data)
    {
        
        // Debugging statement
        echo 'Reached insert_data in Your_model';
        // Assuming you have a table named 'sms_settings'
        $this->db->insert('sma_sms_settings', $data);
    }
}
