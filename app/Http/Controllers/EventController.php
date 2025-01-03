<?php

namespace App\Http\Controllers;

use App\Events\CreateActivity;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Host;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Str;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['attendees.userinfo.user', 'hostedBy.userinfo.user', 'comments', 'images'])->get();
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


        $manager = new ImageManager(new Driver());
        if ($request->hasFile('images')) {

            $images = $request->file('images');

            foreach ($images as $image) {

                $name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('images', $name, 'public');
                $$manager->read($image)->resize(615, 435)->toJpeg(80)->save();

                EventImage::create([
                    'filename' => $path,
                    'event_id' => $activity->id
                ]);
            }

        }
        $act = Event::where('id', '=', $activity->id)
            ->with(['hostedBy.userinfo.user'])->first();

        broadcast(new CreateActivity($act))->toOthers();
        // CreateActivity::dispatch($act);
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
            ->with(['attendees.userinfo.user', 'hostedBy.userinfo.user', 'comments.userinfo.user', 'images'])
            ->first();
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
