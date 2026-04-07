@props(['label', 'id', 'name', 'placeholder', 'required' => false])

<div class="input-wrapper">
    <label for="{{ $id }}">
        {{ $label }}

        @if($required)
            <span class="required">*</span>
        @endif
    </label>

    <textarea
        id="{{ $id }}"
        @class(['invalid' => $errors->has($name)])
        placeholder="{{ $placeholder }}"
        wire:model.live.blur="{{ $name }}"
    ></textarea>

    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>
