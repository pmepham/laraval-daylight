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
                            <i class="ki-solid ki-menu fs-3 m-0"></i></a>Account Management</div>
                </div>
                <div class="card-body p-5">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack mb-5">
                        <button class="btn btn-sm btn-primary create_account">Add an Account</button>
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-solid ki-magnifier fs-1 position-absolute ms-6"></i>
                            <input id="search_account_management_dt" type="text" class="form-control form-control-solid w-250px ps-15" placeholder="Search Accounts" />
                        </div>
                    </div>

                    <!--begin::Datatable-->
                    <table id="account_management_dt" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Activated on</th>
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
    @include('settings.components.create-account-modal', $permissionLevels)
    @include('settings.components.edit-account-modal', $permissionLevels)
    @include('settings.components.delete-account-modal')
@endsection

@section('javascript')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    $(document).ready(function(){

        var accountManagementDt = $('#account_management_dt').DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            ajax: {
                url: '{{ route('settings.accounts.data') }}',
                type: "GET",
            },
            columns: [
                { data: 'name' },
                { data: 'email' },
                { data: 'activated_on', searchable: false },
                { data: 'actions' },
            ],
            columnDefs: [{target: 3, className: 'text-end'}]
        });

        $('body').on('keyup', '#search_account_management_dt', function(){
            accountManagementDt.search($(this).val()).draw();
        });

        $('body').on('click', '.create_account', function(){
            console.log('here')
            $('#create_account_modal').modal('show');
        });

        $('body').on('click', '#create_account', function(){
            var formData = $('#create_account_modal_form').serializeArray();
            $.ajax({
                url: '{{ route('settings.accounts.create') }}',
                type: 'POST',
                data: formData,
                success:function(response){
                    $('#create_account_modal').modal('hide');
                    accountManagementDt.draw();
                },
                error:function(response){
                    errors = response.responseJSON.errors;
                    $.each(errors, function(key, value){
                        input = $('[name="'+key+'"]');
                        parent = input.parent();
                        input.addClass('is-invalid');
                        parent.find('.select2-selection').addClass('border-danger');
                        parent.find('.invalid-feedback').text(value);
                    })
                }
            })
        });

        $('body').on('click', '.edit_account', function(){
            //fetch the data
            var id = $(this).attr('data-user-id');
            var url = location.origin+'/settings/accounts/edit/'+id;
            $.ajax({
                url: url,
                type: 'GET',
                success:function(response){
                    $.each(response, function(key, value){
                        input = $('#edit_account_modal_form [name="'+key+'"]');
                        input.val(value);
                        if(input.attr('type') == 'checkbox'){
                            input.prop('checked', value);
                        }
                        if(input.prop('tagName') == 'SELECT'){
                            input.find('option').each(function () {
                                $(this).prop('selected', false);
                                if($(this).text() == value){
                                    $(this).prop('selected', true);
                                }
                            })
                            input.select2().trigger('select2:select');
                        }
                    });
                    $('#edit_account_modal').modal('show');
                },
            })
        })

        $('body').on('click', '#update_account', function(){
            var id = $('#edit_account_modal_form [name="id"]').val();
            var url = location.origin+'/settings/accounts/update/'+id;
            var formData = $('#edit_account_modal_form').serializeArray();
            $.ajax({
                url: url,
                type: 'PUT',
                data: formData,
                success:function(response){
                    $('#edit_account_modal').modal('hide');
                    accountManagementDt.draw();
                },
                error:function(response){
                    errors = response.responseJSON.errors;
                    $.each(errors, function(key, value){
                        input = $('[name="'+key+'"]');
                        parent = input.parent();
                        input.addClass('is-invalid');
                        parent.find('.select2-selection').addClass('border-danger');
                        parent.find('.invalid-feedback').text(value);
                    })
                }
            })
        });

        $('body').on('click', '.delete_account', function(){
            userId = $(this).attr('data-user-id');
            $('#delete_account_modal_form [name="id"]').val(userId);
            $('#delete_account_modal').modal('show');
        });

        $('body').on('click', '#delete_account', function(){
            var id = $('#delete_account_modal_form [name="id"]').val();
            var url = location.origin+'/settings/accounts/delete/'+id;
            var formData = $('#delete_account_modal_form').serializeArray();
            $.ajax({
                url: url,
                type: 'DELETE',
                data: formData,
                success:function(response){
                    accountManagementDt.draw();
                    $('#delete_account_modal').modal('hide');
                }
            });
        });

    });
</script>
@endsection