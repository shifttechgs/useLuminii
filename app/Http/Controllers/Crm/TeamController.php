<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Mail\TeamMemberInvite;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::with('user')->orderBy('created_at', 'desc')->get();
        return view('crm.team.index', compact('members'));
    }

    public function create()
    {
        return view('crm.team.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'role'      => 'required|in:Admin,SalesRep,Technician,Engineer,Accountant,Support',
            'job_title' => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:30',
        ]);

        $tempPassword = Str::random(12);

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($tempPassword),
            'role'      => $data['role'],
            'phone'     => $data['phone'] ?? null,
            'is_active' => true,
        ]);

        $member = TeamMember::create([
            'user_id'    => $user->id,
            'role'       => $data['role'],
            'job_title'  => $data['job_title'] ?? null,
            'phone'      => $data['phone'] ?? null,
            'is_active'  => true,
            'invited_at' => now(),
        ]);

        Mail::to($user->email)->send(new TeamMemberInvite($user, $tempPassword));

        return redirect()->route('crm.team.index')->with('success', "Invite sent to {$user->email}.");
    }

    public function edit(TeamMember $teamMember)
    {
        $teamMember->load('user');
        return view('crm.team.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $data = $request->validate([
            'role'      => 'required|in:Admin,SalesRep,Technician,Engineer,Accountant,Support',
            'job_title' => 'nullable|string|max:255',
            'phone'     => 'nullable|string|max:30',
            'is_active' => 'boolean',
        ]);

        $teamMember->update($data + ['is_active' => $request->boolean('is_active')]);
        $teamMember->user->update(['role' => $data['role'], 'is_active' => $request->boolean('is_active')]);

        return redirect()->route('crm.team.index')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->update(['is_active' => false]);
        $teamMember->user->update(['is_active' => false]);
        return redirect()->route('crm.team.index')->with('success', 'Team member deactivated.');
    }

    public function resendInvite(TeamMember $teamMember)
    {
        $teamMember->load('user');
        $tempPassword = Str::random(12);
        $teamMember->user->update(['password' => Hash::make($tempPassword), 'invited_at' => now()]);
        Mail::to($teamMember->user->email)->send(new TeamMemberInvite($teamMember->user, $tempPassword));
        return back()->with('success', 'Invite resent.');
    }
}

