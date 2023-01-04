@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.leads.index_title')</h4>
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
                        @can('create', App\Models\Lead::class)
                        <a
                            href="{{ route('leads.create') }}"
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
                                @lang('crud.leads.inputs.tenant_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.active')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.first_name')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.last_name')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.gender')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.email')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.phone')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.birthday')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.notify_news')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.notify_holiday')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.notify_birthday')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.notify_scratch_card')
                            </th>
                            <th class="text-left">
                                @lang('crud.leads.inputs.notify_coupon')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                        <tr>
                            <td>
                                {{ optional($lead->tenant)->facebook_page_id ??
                                '-' }}
                            </td>
                            <td>{{ $lead->active ?? '-' }}</td>
                            <td>{{ $lead->first_name ?? '-' }}</td>
                            <td>{{ $lead->last_name ?? '-' }}</td>
                            <td>{{ $lead->gender ?? '-' }}</td>
                            <td>{{ $lead->email ?? '-' }}</td>
                            <td>{{ $lead->phone ?? '-' }}</td>
                            <td>{{ $lead->birthday ?? '-' }}</td>
                            <td>{{ $lead->notify_news ?? '-' }}</td>
                            <td>{{ $lead->notify_holiday ?? '-' }}</td>
                            <td>{{ $lead->notify_birthday ?? '-' }}</td>
                            <td>{{ $lead->notify_scratch_card ?? '-' }}</td>
                            <td>{{ $lead->notify_coupon ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $lead)
                                    <a href="{{ route('leads.edit', $lead) }}">
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $lead)
                                    <a href="{{ route('leads.show', $lead) }}">
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $lead)
                                    <form
                                        action="{{ route('leads.destroy', $lead) }}"
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
                            <td colspan="14">{!! $leads->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
