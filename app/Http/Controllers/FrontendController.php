<?php


namespace App\Http\Controllers;


class FrontendController extends Controller
{


    public function index()
    {
        $page = 'index';

        echo $page;

    }



    public function main($value)
    {

        if (preg_match('/([a-z0-9\-]+)\.html/', $value, $matches)) {

        } else {

        }
    }


}