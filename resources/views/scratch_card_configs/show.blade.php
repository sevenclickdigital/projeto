@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('scratch-card-configs.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.scratch_card_configs.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.scratch_card_configs.inputs.tenant_id')</h5>
                    <span
                        >{{
                        optional($scratchCardConfig->tenant)->facebook_page_id
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_card_configs.inputs.Keyword')</h5>
                    <span>{{ $scratchCardConfig->Keyword ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_card_configs.inputs.when_send')</h5>
                    <span>{{ $scratchCardConfig->when_send ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_configs.inputs.winner_photo_path')
                    </h5>
                    <x-partials.thumbnail
                        src="{{ $scratchCardConfig->winner_photo_path ? \Storage::url($scratchCardConfig->winner_photo_path) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_configs.inputs.loser_photo_path')
                    </h5>
                    <x-partials.thumbnail
                        src="{{ $scratchCardConfig->loser_photo_path ? \Storage::url($scratchCardConfig->loser_photo_path) : '' }}"
                        size="150"
                    />
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('scratch-card-configs.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\ScratchCardConfig::class)
                <a
                    href="{{ route('scratch-card-configs.create') }}"
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
