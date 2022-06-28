<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\EventUpdaterequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function store(CreateEventRequest $request)
    {

        $event = Event::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'location' => $request->location,
            'type' => $request->type,
            'price' => ($request->price) ?? 0,
            'status' => ($request->status) ?? 'active',
            'description' => $request->description,
            'slots' => $request->slots,
            'date' => Carbon::parse($request->date),
        ]);

        return JSON(CODE_CREATED, 'Event created successfully', new EventResource($event));
    }

    public function show()
    {
        $events = Auth::user()->events;

        return JSON(CODE_SUCCESS, "Events retrieved successfully.", EventResource::collection($events));
    }

    public function showForUser(User $user)
    {
        $events = $user->events;

        return JSON(CODE_SUCCESS, "Events retrieved successfully for a user.", EventResource::collection($events));
    }

    public function update(EventUpdaterequest $request, Event $event)
    {
        if (!Gate::allows('event-owner', $event)) {
            abort(CODE_FORBIDDEN, "You dont have permission to update this event");
        }

        $updated_event = $event->update([
            'name' => ($request->name) ?? $event->name,
            'location' => ($request->location) ?? $event->location,
            'type' => ($request->type) ?? $event->type,
            'price' => ($request->price) ?? $event->price,
            'status' => ($request->status) ?? $event->status,
            'description' => ($request->description) ?? $event->description,
            'slots' => ($request->slots) ?? $event->slots,
            'date' => Carbon::parse(($request->date) ?? $event->date),
        ]);

        abort_if(!$updated_event, CODE_BAD_REQUEST, "Unable to update event. Plesae try again");

        return JSON(CODE_SUCCESS, "Events has been updated successfully.", new EventResource($event));
    }

    public function delete(Event $event)
    {
        if (!Gate::allows('event-owner', $event)) {
            abort(CODE_FORBIDDEN, "You dont have permission to delete this event");
        }

        $delete_event = $event->delete();

        abort_if(!$delete_event, CODE_BAD_REQUEST, "Unable to delete event. Plesae try again");

        return JSON(CODE_SUCCESS, "Events has been deleted successfully.");
    }

    public function showAll()
    {
        $events = Event::paginate(10);

        return JSON(CODE_SUCCESS, "All events retrieved successfully.", EventResource::collection($events));
    }
}
