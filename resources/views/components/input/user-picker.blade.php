@props(['type' => 'text', 'name', 'label' => '', 'placeholder' => ''])

@php
    $id = str_replace('_', '-', $name);
@endphp

<div id="user-picker" class="flex-col form-input" x-data="{
    items: [],
    options: [],
    search: '',
    status: 'pending',
    currEmail: '{{ auth()->user()?->email }}'
}"
    @@edit_event.window="items = $event.detail">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <input type="hidden" name="{{ $name }}" :value="items.map(item => item.email)">

    <input type="text" placeholder="{{ $placeholder }}" x-model="search"
        @@input.debounce="await fetchEmails($data)">

    <div class="flex-col">
        <div class="flex-col user-picker-option-contents" x-show="options.length > 0" x-transition>
            <template x-for="(option, index) in options" :key="index">
                <div class="user-picker-option"
                    @@click="items.push(option); options = options.filter((op) => op != option)">
                    <div class="flex-col">
                        <span x-text="option.name"></span>
                        <span class="text-sm" x-text="option.email"></span>
                    </div>
                </div>
            </template>
        </div>
        <div class="user-picker-option-contents" x-show="status != 'pending' && search != '' && options.length === 0">
            <span class="user-picker-participant-count">
                (Nenhum usuário encontrado.)
        </div>
        </span>
        <span class="user-picker-participant-count" x-show="items.length > 0"
            x-text="`${items.length} participante(s)`"></span>
        <div class="flex-col" x-show="items.length > 0">
            <template x-for="(item, index) in items" :key="index">
                <div class="user-picker-item opaque-on-hover-trigger">
                    <div class="flex-col">
                        <span x-text="currEmail === item.email ? 'Você (' + item.name + ')' : item.name"></span>
                        <span class="text-sm" x-text="item.email"></span>
                    </div>
                    <button type="button" class="btn btn-icon-sm btn-remove-participant opaque-on-hover"
                        @@click="items = removeItem(item, items)"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
            </template>
        </div>
    </div>
</div>
