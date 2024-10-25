<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('UserInfo/AddUserInfo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        UserInfo::create([
            'city' => $request->city,
            'address' => $request->address,
            'user' => auth()->id()
        ]);

        return to_route('event.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userinfo)
    {
        $nuser = UserInfo::where('id', '=', $userinfo)
            ->with(['user', 'follower', 'following', 'reqsender'])->first();
        return inertia('UserInfo/MyProfile', ['userinfo' => $nuser]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
