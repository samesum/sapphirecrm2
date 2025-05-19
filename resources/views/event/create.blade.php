@php
    if(isset($date)){
        $selected_date_range = date('Y-m-d 00:00:00 - Y-m-d 23:59:59', strtotime($date));
    }elseif(isset($event)){
        $selected_date_range = date('Y-m-d H:i:s', strtotime($event->start_date)).' - '.date('Y-m-d H:i:s', strtotime($event->end_date));
    }else{
        $selected_date_range = date('Y-m-d 00:00:00 - Y-m-d 23:59:59');
    }
@endphp
<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.event.store') }}" method="post" id="ajaxEventForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" placeholder="{{get_phrase('Enter Title')}}" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="dateTimeRangePicker">{{ get_phrase('Event date range') }}</label>
                        <br>
                        <input class="form-control ol-form-control dateTimeRangePicker w-100" value="{{$selected_date_range}}" type="text" id="dateTimeRangePicker" name="event_date_range" required>
                    </div>
                    
                    <div class="fpb7 mb-2">
                        <button type="button" class="btn ol-btn-primary" onclick="handleAjaxFormSubmission('ajaxEventForm')">{{ get_phrase('Submit') }}</button>
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