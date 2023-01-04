@php $editing = isset($branchHour) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="day" label="Day">
            @php $selected = old('day', ($editing ? $branchHour->day : '')) @endphp
            <option value="sunday" {{ $selected == 'sunday' ? 'selected' : '' }} >Sunday</option>
            <option value="monday" {{ $selected == 'monday' ? 'selected' : '' }} >Monday</option>
            <option value="tuesday" {{ $selected == 'tuesday' ? 'selected' : '' }} >Tuesday</option>
            <option value="wednesday" {{ $selected == 'wednesday' ? 'selected' : '' }} >Wednesday</option>
            <option value="thursday" {{ $selected == 'thursday' ? 'selected' : '' }} >Thursday</option>
            <option value="friday" {{ $selected == 'friday' ? 'selected' : '' }} >Friday</option>
            <option value="saturday" {{ $selected == 'saturday' ? 'selected' : '' }} >Saturday</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="hour_start"
            label="Hour Start"
            :value="old('hour_start', ($editing ? $branchHour->hour_start : ''))"
            maxlength="255"
            placeholder="Hour Start"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $branchHour->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="hour_end"
            label="Hour End"
            :value="old('hour_end', ($editing ? $branchHour->hour_end : ''))"
            maxlength="255"
            placeholder="Hour End"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="branch_id" label="Branch" required>
            @php $selected = old('branch_id', ($editing ? $branchHour->branch_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Branch</option>
            @foreach($branches as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
