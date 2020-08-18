<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		return view('admin/dashboard');
    }
    
    public function tampilKategori(){
        return view('admin/kategori');
    }
	

}
