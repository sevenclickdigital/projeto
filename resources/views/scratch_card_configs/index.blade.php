@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.scratch_card_configs.index_title')
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
                        @can('create', App\Models\ScratchCardConfig::class)
                        <a
                            href="{{ route('scratch-card-configs.create') }}"
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
                            <th class="text-left">
                                @lang('crud.scratch_card_configs.inputs.tenant_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_configs.inputs.Keyword')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_configs.inputs.when_send')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_configs.inputs.winner_photo_path')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_card_configs.inputs.loser_photo_path')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scratchCardConfigs as $scratchCardConfig)
                        <tr>
                            <td>
                                {{
                                optional($scratchCardConfig->tenant)->facebook_page_id
                                ?? '-' }}
                            </td>
                            <td>{{ $scratchCardConfig->Keyword ?? '-' }}</td>
                            <td>{{ $scratchCardConfig->when_send ?? '-' }}</td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $scratchCardConfig->winner_photo_path ? \Storage::url($scratchCardConfig->winner_photo_path) : '' }}"
                                />
                            </td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $scratchCardConfig->loser_photo_path ? \Storage::url($scratchCardConfig->loser_photo_path) : '' }}"
                                />
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $scratchCardConfig)
                                    <a
                                        href="{{ route('scratch-card-configs.edit', $scratchCardConfig) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $scratchCardConfig)
                                    <a
                                        href="{{ route('scratch-card-configs.show', $scratchCardConfig) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $scratchCardConfig)
                                    <form
                                        action="{{ route('scratch-card-configs.destroy', $scratchCardConfig) }}"
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
                            <td colspan="6">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                {!! $scratchCardConfigs->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
