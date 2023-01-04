@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('coupons.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.coupons.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($coupon->tenant)->facebook_page_id ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.active')</h5>
                    <span>{{ $coupon->active ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.title')</h5>
                    <span>{{ $coupon->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.description')</h5>
                    <span>{{ $coupon->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.code')</h5>
                    <span>{{ $coupon->code ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.coupon_type')</h5>
                    <span>{{ $coupon->coupon_type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.limit')</h5>
                    <span>{{ $coupon->limit ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.start_date')</h5>
                    <span>{{ $coupon->start_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.expire_date')</h5>
                    <span>{{ $coupon->expire_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.min_purchase')</h5>
                    <span>{{ $coupon->min_purchase ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.max_discount')</h5>
                    <span>{{ $coupon->max_discount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.discount_type')</h5>
                    <span>{{ $coupon->discount_type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.discount')</h5>
                    <span>{{ $coupon->discount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.coupons.inputs.when_send')</h5>
                    <span>{{ $coupon->when_send ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('coupons.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Coupon::class)
                <a href="{{ route('coupons.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
