<x-admin-layout>

    <h1 class="app-page-title">Settings</h1>
    <hr class="mb-4">
    <div class="row g-4 settings-section">
        <div class="col-12 col-md-4">
            <h3 class="section-title">General</h3>
            <div class="section-intro">Busine information goes here.</div>
        </div>
        <div class="col-12 col-md-8">
            <div class="app-card app-card-settings shadow-sm p-4">

                <div class="app-card-body">
                    <form class="settings-form" method="POST"
                        action="{{ !empty($system->id) ? '/admin/settings/' . $system->id . '/update' : '/admin/settings/create' }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (!empty($system->id))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label for="setting-input-1" class="form-label">Business Name<span class="ms-2"
                                    data-container="body" data-bs-toggle="popover" data-trigger="hover"
                                    data-placement="top"
                                    data-content="This is a Bootstrap popover example. You can use popover to provide extra info."><svg
                                        width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path
                                            d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z" />
                                        <circle cx="8" cy="4.5" r="1" />
                                    </svg></span></label>
                            <input type="text" class="form-control" id="setting-input-1" name="business_name"
                                required placeholder="Please enter business name"
                                value="{{ $system->business_name ?? null }}">
                        </div>
                        <div class="mb-3">
                            <label for="setting-input-2" class="form-label">Business Address</label>
                            <input type="text" class="form-control" id="setting-input-2" name="address"
                                placeholder="Please enter business address" required
                                value="{{ $system->address ?? null }}">
                        </div>
                        <div class="mb-3">
                            <label for="setting-input-2" class="form-label">Business Number</label>
                            <input type="text" class="form-control" placeholder="Please enter business number"
                                id="setting-input-3" required name="contact" value="{{ $system->contact ?? null }}">
                        </div>
                        <div class="mb-3">
                            <label for="setting-input-3" class="form-label">Business Email Address</label>
                            <input type="email" class="form-control" id="setting-input-4"
                                placeholder="Please enter email address" name="email"
                                value="{{ $system->email ?? null }}">
                        </div>
                        <div class="mb-3">
                            <label for="setting-input-7" class="form-label">Non-Vat(%)</label>
                            <input type="number" class="form-control" id="setting-input-7"
                                placeholder="Please enter vat percentage" name="vat"
                                value="{{ $system->vat ?? 6 }}">
                        </div>
                        <div class="mb-3">
                            <label for="setting-input-3" class="form-label">System Name</label>
                            <input type="text" class="form-control" id="setting-input-5"
                                placeholder="Please enter email address" name="system_name"
                                value="{{ $system->system_name ?? null }}">
                        </div>
                        <div class="mb-3">
                            <label for="setting-input-3" class="form-label">Business logo</label>
                            <input type="file" class="form-control" id="setting-input-6" name="logo"
                                accept="image/*">
                            @if (!empty($system->logo))
                                <img class="logo-icon mt-2" src="{{ asset('storage/' . $system->logo) }}" alt="logo"
                                    width="80">
                            @endif

                        </div>
                        <button type="submit" class="btn app-btn-primary">Save Changes</button>
                    </form>
                </div>
                <!--//app-card-body-->

            </div>
            <!--//app-card-->
        </div>
    </div>
    <!--//row-->


</x-admin-layout>
