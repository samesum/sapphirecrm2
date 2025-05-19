@php $amount = $payment_details['payable_amount']; @endphp


@php
    $model = $payment_details['success_method']['model_name'];
    if ($model == 'InstructorPayment') {
        $settings = DB::table('users')
            ->where('id', $payment_details['items'][0]['id'])
            ->value('paymentkeys');

        $keys = isset($settings) ? json_decode($settings) : null;

        if ($keys) {
            $bank_information = $keys->offline->bank_information;
        }

        if ($bank_information == '') {
            $msg = "This payment gateway isn't configured.";
        }
    } else {
        $payment_keys = json_decode($payment_gateway->keys, true);
        $bank_information = '';

        if ($payment_keys != '') {
            if ($payment_gateway->status == 1) {
                $bank_information = $payment_keys['bank_information'];

                if ($bank_information == '') {
                    $msg = get_phrase("This payment gateway isn't configured.");
                }
            } else {
                $msg = get_phrase('Admin denied transaction through this gateway.');
            }
        } else {
            $msg = get_phrase("This payment gateway isn't configured.");
        }
    }
@endphp

<div class="row my-5">
    <div class="col-md-12 text-start">
        {{ $bank_information }}
    </div>
</div>
<form action="{{ route(get_current_user_role().'.payment.offline.store') }}" method="post" enctype="multipart/form-data">@csrf
    <div class="mb-3">
        <label for="" class="form-label d-flex justify-content-between">
            <span>{{ get_phrase('Payment Document') }}</span>
            <span>{{ get_phrase('(jpg, pdf, txt, png, docx)') }}</span>
        </label>
        <div class="fpb7 mb-2">
            <label class="form-label ol-form-label text-start" for="bank_no">{{ get_phrase('Bank no.') }}</label>
            <input class="form-control ol-form-control" type="number" id="bank_no" name="bank_no" placeholder="{{ get_phrase('Bank no.') }}" required>
        </div>
        <div class="fpb7 mb-2">
            <label class="form-label ol-form-label" for="phone_no">{{ get_phrase('Phone no.') }}</label>
            <input class="form-control ol-form-control" type="number" id="phone_no" name="phone_no" placeholder="{{ get_phrase('Phone no.') }}" required>
        </div>
        <div class="fpb7 mb-2">
            <label class="form-label ol-form-label" for="doc">{{ get_phrase('Document') }}</label>
            <div class="upload-container">
                <div class="drop-zone">
                    <p>{{get_phrase('Drag & Drop or Browse')}}</p>
                    <input type="file" name="doc" class="file-input" hidden>
                </div>
                <ul class="file-list"></ul>
            </div>
        </div>
    </div>

    <div class="text-end">
        <input type="submit" class="btn btn-primary" value="{{ get_phrase('Pay offline') }}">
    </div>
</form>

<script>
    "use strict";

    initiatePlugins();
</script>