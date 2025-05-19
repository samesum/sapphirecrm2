@extends('layouts.admin')
@push('title', get_phrase('Events'))

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    @if (has_permission('event.create'))
                        <button onclick="rightCanvas('{{ route(get_current_user_role() . '.event.create') }}', 'Create event')"
                            class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px enable-no-data-action mb-3 ms-auto">
                            <span class="fi-rr-plus"></span>
                            <span>{{ get_phrase('Add new') }}</span>
                        </button>
                    @endif
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";
        
        $(document).ready(function() {
            let getEvents = @json($events);
            var calendarEl = $('#calendar')[0];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,list'
                },
                initialDate: @json(date('Y-m-d', strtotime('now'))),
                navLinks: true,
                nowIndicator: true,
                editable: true,
                selectable: true,
                dayMaxEvents: true,
                events: getEvents,
                height: 'auto',
                contentHeight: 600,

                dateClick: function(info) {

                    @if (has_permission('event.create'))
                        let create_link =
                            "{{ route(get_current_user_role() . '.event.create') }}?date=" + info
                            .dateStr;
                            let url = create_link;
                            rightCanvas(url, '{{get_phrase("Create Event")}}');
                    @else
                        let create_link = "javascript:void(0)";
                    @endif

                },

                eventClick: function(info) {
                    let eventId = info.event.id;

                    @if(has_permission('event.edit') || has_permission('event.delete'))
                        let update_link = "{{ route(get_current_user_role() . '.event.edit') }}?event_id=" + eventId;
                        let url = update_link;
                        rightCanvas(url, '{{has_permission('event.edit') ? get_phrase("Edit Event") : get_phrase("Delete Event")}}');
                    @else
                        let update_link = "javascript:void(0)";
                    @endif

                },

                eventDidMount: function(info) {
                    $(info.el).css({
                        backgroundColor: info.event.extendedProps.backgroundColor || "#EEF6FF",
                        color: info.event.extendedProps.textColor || "#0A1017",
                        borderRadius: info.event.extendedProps.borderRadius || "8px",
                        padding: info.event.extendedProps.padding || "10px",
                        border: info.event.extendedProps.border || "1px solid #7BD3EA",
                        height: "auto"
                    });
                }
            });

            calendar.render();

        });
    </script>
@endpush
