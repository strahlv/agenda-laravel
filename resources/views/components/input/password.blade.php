@props(['name', 'label' => ''])

<div class="flex-col form-input" x-data="{ passwordVisible: false }">
    <x-input.index ::type="passwordVisible ? 'text' : 'password'" name="{{ $name }}" label="{{ $label }}" />

    <button type="button" class="btn btn-icon password-toggle"
        @@click="passwordVisible = !passwordVisible"><i class="fa-solid"
            :class="passwordVisible ? 'fa-eye-slash' : 'fa-eye'"></i></button>
</div>
