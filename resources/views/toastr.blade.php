<div class="toast-container position-fixed d-flex justify-content-center align-items-center w-100 top-0 end-0 p-2"></div>

<div class="d-none" id="toaster-content">
    <div class="toast fade text-12 d-flex align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="toaster-content-type">
        <div class="toast-body" id="toaster-content-message"></div>
    </div>
</div>
<script>
    "use strict";

    function processServerResponse(response) {
        if (response.success) {
            success(response.success)
        }

        if (response.error) {
            error(response.error)
        }


        if (response.validationError) {
            // Clear previous errors
            $('.error-message').remove();

            // Loop through each error in the validationError object
            for (let field in response.validationError) {
                if (response.validationError.hasOwnProperty(field)) {
                    let messages = response.validationError[field];
                    error(messages);
                }
            }
        }

    }

    function toaster_message(type, message) {
        message = Array.isArray(message) ? message[0] : message;

        // Step 1: Replace any word ending in `_id` with the same word minus `_id`
        message = message.replace(/\b(\w+)_id\b/g, '$1');

        // Step 2: Replace non-alphanumeric characters with space
        message = message.replace(/[^a-zA-Z0-9:]/g, ' ');

        // Step 3: Trim extra spaces
        message = message.replace(/\s+/g, ' ').trim();


        $('.toast-container').html('');

        $("#toaster-content-type").removeClass('success');
        $("#toaster-content-type").removeClass('warning');
        $("#toaster-content-type").removeClass('error');

        $('.toast').removeClass('success');
        $('.toast').removeClass('warning');
        $('.toast').removeClass('error');


        $("#toaster-content-type").addClass(type);
        $("#toaster-content-message").html(message);

        var toasterMessage = $("#toaster-content").html();
        $('.toast-container').html(toasterMessage);
        $('.toast-container .toast').addClass(type);

        var toast = new bootstrap.Toast('.toast');
        toast.show();
    }

    function success(message) {
        toaster_message('success', message);
    }

    function warning(message) {
        toaster_message('warning', message);
    }

    function error(message) {
        toaster_message('error', message);
    }
</script>

@if ($message = Session::get('success'))
    <script>
        "use strict";
        success("{{ $message }}");
    </script>
    @php Session()->forget('success'); @endphp
@elseif($message = Session::get('error'))
    <script>
        "use strict";
        error("{{ $message }}");
    </script>
    @php Session()->forget('error'); @endphp
@elseif(isset($errors) && $errors->any())
    @php
        $message = '<ul>';
        foreach ($errors->all() as $error):
            $message .= '<li>' . $error . '</li>';
        endforeach;
        $message .= '</ul>';
    @endphp
    <script>
        "use strict";
        error("{!! $message !!}");
    </script>
@endif
