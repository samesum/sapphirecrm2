<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.task.update', $task->id) }}" method="post" id="ajaxTaskForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $task->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $task->title }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status" id="status">
                            <option value="not_started" {{ $task->status == 'not_started' ? 'selected' : '' }}>
                                {{ get_phrase('Not Started') }}</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>
                                {{ get_phrase('In Progress') }}</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>
                                {{ get_phrase('Completed') }}</option>
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="progress">{{ get_phrase('Task progress') }}</label>
                        <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="progress" name="progress" required>
                            @for ($i = 0; $i <= 100; $i += 5)
                                <option @if($i == $task->progress) selected @endif value="{{ $i }}"> {{ $i }} % </option>
                            @endfor
                        </select>
                    </div>

                    <div class="fpb7 mb-2 @if(auth()->user()->role_id != 1) d-none @endif">
                        <label class="form-label ol-form-label" for="team_member">{{ get_phrase('Team member') }}</label>
                        @php
                            $assigned_staffs = json_decode($task->team, true) ?? [];
                        @endphp
                        <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="team_member" name="team_member[]" required multiple>
                            <option value="">{{ get_phrase('Select team member') }}</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}" {{ in_array($staff->id, $assigned_staffs) ? 'selected' : '' }}>{{ $staff->name }} - ({{ $staff->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="task_date_range">{{ get_phrase('Date range') }}</label>
                        <input class="form-control ol-form-control dateRangePicker" value="{{ date('Y-m-d', $task->start_date) }} - {{ date('Y-m-d', $task->end_date) }}" type="text" id="task_date_range" name="task_date_range" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxTaskForm')" class="btn ol-btn-primary">{{ get_phrase('Update') }}</button>
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
    $('.ol-modal-select2').addClass('inited');

    $(".ol-modal-niceSelect").niceSelect({
        dropdownParent: $('#ajaxOffcanvas')
    });
    $('.ol-modal-niceSelect').addClass('inited');


    initiatePlugins();
</script>
