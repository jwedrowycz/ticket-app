<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function update(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();
        auth()->user()->password = Hash::make($validated['password']);
        auth()->user()->created_at = Carbon::now();
        auth()->user()->save();

        return redirect()->route('home')->with('status', 'Hasło zostało pomyślnie zmienione');
    }
}
