@props([
    'label',
    'id',
    'name',
    'placeholder' => null,
    'hiddenPlaceholder' => false,
    'required' => false,
])

<div class="input-wrapper">
    <label for="{{ $id }}">
        {{ $label }}

        @if($required)
            <span class="required">*</span>
        @endif
    </label>

    <select
        id="{{ $id }}"
        @class(['invalid' => $errors->has($name)])
        wire:model.live.change="{{ $name }}"
    >
        @if($placeholder)
            <option value="" {{ $hiddenPlaceholder ? 'hidden' : '' }}>
                {{ $placeholder }}
            </option>
        @endif

        {{ $slot }}
    </select>

    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>
