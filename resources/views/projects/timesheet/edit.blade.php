<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.timesheet.update', $timesheet->id) }}" method="post"
            id="ajaxTimeSheetForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $timesheet->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{get_phrase('Title')}}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            value="{{ $timesheet->title }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label for="user" class="form-label">{{ get_phrase('Assign staff') }}</label>
                        <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="staff" name="staff" required>
                            <option value="">{{ get_phrase('Select staff') }}</option>
                            @foreach ($staffs as $staff)
                                <option value="{{$staff->id}}" {{$staff->id == $timesheet->staff ? 'selected':''}}> {{$staff->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="dateTimeRange">{{ get_phrase('Date-time range') }}</label>
                        <input class="form-control ol-form-control dateTimeRangePicker" value="{{ $timesheet->timestamp_end }} - {{ $timesheet->timestamp_start }}" type="text" id="dateTimeRange" name="dateTimeRange" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxTimeSheetForm')" class="btn ol-btn-primary">{{get_phrase('Submit')}}</button>
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
    $(".ol-modal-select2").addClass('inited');

    initiatePlugins();
</script>

