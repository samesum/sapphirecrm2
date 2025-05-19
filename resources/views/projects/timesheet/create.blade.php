<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.timesheet.store') }}" method="post" id="ajaxTimeSheetForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" required placeholder="{{ get_phrase('Enter Title') }}">
                    </div>


                    @if (auth()->user()->role_id == 1)
                        <div class="fpb7 mb-2">
                            <label for="staff" class="form-label">{{ get_phrase('Assign staff') }}</label>
                            <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="staff" name="staff" required>
                                <option value="">{{ get_phrase('Select staff') }}</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}"> {{ $staff->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif(auth()->user()->role_id == 3)
                        <input type="hidden" name="staff" value="{{ auth()->user()->id }}">
                    @else
                        <input type="hidden" name="staff">
                    @endif

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="dateTimeRange">{{ get_phrase('Date-time range') }}</label>
                        <input class="form-control ol-form-control dateTimeRangePicker" type="text" id="dateTimeRange" name="dateTimeRange" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxTimeSheetForm')" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
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
