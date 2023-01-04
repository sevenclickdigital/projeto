@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('branch-hours.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.branch_hours.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.branch_hours.inputs.day')</h5>
                    <span>{{ $branchHour->day ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branch_hours.inputs.hour_start')</h5>
                    <span>{{ $branchHour->hour_start ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branch_hours.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($branchHour->tenant)->facebook_page_id ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branch_hours.inputs.hour_end')</h5>
                    <span>{{ $branchHour->hour_end ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.branch_hours.inputs.branch_id')</h5>
                    <span
                        >{{ optional($branchHour->branch)->name ?? '-' }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('branch-hours.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\BranchHour::class)
                <a
                    href="{{ route('branch-hours.create') }}"
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
