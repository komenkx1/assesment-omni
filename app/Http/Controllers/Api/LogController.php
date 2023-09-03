<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index()
    {
        $log = Activity::all();
        $log->map(function ($item) {
            $item->causer = User::find($item->causer_id)?->name ?? '-';
            return $item;
        });
        return $this->responseMessage($log, true);
    }
}
