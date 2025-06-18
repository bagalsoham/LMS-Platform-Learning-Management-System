@props(['label' => null, 'name', 'placeholder' => null,'value'=>'value'])
<div class="mb-3">
    <label class="form-label">{{ $label ? $label : $name}}</label>
    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
    <input type="text" class="form-control @error($name) is-invalid @enderror" value="{{ $value }}" name="{{ $name }}" placeholder="{{ $placeholder }}">
</div>
