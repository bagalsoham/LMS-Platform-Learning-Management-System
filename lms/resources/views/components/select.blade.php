@props(['label' => null, 'name', 'options' => []])
<div class="mb-3">
    <label class="form-label">{{ $label ? $label : $name }}</label>
    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
    <select class="form-control @error($name) is-invalid @enderror" name="{{ $name }}">
        <option value="">Select {{ $label ? $label : $name }}</option>
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
        @endforeach
    </select>
</div> 