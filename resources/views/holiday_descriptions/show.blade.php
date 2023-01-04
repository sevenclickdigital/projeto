@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('holiday-descriptions.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.holiday_descriptions.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.holiday_descriptions.inputs.tenant_id')</h5>
                    <span
                        >{{
                        optional($holidayDescription->tenant)->facebook_page_id
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.holiday_descriptions.inputs.holiday_id')
                    </h5>
                    <span
                        >{{ optional($holidayDescription->holiday)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holiday_descriptions.inputs.active')</h5>
                    <span>{{ $holidayDescription->active ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holiday_descriptions.inputs.when_send')</h5>
                    <span>{{ $holidayDescription->when_send ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holiday_descriptions.inputs.time')</h5>
                    <span>{{ $holidayDescription->time ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holiday_descriptions.inputs.subject')</h5>
                    <span>{{ $holidayDescription->subject ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.holiday_descriptions.inputs.content')</h5>
                    <span>{{ $holidayDescription->content ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('holiday-descriptions.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\HolidayDescription::class)
                <a
                    href="{{ route('holiday-descriptions.create') }}"
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
