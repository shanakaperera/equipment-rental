<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\DataTables\Editor\PermissionDataTableEditor;
use Modules\User\DataTables\TableView\PermissionDataTable;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param PermissionDataTable $dataTable
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(PermissionDataTable $dataTable)
    {
        $breadcrumbs = [['name' => 'Home', 'url' => route('dashboard')], ['name' => 'Permissions', 'url' => '#']];

        return $dataTable->render('user::permissions.index', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param PermissionDataTableEditor $editorTable
     * @return \Illuminate\Http\Response
     * @throws \Yajra\DataTables\DataTablesEditorException
     */
    public function store(Request $request, PermissionDataTableEditor $editorTable)
    {
        return $editorTable->process($request);
    }

}
