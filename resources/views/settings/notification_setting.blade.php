@extends('layouts.admin')
@push('title', get_phrase('SMTP settings'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="row ">
        <div class="col-md-8">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    @include('settings.smtp_setting')
                </div>
            </div> <!-- end card-body-->
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        "use strict";
        $(document).ready(function() {
            function notification_enable_disable(id, user_type, notification_type) {

                alert();
                var input_val = $('#' + id + user_type + '_' + notification_type).prop('checked');
                if (!input_val) {
                    input_val = 1;
                } else {
                    input_val = 0;
                }
                console.log(user_type);

                $.ajax({
                    type: "get",
                    url: '{{ route('admin.notification_settings.store', ['param1' => 'notification_enable_disable']) }}',
                    data: {
                        id: id,
                        user_types: user_type,
                        notification_type: notification_type,
                        input_val: input_val
                    },


                    success: function(response) {
                        if (response.status == 'success') {
                            console.log(response.msg);
                            success_notify(response.msg);
                        }
                    }
                });
            }
        });
    </script>



@endpush
