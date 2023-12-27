<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\PublicModel;
use App\Models\ContestModel;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $activeTab = request('tab', 'publics');

        // Fetch other necessary data
        $publics = PublicModel::all();
        $contests = ContestModel::all();

        // Pass data to the view
        return view('dashboard', [
            'activeTab' => $activeTab,
            'publics' => $publics,
            'contests' => $contests,
        ]);
    }
    
    public function someAction()
    {
        // Perform some action, and then redirect to the dashboard with the 'publics' tab active
        // For example, after submitting a form
        // ...
        return redirect()->route('dashboard', ['tab' => 'publics']);
    }
}
