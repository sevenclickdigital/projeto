@php $editing = isset($scratchCardAnswer) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="sending_order"
            label="Sending Order"
            :value="old('sending_order', ($editing ? $scratchCardAnswer->sending_order : ''))"
            max="255"
            placeholder="Sending Order"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $scratchCardAnswer->type : '')) @endphp
            <option value="true" {{ $selected == 'true' ? 'selected' : '' }} >True</option>
            <option value="false" {{ $selected == 'false' ? 'selected' : '' }} >False</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="template_type" label="Template Type">
            @php $selected = old('template_type', ($editing ? $scratchCardAnswer->template_type : '')) @endphp
            <option value="true" {{ $selected == 'true' ? 'selected' : '' }} >True</option>
            <option value="false" {{ $selected == 'false' ? 'selected' : '' }} >False</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="elements_title"
            label="Elements Title"
            :value="old('elements_title', ($editing ? $scratchCardAnswer->elements_title : ''))"
            maxlength="255"
            placeholder="Elements Title"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="elements_image_url"
            label="Elements Image Url"
            :value="old('elements_image_url', ($editing ? $scratchCardAnswer->elements_image_url : ''))"
            maxlength="255"
            placeholder="Elements Image Url"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="elements_subtitle"
            label="Elements Subtitle"
            :value="old('elements_subtitle', ($editing ? $scratchCardAnswer->elements_subtitle : ''))"
            maxlength="255"
            placeholder="Elements Subtitle"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="action_type"
            label="Action Type"
            :value="old('action_type', ($editing ? $scratchCardAnswer->action_type : ''))"
            maxlength="255"
            placeholder="Action Type"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="action_url"
            label="Action Url"
            :value="old('action_url', ($editing ? $scratchCardAnswer->action_url : ''))"
            maxlength="255"
            placeholder="Action Url"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="action_messenger_extensions"
            label="Action Messenger Extensions"
        >
            @php $selected = old('action_messenger_extensions', ($editing ? $scratchCardAnswer->action_messenger_extensions : '')) @endphp
            <option value="true" {{ $selected == 'true' ? 'selected' : '' }} >True</option>
            <option value="false" {{ $selected == 'false' ? 'selected' : '' }} >False</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select
            name="action_webview_height_ratio"
            label="Action Webview Height Ratio"
        >
            @php $selected = old('action_webview_height_ratio', ($editing ? $scratchCardAnswer->action_webview_height_ratio : '')) @endphp
            <option value="compact" {{ $selected == 'compact' ? 'selected' : '' }} >Compact</option>
            <option value="tall" {{ $selected == 'tall' ? 'selected' : '' }} >Tall</option>
            <option value="full" {{ $selected == 'full' ? 'selected' : '' }} >Full</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="buttons_type"
            label="Buttons Type"
            :value="old('buttons_type', ($editing ? $scratchCardAnswer->buttons_type : ''))"
            maxlength="255"
            placeholder="Buttons Type"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="buttons_url"
            label="Buttons Url"
            :value="old('buttons_url', ($editing ? $scratchCardAnswer->buttons_url : ''))"
            maxlength="255"
            placeholder="Buttons Url"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="buttons_title"
            label="Buttons Title"
            :value="old('buttons_title', ($editing ? $scratchCardAnswer->buttons_title : ''))"
            maxlength="255"
            placeholder="Buttons Title"
        ></x-inputs.text>
    </x-inputs.group>
</div>
