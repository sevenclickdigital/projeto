@php $editing = isset($scratchCardConfig) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $scratchCardConfig->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="Keyword"
            label="Keyword"
            :value="old('Keyword', ($editing ? $scratchCardConfig->Keyword : ''))"
            maxlength="255"
            placeholder="Keyword"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="when_send" label="When Send">
            @php $selected = old('when_send', ($editing ? $scratchCardConfig->when_send : 'one_month')) @endphp
            <option value="no_send" {{ $selected == 'no_send' ? 'selected' : '' }} >No send</option>
            <option value="one_week" {{ $selected == 'one_week' ? 'selected' : '' }} >One week</option>
            <option value="two_weeks" {{ $selected == 'two_weeks' ? 'selected' : '' }} >Two weeks</option>
            <option value="one_month" {{ $selected == 'one_month' ? 'selected' : '' }} >One month</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $scratchCardConfig->winner_photo_path ? \Storage::url($scratchCardConfig->winner_photo_path) : '' }}')"
        >
            <x-inputs.partials.label
                name="winner_photo_path"
                label="Winner Photo Path"
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
                    name="winner_photo_path"
                    id="winner_photo_path"
                    @change="fileChosen"
                />
            </div>

            @error('winner_photo_path')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $scratchCardConfig->loser_photo_path ? \Storage::url($scratchCardConfig->loser_photo_path) : '' }}')"
        >
            <x-inputs.partials.label
                name="loser_photo_path"
                label="Loser Photo Path"
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
                    name="loser_photo_path"
                    id="loser_photo_path"
                    @change="fileChosen"
                />
            </div>

            @error('loser_photo_path')
            @include('components.inputs.partials.error') @enderror
        </div>
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
                :checked="isset($scratchCardConfig) ? $scratchCardConfig->branches()->where('id', $branch->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
