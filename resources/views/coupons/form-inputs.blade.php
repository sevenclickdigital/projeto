@php $editing = isset($coupon) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $coupon->tenant_id : '')) @endphp
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
            :checked="old('active', ($editing ? $coupon->active : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="title"
            label="Title"
            :value="old('title', ($editing ? $coupon->title : ''))"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $coupon->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="code"
            label="Code"
            :value="old('code', ($editing ? $coupon->code : ''))"
            maxlength="255"
            placeholder="Code"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="coupon_type" label="Coupon Type">
            @php $selected = old('coupon_type', ($editing ? $coupon->coupon_type : 'default')) @endphp
            <option value="default" {{ $selected == 'default' ? 'selected' : '' }} >Default</option>
            <option value="first_order" {{ $selected == 'first_order' ? 'selected' : '' }} >First order</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="limit"
            label="Limit"
            :value="old('limit', ($editing ? $coupon->limit : ''))"
            max="255"
            placeholder="Limit"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="start_date"
            label="Start Date"
            value="{{ old('start_date', ($editing ? optional($coupon->start_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="expire_date"
            label="Expire Date"
            value="{{ old('expire_date', ($editing ? optional($coupon->expire_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="min_purchase"
            label="Min Purchase"
            :value="old('min_purchase', ($editing ? $coupon->min_purchase : ''))"
            max="255"
            step="0.01"
            placeholder="Min Purchase"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="max_discount"
            label="Max Discount"
            :value="old('max_discount', ($editing ? $coupon->max_discount : ''))"
            max="255"
            step="0.01"
            placeholder="Max Discount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="discount_type" label="Discount Type">
            @php $selected = old('discount_type', ($editing ? $coupon->discount_type : '')) @endphp
            <option value="amount" {{ $selected == 'amount' ? 'selected' : '' }} >Amount</option>
            <option value="percent" {{ $selected == 'percent' ? 'selected' : '' }} >Percent</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="discount"
            label="Discount"
            :value="old('discount', ($editing ? $coupon->discount : ''))"
            max="255"
            step="0.01"
            placeholder="Discount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="when_send"
            label="When Send"
            value="{{ old('when_send', ($editing ? optional($coupon->when_send)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
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
                :checked="isset($coupon) ? $coupon->branches()->where('id', $branch->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
