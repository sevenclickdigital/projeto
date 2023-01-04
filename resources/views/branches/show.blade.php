@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('branches.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.branches.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.branch_logo_path')</h5>
                    <x-partials.thumbnail
                        src="{{ $branch->branch_logo_path ? \Storage::url($branch->branch_logo_path) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.branch_cover_path')</h5>
                    <x-partials.thumbnail
                        src="{{ $branch->branch_cover_path ? \Storage::url($branch->branch_cover_path) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.name')</h5>
                    <span>{{ $branch->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.currency')</h5>
                    <span>{{ $branch->currency ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.description')</h5>
                    <span>{{ $branch->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.slug')</h5>
                    <span>{{ $branch->slug ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.phone')</h5>
                    <span>{{ $branch->phone ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.cell')</h5>
                    <span>{{ $branch->cell ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.email')</h5>
                    <span>{{ $branch->email ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.place_id')</h5>
                    <span>{{ $branch->place_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.coordinates')</h5>
                    <span>{{ $branch->coordinates ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.address')</h5>
                    <span>{{ $branch->address ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.city')</h5>
                    <span>{{ $branch->city ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.state')</h5>
                    <span>{{ $branch->state ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.zip_code')</h5>
                    <span>{{ $branch->zip_code ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.country')</h5>
                    <span>{{ $branch->country ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branches.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($branch->tenant)->facebook_page_id ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('branches.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Branch::class)
                <a href="{{ route('branches.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
