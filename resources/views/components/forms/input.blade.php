@props(['label', 'type', 'id', 'name', 'placeholder', 'required' => false])

<div class="input-wrapper">
    <label for="{{ $id }}">
        {{ $label }}

        @if($required)
            <span class="required">*</span>
        @endif
    </label>

    <input
        type="{{ $type }}"
        id="{{ $id }}"
        @class(['invalid' => $errors->has($name)])
        placeholder="{{ $placeholder }}"
        wire:model.live.blur="{{ $name }}"
    >

    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>
