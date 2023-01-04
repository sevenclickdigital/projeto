@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.coupons.index_title')</h4>
            </div>

            <div class="searchbar mt-4 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="input-group">
                                <input
                                    id="indexSearch"
                                    type="text"
                                    name="search"
                                    placeholder="{{ __('crud.common.search') }}"
                                    value="{{ $search ?? '' }}"
                                    class="form-control"
                                    autocomplete="off"
                                />
                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        <i class="icon ion-md-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        @can('create', App\Models\Coupon::class)
                        <a
                            href="{{ route('coupons.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.tenant_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.active')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.title')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.description')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.code')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.coupon_type')
                            </th>
                            <th class="text-right">
                                @lang('crud.coupons.inputs.limit')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.start_date')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.expire_date')
                            </th>
                            <th class="text-right">
                                @lang('crud.coupons.inputs.min_purchase')
                            </th>
                            <th class="text-right">
                                @lang('crud.coupons.inputs.max_discount')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.discount_type')
                            </th>
                            <th class="text-right">
                                @lang('crud.coupons.inputs.discount')
                            </th>
                            <th class="text-left">
                                @lang('crud.coupons.inputs.when_send')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                {{ optional($coupon->tenant)->facebook_page_id
                                ?? '-' }}
                            </td>
                            <td>{{ $coupon->active ?? '-' }}</td>
                            <td>{{ $coupon->title ?? '-' }}</td>
                            <td>{{ $coupon->description ?? '-' }}</td>
                            <td>{{ $coupon->code ?? '-' }}</td>
                            <td>{{ $coupon->coupon_type ?? '-' }}</td>
                            <td>{{ $coupon->limit ?? '-' }}</td>
                            <td>{{ $coupon->start_date ?? '-' }}</td>
                            <td>{{ $coupon->expire_date ?? '-' }}</td>
                            <td>{{ $coupon->min_purchase ?? '-' }}</td>
                            <td>{{ $coupon->max_discount ?? '-' }}</td>
                            <td>{{ $coupon->discount_type ?? '-' }}</td>
                            <td>{{ $coupon->discount ?? '-' }}</td>
                            <td>{{ $coupon->when_send ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $coupon)
                                    <a
                                        href="{{ route('coupons.edit', $coupon) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $coupon)
                                    <a
                                        href="{{ route('coupons.show', $coupon) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $coupon)
                                    <form
                                        action="{{ route('coupons.destroy', $coupon) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="15">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="15">{!! $coupons->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
