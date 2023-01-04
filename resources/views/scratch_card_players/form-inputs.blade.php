@php $editing = isset($scratchCardPlayer) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $scratchCardPlayer->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="scratch_card_id" label="Scratch Card" required>
            @php $selected = old('scratch_card_id', ($editing ? $scratchCardPlayer->scratch_card_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Scratch Card</option>
            @foreach($scratchCards as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="lead_id" label="Lead" required>
            @php $selected = old('lead_id', ($editing ? $scratchCardPlayer->lead_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Lead</option>
            @foreach($leads as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="winner"
            label="Winner"
            :checked="old('winner', ($editing ? $scratchCardPlayer->winner : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
