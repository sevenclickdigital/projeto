@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('newsletters.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.newsletters.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.newsletters.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($newsletter->tenant)->facebook_page_id ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.newsletters.inputs.active')</h5>
                    <span>{{ $newsletter->active ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.newsletters.inputs.sent')</h5>
                    <span>{{ $newsletter->sent ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.newsletters.inputs.date')</h5>
                    <span>{{ $newsletter->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.newsletters.inputs.time')</h5>
                    <span>{{ $newsletter->time ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.newsletters.inputs.subject')</h5>
                    <span>{{ $newsletter->subject ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.newsletters.inputs.content')</h5>
                    <span>{{ $newsletter->content ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('newsletters.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Newsletter::class)
                <a
                    href="{{ route('newsletters.create') }}"
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
