@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('scratch-card-players.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.scratch_card_players.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.scratch_card_players.inputs.tenant_id')</h5>
                    <span
                        >{{
                        optional($scratchCardPlayer->tenant)->facebook_page_id
                        ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_players.inputs.scratch_card_id')
                    </h5>
                    <span
                        >{{ optional($scratchCardPlayer->scratchCard)->name ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_card_players.inputs.lead_id')</h5>
                    <span
                        >{{ optional($scratchCardPlayer->lead)->first_name ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_card_players.inputs.winner')</h5>
                    <span>{{ $scratchCardPlayer->winner ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('scratch-card-players.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\ScratchCardPlayer::class)
                <a
                    href="{{ route('scratch-card-players.create') }}"
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
