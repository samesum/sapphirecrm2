<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.invoice.update', $invoice->id) }}" method="post" id="ajaxInvoiceForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $invoice->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $invoice->title }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="payment">{{ get_phrase('Payment') }}</label>
                        <input class="form-control ol-form-control" type="number" id="payment" name="payment" value="{{ $invoice->payment }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="paymentStatus">{{ get_phrase('Payment status') }}</label>
                        <select name="payment_status" class="form-control ol-select2" id="paymentStatus" required>
                            <option value="unpaid" @if($invoice->payment_status == 'unpaid') selected @endif>{{get_phrase('Unpaid')}}</option>
                            <option value="processing" @if($invoice->payment_status == 'processing') selected @endif>{{get_phrase('Processing')}}</option>
                            <option value="paid" @if($invoice->payment_status == 'paid') selected @endif>{{get_phrase('Completed')}}</option>
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="due_date">{{ get_phrase('Due Date') }}</label>
                        <input class="form-control ol-form-control datePicker" value="{{$invoice->due_date}}" type="text" id="due_date" name="due_date" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxInvoiceForm')" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
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