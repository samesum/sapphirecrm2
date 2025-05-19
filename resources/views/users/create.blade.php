<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route('admin.user.store') }}" method="post" id="ajaxUserForm" enctype="multipart/form-data">@csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <input type="hidden" name="role_id" value="{{ $role_id }}" />
                        <label class="form-label ol-form-label" for="name">{{ get_phrase('Name') }}</label>
                        <input class="form-control ol-form-control" type="text" id="name" name="name" placeholder="{{ get_phrase('Name') }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="email">{{ get_phrase('Email') }}</label>
                        <input class="form-control ol-form-control" type="email" id="email" name="email" placeholder="{{ get_phrase('Email') }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="password">{{ get_phrase('Password') }}</label>
                        <input class="form-control ol-form-control" type="password" id="password" name="password" placeholder="{{ get_phrase('Min 8 characters required') }}" required>
                    </div>
                    <div class="fpb-7 mb-2">
                        <label class="form-label ol-form-label" for="role_id">{{ get_phrase('User Type') }}</label>
                        <div class="d-flex flex-row flex-wrap align-items-center">
                            @foreach ($roles as $role)
                                <div class="radio-check form-check me-3">
                                    <input type="radio" @checked(request()->query('type') == $role->title) class="radio-input form-check-input" id="role_{{ $role->id }}" name="role_id" value="{{ $role->id }}" required>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="photo">{{ get_phrase('Photo') }}</label>
                        <div class="upload-container">
                            <div class="drop-zone">
                                <p>{{get_phrase('Drag & Drop or Browse')}}</p>
                                <input type="file" name="photo" class="file-input" hidden>
                            </div>
                            <ul class="file-list"></ul>
                        </div>
                    </div>

                    <div class="fpb7 mb-2">
                        <button type="button" id="ajaxFormBtn" class="btn ol-btn-primary" onclick="handleAjaxFormSubmission('ajaxUserForm')">{{ get_phrase('Add user') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    "use strict";

    initiatePlugins();
</script>