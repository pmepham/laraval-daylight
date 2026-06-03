<div class="modal fade" tabindex="-1" id="create_site_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create a Site</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-solid ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="create_site_modal_form" class="mb-0">
                    @csrf
                    <div class="mb-5">
                        <label class="form-label">Name <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Site name" autocomplete="off">
                        <div class="invalid-feedback">Name is required.</div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-6">
                            <label class="form-label">Address line 1 <span class="text-danger fw-bold">*</span></label>
                            <input type="text" name="address_line_1" class="form-control" placeholder="Address line 1"
                                autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Address line 2</label>
                            <input type="text" name="address_line_2" class="form-control" placeholder="Address line 2"
                                autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-6">
                            <label class="form-label">Address line 3</label>
                            <input type="text" name="address_line_3" class="form-control" placeholder="Address line 3"
                                autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Address line 4</label>
                            <input type="text" name="address_line_4" class="form-control" placeholder="Address line 4"
                                autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Post code <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="post_code" class="form-control" placeholder="Post code"
                            autocomplete="off">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!--begin::Repeater-->
                    <div id="site_rooms">
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="form-label">Rooms</label>
                            <div data-repeater-list="site_rooms">
                                <div data-repeater-item>
                                    <div class="mb-5">
                                        <label class="form-label">Room name <span class="text-danger fw-bold">*</span></label>
                                        <input type="hidden" name="room_id" value="">
                                        <div class="d-flex align-items-center">
                                            <input type="text" name="name" class="form-control me-2" placeholder="Room name" autocomplete="off">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-flex btn-light-danger">
                                                <i class="ki-solid ki-cross fs-3"></i>Delete
                                            </a>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
                                <i class="ki-solid ki-plus fs-3"></i>
                                Add Room
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button id="create_site" type="button" class="btn btn-primary" data-url="{{ route('settings.sites.create') }}">Save</button>
            </div>
        </div>
    </div>
</div>