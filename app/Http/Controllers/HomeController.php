<?php

namespace App\Http\Controllers;

use App\Models\{Plan, User};
use Illuminate\Http\{Request, RedirectResponse};

class HomeController extends Controller
{
    public function authorize(Request $request): RedirectResponse
    {
        $user = User::firstOrCreate(['username' => $request->input('username')]);

        // Assign free plan if new user or no active histories
        if ($user->wasRecentlyCreated || !$user->miningHistories()->exists()) {
            Plan::where('is_default', true)->first()?->histories()->create([
                'user_id'     => $user->id,
                'status'      => 'active',
                'expire_date' => time() + 604800, // 7 days in seconds
                'last_sum'    => time()
            ]);
        }

        return redirect('dashboard')->with('user_data', $user);
    }

    public function logout(): RedirectResponse
    {
        session()->flush();
        return redirect('/');
    }
}
