<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        return view('maintenance.index');
    }

    public function admin()
    {
        return view('maintenance.admin');
    }

    public function setAdmin(Request $request)
    {
        $configuration = Configuration::where('name', '=', 'maintenance-mode')
            ->first();
        $message = "";
        if ($request->input('maintenance')) {
            $configuration->value = true;
            $message = "Successfully enabled maintenance mode";
        } else {
            $configuration->value = false;
            $message = "Successfully disabled maintenance mode";
        }
        //$configuration->value = $request->input('maintenance');
        $configuration->save();

        return redirect()
            ->route('maintenance.admin')
            ->with('success', $message);
    }
}
