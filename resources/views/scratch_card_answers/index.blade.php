@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.scratch_card_answers.index_title')
                </h4>
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
                        @can('create', App\Models\ScratchCardAnswer::class)
                        <a
                            href="{{ route('scratch-card-answers.create') }}"
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
                            <th class="text-right">
                                @lang('crud.scratch_card_answers.inputs.sending_order')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.type')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.template_type')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.elements_title')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.elements_image_url')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.elements_subtitle')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.action_type')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.action_url')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.action_messenger_extensions')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.action_webview_height_ratio')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.buttons_type')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.buttons_url')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_answers.inputs.buttons_title')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scratchCardAnswers as $scratchCardAnswer)
                        <tr>
                            <td>
                                {{ $scratchCardAnswer->sending_order ?? '-' }}
                            </td>
                            <td>{{ $scratchCardAnswer->type ?? '-' }}</td>
                            <td>
                                {{ $scratchCardAnswer->template_type ?? '-' }}
                            </td>
                            <td>
                                {{ $scratchCardAnswer->elements_title ?? '-' }}
                            </td>
                            <td>
                                {{ $scratchCardAnswer->elements_image_url ?? '-'
                                }}
                            </td>
                            <td>
                                {{ $scratchCardAnswer->elements_subtitle ?? '-'
                                }}
                            </td>
                            <td>
                                {{ $scratchCardAnswer->action_type ?? '-' }}
                            </td>
                            <td>{{ $scratchCardAnswer->action_url ?? '-' }}</td>
                            <td>
                                {{
                                $scratchCardAnswer->action_messenger_extensions
                                ?? '-' }}
                            </td>
                            <td>
                                {{
                                $scratchCardAnswer->action_webview_height_ratio
                                ?? '-' }}
                            </td>
                            <td>
                                {{ $scratchCardAnswer->buttons_type ?? '-' }}
                            </td>
                            <td>
                                {{ $scratchCardAnswer->buttons_url ?? '-' }}
                            </td>
                            <td>
                                {{ $scratchCardAnswer->buttons_title ?? '-' }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $scratchCardAnswer)
                                    <a
                                        href="{{ route('scratch-card-answers.edit', $scratchCardAnswer) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $scratchCardAnswer)
                                    <a
                                        href="{{ route('scratch-card-answers.show', $scratchCardAnswer) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $scratchCardAnswer)
                                    <form
                                        action="{{ route('scratch-card-answers.destroy', $scratchCardAnswer) }}"
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
                            <td colspan="14">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="14">
                                {!! $scratchCardAnswers->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
