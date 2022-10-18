<?php

namespace Modules\Translation\Datatables\Editor;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTablesEditor;
use Modules\Translation\Entities\TranslationLanguage;

class TranslationLanguageDataTableEditor extends DataTablesEditor
{
    protected $model = TranslationLanguage::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'lang_name' => 'required',
            'slug'      => 'required|unique:' . $this->resolveModel()->getTable(),
        ];
    }

    /**
     * Get edit action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function editRules(Model $model)
    {
        return [
            'lang_name' => 'required',
            'slug'      => 'required|' . Rule::unique($model->getTable())->ignore($model->getKey()),
        ];
    }

    /**
     * Get remove action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function removeRules(Model $model)
    {
        return [];
    }

    protected function createMessages()
    {
        return [
            'lang_name.required' => 'Language name is required'
        ];
    }

    protected function editMessages()
    {
        return [
            'lang_name.required' => 'Language name is required'
        ];
    }
}
