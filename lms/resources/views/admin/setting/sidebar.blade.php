<div class="col-12 col-md-3 border-end">
    <div class="card-body">
        <h4 class="subheader">Business settings</h4>
        <div class="list-group list-group-transparent">
            <a href="{{ route('admin.settings.index') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('admin.settings.index') ? 'active' : '' }}">
                General Settings
            </a>

            <a href="{{ route('admin.logo-settings.index') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('admin.logo-settings.index') ? 'active' : '' }}">
                Logo & Favicon Settings
            </a>

            <a href="{{ route('admin.commission-settings.index') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('admin.commission-settings.index') ? 'active' : '' }}">
                Commission Settings
            </a>

            <a href="{{ route('admin.smtp-settings.index') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('admin.smtp-settings.index') ? 'active' : '' }}">
                SMTP Settings
            </a>
        </div>
    </div>
</div>
