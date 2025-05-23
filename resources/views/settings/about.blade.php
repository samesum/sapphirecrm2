@extends('layouts.admin')
@push('title', get_phrase('About'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $curl_enabled = function_exists('curl_version');
    @endphp
    <div class="row mt-4">
        <div class="col-xl-7">
            <div class="ol-card p-4">
                <p class="title text-14px mb-3">{{ get_phrase('About this application') }}</p>
                <div class="ol-card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <div class="table-responsive">
                                        <table class="table eTable">
                                            <div class="chart-widget-list">
                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Software version') }}
                                                    <span class="ms-auto float-end ml-5">{{ get_settings('version') }}</span>
                                                </p>
                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Laravel version') }}
                                                    <span class="ms-auto float-end ml-5">{{app()->version()}}</span>
                                                </p>
                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Check update') }}
                                                    <span class="ms-auto float-end">
                                                        <a href="https://codecanyon.net/user/creativeitem/portfolio" target="_blank">
                                                            <i class="bi bi-telegram"></i>
                                                            {{ get_phrase('Check update') }}
                                                        </a>
                                                    </span>
                                                </p>
                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Php version') }}
                                                    <span class="ms-auto float-end">{{ phpversion() }}</span>
                                                </p>
                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Curl enable') }}
                                                    <span class="ms-auto float-end">
                                                        {!!$curl_enabled ? '<span class="eBadge ebg-soft-success">' . removeScripts(get_phrase('enabled')) . '</span>' : '<span class="eBadge ebg-soft-danger">' . removeScripts(get_phrase('disabled')) . '</span>'!!}
                                                    </span>
                                                </p>

                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Purchase code') }}
                                                    <span class="ms-auto float-end">{{ get_settings('purchase_code') }}</span>
                                                </p>

                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Product license') }}
                                                    @if ($application_details['product_license'] == 'valid')
                                                        <span class="ms-auto float-end badge bg-success text-capitalize">{{ $application_details['product_license'] }}</span>
                                                    @else
                                                        <span class="ms-auto float-end badge bg-danger mt-1 text-capitalize">{{ $application_details['product_license'] }}</span>
                                                        <button class="btn custom_btns ol-btn-primary float-end ms-2 me-2 py-0 text-13px"
                                                            onclick="modal('{{ get_phrase('Enter valid purchase code') }}', '{{ route('admin.save_valid_purchase_code', ['action_type' => 'show']) }}', )">{{ get_phrase('Enter valid purchase code') }}</button>
                                                    @endif
                                                </p>


                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Customer support status') }}
                                                    <span class="ms-auto float-end">
                                                        @if (strtolower($application_details['purchase_code_status']) == 'expired')
                                                            <span class="badge bg-danger float-end mb-1 text-capitalize">{{ $application_details['purchase_code_status'] }}</span>
                                                            <a href="https://codecanyon.net/user/creativeitem/portfolio" target="_blank" class="btn btn-success float-end me-2 py-0 text-13px">{{ get_phrase('Renew support') }}</a>
                                                        @elseif (strtolower($application_details['purchase_code_status']) == 'valid')
                                                            <span class="badge bg-success text-capitalize">{{ $application_details['purchase_code_status'] }}</span>
                                                        @else
                                                            <span class="badge bg-danger text-capitalize">{{ $application_details['purchase_code_status'] }}</span>
                                                        @endif
                                                    </span>
                                                </p>

                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Support expiry date') }}

                                                    @if ($application_details['support_expiry_date'] != 'invalid')
                                                        <span class="ms-auto float-end">{{ $application_details['support_expiry_date'] }}</span>
                                                    @else
                                                        <span class="ms-auto float-end"><span class="badge bg-danger">{{ ucfirst($application_details['support_expiry_date']) }}</span></span>
                                                    @endif
                                                </p>

                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Customer name') }}
                                                    @if ($application_details['customer_name'] != 'invalid')
                                                        <span class="ms-auto float-end">{{ $application_details['customer_name'] }}</span>
                                                    @else
                                                        <span class="ms-auto float-end"><span class="badge bg-danger">{{ ucfirst($application_details['customer_name']) }}</span></span>
                                                    @endif
                                                </p>

                                                <p class="border-bottom mb-2 pb-2 text-13px d-flex align-items-center">
                                                    <i class="fi-rr-hand-back-point-right me-3"></i>
                                                    {{ get_phrase('Get customer support') }}
                                                    <span class="ms-auto float-end"><a class="about-sc-one" href="http://support.creativeitem.com" target="_blank"> <i class="bi bi-telegram"></i>
                                                            {{ get_phrase('Customer support') }}
                                                            <i class="fi-rr-navigation"></i>
                                                        </a> </span>
                                                </p>

                                            </div>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
