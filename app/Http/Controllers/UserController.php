<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        //  $users =User::all();
        $users = User::where('role_id', 2)->get();
        if(request()->ajax())
        {
            return Datatables::of($users)
                   ->addIndexColumn()
                   ->addColumn('action',function($row){
                        $btn = '';
                        $del = '';
                        
                        $ban = "";

                        // if($row->suspensed == 1){
                        // $ban = '<a href="'.route('users.unsuspended',[$row->id]).'" class="ban btn btn-outline-warning btn-md">Ban</a>';
                        // $btn .= $ban;
                        // }
                        // else {
                        // $ban = '<a href="'.route('users.suspended',[$row->id]).'" class="ban btn btn-warning btn-md"><i class="fa-solid fa-ban"></i></a>';
                        // $btn .= $ban;
                        // }

                        $del = '<a href="'.route('users.delete',[$row->id]).'" class="delete btn btn-danger btn-md"
                        onclick="return confirm(\'Are you sure you want to delete this user?\')">
                        <i class="fa-solid fa-trash"></i></a>';
                        $btn .= $del;

                        return $btn;
                   }) 

                   ->rawColumns(['action'])

                   ->make(true);    
        }
        return view('users.index');
    }

    public function delete($id)

    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index');
    }

}
