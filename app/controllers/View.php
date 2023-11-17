<?php

defined('BASEPATH') or exit('No direct script access allowed');

class View extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->Settings->mmode && $this->v != 'login') {
            redirect('notify/offline');
        }
    }

    public function quote($hash = null)
    {
        if ($this->input->get('hash')) {
            $hash = $this->input->get('hash');
        }
        $inv = $this->db->get_where('quotes', ['hash' => $hash], 1)->row();
        if (!$inv) {
            $data['page_title'] = lang('Quotation Not Found');
            $data['msg']        = '🤷🏼‍♀️'; // 🤫 😱 👻 🤡 👨‍✈️ 👮‍♂️
            $data['msg1']       = 'We are unable to find your quotation.';
            return $this->load->view('default/notify', $data);
        }

        $this->data['logo'] = true;
        $this->load->library('inv_qrcode');
        $this->load->admin_model('quotes_model');
        $this->lang->admin_load('quotations', $this->Settings->user_language);

        $this->data['barcode']   = ''; //"<img src='" . admin_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer']  = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller']    = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user']      = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv']       = $inv;
        $this->data['rows']      = $this->quotes_model->getAllQuoteItems($inv->id);

        $this->load->view($this->theme . 'quotes/public_view', $this->data);
    }

    public function sale($hash = null)
    {
        if ($this->input->get('hash')) {
            $hash = $this->input->get('hash');
        }
        $inv = $this->db->get_where('sales', ['hash' => $hash], 1)->row();
        if (!$inv) {
            $data['page_title'] = lang('Order Not Found');
            $data['msg']        = '🤷🏼‍♀️'; // 🤫 😱 👻 🤡 👨‍✈️ 👮‍♂️
            $data['msg1']       = 'We are unable to find your order.';
            return $this->load->view('default/notify', $data);
        }

        $this->data['logo'] = true;
        $this->load->library('inv_qrcode');
        $this->load->admin_model('sales_model');
        $this->lang->admin_load('sales', $this->Settings->user_language);

        $this->data['barcode']     = ''; //"<img src='" . admin_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer']    = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller']      = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user']        = $this->site->getUser($inv->created_by);
        $this->data['warehouse']   = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv']         = $inv;
        $this->data['rows']        = $this->sales_model->getAllInvoiceItems($inv->id);
        $this->data['return_sale'] = $inv->return_id ? $this->sales_model->getInvoiceByID($inv->return_id) : null;
        $this->data['return_rows'] = $inv->return_id ? $this->sales_model->getAllInvoiceItems($inv->return_id) : null;

        $this->load->view($this->theme . 'sales/public_view', $this->data);
    }
}
