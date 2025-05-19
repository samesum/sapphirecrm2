<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.project.store') }}" method="post" id="ajaxProjectForm"> @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" placeholder="{{ get_phrase('Enter title') }}" type="text" id="title" name="title" required>
                    </div>

                    @if (auth()->user()->role_id == 2)
                        <input type="hidden" value="{{auth()->user()->id}}">
                    @else
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                            <select class="form-select ol-modal-select2 ol-select2 ol-form-control" name="client_id" required>
                                <option value=""> {{ get_phrase('Select client') }} </option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="code">{{ get_phrase('Code') }}</label>
                        <input class="form-control ol-form-control" value="{{strtoupper(random(8))}}" placeholder="{{ get_phrase('Enter code') }}" type="text" id="code" name="code" readonly required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="description">{{ get_phrase('Description') }}</label>
                        <textarea class="form-control ol-form-control" id="description" name="description" placeholder="{{ get_phrase('Enter description') }}" required></textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="note">{{ get_phrase('Note') }}</label>
                        <textarea class="form-control ol-form-control" id="note" name="note" placeholder="{{ get_phrase('Enter Note') }}" required></textarea>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="category_id">{{ get_phrase('Category') }}</label>
                        <select class="form-select ol-modal-select2 ol-select2 ol-form-control" name="category_id" required>
                            <option value=""> {{ get_phrase('Select category') }} </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if (auth()->user()->role_id == 1)
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label" for="staffs">{{ get_phrase('Staffs') }}</label>
                            <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="staffs" name="staffs[]" required multiple>
                                <option value="">{{ get_phrase('Select staffs') }}</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }} - ({{ $staff->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="budget">{{ get_phrase('Budget') }}</label>
                        <input class="form-control ol-form-control" type="number" id="budget" name="budget" placeholder="{{ get_phrase('Enter budget') }}" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-niceSelect ol-modal-niceSelect" id="status" name="status" required>
                            <option value="in_progress">{{ get_phrase('In Progress') }}</option>
                            <option value="not_started">{{ get_phrase('Not Started') }}</option>
                            <option value="completed">{{ get_phrase('Completed') }}</option>
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="note">{{ get_phrase('Progress') }}</label>
                        <select class="form-control ol-form-control ol-modal-select2 ol-select2" data-toggle="select2" id="progress" name="progress" required>
                            <option value="">{{ get_phrase('Select progress') }}</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="privacy">{{ get_phrase('Privacy') }}</label>
                        <select class="form-control ol-form-control ol-niceSelect ol-modal-niceSelect" data-toggle="select2" id="privacy" name="privacy" required>
                            <option value="">{{ get_phrase('Select Privacy') }}</option>
                            <option value="public">{{ get_phrase('Public') }}</option>
                            <option value="private">{{ get_phrase('Private') }}</option>
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="button" class="btn ol-btn-primary" onclick="handleAjaxFormSubmission('ajaxProjectForm')">{{ get_phrase('Submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    "use strict";

    $(".ol-modal-select2").select2({
        dropdownParent: $('#ajaxOffcanvas')
    });
    $(".ol-modal-niceSelect").niceSelect({
        dropdownParent: $('#ajaxOffcanvas')
    });
</script>
