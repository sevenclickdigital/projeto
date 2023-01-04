@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.tenants.index_title')</h4>
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
                        @can('create', App\Models\Tenant::class)
                        <a
                            href="{{ route('tenants.create') }}"
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
                                @lang('crud.tenants.inputs.max_lead')
                            </th>
                            <th class="text-right">
                                @lang('crud.tenants.inputs.max_branch')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.facebook_page_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.facebook_access_token')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.instagram_page_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.instagram_access_token')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.color_primary')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.color_secondary')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.custom_font')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.participation_terms')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.privacy')
                            </th>
                            <th class="text-left">
                                @lang('crud.tenants.inputs.terms_of_use')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->max_lead ?? '-' }}</td>
                            <td>{{ $tenant->max_branch ?? '-' }}</td>
                            <td>{{ $tenant->facebook_page_id ?? '-' }}</td>
                            <td>{{ $tenant->facebook_access_token ?? '-' }}</td>
                            <td>{{ $tenant->instagram_page_id ?? '-' }}</td>
                            <td>
                                {{ $tenant->instagram_access_token ?? '-' }}
                            </td>
                            <td>{{ $tenant->color_primary ?? '-' }}</td>
                            <td>{{ $tenant->color_secondary ?? '-' }}</td>
                            <td>{{ $tenant->custom_font ?? '-' }}</td>
                            <td>{{ $tenant->participation_terms ?? '-' }}</td>
                            <td>{{ $tenant->privacy ?? '-' }}</td>
                            <td>{{ $tenant->terms_of_use ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $tenant)
                                    <a
                                        href="{{ route('tenants.edit', $tenant) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $tenant)
                                    <a
                                        href="{{ route('tenants.show', $tenant) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $tenant)
                                    <form
                                        action="{{ route('tenants.destroy', $tenant) }}"
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
                            <td colspan="13">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="13">{!! $tenants->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
