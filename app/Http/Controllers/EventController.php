<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $page_data['events'] = Event::select('id', 'title', 'start_date as start', 'end_date as end')->get();
        return view('event.index', $page_data);
    }

    public function create()
    {
        $page_data['date'] = request()->query('date');
        return view('event.create', $page_data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|string|max:255',
            'event_date_range' => 'required',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $event_date_range = explode(' - ', $request->event_date_range);
        $start_date = date('Y-m-d H:i:s', strtotime($event_date_range[0]));
        $end_date = date('Y-m-d H:i:s', strtotime($event_date_range[1]));

        $data['title']      = $request->title;
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;

        Event::insert($data);
        return response()->json([
            'success' => 'Event Created.',
        ]);
    }

    public function delete($id)
    {
        Event::where('id', $id)->delete();
        return response()->json([
            'success' => 'Event deleted.',
        ]);
    }

    public function edit(Request $request)
    {
        $data['event'] = Event::where('id', $request->event_id)->first();
        return view('event.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|string|max:255',
            'event_date_range' => 'required',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }
        
        $event_date_range = explode(' - ', $request->event_date_range);
        $start_date = date('Y-m-d H:i:s', strtotime($event_date_range[0]));
        $end_date = date('Y-m-d H:i:s', strtotime($event_date_range[1]));

        $data['title']      = $request->title;
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;

        Event::where('id', $request->id)->update($data);

        return response()->json([
            'success' => 'Event updated.',
        ]);
    }

}
