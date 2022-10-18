<?php

namespace Modules\User\DataTables\Editor;

use Illuminate\Validation\Rule;
use Modules\User\Entities\User;
use Modules\User\Events\UserCreated;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Traits\UserSequenceManager;

class UserDataTableEditor extends DataTablesEditor
{
    use UserSequenceManager;

    protected $model = User::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:' . $this->resolveModel()->getTable(),
            'password'   => 'required|min:6|confirmed',
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'sometimes|required|email|' . Rule::unique($model->getTable())->ignore($model->getKey()),
            'password'   => 'sometimes|nullable|min:6|confirmed',
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

    /**
     * Event hook that is fired before creating a new record.
     *
     * @param \Illuminate\Database\Eloquent\Model $model Empty model instance.
     * @param array $data Attribute values array received from Editor.
     * @return array The updated attribute values array.
     */
    public function creating(Model $model, array $data)
    {
        $data['password'] = bcrypt($data['password']);

        $data['code'] = $this->getNextUserCode();

        return $data;
    }

    /**
     * Event hook that is fired after a new record is created.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The newly created model.
     * @param array $data Attribute values array received from `creating` or
     *   `saving` hook.
     * @return \Illuminate\Database\Eloquent\Model Since version 1.8.0 it must
     *   return the $model.
     */
    public function created(Model $model, array $data)
    {
        event(new UserCreated($model));

        return $model;
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
        if (empty(data_get($data, 'password'))) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        return $data;
    }
}
