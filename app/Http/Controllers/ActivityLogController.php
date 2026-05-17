<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Gate::authorize('admin');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('causer')) {
            $query->where('causer_id', $request->causer)
                  ->where('causer_type', User::class);
        }

        if ($request->filled('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        $logs    = $query->paginate(30)->withQueryString();
        $users   = User::orderBy('name')->get();
        $logNames = Activity::distinct()->pluck('log_name');

        return view('logs.index', compact('logs', 'users', 'logNames'));
    }

    public function show(Activity $log)
    {
        return view('logs.show', compact('log'));
    }
}
