@props(['label' => null, 'name', 'placeholder' => null])
<div class="mb-3">
    <label class="form-label">{{ $label ? $label : $name}}</label>
    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
    <input type="text" class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" placeholder="{{ $placeholder }}">
</div>
