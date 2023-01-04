@php $editing = isset($product) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="tenant_id" label="Tenant" required>
            @php $selected = old('tenant_id', ($editing ? $product->tenant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Tenant</option>
            @foreach($tenants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $product->type : 'catalog_online')) @endphp
            <option value="catalog_online" {{ $selected == 'catalog_online' ? 'selected' : '' }} >Catalog online</option>
            <option value="catalog_pdf" {{ $selected == 'catalog_pdf' ? 'selected' : '' }} >Catalog pdf</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="category_product_id"
            label="Category Product"
            required
        >
            @php $selected = old('category_product_id', ($editing ? $product->category_product_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Category Product</option>
            @foreach($categoryProducts as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $product->product_photo_path ? \Storage::url($product->product_photo_path) : '' }}')"
        >
            <x-inputs.partials.label
                name="product_photo_path"
                label="Product Photo Path"
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
                    name="product_photo_path"
                    id="product_photo_path"
                    @change="fileChosen"
                />
            </div>

            @error('product_photo_path')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $product->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="price"
            label="Price"
            :value="old('price', ($editing ? $product->price : ''))"
            max="255"
            step="0.01"
            placeholder="Price"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $product->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name=" button_text"
            label="Button Text"
            :value="old(' button_text', ($editing ? $product-> button_text : ''))"
            maxlength="255"
            placeholder="Button Text"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name=" button_path"
            label="Button Path"
            :value="old(' button_path', ($editing ? $product-> button_path : ''))"
            maxlength="255"
            placeholder="Button Path"
        ></x-inputs.text>
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
                :checked="isset($product) ? $product->branches()->where('id', $branch->id)->exists() : false"
                :add-hidden-value="false"
            ></x-inputs.checkbox>
        </div>
        @endforeach
    </div>
</div>
