<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
         $users =User::all();
        if(request()->ajax())
        {
            return Datatables::of($users)
                   ->addIndexColumn()
                   ->addColumn('action',function($row){
                        $btn = '';
                        $del = '';
                        
                        $ban = "";

                        if($row->suspensed == 1){
                        $ban = '<a href="'.route('users.unsuspended',[$row->id]).'" class="ban btn btn-outline-warning btn-md">Ban</a>';
                        $btn .= $ban;
                        }
                        else {
                        $ban = '<a href="'.route('users.suspended',[$row->id]).'" class="ban btn btn-warning btn-md"><i class="fa-solid fa-ban"></i></a>';
                        $btn .= $ban;
                        }

                        $del = '<a href="'.route('users.delete',[$row->id]).'" class="delete btn btn-danger btn-md"><i class="fa-solid fa-trash"></i></a>';
                        $btn .= $del;

                        return $btn;
                   }) 

                   ->rawColumns(['action'])

                   ->make(true);    
        }
        return view('users.index');
    }

    
    public function show($id)
    {
        $data = User::find($id);

        return view('users.show', [
            'user' => $data
        ]);
    }

}
