<?php
namespace App\Admin\Controllers;

use App\AdminPremission;

class PremissionController extends Controller{
    public function index(){
        $premissions = AdminPremission::paginate(10);
        return view('admin.premission.index',compact('premissions'));
    }

    public function create(){
        return view('admin.premission.create');
    }

    public function store(){
        $this->validate(request(),[
            'name' => 'required|min:3',
            'description' => 'required'
        ]);
        AdminPremission::create(request(['name','description']));
        return redirect('/admin/premissions');

    }

}