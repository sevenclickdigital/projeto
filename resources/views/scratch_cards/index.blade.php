@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.scratch_cards.index_title')
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
                        @can('create', App\Models\ScratchCard::class)
                        <a
                            href="{{ route('scratch-cards.create') }}"
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
                                @lang('crud.scratch_cards.inputs.tenant_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_cards.inputs.published')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_cards.inputs.award_photo_path')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_cards.inputs.name')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_cards.inputs.description')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_cards.inputs.Keyword')
                            </th>
                            <th class="text-right">
                                @lang('crud.scratch_cards.inputs.chances_of_winning')
                            </th>
                            <th class="text-right">
                                @lang('crud.scratch_cards.inputs. play_number')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_cards.inputs.show_day')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_cards.inputs.prize_availability')
                            </th>
                            <th class="text-left">
                                @lang('crud.scratch_cards.inputs.prize_date_end')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scratchCards as $scratchCard)
                        <tr>
                            <td>
                                {{
                                optional($scratchCard->tenant)->facebook_page_id
                                ?? '-' }}
                            </td>
                            <td>{{ $scratchCard->published ?? '-' }}</td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $scratchCard->award_photo_path ? \Storage::url($scratchCard->award_photo_path) : '' }}"
                                />
                            </td>
                            <td>{{ $scratchCard->name ?? '-' }}</td>
                            <td>{{ $scratchCard->description ?? '-' }}</td>
                            <td>{{ $scratchCard->Keyword ?? '-' }}</td>
                            <td>
                                {{ $scratchCard->chances_of_winning ?? '-' }}
                            </td>
                            <td>{{ $scratchCard-> play_number ?? '-' }}</td>
                            <td>{{ $scratchCard->show_day ?? '-' }}</td>
                            <td>
                                {{ $scratchCard->prize_availability ?? '-' }}
                            </td>
                            <td>{{ $scratchCard->prize_date_end ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $scratchCard)
                                    <a
                                        href="{{ route('scratch-cards.edit', $scratchCard) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $scratchCard)
                                    <a
                                        href="{{ route('scratch-cards.show', $scratchCard) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $scratchCard)
                                    <form
                                        action="{{ route('scratch-cards.destroy', $scratchCard) }}"
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
                            <td colspan="12">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">
                                {!! $scratchCards->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
