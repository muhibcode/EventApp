<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class AttendeeController extends Controller
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

        $user = UserInfo::where('user', '=', auth()->id())->first();
        // $event = Event::where('id', '=', $request->eventID)->first();
        $attendee = Attendee::create([
            'userinfo' => $user->id,
            'is_host' => false
        ]);
        // info($event);
        // $event->attendees()->create([
        //     'userinfo' => $user->id,
        //     'is_host' => false
        // ]);
        $attendee->activities()->attach($request->eventID);


        // return redirect('activity/' . $request->activityID)->with(['message' => 'You have joined the Activity']);

        return to_route('event.index')->with(['message' => 'You have joined the Activity']);
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
