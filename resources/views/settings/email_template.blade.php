@extends('layouts.admin')
@push('title', get_phrase('Email templates'))
@section('content')
    @if (request()->is('admin/settings/email_temp'))
        <style>
            .offcanvas.global {
                width: 80% !important;
            }
        </style>
    @endif

    @php
        $notify_settings = App\Models\NotificationSetting::get();
    @endphp
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="ol-card p-3">
                <div class="ol-card-body">
                    <div class="table-responsive">
                        <table class="table table-normal">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ get_phrase('Email type') }}</th>
                                    <th scope="col">{{ get_phrase('Email subject') }}</th>
                                    <th scope="col">{{ get_phrase('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notify_settings as $key => $notification_row)
                                    <tr>
                                        <td scope="row">{{ ++$key }}</td>
                                        <td>
                                            {{ $notification_row->setting_title }}
                                            <p class="text-muted">{{ $notification_row->setting_sub_title }}</p>
                                        </td>
                                        <td>
                                            @foreach (json_decode($notification_row->subject, true) as $user_type => $subject)
                                                {{ $subject }}
                                            @endforeach
                                        </td>

                                        <td>
                                            <a class="btn ol-btn-primary" href="javascript:void(0)" onclick="modal('{{get_phrase('Edit email template')}}', '{{ route(get_current_user_role() . '.email.temp.edit', ['id' => $notification_row->id]) }}', 'modal-lg')">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.53999 19.52C4.92999 19.52 4.35999 19.31 3.94999 18.92C3.42999 18.43 3.17999 17.69 3.26999 16.89L3.63999 13.65C3.70999 13.04 4.07999 12.23 4.50999 11.79L12.72 3.1C14.77 0.930003 16.91 0.870003 19.08 2.92C21.25 4.97 21.31 7.11 19.26 9.28L11.05 17.97C10.63 18.42 9.84999 18.84 9.23999 18.94L6.01999 19.49C5.84999 19.5 5.69999 19.52 5.53999 19.52ZM15.93 2.91C15.16 2.91 14.49 3.39 13.81 4.11L5.59999 12.81C5.39999 13.02 5.16999 13.52 5.12999 13.81L4.75999 17.05C4.71999 17.38 4.79999 17.65 4.97999 17.82C5.15999 17.99 5.42999 18.05 5.75999 18L8.97999 17.45C9.26999 17.4 9.74999 17.14 9.94999 16.93L18.16 8.24C19.4 6.92 19.85 5.7 18.04 4C17.24 3.23 16.55 2.91 15.93 2.91Z" fill="#fff" />
                                                    <path d="M17.3399 10.95C17.3199 10.95 17.2899 10.95 17.2699 10.95C14.1499 10.64 11.6399 8.27 11.1599 5.17C11.0999 4.76 11.3799 4.38 11.7899 4.31C12.1999 4.25 12.5799 4.53 12.6499 4.94C13.0299 7.36 14.9899 9.22 17.4299 9.46C17.8399 9.5 18.1399 9.87 18.0999 10.28C18.0499 10.66 17.7199 10.95 17.3399 10.95Z" fill="#fff" />
                                                    <path d="M21 22.75H3C2.59 22.75 2.25 22.41 2.25 22C2.25 21.59 2.59 21.25 3 21.25H21C21.41 21.25 21.75 21.59 21.75 22C21.75 22.41 21.41 22.75 21 22.75Z" fill="#fff" />
                                                </svg>

                                                {{ get_phrase('Edit template') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
