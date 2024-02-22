@props(['error'])

@error($error)
    <p class="form-error">{{ $message }}</p>
@enderror
