<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;

class PusherAuthController extends Controller
{
    public function auth(Request $request)
    {
        $socketId = $request->input('socket_id');
        $channelName = $request->input('channel_name');

        // Configure your Pusher credentials
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id')
        );

        // Generate the auth signature
        $auth = $pusher->socket_auth($channelName, $socketId);

        return $auth;
    }
}
