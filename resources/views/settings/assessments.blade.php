@extends('layout.main')

@section('title')
    System Settings
@endsection

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
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
                                <i class="ki-solid ki-menu fs-3 m-0"></i></a>Assessment Framework</div>
                    </div>
                    <div class="card-body p-5">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-5">
                            <button class="btn btn-sm btn-primary create_assessment_framework">Add an Assessment Framework</button>
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-solid ki-magnifier fs-1 position-absolute ms-6"></i>
                                <input id="search_assessment_framework_management_dt" type="text"
                                    class="form-control form-control-solid w-250px ps-15" placeholder="Search Assessment Frameworks" />
                            </div>
                        </div>

                        <!--begin::Datatable-->
                        <table id="assessment_framework_dt" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Assessment Framework Name</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody cla="text-gray-600 fw-semibold">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('settings.components.create-assessment-framework-modal')
    @include('settings.components.delete-assessment-framework-modal')
@endsection

@section('javascript')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function () {

            var assessmentFrameworkDt = $('#assessment_framework_dt').DataTable({
                searchDelay: 300,
                processing: true,
                serverSide: true,
                ordering: false,
                autoWidth: false,
                ajax: {
                    url: '{{ route('settings.assessment.framework.data') }}',
                    type: "GET",
                },
                columns: [
                    { data: 'name' },
                    { data: 'actions' },
                ],
                columnDefs: [{ target: 1, className: 'text-end' }]
            });

            $('body').on('keyup', '#search_assessment_framework_dt', function () {
                assessmentFrameworkDt.search($(this).val()).draw();
            });

            function resetAssessmentFrameworkForm(id) {
                $(id)[0].reset();
                $(id + ' .is-invalid').each(function () {
                    var input = $(this);
                    parent = input.closest('.mb-5');
                    input.removeClass('is-invalid');
                    parent.find('.select2-selection').removeClass('border-danger');
                    parent.find('.invalid-feedback').text('').hide();
                });
            }

            $('body').on('click', '.create_assessment_framework', function () {
                resetAssessmentFrameworkForm('#create_assessment_framework_modal_form');
                $('#create_assessment_framework_modal').modal('show');
            });

            $('body').on('click', '#create_assessment_framework', function () {
                var formData = $('#create_assessment_framework_modal_form').serializeArray();
                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#create_assessment_framework_modal').modal('hide');
                        resetAssessmentFrameworkForm('#create_assessment_framework_modal_form');
                        assessmentFrameworkDt.draw();
                    },
                    error: function (response) {
                        errors = response.responseJSON.errors || {};

                        $.each(errors, function (key, value) {
                            var inputName = key.includes('.') ? key.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']' : key; // Keep non-nested keys unchanged
                            var input = $('#create_assessment_framework_modal_form [name="' + inputName.replace(/(\[|\])/g, '\\$1') + '"]');
                            parent = input.closest('.mb-5');
                            input.addClass('is-invalid');
                            parent.find('.select2-selection').addClass('border-danger');
                            parent.find('.invalid-feedback').first().text(value[0]).show();
                        })
                    }
                })
            });

            $('body').on('click', '.delete_assessment_framework ', function () {
                assessmentFrameworkId = $(this).attr('data-assessment-framework-id');
                $('#delete_assessment_framework_modal_form [name="id"]').val(assessmentFrameworkId);
                $('#delete_assessment_framework_modal').modal('show');
            });

            $('body').on('click', '#delete_assessment_framework', function () {
                var id = $('#delete_assessment_framework_modal_form [name="id"]').val();
                var url = location.origin + '/settings/assessments/framework/' + id;
                var formData = $('#delete_assessment_framework_modal_form').serializeArray();
                console.log(formData)
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: formData,
                    success: function (response) {
                        console.log(response)
                        assessmentFrameworkDt.draw();
                        $('#delete_assessment_framework_modal').modal('hide');
                    }
                });
            });

        });
    </script>
@endsection