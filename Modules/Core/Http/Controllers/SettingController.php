<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\DataTables\Editor\SettingDataTableEditor;
use Modules\Core\DataTables\TableView\SettingsDataTable;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SettingsDataTable $dataTable
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(SettingsDataTable $dataTable)
    {
        $breadcrumbs = [['name' => 'Home', 'url' => route('dashboard')], ['name' => 'Settings', 'url' => '#']];

        return user()->isAbleTo('view-system-variable') ?
            $dataTable->render('core::settings.index', compact('breadcrumbs')) :
            redirect()->route('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param SettingDataTableEditor $editorTable
     * @return \Illuminate\Http\Response
     * @throws \Yajra\DataTables\DataTablesEditorException
     */
    public function store(Request $request, SettingDataTableEditor $editorTable)
    {
        return $editorTable->process($request);
    }

}
