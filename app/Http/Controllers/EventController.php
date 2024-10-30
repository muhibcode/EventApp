<?php

namespace App\Http\Controllers;

use App\Events\CreateActivity;
use App\Events\UserFollow;
use App\Models\Event;
use App\Models\Host;
use App\Models\Notiifcations;
use App\Models\UserInfo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use Str;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['attendees.userinfo.user', 'hostedBy.userinfo.user', 'comments'])->get();
        // $notifications = Notiifcations::where('user_id', '=', auth()->id())->get();
        // $attendee = Attendee::with(['activities.city', 'user', 'city'])->get();
        // Activity::orderByDesc('created_at')->paginate(10)

        return inertia('Event/Index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Event/CreateEvent');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $activity = Event::create([
            'title' => $request->title,
            'city' => $request->city,
            'venue' => $request->venue,
            'slug' => Str::slug($request->title),
            'date' => Carbon::parse($request->heldAt),
            'time' => $request->time,
            'description' => $request->description,
            'type' => $request->type,
        ]);


        $user = UserInfo::where('user', '=', auth()->id())->first();
        // $activity->attendees()->attach($attendee->id);
        $activity->attendees()->create([
            'is_host' => true,
            'userinfo' => $user->id
        ]);

        Host::create([
            'event' => $activity->id,
            'userinfo' => $user->id
        ]);

        $act = Event::where('id', '=', $activity->id)
            ->with(['hostedBy.userinfo.user'])->first();

        broadcast(new CreateActivity($act))->toOthers();
        // CreateActivity::dispatch($activity);
        // return response()->json($activity);

        return to_route('userinfo.show', $user->id)
            ->with(['message' => 'Activity created Successfuly']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $event)
    {
        // $act = Activity::where('id', $activity)
        $act = Event::where('id', '=', $event)
            ->with('attendees.userinfo.user')
            ->with('hostedBy.userinfo.user')
            ->with('comments.userinfo.user')->first();
        // $act = $activity->with('attendees.user')->with('hostedBy.user')->first();
        // $act = Activity::firstWhere('id', '=', $id);
        // dd($act);
        return inertia('Event/SingleEvent', ['event' => $act]);
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
