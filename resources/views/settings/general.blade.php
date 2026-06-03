@extends('layout.main')

@section('title')
    System Settings
@endsection

@section('breadcrumbs')
    <x-breadcrumbs :items="$breadcrumbs"></x-breadcrumbs>
@endsection

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid py-0">
        <div id="kt_app_content_container" class="container-fluid g-0">
            <!--begin::Inbox App - Messages -->
            <div class="d-flex flex-column flex-lg-row">
                @include('settings.components.settings-menu', ['active_settings_menu' => 'general'])
                <div class="card flex-grow-1 ms-lg-5">
                    <div class="card-header">
                        <div class="card-title fs-3 fw-bold"><a href="{{ route('settings.general') }}"
                                class="btn btn-sm btn-icon btn-color-primary btn-light btn-active-light-primary d-lg-none me-3"
                                data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top"
                                id="kt_inbox_aside_toggle" aria-label="Toggle inbox menu"
                                data-bs-original-title="Toggle inbox menu" data-kt-initialized="1">
                                <i class="ki-solid ki-menu fs-3 m-0"></i></a>General Settings</div>
                    </div>
                    <div class="card-body p-5">
                        @csrf
                        <div class="row mb-5">
                            <div class="col-12">
                                <label class="form-label">Company name</label>
                                <input type="text" name="name" class="form-control form-control-lg save_input"
                                    value="{{ $company->name }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            $('body').on('change', '.save_input', function () {
                saveInput($(this));
            });

            function saveInput(element) {
                var _token = $('[name="_token"]').val();
                var parent = element.parent();
                var name = element.attr('name');
                var type = element.attr('type');
                var value = element.val() ?? undefined;
                var label = parent.find('.form-label').text();
                $.ajax({
                    url: '{{ route('settings.general.update') }}',
                    type: 'PUT',
                    data: { _token: _token, name: name, type: type, value: value },
                    success: function () {
                        element.addClass('is-valid');
                        parent.find('.select2-selection').addClass('border-success');
                        toastr.success(label + " was updated successfully!", "Change successful");
                    },
                    error: function (response) {
                        error = response.responseJSON.errors;
                        element.addClass('is-invalid');
                        parent.find('.select2-selection').addClass('border-danger');
                        parent.find('.invalid-feedback').text(Object.values(error)[0]);
                    }
                })
            }

        });
    </script>

@endsection