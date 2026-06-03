<div class="modal fade" tabindex="-1" id="create_account_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create an Account</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-solid ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="create_account_modal_form" class="mb-0">
                    @csrf
                    <div class="mb-5">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" autocomplete="off">
                        <div class="invalid-feedback">Email is required.</div>
                    </div>
                    <div class="mb-5 row">
                        <div class="col-6">
                            <label class="form-label">Firstname</label>
                            <input type="text" name="firstname" class="form-control" placeholder="Firstname" autocomplete="off">
                            <div class="invalid-feedback">Firstname is required</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Lastname</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Lastname" autocomplete="off">
                            <div class="invalid-feedback">Lastname is required</div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="password" autocomplete="off">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-0 row">
                        <div class="col-6">
                            <label class="form-label">Permission Level</label>
                            <select name="permission_level" class="form-select" data-control="select2" data-placeholder="Select an option" data-allow-clear="true">
                                @foreach($permissionLevels as $permissionLevel):
                                <option value="<?= $permissionLevel; ?>"><?= $permissionLevel; ?></option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Permission Level is required</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="activated" name="activated" checked/>
                                <label class="form-label" for="activated">
                                    Account Activated
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button id="create_account" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>