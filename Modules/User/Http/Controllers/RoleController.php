<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\DataTables\TableView\RoleDataTable;
use Modules\User\DataTables\Editor\RoleDataTableEditor;
use Modules\User\Entities\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RoleDataTable $dataTable
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(RoleDataTable $dataTable)
    {
        $breadcrumbs = [['name' => 'Home', 'url' => route('dashboard')], ['name' => 'Roles', 'url' => '#']];

        return $dataTable->render('user::roles.index', compact('breadcrumbs'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param RoleDataTableEditor $editorTable
     * @return \Illuminate\Http\Response
     * @throws \Yajra\DataTables\DataTablesEditorException
     */
    public function store(Request $request, RoleDataTableEditor $editorTable)
    {
        return $editorTable->process($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Modules\User\Entities\Role $role
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Role $role)
    {
        if (!auth()->user()->hasRole('developer') && $role->name == 'developer') {
            return redirect()->route('admin.roles.index');
        }

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('dashboard')],
            ['name' => 'Roles', 'url' => route('admin.roles.index')],
            ['name' => $role->display_name, 'url' => '#'],
        ];

        return view('user::roles.edit', compact('role', 'breadcrumbs'));
    }
}
