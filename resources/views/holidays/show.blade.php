@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('holidays.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.holidays.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.holidays.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($holiday->tenant)->facebook_page_id ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holidays.inputs.name')</h5>
                    <span>{{ $holiday->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holidays.inputs.date')</h5>
                    <span>{{ $holiday->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holidays.inputs.active')</h5>
                    <span>{{ $holiday->active ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holidays.inputs.custom')</h5>
                    <span>{{ $holiday->custom ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('holidays.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Holiday::class)
                <a href="{{ route('holidays.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
