@php $editing = isset($rating) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $rating->tenant_id : '')) @endphp
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
            :checked="old('active', ($editing ? $rating->active : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $rating->award_photo_path ? \Storage::url($rating->award_photo_path) : '' }}')"
        >
            <x-inputs.partials.label
                name="award_photo_path"
                label="Award Photo Path"
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
                    name="award_photo_path"
                    id="award_photo_path"
                    @change="fileChosen"
                />
            </div>

            @error('award_photo_path')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="subject"
            label="Subject"
            :value="old('subject', ($editing ? $rating->subject : ''))"
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
            >{{ old('content', ($editing ? $rating->content : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    @if($editing)
    <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.branches.name')</h4>

        @foreach ($branches as $branch)
        <div>
            <x-inputs.checkbox
                id="branch{{ $branch->id }}"
                name="branches[]"
                label="{{ ucfirst($branch->name) }}"
                value="{{ $branch->id }}"
                :checked="isset($rating) ? $rating->branches()->where('id', $branch->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
    @endif
</div>
