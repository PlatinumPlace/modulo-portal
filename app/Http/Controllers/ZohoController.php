<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Zoho;

class ZohoController extends Controller
{
    public function index()
    {
        $zoho = new Zoho;
        //$zoho->generateTokens($grant_token);
    }
}