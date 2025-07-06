<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MaterialDesignController extends Controller
{
    /**
     * Toggle between original and Material Design versions
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleDesign(Request $request)
    {
        $currentDesign = Session::get('design_version', 'original');
        $newDesign = $currentDesign === 'original' ? 'material' : 'original';
        
        Session::put('design_version', $newDesign);
        
        return back()->with('success', 'Design switched to ' . ucfirst($newDesign) . ' version');
    }
}
