@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('qrbilders.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.qrbilders.create_title')
            </h4>

            <x-form
                method="POST"
                action="{{ route('qrbilders.store') }}"
                has-files
                class="mt-4"
            >
                @include('resources.views.qrbilders.form-inputs')

                <div class="mt-4">
                    <a
                        href="{{ route('qrbilders.index') }}"
                        class="btn btn-light"
                    >
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
