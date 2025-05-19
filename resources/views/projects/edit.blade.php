<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.project.update', $project->code) }}" method="post" id="ajaxProjectForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $project->title }}" required>
                    </div>

                    @if (auth()->user()->role_id != 2)
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="client_id" required>
                                <option value="">{{ get_phrase('Select a client') }}</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="code">{{ get_phrase('Code') }}</label>
                        <input class="form-control ol-form-control" type="text" id="code" name="code" value="{{ $project->code }}" readonly required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="description">{{ get_phrase('Description') }}</label>
                        <textarea class="form-control ol-form-control" id="description" name="description" required>{{ $project->description }}</textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="category_id">{{ get_phrase('Category') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="category_id" required>
                            <option value=""> {{ get_phrase('select category') }} </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $project->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if (auth()->user()->role_id == 1)
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label" for="staffs">{{ get_phrase('Staffs') }}</label>
                            @php
                                $assigned_staffs = json_decode($project->staffs, true) ?? [];
                            @endphp
                            <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="staffs" name="staffs[]" required multiple>
                                <option value="">{{ get_phrase('Select staffs') }}</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}" {{ in_array($staff->id, $assigned_staffs) ? 'selected' : '' }}>{{ $staff->name }} - ({{ $staff->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="budget">{{ get_phrase('Budget') }}</label>
                        <input class="form-control ol-form-control" type="number" id="budget" name="budget" value="{{ $project->budget }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status" id="status">
                            <option value="not_started" {{ $project->status == 'not_started' ? 'selected' : '' }}>
                                {{ get_phrase('Not Started') }}</option>
                            <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>
                                {{ get_phrase('In Progress') }}</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>
                                {{ get_phrase('Completed') }}</option>
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="note">{{ get_phrase('Progress') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" id="progress" name="progress" required>
                            <option value="{{ old('progress', $project->progress) }}">{{ old('progress', $project->progress) }}</option>
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="note">{{ get_phrase('Note') }}</label>
                        <textarea class="form-control ol-form-control" id="note" name="note" required>{{ $project->note }}</textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="privacy">{{ get_phrase('Privacy') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" id="privacy" name="privacy" required>
                            <option value="">{{ get_phrase('Select Privacy') }}</option>
                            <option value="public" {{ $project->privacy == 'public' ? 'selected' : '' }}>{{ get_phrase('Public') }}</option>
                            <option value="private" {{ $project->privacy == 'private' ? 'selected' : '' }}>{{ get_phrase('Private') }}</option>
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="button" class="btn ol-btn-primary" onclick="handleAjaxFormSubmission('ajaxProjectForm')">{{ get_phrase('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    "use strict";

    $("select.ol-select2:not(.inited)").select2({
        dropdownParent: $('#ajaxOffcanvas')
    });
    $("select.ol-niceSelect:not(.inited)").niceSelect({
        dropdownParent: $('#ajaxOffcanvas')
    });
</script>
