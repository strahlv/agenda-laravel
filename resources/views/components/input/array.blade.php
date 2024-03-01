@props(['type' => 'text', 'name', 'label' => ''])

@php
    $id = str_replace('_', '-', $name);
@endphp

<div class="flex-col form-input" x-data="{ items: [] }">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <input type="hidden" name="{{ $name }}" :value="items">

    <input type="text" @@input.debounce="fetchEmails">

    <textarea name="{{ $name }}_input" id="{{ $id }}" cols="30" rows="1" style="padding: 8px"
        @@keyup.enter="items.push((event.target.value).replaceAll('\n','')); event.target.value = ''"></textarea>

    <div class="flex-row flex-wrap gap-10">
        <template x-for="(item, index) in items" :key="index">
            <div style="padding: 4px; background-color: var(--clr-primary-lt)">
                <span x-text="item"></span><button type="button" {{-- @@click="items = items.filter((i) => i != item)">X</button> --}}
                    @@click="items = removeItem(item, items)">X</button>
            </div>
        </template>
    </div>
</div>

<script>
    function removeItem(itemToRemove, array) {
        return array.filter((item) => item != itemToRemove)
    }

    function fetchEmails() {
        // $.ajax('/');
    }
</script>
