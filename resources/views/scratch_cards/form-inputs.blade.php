@php $editing = isset($scratchCard) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $scratchCard->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="published" label="Published">
            @php $selected = old('published', ($editing ? $scratchCard->published : 'draft')) @endphp
            <option value="published" {{ $selected == 'published' ? 'selected' : '' }} >Published</option>
            <option value="draft" {{ $selected == 'draft' ? 'selected' : '' }} >Draft</option>
            <option value="archived" {{ $selected == 'archived' ? 'selected' : '' }} >Archived</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $scratchCard->award_photo_path ? \Storage::url($scratchCard->award_photo_path) : '' }}')"
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
            name="name"
            label="Name"
            :value="old('name', ($editing ? $scratchCard->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $scratchCard->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="Keyword"
            label="Keyword"
            :value="old('Keyword', ($editing ? $scratchCard->Keyword : ''))"
            maxlength="255"
            placeholder="Keyword"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="chances_of_winning"
            label="Chances Of Winning"
            :value="old('chances_of_winning', ($editing ? $scratchCard->chances_of_winning : ''))"
            max="255"
            placeholder="Chances Of Winning"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name=" play_number"
            label="Play Number"
            :value="old(' play_number', ($editing ? $scratchCard-> play_number : ''))"
            max="255"
            placeholder="Play Number"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="show_day"
            label="Show Day"
            :value="old('show_day', ($editing ? $scratchCard->show_day : ''))"
            maxlength="255"
            placeholder="Show Day"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="prize_availability" label="Prize Availability">
            @php $selected = old('prize_availability', ($editing ? $scratchCard->prize_availability : 'always')) @endphp
            <option value="always" {{ $selected == 'always' ? 'selected' : '' }} >Always</option>
            <option value="date" {{ $selected == 'date' ? 'selected' : '' }} >Date</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="prize_date_end"
            label="Prize Date End"
            value="{{ old('prize_date_end', ($editing ? optional($scratchCard->prize_date_end)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
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
                :checked="isset($scratchCard) ? $scratchCard->branches()->where('id', $branch->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
