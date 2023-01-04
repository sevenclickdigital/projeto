@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.branches.index_title')</h4>
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
                        @can('create', App\Models\Branch::class)
                        <a
                            href="{{ route('branches.create') }}"
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
                                @lang('crud.branches.inputs.branch_logo_path')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.branch_cover_path')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.name')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.currency')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.description')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.slug')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.phone')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.cell')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.email')
                            </th>
                            <th class="text-right">
                                @lang('crud.branches.inputs.place_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.coordinates')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.address')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.city')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.state')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.zip_code')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.country')
                            </th>
                            <th class="text-left">
                                @lang('crud.branches.inputs.tenant_id')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $branch)
                        <tr>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $branch->branch_logo_path ? \Storage::url($branch->branch_logo_path) : '' }}"
                                />
                            </td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $branch->branch_cover_path ? \Storage::url($branch->branch_cover_path) : '' }}"
                                />
                            </td>
                            <td>{{ $branch->name ?? '-' }}</td>
                            <td>{{ $branch->currency ?? '-' }}</td>
                            <td>{{ $branch->description ?? '-' }}</td>
                            <td>{{ $branch->slug ?? '-' }}</td>
                            <td>{{ $branch->phone ?? '-' }}</td>
                            <td>{{ $branch->cell ?? '-' }}</td>
                            <td>{{ $branch->email ?? '-' }}</td>
                            <td>{{ $branch->place_id ?? '-' }}</td>
                            <td>{{ $branch->coordinates ?? '-' }}</td>
                            <td>{{ $branch->address ?? '-' }}</td>
                            <td>{{ $branch->city ?? '-' }}</td>
                            <td>{{ $branch->state ?? '-' }}</td>
                            <td>{{ $branch->zip_code ?? '-' }}</td>
                            <td>{{ $branch->country ?? '-' }}</td>
                            <td>
                                {{ optional($branch->tenant)->facebook_page_id
                                ?? '-' }}
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $branch)
                                    <a
                                        href="{{ route('branches.edit', $branch) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $branch)
                                    <a
                                        href="{{ route('branches.show', $branch) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $branch)
                                    <form
                                        action="{{ route('branches.destroy', $branch) }}"
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
                            <td colspan="18">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="18">{!! $branches->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
