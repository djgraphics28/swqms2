<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('dashboard', function ($user) {
    return true;
});
