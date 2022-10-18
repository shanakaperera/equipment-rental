<?php

namespace Modules\User\Http\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Core\Http\Livewire\AlertTrait;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Hash;
use Modules\Media\Traits\MediaHandler;

class ProfileForm extends Component
{
    use WithFileUploads, MediaHandler, AlertTrait;

    public User $user;
    public $photo;
    public $password;
    public $passwordConfirmation;
    public $changePass = false;

    protected $rules = [
        'user.last_name'  => 'required',
        'user.first_name' => 'required',
        'user.email'      => 'required',
        'password'        => 'required_if:changePass,true|same:passwordConfirmation',
    ];

    protected $messages = [
        'password.required_if' => 'Password field is required'
    ];

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|mimes:jpg,jpeg,png|max:1024',
        ]);

    }

    public function updated()
    {
        if (!$this->changePass) {
            $this->password = null;
            $this->passwordConfirmation = null;
        }

        $this->validate();
    }

    public function mount()
    {
        $this->user = auth()->user();

    }

    public function updateProfile()
    {
        $this->validate();

        if ($this->photo) {

            $this->validate([
                'photo' => 'image|mimes:jpg,jpeg,png|max:1024',
            ]);

            $this->uploadAvatar($this->photo);

        }

        $this->user->save();

        if ($this->password) {
            $this->user->update(['password' => Hash::make($this->password)]);
            $this->changePass = false;
            $this->password = null;
            $this->passwordConfirmation = null;
        }

        $this->showSuccessToast('Saved successfully !');

    }

    public function render()
    {
        return view('user::livewire.auth.profile-form');
    }
}
