<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.milestone.update', $milestone->id) }}" method="post" id="ajaxMilestoneForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <input type="hidden" name="project_id" value="{{ $milestone->project_id }}" />
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $milestone->title }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="description">{{ get_phrase('Description') }}</label>
                        <textarea class="form-control ol-form-control" name="description" id="description" cols="30" rows="5" required>{{ $milestone->description }}</textarea>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="progress">{{ get_phrase('Task progress') }}</label>
                        <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="progress" name="progress" required>
                            @for ($i = 0; $i <= 100; $i += 5)
                                <option @if($i == $milestone->progress) selected @endif value="{{ $i }}"> {{ $i }} % </option>
                            @endfor
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="task_id">{{ get_phrase('Select Tasks') }}</label>
                        <div class="d-flex gap-2 flex-row flex-wrap align-items-center">
                            @php
                                $tasks = App\Models\Task::where('project_id', $milestone->project_id)->get();
                            @endphp
                            @foreach ($tasks as $task)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="task_{{ $task->id }}" name="tasks[]" value="{{ $task->id }}" {{ in_array($task->id, $milestone->tasks) ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="task_{{ $task->id }}">
                                        {{ $task->title }} ({{$task->progress}}%)
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxMilestoneForm')" class="btn ol-btn-primary">{{ get_phrase('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(".ol-modal-select2").select2({
        dropdownParent: $('#ajaxOffcanvas')
    });
    $('.ol-modal-select2').addClass('inited');

    $(".ol-modal-niceSelect").niceSelect({
        dropdownParent: $('#ajaxOffcanvas')
    });
    $('.ol-modal-niceSelect').addClass('inited');
</script>