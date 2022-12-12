<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Lookup;
use App\Models\User;
use App\Services\LookupService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function index()
    {
        return view('user.index_user', [
            'users' => User::all(),
        ]);
    }

    public function create()
    {
        return view('user.create_user', [
            'roles' => LookupService::getCategoryBy(Lookup::ROLES),
        ]);
    }

    public function edit(User $user)
    {
        return view('user.edit_user', [
            'user' => $user,
            'roles' => LookupService::getCategoryBy(Lookup::ROLES),
        ]);
    }

    public function store(UserRequest $request)
    {
        $objResult = $this->userService->createUser((object) $request->validated());
        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }
        return redirect()->route('users.index')->with('success', $objResult->Message);
    }

    public function update(UserRequest $request, User $user)
    {
        $objParam = [
            'name', 'email', 'role'
        ];
        if ($request->filled('password')) {
            $objParam[] = 'password';
        }
        $objResult = $this->userService->updateUser((object) $request->only($objParam), $user->id);
        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }
        return redirect()->route('users.edit', $user->id)->with('success', $objResult->Message);
    }

    public function delete(User $user)
    {
        $objResult = $this->userService->deleteUser($user->id);
        if (!$objResult->Status) {
            return back()->with('error', $objResult->Message);
        }
        return redirect()->route('users.index')->with('success', $objResult->Message);
    }
}
