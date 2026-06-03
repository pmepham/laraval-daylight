@extends('layout.auth')

@section('title') Login @endsection

@section('content')
<div class="w-lg-500px p-10 p-lg-15 mx-auto card shadow-sm">
    <form class="form w-100" novalidate id="login-form">
        <div class="text-center mb-10">
            <img alt="Logo" src="assets/media/logos/daylight.png" class="" style="width:300px;">
            <h1 class="text-gray-900 mb-3">Login</h1>
        </div>
        @csrf
        <div id="error" style="display:none;">
            <div class="alert alert-dismissible bg-light-danger d-flex flex-column align-items-center flex-sm-row w-100 p-5 mb-10">
                <i class="ki-solid ki-information-3 fs-2hx text-danger me-4 mb-5 mb-sm-0"></i>
                <div class="d-flex flex-column pe-0">
                    <h4 class="fw-semibold mb-0 error-message"></h4>
                </div>
            </div>
        </div>
        <div class="form-input mb-5">
            <label class="form-label fs-6 fw-bold text-gray-900">Email</label>
            <input class="form-control form-control-lg form-control" type="text" name="email" autocomplete="off">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-input mb-5">
            <div class="d-flex flex-stack mb-2">
                <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Password</label>
            </div>
            <input class="form-control form-control-lg form-control" type="password" name="password"
                autocomplete="off">
            <div class="invalid-feedback"></div>
        </div>
        <div class="text-center">
            <button id="login-submit" class="btn btn-lg btn-primary w-100 mb-5">
                <span class="indicator-label">Login</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>


            <!--
            <div class="text-center text-muted text-uppercase fw-bold mb-5">or</div>
            <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="h-20px me-3">Continue with
                Google</a>
            <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                <img alt="Logo" src="assets/media/svg/brand-logos/facebook-4.svg" class="h-20px me-3">Continue with
                Facebook</a>
            <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100">
                <img alt="Logo" src="assets/media/svg/brand-logos/apple-black.svg" class="theme-light-show h-20px me-3">
                <img alt="Logo" src="assets/media/svg/brand-logos/apple-black-dark.svg"
                    class="theme-dark-show h-20px me-3">Continue with Apple</a>
            -->

        </div>
        <div class="text-center">
            Don't have an account? <a href="/register">Register</a>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function(){

    $('#login-submit').on('click', function(e){
        e.preventDefault();
        var submit = $(this)
        if (!submit.prop('disabled')) {
            submit.prop('disabled', true);
            submit.attr('data-kt-indicator', 'on');
            var form = $('#login-form');
            var formData = form.serializeArray();
            $.ajax({
                url: '{{ route('login.authenticate') }}',
                type: 'POST',
                data: formData,
                success:function(response){
                    $('#error').hide();
                    form.find('.is-invalid').removeClass('is-invalid')
                    form.find('.form-control').addClass('is-valid')
                    KTUtil.loadSwal('Logging In', 'Please wait...', 'success', null);
                    setTimeout(function () {
                        window.location.assign(response.redirect);
                    }, 1500);
                },
                error:function(response){
                    form.find('.is-invalid').removeClass('is-invalid');
                    submit.prop('disabled', false);
                    submit.attr('data-kt-indicator', '');
                    var errors = response.responseJSON.errors;
                    if (errors != undefined) {
                        $('#error').hide();
                        form.find('.is-invalid').removeClass('is-invalid');
                        $.each(errors, function (key, value) {
                            form.find('[name="' + key + '"]').addClass('is-invalid').closest('.form-input').find('.invalid-feedback').text(value);
                        })
                    }
                }
            });
        }
    });

});
</script>
@endsection