@php $editing = isset($holidayDescription) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $holidayDescription->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="holiday_id" label="Holiday" required>
            @php $selected = old('holiday_id', ($editing ? $holidayDescription->holiday_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Holiday</option>
            @foreach($holidays as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="active"
            label="Active"
            :checked="old('active', ($editing ? $holidayDescription->active : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="when_send" label="When Send">
            @php $selected = old('when_send', ($editing ? $holidayDescription->when_send : 'one_day')) @endphp
            <option value="one_day" {{ $selected == 'one_day' ? 'selected' : '' }} >One day</option>
            <option value="two_days" {{ $selected == 'two_days' ? 'selected' : '' }} >Two days</option>
            <option value="three_days" {{ $selected == 'three_days' ? 'selected' : '' }} >Three days</option>
            <option value="four_days" {{ $selected == 'four_days' ? 'selected' : '' }} >Four days</option>
            <option value="five_days" {{ $selected == 'five_days' ? 'selected' : '' }} >Five days</option>
            <option value="one_week" {{ $selected == 'one_week' ? 'selected' : '' }} >One week</option>
            <option value="two_weeks" {{ $selected == 'two_weeks' ? 'selected' : '' }} >Two weeks</option>
            <option value="one_month" {{ $selected == 'one_month' ? 'selected' : '' }} >One month</option>
            <option value="in_day" {{ $selected == 'in_day' ? 'selected' : '' }} >In day</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="time"
            label="Time"
            :value="old('time', ($editing ? $holidayDescription->time : ''))"
            maxlength="255"
            placeholder="Time"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="subject"
            label="Subject"
            :value="old('subject', ($editing ? $holidayDescription->subject : ''))"
            maxlength="255"
            placeholder="Subject"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="content"
            label="Content"
            maxlength="255"
            required
            >{{ old('content', ($editing ? $holidayDescription->content : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.branches.name')</h4>

        @foreach ($branches as $branch)
        <div>
            <x-inputs.checkbox
                id="branch{{ $branch->id }}"
                name="branches[]"
                label="{{ ucfirst($branch->name) }}"
                value="{{ $branch->id }}"
                :checked="isset($holidayDescription) ? $holidayDescription->branches()->where('id', $branch->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
