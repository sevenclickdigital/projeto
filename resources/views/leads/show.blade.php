@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('leads.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.leads.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($lead->tenant)->facebook_page_id ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.active')</h5>
                    <span>{{ $lead->active ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.first_name')</h5>
                    <span>{{ $lead->first_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.last_name')</h5>
                    <span>{{ $lead->last_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.gender')</h5>
                    <span>{{ $lead->gender ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.email')</h5>
                    <span>{{ $lead->email ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.phone')</h5>
                    <span>{{ $lead->phone ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.birthday')</h5>
                    <span>{{ $lead->birthday ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.notify_news')</h5>
                    <span>{{ $lead->notify_news ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.notify_holiday')</h5>
                    <span>{{ $lead->notify_holiday ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.notify_birthday')</h5>
                    <span>{{ $lead->notify_birthday ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.notify_scratch_card')</h5>
                    <span>{{ $lead->notify_scratch_card ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.leads.inputs.notify_coupon')</h5>
                    <span>{{ $lead->notify_coupon ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('leads.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Lead::class)
                <a href="{{ route('leads.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
