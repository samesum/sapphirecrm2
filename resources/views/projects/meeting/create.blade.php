<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.meeting-store') }}" method="post" id="ajaxMeetingForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" placeholder="{{ get_phrase('Enter Title') }}" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label ol-form-label" for="meetingStatus">{{ get_phrase('Meeting status') }}</label>
                        <select name="status" id="meetingStatus" class="form-control ol-select2" required>
                            <option value="upcoming">{{ get_phrase('Upcoming') }}</option>
                            <option value="ongoing">{{ get_phrase('Ongoing') }}</option>
                            <option value="ended">{{ get_phrase('Ended') }}</option>
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="timestamp_meeting">{{ get_phrase('Time') }}</label>
                        <input type="text" class="form-control ol-form-control dateTimePicker" id="timestamp_meeting" name="timestamp_meeting" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label ol-form-label" for="meetingType">{{ get_phrase('Meeting type') }}</label>
                        <select name="meeting_type" id="meetingType" class="form-control ol-select2" required>
                            <option value="online">{{ get_phrase('Online') }}</option>
                            <option value="offline">{{ get_phrase('Offline') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label ol-form-label" for="meetingAgenda">{{ get_phrase('Meeting agenda') }}</label>
                        <textarea name="agenda" id="meetingAgenda" class="form-control ol-form-control" rows="6"></textarea>
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
