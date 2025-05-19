@php
    $project_details = App\Models\Project::where('id', $invoice->project_id)->first();
    $client_details = App\Models\User::where('id', $project_details->client_id)->first();
    $payment_gateways = App\Models\Payment_gateway::where('status', 1)->get();
@endphp

<div class="row invoice">
    <div class="col-12">
        <div class="ol-card p-4">
            <div class="card-body print-table">
                <div class="row">
                    <div class="col-auto">
                        <h4 class="invoice-title">{{ $invoice->title }}</h4>
                    </div>
                    <div class="col-auto ms-auto print-d-none">
                        <a class="btn ol-btn-primary in-btn btn-sm" onclick="window.print();" href="#"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                    </div>
                </div>
                <p class="in-16">#{{ $invoice->id }}</p>
                <p class="in-h-p mt-3"> <span>{{ get_phrase('Invoice Date') }}</span> <span>{{ date('d M Y', strtotime($invoice->timestamp_start)) }}</span> </p>
                <p class="in-h-p mb-3"> <span>{{ get_phrase('Due Date') }}</span> <span>{{ date('d M Y', strtotime($invoice->due_date)) }}</span> </p>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="invoice-title"> {{ get_phrase('Invoice To') }} </h4>
                        <p class="in-row-p">{{ $client_details->name }}</p>
                        <p class="in-row-p">{{ $client_details->email }}</p>
                        <p class="in-row-p">{{ $client_details->address }}</p>
                        <p class="in-row-p">{{ $client_details->phone }}</p>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="invoice-title"> {{ get_phrase('Payment Details') }} </h4>
                        <p class="in-row-p"><span>{{ get_phrase('Due') }}</span> <strong>{{ currency($invoice->payment) }}</strong></p>
                        <p class="in-row-p"><span>{{ get_phrase('Payment Methods') }}</span></p>
                        <p class="d-flex flex-wrap">
                            @foreach ($payment_gateways as $payment)
                                <span class="pe-1">{{ $payment->title . ', ' }}</span>
                            @endforeach
                        </p>

                    </div>
                </div>
                <hr>
                <table class="table">
                    <tr class="in-tr">
                        <th> {{ get_phrase('Description') }} </th>
                        <th> {{ get_phrase('Quality') }} </th>
                        <th> {{ get_phrase('Price') }} </th>
                        <th> {{ get_phrase('Amount') }} </th>
                    </tr>
                    <tr class="in-tr">
                        <td>{{ $invoice->title }}</td>
                        <td>1</td>
                        <td>{{ currency($invoice->payment) }}</td>
                        <td>{{ currency($invoice->payment) }}</td>
                    </tr>
                </table>

                @if(auth()->user()->role_id == 2)
                    <a href="{{ route(get_current_user_role() . '.invoice.payout', $invoice->id) }}" class="in-btn print-d-none"> {{ get_phrase('Pay') }} </a>
                @endif

                <p class="in-note print-d-none"><strong>{{ get_phrase('NOTE') }}</strong>: {{ get_phrase('All accounts are to be paid within 7 days from receipt of invoice. To be paid
                                        by cheque or credit card or direct payment online. If account is not paid within 7 days the credits
                                        details supplied as confirmation of work undertaken will be charged the agreed quoted fee noted
                                        above.') }}</p>
            </div>
        </div>

    </div>
</div>
