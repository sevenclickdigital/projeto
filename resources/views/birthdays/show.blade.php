@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('birthdays.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.birthdays.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.birthdays.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($birthday->tenant)->facebook_page_id ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.birthdays.inputs.when_send')</h5>
                    <span>{{ $birthday->when_send ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.birthdays.inputs.time')</h5>
                    <span>{{ $birthday->time ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.birthdays.inputs.subject')</h5>
                    <span>{{ $birthday->subject ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.birthdays.inputs.content')</h5>
                    <span>{{ $birthday->content ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('birthdays.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Birthday::class)
                <a href="{{ route('birthdays.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
