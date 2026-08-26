<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = User::find(session('user_data.id'));
        
        if (!$user) return redirect('/');

        // Orchestrate background tasks
        $user->expirePlans();
        $user->syncBalance();

        return view('dashboard', [
            'address'           => $user->username,
            'balance'           => number_format($user->balance, 8, '.', ''),
            'acplans'           => $user->activePlans(),
            'user_earning_rate' => $user->getTotalEarningRate()
        ]);
    }
}
