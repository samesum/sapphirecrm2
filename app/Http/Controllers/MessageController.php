<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function message($message_thread_code = "")
    {
        if( $message_thread_code == "") {
            $thread_details = MessageThread::where('contact_one', auth()->user()->id)->orWhere('contact_two', auth()->user()->id)->orderBy('id', 'desc')->firstOrNew();
        }else{
            $thread_details = MessageThread::where('code', $message_thread_code)->firstOrNew();
        }


        $page_data['thread_code']    = $thread_details->code;
        $page_data['thread_details'] = $thread_details;

        if ($message_thread_code != '') {
            Message::where('thread_id', $page_data['thread_details']->id)->where('read', '!=', '1')->update(['read' => 1]);
        }

        return view('message.message', $page_data);
    }

    public function message_new()
    {
        return view('message.message_new');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message'     => 'required',
            'sender_id'   => 'required|integer|exists:App\Models\User,id',
            'receiver_id' => 'required|integer|exists:App\Models\User,id',
            'thread_id'   => 'required|integer',
        ]);

        $data['message']     = $request->message;
        $data['sender_id']   = $request->sender_id;
        $data['receiver_id'] = $request->receiver_id;
        $data['thread_id']   = $request->thread_id;
        $data['created_at']  = date('Y-m-d H:i:s');
        $data['read']        = null;

        Message::insert($data);

        $message_thread = MessageThread::find($request->thread_id)->code;

        Session::flash('success', get_phrase('Message Sent'));
        return redirect(route(get_current_user_role().'.message', ['message_thread' => $message_thread]));
    }

    public function thread_store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|integer|exists:App\Models\User,id',
        ]);

        $data['contact_one'] = Auth::user()->id;
        $data['contact_two'] = $request->receiver_id;
        $data['code']        = Str::random(20);
        $data['created_at']  = date('Y-m-d H:i:s');

        MessageThread::insert($data);

        Session::flash('success', get_phrase('Message thread created'));
        return redirect(route(get_current_user_role().'.message', ['message_thread' => $data['code']]));
    }

    public function searchThreads(Request $request)
    {
        $user_id_arr = array();
        $user_id     = $request->user()->id;
        $search      = $request->input('search');

        $users = User::where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->limit(50)->get();
        foreach ($users as $users) {
            $user_id_arr[] = $users->id;
        }

        $messageThreads = MessageThread::where(function ($query) use ($user_id_arr) {
            $query->whereIn('sender', $user_id_arr)->where('receiver', Auth::user()->id);
        })
            ->orWhere(function ($query) use ($user_id_arr) {
                $query->whereIn('receiver', $user_id_arr)->where('sender', Auth::user()->id);
            })
            ->get();

        $page_data['message_threads'] = $messageThreads;
        $page_data['search']          = $search;
        $page_data['thread']          = $request->thread;

        return view('message.message_left_side_bar', $page_data);
    }
}
