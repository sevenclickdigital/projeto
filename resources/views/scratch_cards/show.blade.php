@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('scratch-cards.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.scratch_cards.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs.tenant_id')</h5>
                    <span
                        >{{ optional($scratchCard->tenant)->facebook_page_id ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs.published')</h5>
                    <span>{{ $scratchCard->published ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs.award_photo_path')</h5>
                    <x-partials.thumbnail
                        src="{{ $scratchCard->award_photo_path ? \Storage::url($scratchCard->award_photo_path) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs.name')</h5>
                    <span>{{ $scratchCard->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs.description')</h5>
                    <span>{{ $scratchCard->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs.Keyword')</h5>
                    <span>{{ $scratchCard->Keyword ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_cards.inputs.chances_of_winning')
                    </h5>
                    <span>{{ $scratchCard->chances_of_winning ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs. play_number')</h5>
                    <span>{{ $scratchCard-> play_number ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs.show_day')</h5>
                    <span>{{ $scratchCard->show_day ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_cards.inputs.prize_availability')
                    </h5>
                    <span>{{ $scratchCard->prize_availability ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_cards.inputs.prize_date_end')</h5>
                    <span>{{ $scratchCard->prize_date_end ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('scratch-cards.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\ScratchCard::class)
                <a
                    href="{{ route('scratch-cards.create') }}"
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
