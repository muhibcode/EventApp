<?php

namespace App\Http\Controllers;

use App\Events\FollowReq;
use App\Events\Notify;
use App\Events\UserFollow;
use App\Models\FollowRequest;
use App\Models\Notiifcations;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class FollowRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $f_requests = UserInfo::where('user', '=', auth()->id())
            ->with('reqsender.user')->first();

        return inertia('FRequest/Index', ['reqs' => $f_requests]);
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
        $user = UserInfo::where('user', '=', $request->tuser)->first();
        $message = $request->name . ' sending you a follow request';
        Notiifcations::create([
            'content' => $message,
            'user_id' => $request->tuser
        ]);
        // event(new UserFollow($message, $user->user));
        $user->reqsender()->attach($request->follower);
        Notify::dispatch($message, $user->id);

        // FollowRequest::create([
        //     'tuser' => $request->tuser,
        //     'follower' => $request->follower
        // ]);

        return to_route('userinfo.show', $request->tuser);

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
