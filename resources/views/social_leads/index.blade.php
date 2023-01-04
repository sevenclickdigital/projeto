@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.social_leads.index_title')
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
                        @can('create', App\Models\SocialLead::class)
                        <a
                            href="{{ route('social-leads.create') }}"
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
                                @lang('crud.social_leads.inputs.active')
                            </th>
                            <th class="text-left">
                                @lang('crud.social_leads.inputs.profile_photo_path')
                            </th>
                            <th class="text-left">
                                @lang('crud.social_leads.inputs.social_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.social_leads.inputs.social_key')
                            </th>
                            <th class="text-left">
                                @lang('crud.social_leads.inputs.tenant_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.social_leads.inputs.social_type')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($socialLeads as $socialLead)
                        <tr>
                            <td>{{ $socialLead->active ?? '-' }}</td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $socialLead->profile_photo_path ? \Storage::url($socialLead->profile_photo_path) : '' }}"
                                />
                            </td>
                            <td>{{ $socialLead->social_id ?? '-' }}</td>
                            <td>{{ $socialLead->social_key ?? '-' }}</td>
                            <td>
                                {{
                                optional($socialLead->tenant)->facebook_page_id
                                ?? '-' }}
                            </td>
                            <td>{{ $socialLead->social_type ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $socialLead)
                                    <a
                                        href="{{ route('social-leads.edit', $socialLead) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $socialLead)
                                    <a
                                        href="{{ route('social-leads.show', $socialLead) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $socialLead)
                                    <form
                                        action="{{ route('social-leads.destroy', $socialLead) }}"
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
                            <td colspan="7">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">{!! $socialLeads->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
