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
                        $show = '';
                        $edit = "";
                        $ban = "";

                        $show = '<a href="'.route('users.show',[$row->id]).'" class="show btn btn-primary btn-sm">View</a>';
                        $btn .= $show;

                        $ban = '<a href="'.route('users.ban',[$row->id]).'" class="ban btn btn-warning btn-sm">Ban</a>';
                        $btn .= $ban;

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
