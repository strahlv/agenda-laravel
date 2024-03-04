@props(['type' => 'text', 'name', 'label' => ''])

@php
    $id = str_replace('_', '-', $name);
@endphp

<div id="user-picker" class="flex-col form-input" x-data="{ items: [], options: [], search: '', status: 'pending' }"
    @@edit_event.window="items = $event.detail.map(p => p.email)">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <input type="hidden" name="{{ $name }}" :value="items">

    <input type="text" x-model="search" @@input.debounce="await fetch($data)">

    <div class="flex-col user-picker">
        <div class="flex-col" x-show="options.length > 0">
            <template x-for="(option, index) in options" :key="index">
                <div class="user-picker-option"
                    @@click="items.push(option); options = options.filter((op) => op != option)">
                    <span x-text="option"></span>
                </div>
            </template>
        </div>
        <span x-show="status != 'pending' && search != '' && options.length === 0">
            Nenhum usuário encontrado.
        </span>
        <div class="flex-col" x-show="items.length > 0">
            <template x-for="(item, index) in items" :key="index">
                <div class="user-picker-item opaque-on-hover-trigger">
                    <span x-text="item"></span><button type="button" class="btn btn-icon-sm opaque-on-hover"
                        @@click="items = removeItem(item, items)"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    function removeItem(itemToRemove, array) {
        return array.filter((item) => item != itemToRemove)
    }

    // async function fetchEmails(email) {
    //     status = 'pending';

    //     if (email === '') {
    //         return [];
    //     }

    //     var data = await $.get(`/users?email=${email}`);
    //     status = 'idle';
    //     return data.map((item) => item.email);
    // }

    async function fetch(data) {
        data.status = 'pending';

        if (data.search === '') {
            data.options = [];
            data.status = 'idle';
            return;
        }

        var responseData = await $.get(`/users?email=${data.search}`);
        data.options = responseData
            .map(item => item.email)
            .filter(item => !data.items.includes(item))

        data.status = 'idle';
    }
</script>
