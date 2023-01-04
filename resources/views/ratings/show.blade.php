@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('ratings.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.ratings.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.ratings.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($rating->tenant)->facebook_page_id ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.ratings.inputs.active')</h5>
                    <span>{{ $rating->active ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.ratings.inputs.award_photo_path')</h5>
                    <x-partials.thumbnail
                        src="{{ $rating->award_photo_path ? \Storage::url($rating->award_photo_path) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.ratings.inputs.subject')</h5>
                    <span>{{ $rating->subject ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.ratings.inputs.content')</h5>
                    <span>{{ $rating->content ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('ratings.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Rating::class)
                <a href="{{ route('ratings.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
