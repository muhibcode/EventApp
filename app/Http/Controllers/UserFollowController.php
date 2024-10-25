<?php

namespace App\Http\Controllers;

use App\Events\Notify;
use App\Events\UserFollow;
use App\Models\Notiifcations;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class UserFollowController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // info($request->id);
        $user = UserInfo::where('id', '=', $request->tuser)
            ->with('user')->first();
        info($user);

        $user->reqsender()->detach($request->follower);
        $user->follower()->attach($request->follower);
        $follow = UserInfo::where('user', '=', $request->follower)->first();
        $message = 'accepts your follow request';


        $data = [
            'user_follower' => $follow->follower->count(),
            'user_following' => $follow->following->count(),
            'target_user_follower' => $user->follower->count(),
            'target_user_following' => $user->following->count(),
            'user_id' => $request->follower,
            'target_user' => $request->tuser


        ];

        Notiifcations::create([
            'content' => $message,
            'user_id' => $follow->user
        ]);

        Notify::dispatch($message, $follow->user);
        UserFollow::dispatch($data, $follow->user);
        // event(new UserFollow($data, $follow->user));

        return to_route('userinfo.show', $user->user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
