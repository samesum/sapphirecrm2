@php
    if (isset($date)) {
        $selected_date_range = date('Y-m-d 00:00:00 - Y-m-d 23:59:59', strtotime($date));
    } elseif (isset($event)) {
        $selected_date_range = date('Y-m-d H:i:s', strtotime($event->start_date)) . ' - ' . date('Y-m-d H:i:s', strtotime($event->end_date));
    }
@endphp

<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.event.update', $event->id) }}" method="post" id="ajaxEventForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $event->title }}" {{ has_permission('event.edit') ? '' : 'disabled' }}>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="dateTimeRangePicker">{{ get_phrase('Event date range') }}</label>
                        <br>
                        <input class="form-control ol-form-control dateTimeRangePicker w-100" type="text" id="dateTimeRangePicker" value="{{ $selected_date_range }}" name="event_date_range" required {{ has_permission('event.edit') ? '' : 'disabled' }}>
                    </div>

                    <div class="fpb7 mb-2 d-flex gap-3 justify-content-start">
                        @if (has_permission('event.edit'))
                            <button type="button" onclick="handleAjaxFormSubmission('ajaxEventForm')" class="btn ol-btn-primary">{{ get_phrase('Update') }}</button>
                        @endif

                        @if (has_permission('event.delete'))
                            <a href="javascript:void(0)" onclick="confirmModal('{{ route(get_current_user_role() . '.event.delete', ['id' => $event->id]) }}')" class="btn ol-btn-danger">{{ get_phrase('Delete') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    'use strict';

    $(document).ready(function() {
        initiatePlugins();
    });
</script>
