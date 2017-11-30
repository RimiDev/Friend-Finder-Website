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

    public function index(Request $request)
    {
        $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();
        foreach ($friendStatus as $friend)
            $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

        if(isset($friendNames) && count($friendNames) > 0 && isset($friendStatus) && count($friendStatus) > 0)
            return view('manageFriends', ['friendNames' => $friendNames, 'friendStatus' => $friendStatus]);
        return view('manageFriends');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchSaveUpdateFriends(Request $request)
    {
        if ($request->get('submitFriendSearch'))
        {
            $searchNames = $this->searchPeople($request);

            $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();
            foreach ($friendStatus as $friend)
                $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

            if(isset($friendNames) && count($friendNames) > 0 && isset($friendStatus) && count($friendStatus) > 0)
                return view('manageFriends', ['searchNames' => $searchNames, 'friendNames' => $friendNames,
                    'friendStatus' => $friendStatus]);
            return view('manageFriends', ['searchNames' => $searchNames]);
        }

        else if ($request->get('addFriendBtn'))
        {
            $this->saveFriend($request);

            $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();
            foreach ($friendStatus as $friend)
                $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

            return view('manageFriends', ['friendNames' => $friendNames, 'friendStatus' => $friendStatus]);
        }

        else if ($request->get('acceptRequest'))
        {
            $this->acceptFriendRequest($request);
        }
        else if ($request->get('declineRequest'))
        {
            $this->declineFriendRequest($request);
        }
    }

    public function searchPeople(Request $request)
    {
        $searchNames = User::where(('name'), 'ilike', '%' . $request->get('name') . '%')->
            where('name', '!=', Auth::user()->name)->paginate(10);

        return $searchNames;
    }

    private function saveFriend(Request $request)
    {
        $checkExists = Friend::where('email', '=', Auth::user()->email)->
            where('friendEmail', '=', $request->get('addFriendBtn'))->get();

        if (count($checkExists) <= 0)
        {
            $friend = new Friend();
            $friend->email = Auth::user()->email;
            $friend->user_id = Auth::user()->id;
            $friend->status = 'Request Sent';
            $friend->friendEmail = $request->get('addFriendBtn');
            $friend->save();

            $friend = new Friend();
            $friend->email = $request->get('addFriendBtn');
            $friend->user_id = Auth::user()->id;
            $friend->status = 'Request Received';
            $friend->friendEmail = Auth::user()->email;
            $friend->save();
        }
    }

    private function acceptFriendRequest(Request $request)
    {
        //Update table change request sent and request received to confirmed
    }

    private function declineFriendRequest(Request $request)
    {
        //Remove request sent and request received from table
    }
}
