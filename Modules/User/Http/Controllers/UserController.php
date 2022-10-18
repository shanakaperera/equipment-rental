<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\DataTables\Editor\UserDataTableEditor;
use Modules\User\DataTables\TableView\UserDataTable;
use Modules\User\Entities\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        $breadcrumbs = [['name' => 'Home', 'url' => route('dashboard')], ['name' => 'Users', 'url' => '#']];

        return $dataTable->render('user::users.index', compact('breadcrumbs'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param UserDataTableEditor $editorTable
     * @return \Illuminate\Http\Response
     * @throws \Yajra\DataTables\DataTablesEditorException
     */
    public function store(Request $request, UserDataTableEditor $editorTable)
    {
        return $editorTable->process($request);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \Modules\User\Entities\User $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(User $user)
    {
        if (!auth()->user()->hasRole('developer') && $user->hasRole('developer')) {
            return redirect()->route('admin.users.index');
        }

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('dashboard')],
            ['name' => 'Users', 'url' => route('admin.users.index')],
            ['name' => $user->full_name, 'url' => '#'],
        ];

        return view('user::users.edit', compact('user', 'breadcrumbs'));
    }


}
