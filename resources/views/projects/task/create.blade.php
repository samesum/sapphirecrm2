<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.task.store') }}" method="post" id="ajaxTaskForm">
            @csrf
            <div class="row">
                <div class="col-12">

                    @if (isset($project_id))
                        <input type="hidden" name="project_id" value="{{ $project_id }}" />
                    @else
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label" for="header_project_id">{{ get_phrase('Select project') }}</label>
                            <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="header_project_id" name="project_id" required>
                                <option value="">{{ get_phrase('Select Project') }}</option>
                                @foreach (App\Models\Project::orderBy('id', 'desc')->get() as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif


                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Task Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Task status') }}</label>
                        <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="status" name="status" required>
                            <option value="">
                                {{ get_phrase('Select Status') }}</option>
                            <option value="in_progress">{{ get_phrase('In Progress') }}</option>
                            <option value="not_started">{{ get_phrase('Not Started') }}</option>
                            <option value="completed">{{ get_phrase('Completed') }}</option>
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="progress">{{ get_phrase('Task progress') }}</label>
                        <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="progress" name="progress" required>
                            @for ($i = 0; $i <= 100; $i += 5)
                                <option value="{{ $i }}"> {{ $i }} % </option>
                            @endfor
                        </select>
                    </div>

                    @if (auth()->user()->role_id == 1)
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label" for="team_member">{{ get_phrase('Team member') }}</label>
                            <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="team_member" name="team_member[]" required multiple>
                                <option value="">{{ get_phrase('Select team member') }}</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }} - ({{ $staff->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif(auth()->user()->role_id == 3)
                        <input type="hidden" name="team_member[]" value="{{ auth()->user()->id }}">
                    @else
                        <input type="hidden" name="team_member[]">
                    @endif


                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="task_date_range">{{ get_phrase('Date range') }}</label>
                        <input class="form-control ol-form-control dateRangePicker" type="text" id="task_date_range" name="task_date_range" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxTaskForm')" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
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
