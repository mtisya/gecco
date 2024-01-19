<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author  : Sammy Mutisya
 *  Email   : msammy@clone-technologies.com
 *  For     : SMS Lib
 *  ==============================================================================
 */

use AfricasTalking\SDK\AfricasTalking;


$username = 'sandbox'; // Use 'sandbox' for development in the test environment
$apiKey = 'a9ec3b849107a547801ee252841f7b0c0f3c310829cf62b289153787c4edcfb7'; // Use your sandbox app API key for development in the test environment

$AT = new AfricasTalking($username, $apiKey);
