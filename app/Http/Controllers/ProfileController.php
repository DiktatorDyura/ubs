<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        //bilgi değiştirme sayfasına yönlendir
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        //kullanıcı bilgileri güncellenir
        $request->user()->fill($request->validated());

        //eğer öğrenci numarası değişirse email doğrulaması yapılır
        if ($request->user()->isDirty('studentNumber')) {
            $request->user()->email_verified_at = null;
        }

        //kullanıcı bilgileri kaydedilir
        $request->user()->save();

        //bilgi değiştirme sayfasına yönlendirme
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        //kullanıcı hesabını silme işlemi
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        //kullanıcı bilgileri alınır
        $user = $request->user();

        //kullanıcı oturumu kapatılır
        Auth::logout();

        //kullanıcı hesabı silinir
        $user->delete();

        //kullanıcı oturumu kapatılır
        $request->session()->invalidate();
        //csrf token yenilenir
        $request->session()->regenerateToken();

        //ana sayfaya yönlendirme
        return Redirect::to('/');
    }
}
