@php $editing = isset($tenant) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="max_lead"
            label="Max Lead"
            :value="old('max_lead', ($editing ? $tenant->max_lead : ''))"
            max="255"
            placeholder="Max Lead"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="max_branch"
            label="Max Branch"
            :value="old('max_branch', ($editing ? $tenant->max_branch : ''))"
            max="255"
            placeholder="Max Branch"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="facebook_page_id"
            label="Facebook Page Id"
            maxlength="255"
            >{{ old('facebook_page_id', ($editing ? $tenant->facebook_page_id :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="facebook_access_token"
            label="Facebook Access Token"
            maxlength="255"
            >{{ old('facebook_access_token', ($editing ?
            $tenant->facebook_access_token : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="instagram_page_id"
            label="Instagram Page Id"
            maxlength="255"
            >{{ old('instagram_page_id', ($editing ? $tenant->instagram_page_id
            : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="instagram_access_token"
            label="Instagram Access Token"
            maxlength="255"
            >{{ old('instagram_access_token', ($editing ?
            $tenant->instagram_access_token : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="color_primary"
            label="Color Primary"
            :value="old('color_primary', ($editing ? $tenant->color_primary : ''))"
            maxlength="9"
            placeholder="Color Primary"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="color_secondary"
            label="Color Secondary"
            :value="old('color_secondary', ($editing ? $tenant->color_secondary : ''))"
            maxlength="9"
            placeholder="Color Secondary"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="custom_font"
            label="Custom Font"
            :value="old('custom_font', ($editing ? $tenant->custom_font : ''))"
            maxlength="255"
            placeholder="Custom Font"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="participation_terms"
            label="Participation Terms"
            maxlength="255"
            >{{ old('participation_terms', ($editing ?
            $tenant->participation_terms : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="privacy" label="Privacy" maxlength="255"
            >{{ old('privacy', ($editing ? $tenant->privacy : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="terms_of_use"
            label="Terms Of Use"
            maxlength="255"
            >{{ old('terms_of_use', ($editing ? $tenant->terms_of_use : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
