<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.meeting.update',['id'=>$meeting->id]) }}" method="post" id="ajaxMeetingForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $meeting->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            value="{{ $meeting->title }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label ol-form-label" for="meetingStatus">{{ get_phrase('Meeting status') }}</label>
                        <select name="status" id="meetingStatus" class="form-control ol-select2" required>
                            <option value="upcoming" @if($meeting->status == 'upcoming') selected @endif>{{ get_phrase('Upcoming') }}</option>
                            <option value="ongoing" @if($meeting->status == 'ongoing') selected @endif>{{ get_phrase('Ongoing') }}</option>
                            <option value="ended" @if($meeting->status == 'ended') selected @endif>{{ get_phrase('Ended') }}</option>
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="timestamp_meeting">{{ get_phrase('Time') }}</label>
                        <input type="text" class="form-control ol-form-control dateTimePicker" id="timestamp_meeting" name="timestamp_meeting" value="{{ $meeting->timestamp_meeting }}" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label ol-form-label" for="meetingType">{{ get_phrase('Meeting type') }}</label>
                        <select name="meeting_type" id="meetingType" class="form-control ol-select2" required>
                            <option value="online" @if($meeting->meeting_type == 'online') selected @endif>{{ get_phrase('Online') }}</option>
                            <option value="offline" @if($meeting->meeting_type == 'offline') selected @endif>{{ get_phrase('Offline') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label ol-form-label" for="meetingAgenda">{{ get_phrase('Meeting agenda') }}</label>
                        <textarea name="agenda" id="meetingAgenda" class="form-control ol-form-control" rows="6">{{ $meeting->agenda }}</textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxMeetingForm')" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
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