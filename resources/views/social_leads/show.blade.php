@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('social-leads.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.social_leads.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.social_leads.inputs.active')</h5>
                    <span>{{ $socialLead->active ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.social_leads.inputs.profile_photo_path')
                    </h5>
                    <x-partials.thumbnail
                        src="{{ $socialLead->profile_photo_path ? \Storage::url($socialLead->profile_photo_path) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.social_leads.inputs.social_id')</h5>
                    <span>{{ $socialLead->social_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.social_leads.inputs.social_key')</h5>
                    <span>{{ $socialLead->social_key ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.social_leads.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($socialLead->tenant)->facebook_page_id ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.social_leads.inputs.social_type')</h5>
                    <span>{{ $socialLead->social_type ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('social-leads.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\SocialLead::class)
                <a
                    href="{{ route('social-leads.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
