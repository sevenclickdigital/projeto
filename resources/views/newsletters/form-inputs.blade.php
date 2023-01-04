@php $editing = isset($newsletter) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $newsletter->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="active"
            label="Active"
            :checked="old('active', ($editing ? $newsletter->active : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="sent"
            label="Sent"
            :checked="old('sent', ($editing ? $newsletter->sent : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($newsletter->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="time"
            label="Time"
            :value="old('time', ($editing ? $newsletter->time : ''))"
            maxlength="255"
            placeholder="Time"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="subject"
            label="Subject"
            :value="old('subject', ($editing ? $newsletter->subject : ''))"
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
            >{{ old('content', ($editing ? $newsletter->content : ''))
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
                :checked="isset($newsletter) ? $newsletter->branches()->where('id', $branch->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
