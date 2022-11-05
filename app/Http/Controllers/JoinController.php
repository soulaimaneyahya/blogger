<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class JoinController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Group $group)
    {
        auth()->user()->join()->toggle($group);
        return redirect()->route('groups.show', $group);
    }
}
