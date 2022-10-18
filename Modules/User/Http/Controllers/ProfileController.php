<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        $breadcrumbs = [['name' => 'Home', 'url' => route('dashboard')], ['name' => 'Profile', 'url' => '#']];

        return view('user::auth.profile', compact('breadcrumbs'));
    }
}
