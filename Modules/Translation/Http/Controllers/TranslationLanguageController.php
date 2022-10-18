<?php

namespace Modules\Translation\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Translation\Datatables\Editor\TranslationLanguageDataTableEditor;
use Modules\Translation\Datatables\TableView\TranslationLanguageDataTable;

class TranslationLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TranslationLanguageDataTable $dataTable
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(TranslationLanguageDataTable $dataTable)
    {
        $breadcrumbs = [['name' => 'Home', 'url' => route('dashboard')], ['name' => 'Translation Languages', 'url' => '#']];

        return $dataTable->render('translation::translation-languages.index', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param TranslationLanguageDataTableEditor $editorTable
     * @return \Illuminate\Http\Response
     * @throws \Yajra\DataTables\DataTablesEditorException
     */
    public function store(Request $request, TranslationLanguageDataTableEditor $editorTable)
    {
        return $editorTable->process($request);
    }
}
