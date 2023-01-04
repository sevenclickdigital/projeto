@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a
                    href="{{ route('rating-google-businesses.index') }}"
                    class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.rating_google_businesses.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.rating_google_businesses.inputs.tenant_id')
                    </h5>
                    <span
                        >{{
                        optional($ratingGoogleBusiness->tenant)->facebook_page_id
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.rating_google_businesses.inputs.name')</h5>
                    <span>{{ $ratingGoogleBusiness->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.rating_google_businesses.inputs.text')</h5>
                    <span>{{ $ratingGoogleBusiness->text ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.rating_google_businesses.inputs.stars')</h5>
                    <span>{{ $ratingGoogleBusiness->stars ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('rating-google-businesses.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\RatingGoogleBusiness::class)
                <a
                    href="{{ route('rating-google-businesses.create') }}"
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
