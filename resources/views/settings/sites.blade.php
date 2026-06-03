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
                                <i class="ki-solid ki-menu fs-3 m-0"></i></a>Site Management</div>
                    </div>
                    <div class="card-body p-5">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-5">
                            <button class="btn btn-sm btn-primary create_site">Add a Site</button>
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-solid ki-magnifier fs-1 position-absolute ms-6"></i>
                                <input id="search_site_management_dt" type="text"
                                    class="form-control form-control-solid w-250px ps-15" placeholder="Search Sites" />
                            </div>
                        </div>

                        <!--begin::Datatable-->
                        <table id="site_management_dt" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Site Name</th>
                                    <th>Rooms</th>
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
    @include('settings.components.create-site-modal')
    @include('settings.components.edit-site-modal')
    @include('settings.components.delete-site-modal')
@endsection

@section('javascript')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function () {

            var siteManagementDt = $('#site_management_dt').DataTable({
                searchDelay: 300,
                processing: true,
                serverSide: true,
                ordering: false,
                autoWidth: false,
                ajax: {
                    url: '{{ route('settings.sites.data') }}',
                    type: "GET",
                },
                columns: [
                    { data: 'name' },
                    { data: 'rooms' },
                    { data: 'actions' },
                ],
                columnDefs: [{ target: 2, className: 'text-end' }]
            });

            $('body').on('keyup', '#search_site_management_dt', function () {
                siteManagementDt.search($(this).val()).draw();
            });

            var createRoomsRepeater = $('#create_site_modal #site_rooms').repeater({
                initEmpty: false,
                isFirstItemUndeletable: true,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });

            var editRoomsRepeater = $('#edit_site_modal #site_rooms').repeater({
                initEmpty: false,
                isFirstItemUndeletable: true,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });

            function resetSiteForm(id) {
                $(id)[0].reset();
                $(id + ' .is-invalid').each(function () {
                    var input = $(this);
                    parent = input.closest('.mb-5');
                    input.removeClass('is-invalid');
                    parent.find('.select2-selection').removeClass('border-danger');
                    parent.find('.invalid-feedback').text('').hide();
                });
            }

            $('body').on('click', '.create_site', function () {
                resetSiteForm('#create_site_modal_form');
                $('#create_site_modal').modal('show');
            });

            $('body').on('click', '#create_site', function () {
                var formData = $('#create_site_modal_form').serializeArray();
                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#create_site_modal').modal('hide');
                        resetSiteForm('#create_site_modal_form');
                        siteManagementDt.draw();
                    },
                    error: function (response) {
                        errors = response.responseJSON.errors || {};

                        $.each(errors, function (key, value) {
                            var inputName = key.includes('.') ? key.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']' : key; // Keep non-nested keys unchanged
                            var input = $('#create_site_modal_form [name="' + inputName.replace(/(\[|\])/g, '\\$1') + '"]');
                            parent = input.closest('.mb-5');
                            input.addClass('is-invalid');
                            parent.find('.select2-selection').addClass('border-danger');
                            parent.find('.invalid-feedback').first().text(value[0]).show();
                        })
                    }
                })
            });

            $('body').on('click', '.edit_site', function () {
                resetSiteForm('#edit_site_modal_form');
                var id = $(this).attr('data-site-id');
                var url = location.origin + '/settings/sites/edit/' + id;
                $('#edit_site_modal_form [name="id"]').val(id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        $.each(response.site, function (key, value) {
                            input = $('#edit_site_modal_form [name="' + key + '"]');
                            input.val(value);
                        });

                        if (response.rooms.length > 0) {
                            editRoomsRepeater.setList(response.rooms.map(room => ({
                                name: room.name,
                                room_id: room.encrypted_id
                            })));
                            $('#edit_site_modal #site_rooms [data-repeater-item]').first().find('[data-repeater-delete]').remove();
                        }

                        setTimeout(function() {
                            $('#edit_site_modal').modal('show');
                        }, 300);
                    },
                })
            })

            $('body').on('click', '#update_site', function () {
                var id = $('#edit_site_modal_form [name="id"]').val();
                var url = location.origin + '/settings/sites/update/' + id;
                var formData = $('#edit_site_modal_form').serializeArray();
                console.log(url, formData);
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: formData,
                    success: function (response) {
                        $('#edit_site_modal').modal('hide');
                        siteManagementDt.draw();
                    },
                    error: function (response) {
                        errors = response.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            input = $('[name="' + key + '"]');
                            parent = input.parent();
                            input.addClass('is-invalid');
                            parent.find('.select2-selection').addClass('border-danger');
                            parent.find('.invalid-feedback').text(value);
                        })
                    }
                })
            });

            $('body').on('click', '.delete_site', function () {
                siteId = $(this).attr('data-site-id');
                $('#delete_site_modal_form [name="id"]').val(siteId);
                $('#delete_site_modal').modal('show');
            });

            $('body').on('click', '#delete_site', function () {
                var id = $('#delete_site_modal_form [name="id"]').val();
                var url = location.origin + '/settings/sites/delete/' + id;
                var formData = $('#delete_site_modal_form').serializeArray();
                console.log(formData)
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: formData,
                    success: function (response) {
                        siteManagementDt.draw();
                        $('#delete_site_modal').modal('hide');
                    }
                });
            });

        });
    </script>
@endsection