@php $editing = isset($ratingGoogleBusiness) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $ratingGoogleBusiness->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $ratingGoogleBusiness->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="text" label="Text" maxlength="255"
            >{{ old('text', ($editing ? $ratingGoogleBusiness->text : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="stars" label="Stars">
            @php $selected = old('stars', ($editing ? $ratingGoogleBusiness->stars : '')) @endphp
            <option value="one_star" {{ $selected == 'one_star' ? 'selected' : '' }} >One star</option>
            <option value="two_stars" {{ $selected == 'two_stars' ? 'selected' : '' }} >Two stars</option>
            <option value="three_stars" {{ $selected == 'three_stars' ? 'selected' : '' }} >Three stars</option>
            <option value="four_stars" {{ $selected == 'four_stars' ? 'selected' : '' }} >Four stars</option>
            <option value="five_stars" {{ $selected == 'five_stars' ? 'selected' : '' }} >Five stars</option>
        </x-inputs.select>
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
                :checked="isset($ratingGoogleBusiness) ? $ratingGoogleBusiness->branches()->where('id', $branch->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
