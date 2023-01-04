@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('scratch-card-answers.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.scratch_card_answers.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.sending_order')
                    </h5>
                    <span>{{ $scratchCardAnswer->sending_order ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scratch_card_answers.inputs.type')</h5>
                    <span>{{ $scratchCardAnswer->type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.template_type')
                    </h5>
                    <span>{{ $scratchCardAnswer->template_type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.elements_title')
                    </h5>
                    <span>{{ $scratchCardAnswer->elements_title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.elements_image_url')
                    </h5>
                    <span
                        >{{ $scratchCardAnswer->elements_image_url ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.elements_subtitle')
                    </h5>
                    <span
                        >{{ $scratchCardAnswer->elements_subtitle ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.action_type')
                    </h5>
                    <span>{{ $scratchCardAnswer->action_type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.action_url')
                    </h5>
                    <span>{{ $scratchCardAnswer->action_url ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.action_messenger_extensions')
                    </h5>
                    <span
                        >{{ $scratchCardAnswer->action_messenger_extensions ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.action_webview_height_ratio')
                    </h5>
                    <span
                        >{{ $scratchCardAnswer->action_webview_height_ratio ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.buttons_type')
                    </h5>
                    <span>{{ $scratchCardAnswer->buttons_type ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.buttons_url')
                    </h5>
                    <span>{{ $scratchCardAnswer->buttons_url ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.scratch_card_answers.inputs.buttons_title')
                    </h5>
                    <span>{{ $scratchCardAnswer->buttons_title ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('scratch-card-answers.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\ScratchCardAnswer::class)
                <a
                    href="{{ route('scratch-card-answers.create') }}"
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
