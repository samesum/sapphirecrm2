@extends('layouts.admin')
@push('title', get_phrase('Manage profile'))

@section('content')
    @php
        $auth = auth()->user();
    @endphp

    <div class="row ">
        <div class="col-xl-7">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route(get_current_user_role().'.manage.profile.update') }}" method="post" enctype="multipart/form-data">@csrf
                        <input type="hidden" name="type" value="general">
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Name') }}</label>
                            <input type="text" class="form-control ol-form-control" name="name" value="{{ $auth->name }}" placeholder="{{get_phrase('Enter name')}}" required />
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Email') }}</label>
                            <input type="email" class="form-control ol-form-control" name="email" value="{{ $auth->email }}" placeholder="{{get_phrase('Enter email')}}" required />
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Facebook link') }}</label>
                            <input type="text" class="form-control ol-form-control" name="facebook" value="{{ $auth->facebook }}" placeholder="{{get_phrase('Enter facebook link')}}"/>
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Twitter link') }}</label>
                            <input type="text" class="form-control ol-form-control" name="twitter" value="{{ $auth->twitter }}" placeholder="{{get_phrase('Enter twitter link')}}" />
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Linkedin link') }}</label>
                            <input type="text" class="form-control ol-form-control" name="linkedin" value="{{ $auth->linkedin }}" placeholder="{{get_phrase('Enter linkedin link')}}"/>
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('A short title about yourself') }}</label>
                            <textarea rows="5" id="short-title" class="form-control ol-form-control" name="about" placeholder="{{get_phrase('Start writing')}}">{{ $auth->about }}</textarea>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="skills">{{ get_phrase('Skills') }}</label>
                            <input type="text" name="skills" value="{{ $auth->skills }}" id="skills" class="tagify form-control ol-form-control w-100 p-2" placeholder="{{get_phrase('Enter skills')}}" data-role="tagsinput">
                            <small class="text-muted">{{ get_phrase('Write your skill and click the enter button') }}</small>
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Biography') }}</label>
                            <textarea rows="5" class="form-control ol-form-control text_editor" name="biography" placeholder="{{get_phrase('Start writing')}}">{!! removeScripts($auth->biography) !!}</textarea>
                        </div>


                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Photo') }}
                                <small>({{ get_phrase('The image size should be any square image') }})</small>
                            </label>
                            <div class="gap-2 d-flex align-items-center">
                                <img class = "rounded-circle img-thumbnail image-50" src="{{ get_image($auth->photo) }}">
                                <div class="upload-container">
                                    <div class="drop-zone">
                                        <p>{{get_phrase('Drag & Drop or Browse')}}</p>
                                        <input type="file" name="photo" class="file-input" hidden>
                                    </div>
                                    <ul class="file-list"></ul>
                                </div>
                            </div>
                        </div>

                        <div class="fpb7 mb-2">
                            <button type="submit" class="btn mt-4 ol-btn-primary">{{ get_phrase('Update profile') }}</button>
                        </div>
                    </form>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
        <div class="col-xl-5">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route(get_current_user_role().'.manage.profile.update') }}" method="post"> @csrf
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Current password') }}</label>
                            <input type="password" class="form-control ol-form-control" name="current_password" placeholder="{{get_phrase('Enter current password')}}" required />
                        </div>
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('New password') }}</label>
                            <input type="password" class="form-control ol-form-control" name="new_password" placeholder="{{get_phrase('Enter new password')}}" required />
                        </div>
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Confirm password') }}</label>
                            <input type="password" class="form-control ol-form-control" name="confirm_password" placeholder="{{get_phrase('Enter confirm password')}}" required />
                        </div>
                        <div class="fpb7 mb-2">
                            <button type="submit" class="ol-btn-primary">{{ get_phrase('Update password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
