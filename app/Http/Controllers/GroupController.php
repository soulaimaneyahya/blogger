<?php

namespace App\Http\Controllers;

use App\Models\Group;

use Illuminate\Contracts\View\View;

class GroupController extends Controller
{
    public function index(): View
    {
        $per_page = request('per_page') ?? 10;
        $groups = Group::with('members')
            ->select(['id', 'name', 'description', 'created_at'])
            ->withCount('members')
            ->paginate($per_page) // page = 1
            ->appends([
                'per_page' => $per_page, // & per_page=10
            ]);
        return view('groups.index', compact('groups'));
    }

    public function show(Group $group): View
    {
        $group = Group::with('members')->select(['id', 'name', 'description', 'created_at'])->withCount('members')->find($group->id);
        return view('groups.show', compact('group'));
    }
}