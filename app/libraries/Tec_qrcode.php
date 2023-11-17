<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author  : Mian Saleem
 *  Email   : saleem@tecdiary.com
 *  For     : PHP QR Code
 *  Web     : http://phpqrcode.sourceforge.net
 *  License : open source (LGPL)
 *  ==============================================================================
 */

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Tec_qrcode
{
    public function generate($params = [])
    {
        return (new QRCode(new QROptions(['imageBase64' => false, 'outputType' => QRCode::OUTPUT_MARKUP_SVG])))->render($params['data']);
    }
}
