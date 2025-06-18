@props(['label' => null, 'name','checked'=>false])
<div class="form-check form-switch mb-3">
    <input type="checkbox" class="form-check-input @error($name) is-invalid @enderror" name="{{ $name }}" value="1" id="{{ $name }}" @checked($checked)>
    <label class="form-check-label" for="{{ $name }}">{{ $label ? $label : $name }}</label>
    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>
