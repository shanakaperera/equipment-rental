<?php

namespace Modules\Core\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class FormComponent extends Component
{
    public $title = "";
    public $layout;
    public $data = [];
    public $horizontalForm = true;
    public $formCol = "";

    public function render()
    {
        return view('core::livewire.form-component')
            ->layout($this->layout ?? config('livewire.layout'));
    }

    public function data($key, $default = null)
    {
        return Arr::get($this->data, $key, $default);
    }

    public function dataOnly($keys)
    {
        return Arr::only($this->data, $keys);
    }

    public function dataExcept($keys)
    {
        return Arr::except($this->data, $keys);
    }

    public function fields()
    {
        return [];
    }

    public function buttons()
    {
        return [];
    }

    public function validate($rules = null, $messages = [], $attributes = [])
    {
        $validator = Validator::make($this->data, $rules ?? $this->getRules(), $messages, $attributes);
        $validatedData = $validator->validate();

        $this->resetErrorBag();

        return $validatedData;
    }

    public function addArrayableItem($name)
    {
        $array = $this->data($name);
        $key = $array ? max(array_keys($array)) + 1 : 0;

        Arr::set($this->data, $name . '.' . $key, []);
    }

    public function removeArrayableItem($key)
    {
        Arr::forget($this->data, $key);
    }
}
