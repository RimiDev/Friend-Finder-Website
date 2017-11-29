<?php

namespace App\Http\Controllers;

use App\Friend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $allFriends = User::where('name', '!=', Auth::user()->name);
        return view('manageFriends', ['completeFriends' => $allFriends]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function friends(Request $request)
    {
        if($request->get('submitFriendSearch'))
        {
            $dbNames = User::where(('name'), 'ilike', '%' . $request->get('name') . '%')->
                where('name', '!=', Auth::user()->name)->paginate(10);
            $friends = $request->user()->friends()->get();
            $allFriends = User::where('name', '!=', Auth::user()->name)->paginate(10);

            return view('manageFriends', ['friends' => $dbNames, 'status' => $friends, 'completeFriends' => $allFriends]);
        }
        else if($request->get('addFriendBtn'))
        {
            $friend = new Friend();
            $friend->email = Auth::user()->email;
            $friend->user_id = Auth::user()->id;
            $friend->status = 'pending';
            $friend->friendEmail = $request->get('addFriendBtn');
            $friend->save();

            $dbNames = User::where('name', '!=', Auth::user()->name)->paginate(10);
            $friends = $request->user()->friends()->get();
            return view('manageFriends' , ['friends' => $dbNames, 'status' => $friends]);
        }
    }
}
