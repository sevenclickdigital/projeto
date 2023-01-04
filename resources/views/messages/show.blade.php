@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('messages.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.messages.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.messages.inputs.text')</h5>
                    <span>{{ $message->text ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.messages.inputs.read')</h5>
                    <span>{{ $message->read ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.messages.inputs.message_key')</h5>
                    <span>{{ $message->message_key ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.messages.inputs.sender')</h5>
                    <span>{{ $message->sender ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.messages.inputs.sender_id')</h5>
                    <span>{{ $message->sender_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.messages.inputs.receiver_id')</h5>
                    <span>{{ $message->receiver_id ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.messages.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($message->tenant)->facebook_page_id ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('messages.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Message::class)
                <a href="{{ route('messages.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
