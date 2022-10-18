<?php

namespace Modules\User\DataTables\Editor;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Permission;
use Yajra\DataTables\DataTablesEditor;

class PermissionDataTableEditor extends DataTablesEditor
{
    protected $model = Permission::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'name'         => 'required|unique:' . $this->resolveModel()->getTable(),
            'display_name' => 'required',
            'ltpm'         => 'required',
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
            'name'         => 'required|' . Rule::unique($model->getTable())->ignore($model->getKey()),
            'display_name' => 'required',
            'ltpm'         => 'required',
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
            'ltpm.required' => 'Model is required'
        ];
    }

    protected function editMessages()
    {
        return [
            'ltpm.required' => 'Model is required'
        ];
    }

    /**
     * Event hook that is fired before creating a new record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Empty model instance.
     * @param array $data Attribute values array received from Editor.
     * @return array The updated attribute values array.
     */
    public function creating(Model $model, array $data)
    {
        // Code can change the attribute values array before saving data to the
        // database.
        // Can be used to initialize values on new model.

        // Since arrays are copied when passed by value, the function must return
        // the updated $data array
        return $data;
    }

    /**
     * Event hook that is fired before updating an existing record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Model instance retrived
     *  retrived from database.
     * @param array $data Attribute values array received from Editor.
     * @return array The updated attribute values array.
     */
    public function updating(Model $model, array $data)
    {
        // Can be used to modify the attribute values received from Editor before
        // applying changes to model.

        // Since arrays are copied when passed by value, the function must return
        // the updated $data array
        return $data;
    }
}
