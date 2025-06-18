@props(['label' => null, 'name'])
<div class="form-check mb-3">
    <input type="checkbox" class="form-check-input @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $name }}" value="1">
    <label class="form-check-label" for="{{ $name }}">{{ $label ? $label : $name }}</label>
    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div> 