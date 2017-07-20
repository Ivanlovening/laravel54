<?php
namespace App\Admin\Controllers;

class HomeController extends Controller{
    public function index(){
        return view('admin.home.index');
    }
}