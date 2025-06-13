<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    //
    public function showChangeForm()
{
    return view('auth.change-password');
}

public function update(Request $request)
{
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = auth()->user();
    $user->password = Hash::make($request->password);
    $user->must_change_password = false;
    $user->save();

    return redirect('/Espaces')->with('success', 'Mot de passe mis à jour avec succès.');
}

}
