@php $editing = isset($socialLead) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.checkbox
            name="active"
            label="Active"
            :checked="old('active', ($editing ? $socialLead->active : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $socialLead->profile_photo_path ? \Storage::url($socialLead->profile_photo_path) : '' }}')"
        >
            <x-inputs.partials.label
                name="profile_photo_path"
                label="Profile Photo Path"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="profile_photo_path"
                    id="profile_photo_path"
                    @change="fileChosen"
                />
            </div>

            @error('profile_photo_path')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="social_id" label="Social Id" maxlength="255"
            >{{ old('social_id', ($editing ? $socialLead->social_id : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="social_key" label="Social Key" maxlength="255"
            >{{ old('social_key', ($editing ? $socialLead->social_key : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $socialLead->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="social_type" label="Social Type">
            @php $selected = old('social_type', ($editing ? $socialLead->social_type : '')) @endphp
            <option value="instagram" {{ $selected == 'instagram' ? 'selected' : '' }} >Instagram</option>
            <option value="facebook" {{ $selected == 'facebook' ? 'selected' : '' }} >Facebook</option>
            <option value="whatsapp" {{ $selected == 'whatsapp' ? 'selected' : '' }} >Whatsapp</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
