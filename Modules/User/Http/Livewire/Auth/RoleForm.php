<?php

namespace Modules\User\Http\Livewire\Auth;

use Modules\User\Entities\Role;
use Modules\User\Entities\Permission;
use Modules\Core\Http\Livewire\AlertTrait;
use Modules\Core\View\Components\Form\View;
use Modules\Core\View\Components\Form\Input;
use Modules\Core\Http\Livewire\FormComponent;
use Modules\Core\View\Components\Form\Button;

class RoleForm extends FormComponent
{
    use AlertTrait;

    public Role $role;

    public function mount($model)
    {
        $this->horizontalForm = true;
        $this->formCol = "col-md-8";
        $this->role = $model;

        $existingPerms = $model->permissions->mapToGroups(function ($perm) {
            return [strtolower(substr(strrchr(rtrim($perm->ltpm, '\\'), '\\'), 1)) => $perm->name];
        })->map(function ($parent) {
            return $parent->mapWithKeys(function ($item) {
                return [$item => $item];
            });
        })->toArray();

        $this->data = array_merge($existingPerms, $model->only(['name', 'display_name', 'description']));

    }

    public function fields()
    {
        $fields = [
            Input::make('name', 'Name')->inline(),
            Input::make('display_name', 'Display Name')->inline(),
            Input::make('description', 'Description')->inline(),
            View::make('core::layouts.includes.title', ['title' => '<h3 style="margin-top: 30px">Role Permissions</h3> <hr>'])
        ];

        $fields = array_merge($fields, Permission::permissionCheckBoxes());

        return $fields;
    }

    public function buttons()
    {
        return [
            Button::make('Submit', 'success')->withAttributes(['class' => 'btn-flat'])
                ->icon('fas fa-lg fa-save')->click('submit'),
        ];
    }

    public function rules()
    {
        return [
            'name'         => 'required',
            'display_name' => 'required',
        ];
    }

    public function submit()
    {
        $this->validate();

        $permissions = $this->dataExcept(['name', 'display_name', 'description']);

        $this->role->syncPermissions(array_keys(array_merge(... array_values($permissions))));

        $this->role->update($this->dataOnly(['name', 'display_name', 'description']));

        $this->showSuccessToast("Role updated successfully !");

    }
}
