<div class="modal fade" tabindex="-1" id="create_booking_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create a Booking</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-solid ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="create_booking_modal_form" class="mb-0">
                    @csrf
                    <div class="mb-5">
                        <label class="form-label">Subject <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="subject" class="form-control" placeholder="Booking subject" autocomplete="off">
                        <div class="invalid-feedback">Subject is required.</div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-6">
                            <label class="form-label">Date from <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="start_datetime" class="form-control" placeholder="Date from"
                                autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Date to</label>
                            <input type="text" name="end_datetime" class="form-control" placeholder="Date to"
                                autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button id="create_booking" type="button" class="btn btn-primary" data-url="{{ route('booking.create') }}">Save</button>
            </div>
        </div>
    </div>
</div>