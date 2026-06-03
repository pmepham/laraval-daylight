@extends('layout.auth')

@section('title') Register @endsection

@section('content')
<div class="w-lg-500px p-10 p-lg-15 mx-auto card shadow-sm">
    <form class="form w-100" novalidate="novalidate" id="login-form">
        <div class="text-center mb-10">
            <img alt="Logo" src="assets/media/logos/daylight.png" class="" style="width:300px;">
            <h1 class="text-gray-900 mb-3">Register</h1>
        </div>
        @csrf
        <div class="row mb-5">
            <div class="col-6">
                <div class="form-input">
                    <label class="form-label fs-6 fw-bold text-gray-900">Firstname <span class="text-danger">*</span></label>
                    <input class="form-control form-control-lg form-control" type="text" name="firstname" autocomplete="off">
                </div>
            </div>
            <div class="col-6">
                <div class="form-input">
                    <label class="form-label fs-6 fw-bold text-gray-900">Lastname <span class="text-danger">*</span></label>
                    <input class="form-control form-control-lg form-control" type="text" name="lastname" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-input">
                    <input type="hidden" name="name">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
        <div class="form-input mb-5">
            <label class="form-label fs-6 fw-bold text-gray-900">Email <span class="text-danger">*</span></label>
            <input class="form-control form-control-lg form-control" type="text" name="email" autocomplete="off">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-input mb-5">
            <div class="d-flex flex-stack mb-2">
                <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Password <span class="text-danger">*</span></label>
            </div>
            <input class="form-control form-control-lg form-control" type="password" name="password" autocomplete="off">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-input mb-5">
            <div class="d-flex flex-stack mb-2">
                <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Confirm Password <span class="text-danger">*</span></label>
            </div>
            <input class="form-control form-control-lg form-control" type="password" name="confirm_password"
                autocomplete="off">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="tac" name="tac" />
            <label class="form-label" for="tac">
                I agree to the <a href="#tandc">Terms and Conditions</a>
            </label>
            <div class="invalid-feedback">You must agree to Terms and Conditions</div>
        </div>
        <div class="text-center">
            <button id="register-submit" class="btn btn-lg btn-primary w-100 mb-5">
                <span class="indicator-label">Register</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
        <div class="text-center">
            Already have an account? <a href="/login">Login</a>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    $('body').on('click', '#register-submit', function(e){
        e.preventDefault();
        var submit = $(this)
        if (!submit.prop('disabled')) {
            submit.prop('disabled', true);
            submit.attr('data-kt-indicator', 'on');
            var form = $('#login-form');
            var formData = form.serializeArray();
            $.ajax({
                url: '{{ route('register.authenticate') }}',
                type: 'POST',
                data: formData,
                success:function(response){
                    $('#error').hide();
                    form.find('.is-invalid').removeClass('is-invalid')
                    form.find('.form-control').addClass('is-valid')
                    KTUtil.loadSwal('Logging In', 'Please wait...', 'success');
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
</script>
@endsection