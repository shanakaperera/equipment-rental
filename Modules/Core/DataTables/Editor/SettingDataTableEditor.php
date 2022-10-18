<?php

namespace Modules\Core\DataTables\Editor;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\Setting;
use Yajra\DataTables\DataTablesEditor;

class SettingDataTableEditor extends DataTablesEditor
{
    protected $model = Setting::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            //'key'   => 'required|string|unique:' . $this->resolveModel()->getTable(),
            'key'   => 'required|string',
            'value' => 'required|string',
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
            //'key'   => 'required|string|unique:' . Rule::unique($model->getTable())->ignore($model->getKey()),
            'key'   => 'required|string',
            'value' => 'required|string',
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
}
