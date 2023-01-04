@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('tenants.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.tenants.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.max_lead')</h5>
                    <span>{{ $tenant->max_lead ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.max_branch')</h5>
                    <span>{{ $tenant->max_branch ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.facebook_page_id')</h5>
                    <span>{{ $tenant->facebook_page_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.facebook_access_token')</h5>
                    <span>{{ $tenant->facebook_access_token ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.instagram_page_id')</h5>
                    <span>{{ $tenant->instagram_page_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.instagram_access_token')</h5>
                    <span>{{ $tenant->instagram_access_token ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.color_primary')</h5>
                    <span>{{ $tenant->color_primary ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.color_secondary')</h5>
                    <span>{{ $tenant->color_secondary ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.custom_font')</h5>
                    <span>{{ $tenant->custom_font ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.participation_terms')</h5>
                    <span>{{ $tenant->participation_terms ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.privacy')</h5>
                    <span>{{ $tenant->privacy ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tenants.inputs.terms_of_use')</h5>
                    <span>{{ $tenant->terms_of_use ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('tenants.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Tenant::class)
                <a href="{{ route('tenants.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
