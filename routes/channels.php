<?php

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user-follow.{id}', function ($user, int $id) {
    // return auth()->id() === User::find($id)->id;
    // return true;
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.User.{id}', function ($user, int $id) {
    // return auth()->id() === User::find($id)->id;
    // return true;
    return (int) $user->id === (int) $id;
});
