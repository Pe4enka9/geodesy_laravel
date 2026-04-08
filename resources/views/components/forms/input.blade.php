@props([
    'label',
    'type',
    'id',
    'name',
    'placeholder' => '',
    'required' => false,
    'password' => false,
])

<div class="input-wrapper">
    <label for="{{ $id }}">
        {{ $label }}

        @if($required)
            <span class="required">*</span>
        @endif

        @if($password)
            <div class="input-wrapper__password">(оставьте пустым, чтобы не менять)</div>
        @endif
    </label>

    <input
        type="{{ $type }}"
        id="{{ $id }}"
        @class(['invalid' => $errors->has($name)])
        placeholder="{{ $placeholder }}"
        wire:model.live.debounce.250ms="{{ $name }}"
    >

    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>
