@extends('layouts.admin')
@push('title', get_phrase('Zoom Settings'))
@section('content')

<div class="row">
    <div class="col-xl-7">
        <div class="ol-card p-4">
            <div class="ol-card-body">
                <form class="required-form" action="{{ route('admin.system_settings.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label" for="zoom_client_id">{{ get_phrase('Zoom Client Id') }}<span>*</span></label>
                        <input type="text" name="zoom_client_id" id = "zoom_client_id" class="form-control ol-form-control" value="{{ get_settings('zoom_client_id') }}" required>
                    </div>
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label" for="zoom_client_secret">{{ get_phrase('Zoom Client Secret') }}<span>*</span></label>
                        <input type="text" name="zoom_client_secret" id = "zoom_client_secret" class="form-control ol-form-control" value="{{ get_settings('zoom_client_secret') }}" required>
                    </div>
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label" for="zoom_account_id">{{ get_phrase('Zoom Account Id') }}<span>*</span></label>
                        <input type="text" name="zoom_account_id" id = "zoom_account_id" class="form-control ol-form-control" value="{{ get_settings('zoom_account_id') }}" required>
                    </div>
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label" for="zoom_account_id">{{ get_phrase('Zoom Account Email') }}<span>*</span></label>
                        <input type="text" name="zoom_account_email" id = "zoom_account_email" class="form-control ol-form-control" value="{{ get_settings('zoom_account_email') }}" required>
                    </div>
                    <button type="submit" class="btn mt-2 ol-btn-primary"> {{get_phrase('Update')}} </button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection