<?php

namespace App\Http\Controllers;

class ServicesController extends Controller
{
    public function webDesign()
    {
        return view('services.web-design');
    }

    public function mobileApps()
    {
        return view('services.mobile-app-development');
    }

    public function webApps()
    {
        return view('services.web-application-development');
    }

    public function customSoftware()
    {
        return view('services.custom-software-development');
    }

    public function devOps()
    {
        return view('services.devops-cloud');
    }
}
