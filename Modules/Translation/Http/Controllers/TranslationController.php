<?php

namespace Modules\Translation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Translation\Entities\TranslationLanguage;
use Modules\Translation\Datatables\TableView\TranslationDataTable;
use Modules\Translation\Datatables\Editor\TranslationDataTableEditor;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $lang
     * @param TranslationDataTable $dataTable
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index($lang, TranslationDataTable $dataTable)
    {
        $language = TranslationLanguage::where('slug', $lang)->first();

        $title = $language->lang_name . ' ' . trans_choice('translation::general.title', 2);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('dashboard')],
            ['name' => trans('translation::general.translation_languages'), 'url' => route('admin.translation-languages.index')],
            ['name' => $title, 'url' => '#']
        ];

        return $dataTable->render('translation::translations.index', compact('breadcrumbs', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param TranslationDataTableEditor $editorTable
     * @return \Illuminate\Http\Response
     * @throws \Yajra\DataTables\DataTablesEditorException
     */
    public function store(Request $request, TranslationDataTableEditor $editorTable)
    {
        return $editorTable->process($request);
    }
}
