<div>
    <form class="form-horizontal" wire:submit.prevent="updateProfile">
        <div class="row">
            <div class="col-md-8 mb-2">

                <x-adminlte-input wire:model="user.first_name" error-key="user.first_name" name="first_name" label="First Name" fgroup-class="form-group row" igroup-class="col-sm-10"
                                  placeholder="First Name" label-class="col-sm-2 col-form-label"/>

                <x-adminlte-input wire:model="user.last_name" error-key="user.last_name" name="last_name" label="Last Name" fgroup-class="form-group row" igroup-class="col-sm-10"
                                  placeholder="Last Name" label-class="col-sm-2 col-form-label"/>

                <x-adminlte-input wire:model="user.email" error-key="user.email" name="email" label="Email" fgroup-class="form-group row" igroup-class="col-sm-10"
                                  placeholder="Email" label-class="col-sm-2 col-form-label" readonly/>

                <x-adminlte-input-switch wire:model="changePass" name="change_pass" label="Change Password" fgroup-class="form-group row" igroup-class="col-sm-10"
                                         label-class="col-sm-2 col-form-label" data-on-color="success" data-on-text="YES" data-off-text="NO" data-off-color="danger"/>

                @if($changePass)
                    <x-adminlte-input wire:model="password" name="password" label="Password" type="password" fgroup-class="form-group row" igroup-class="col-sm-10"
                                     label-class="col-sm-2 col-form-label"/>
                    <x-adminlte-input wire:model="passwordConfirmation" name="password_confirmation" label="Password Confirm" type="password"
                                      fgroup-class="form-group row" igroup-class="col-sm-10" label-class="col-sm-2 col-form-label"/>
                @endif

                <div class="float-right d-md-block d-none">
                    <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
                </div>
            </div>

            <div class="col-md-4">
                <x-adminlte-profile-widget name="Profile Image" theme="teal" img="{{ $photo ? $photo->temporaryUrl() : auth()->user()->avatar()}}"
                                           alt="{{ auth()->user()->full_name }}" with-upload="photo">
                </x-adminlte-profile-widget>

                <div class="float-right d-sm-block d-md-none">
                    <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
                </div>
            </div>
        </div>
    </form>
</div>
