@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('category-products.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.category_products.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.category_products.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($categoryProduct->tenant)->facebook_page_id
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.category_products.inputs.active')</h5>
                    <span>{{ $categoryProduct->active ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.category_products.inputs.name')</h5>
                    <span>{{ $categoryProduct->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.category_products.inputs.category_photo_path')
                    </h5>
                    <x-partials.thumbnail
                        src="{{ $categoryProduct->category_photo_path ? \Storage::url($categoryProduct->category_photo_path) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.category_products.inputs.description')</h5>
                    <span>{{ $categoryProduct->description ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('category-products.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\CategoryProduct::class)
                <a
                    href="{{ route('category-products.create') }}"
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
