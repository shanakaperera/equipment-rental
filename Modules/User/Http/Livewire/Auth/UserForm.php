<?php

namespace Modules\User\Http\Livewire\Auth;

use Modules\Core\View\Components\Form\CheckBox;
use Modules\Core\View\Components\Form\Select;
use Modules\User\Entities\User;
use Modules\User\Entities\Permission;
use Modules\Core\Http\Livewire\AlertTrait;
use Modules\Core\View\Components\Form\View;
use Modules\Core\View\Components\Form\Input;
use Modules\Core\Http\Livewire\FormComponent;
use Modules\Core\View\Components\Form\Button;

class UserForm extends FormComponent
{
    use AlertTrait;

    public User $user;

    public function mount($model)
    {
        $this->horizontalForm = true;
        $this->formCol = "col-md-8";
        $this->user = $model;

        $existingPerms = $model->permissions->mapToGroups(function ($perm) {
            return [strtolower(substr(strrchr(rtrim($perm->ltpm, '\\'), '\\'), 1)) => $perm->name];
        })->map(function ($parent) {
            return $parent->mapWithKeys(function ($item) {
                return [$item => $item];
            });
        })->toArray();

        $this->data = array_merge($existingPerms, $model->only(['code', 'first_name', 'last_name', 'email', 'status']),
            ['role_id' => optional($this->user->roles()->first())->id]);

    }

    public function fields()
    {
        $fields = [
            Input::make('code', 'Code')->inline()->readonly(),
            Input::make('first_name', 'First Name')->inline(),
            Input::make('last_name', 'Last Name')->inline(),
            Input::make('email', 'Email')->inline()->readonly(),
            Select::make('role_id', 'User Role')
                ->options(roles(false, !auth()->user()->hasRole('developer')))
                ->inline()->withAttributes(['class' => 'form-control']),
            CheckBox::make('status', 'Status')->inline()->withAttributes(['class' => 'ml-1 mt-2'])
        ];

        if (user()->isAbleTo('create-user-role')) {
            array_push($fields, View::make('core::layouts.includes.title', ['title' => '<h3 style="margin-top: 30px">User Permissions</h3> <hr>']));
            $fields = array_merge($fields, Permission::permissionCheckBoxes());
        }

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
            'first_name' => 'required',
            'last_name'  => 'required',
        ];
    }

    public function submit()
    {
        $this->validate();

        $permissions = $this->dataExcept(['code', 'first_name', 'last_name', 'email', 'role_id', 'status']);

        if (user()->isAbleTo('create-user-role')) {
            $this->user->syncPermissions(array_keys(array_merge(... array_values($permissions))));
        }

        $this->user->update($this->dataOnly(['first_name', 'last_name', 'status']));

        $this->user->syncRoles([$this->data('role_id')]);

        $this->showSuccessToast("User updated successfully !");

    }
}
