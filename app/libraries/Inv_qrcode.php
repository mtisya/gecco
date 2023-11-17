<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author  : Mian Saleem
 *  Email   : saleem@tecdiary.com
 *  For     : Invoice QR Code
 *  Web     : https://github.com/SallaApp/ZATCA
 *  License : MIT License
 *  ==============================================================================
 */

use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\TaxNumber;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;

class Inv_qrcode
{
    public function base64($params = [])
    {
        return GenerateQrCode::fromArray([
            new Seller($params['seller']),
            new TaxNumber($params['vat_no']),
            new InvoiceDate(date('c', strtotime($params['date']))),
            new InvoiceTotalAmount($params['grand_total']),
            new InvoiceTaxAmount($params['total_tax_amount'])
        ])->toBase64();
    }

    public function render($params = [])
    {
        return GenerateQrCode::fromArray([
            new Seller($params['seller']),
            new TaxNumber($params['vat_no']),
            new InvoiceDate(date('c', strtotime($params['date']))),
            new InvoiceTotalAmount($params['grand_total']),
            new InvoiceTaxAmount($params['total_tax_amount'])
        ])->render();
    }

    public function tlv($params = [])
    {
        return GenerateQrCode::fromArray([
            new Seller($params['seller']),
            new TaxNumber($params['vat_no']),
            new InvoiceDate(date('c', strtotime($params['date']))),
            new InvoiceTotalAmount($params['grand_total']),
            new InvoiceTaxAmount($params['total_tax_amount'])
        ])->toTLV();
    }
}
