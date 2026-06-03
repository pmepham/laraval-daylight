<div class="d-none d-lg-flex flex-column flex-lg-row-auto w-100 w-lg-275px" data-kt-drawer="true"
    data-kt-drawer-name="inbox-aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_inbox_aside_toggle">

    <!--begin::Sticky aside-->
    <div class="card card-flush mb-0" data-kt-sticky="false" data-kt-sticky-name="inbox-aside-sticky"
        data-kt-sticky-offset="{default: false, xl: '100px'}" data-kt-sticky-width="{lg: '275px'}"
        data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false"
        data-kt-sticky-zindex="95">
        <!--begin::Aside content-->
        <div class="card-body p-5">
            <div
                class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary mb-10">
                <div class="menu-item mb-3">
                    <a class="menu-link  @if($active_settings_menu == 'general') 'active' @endif" href="{{ route('settings.general') }}">
                        <span class="menu-icon"><i class="ki-solid ki-setting-2 fs-2 me-3"></i></span>
                        <span class="menu-title fw-bold">General Settings</span>
                    </a>
                </div>
                <div class="menu-item mb-3">
                    <a class="menu-link <?= $active_settings_menu == 'accounts' ? 'active' : '' ?>" href="{{ route('settings.accounts') }}">
                        <span class="menu-icon"><i class="ki-solid ki-people fs-2 me-3"></i></span>
                        <span class="menu-title fw-bold">Account Management</span>
                    </a>
                </div>
                <div class="menu-item mb-3">
                    <a class="menu-link <?= $active_settings_menu == 'assessments' ? 'active' : '' ?>" href="{{ route('settings.assessments') }}">
                        <span class="menu-icon"><i class="ki-solid ki-questionnaire-tablet fs-2 me-3"></i></span>
                        <span class="menu-title fw-bold">Assessment Management</span>
                    </a>
                </div>
                <div class="menu-item mb-3">
                    <a class="menu-link <?= $active_settings_menu == 'sites' ? 'active' : '' ?>" href="{{ route('settings.sites') }}">
                        <span class="menu-icon"><i class="ki-solid ki-geolocation-home fs-2 me-3"></i></span>
                        <span class="menu-title fw-bold">Site Management</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>