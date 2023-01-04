@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('qrbilders.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.qrbilders.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.qrbilders.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($qrbilder->tenant)->facebook_page_id ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.qrbilders.inputs.name')</h5>
                    <span>{{ $qrbilder->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.qrbilders.inputs.slug')</h5>
                    <span>{{ $qrbilder->slug ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.qrbilders.inputs.bilder_photo_path')</h5>
                    <x-partials.thumbnail
                        src="{{ $qrbilder->bilder_photo_path ? \Storage::url($qrbilder->bilder_photo_path) : '' }}"
                        size="150"
                    />
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('qrbilders.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Qrbilder::class)
                <a href="{{ route('qrbilders.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
