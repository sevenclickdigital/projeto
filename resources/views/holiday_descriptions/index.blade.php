@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.holiday_descriptions.index_title')
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
                        @can('create', App\Models\HolidayDescription::class)
                        <a
                            href="{{ route('holiday-descriptions.create') }}"
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
                                @lang('crud.holiday_descriptions.inputs.tenant_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.holiday_descriptions.inputs.holiday_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.holiday_descriptions.inputs.active')
                            </th>
                            <th class="text-left">
                                @lang('crud.holiday_descriptions.inputs.when_send')
                            </th>
                            <th class="text-left">
                                @lang('crud.holiday_descriptions.inputs.time')
                            </th>
                            <th class="text-left">
                                @lang('crud.holiday_descriptions.inputs.subject')
                            </th>
                            <th class="text-left">
                                @lang('crud.holiday_descriptions.inputs.content')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($holidayDescriptions as $holidayDescription)
                        <tr>
                            <td>
                                {{
                                optional($holidayDescription->tenant)->facebook_page_id
                                ?? '-' }}
                            </td>
                            <td>
                                {{ optional($holidayDescription->holiday)->name
                                ?? '-' }}
                            </td>
                            <td>{{ $holidayDescription->active ?? '-' }}</td>
                            <td>{{ $holidayDescription->when_send ?? '-' }}</td>
                            <td>{{ $holidayDescription->time ?? '-' }}</td>
                            <td>{{ $holidayDescription->subject ?? '-' }}</td>
                            <td>{{ $holidayDescription->content ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $holidayDescription)
                                    <a
                                        href="{{ route('holiday-descriptions.edit', $holidayDescription) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $holidayDescription)
                                    <a
                                        href="{{ route('holiday-descriptions.show', $holidayDescription) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $holidayDescription)
                                    <form
                                        action="{{ route('holiday-descriptions.destroy', $holidayDescription) }}"
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
                            <td colspan="8">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                {!! $holidayDescriptions->render() !!}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
