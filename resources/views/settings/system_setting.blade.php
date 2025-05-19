@extends('layouts.admin')
@push('title', get_phrase('System settings'))

@section('content')
    <div class="row">
        <div class="col-xl-7">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <div class="col-lg-12">
                        <form class="required-form" action="{{ route('admin.system_settings.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="system_name">{{ get_phrase('Website name') }}<span>*</span></label>
                                <input type="text" name = "system_name" id = "system_name" class="form-control ol-form-control" value="{{ get_settings('system_name') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="system_title">{{ get_phrase('Website title') }}<span>*</span></label>
                                <input type="text" name = "system_title" id = "system_title" class="form-control ol-form-control" value="{{ get_settings('system_title') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label for="website_keywords" class="form-label ol-form-label">{{ get_phrase('Website keywords') }}</label>
                                <input type="text" class="form-control ol-form-control bootstrap-tag-input w-100" id = "website_keywords" name="website_keywords" data-role="tagsinput" value="{{ get_settings('website_keywords') }}" />
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="website_description">{{ get_phrase('Website description') }}</label>
                                <textarea name="website_description" id = "website_description" class="form-control ol-form-control" rows="5">{{ get_settings('website_description') }}</textarea>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="author">{{ get_phrase('Author') }}</label>
                                <input type="text" name = "author" id = "author" class="form-control ol-form-control" value="{{ get_settings('author') }}">
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="slogan">{{ get_phrase('Slogan') }}<span>*</span></label>
                                <input type="text" name = "slogan" id = "slogan" class="form-control ol-form-control" value="{{ get_settings('slogan') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="system_email">{{ get_phrase('System email') }}<span>*</span></label>
                                <input type="text" name = "system_email" id = "system_email" class="form-control ol-form-control" value="{{ get_settings('system_email') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="address">{{ get_phrase('Address') }}</label>
                                <textarea name="address" id = "address" class="form-control ol-form-control" rows="5">{{ get_settings('address') }}</textarea>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="phone">{{ get_phrase('Phone') }}</label>
                                <input type="text" name = "phone" id = "phone" class="form-control ol-form-control" value="{{ get_settings('phone') }}">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="language">{{ get_phrase('System language') }}</label>
                                <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="language" id="language">
                                    @foreach (App\Models\Language::get() as $language)
                                        <option value="{{ strtolower($language->name) }}" @if (get_settings('language') == strtolower($language->name)) selected @endif>{{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="list_view_type">{{ get_phrase('List View Type') }}</label>
                                <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="list_view_type" id="list_view_type">
                                    <option value="grid" {{ get_settings('list_view_type') == 'grid' ? 'selected' : '' }}>
                                        {{ get_phrase('Grid View') }} </option>
                                    <option value="list" {{ get_settings('list_view_type') == 'list' ? 'selected' : '' }}>
                                        {{ get_phrase('List View') }} </option>
                                </select>
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="footer_text">{{ get_phrase('Footer text') }}</label>
                                <input type="text" name = "footer_text" id = "footer_text" class="form-control ol-form-control" value="{{ get_settings('footer_text') }}">
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="footer_link">{{ get_phrase('Footer link') }}</label>
                                <input type="text" name = "footer_link" id = "footer_link" class="form-control ol-form-control" value="{{ get_settings('footer_link') }}">
                            </div>


                            <button type="submit" class="btn ol-btn-primary" onclick="checkRequiredFields()">{{ get_phrase('Save Changes') }}</button>
                        </form>


                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-5">
            <div class="ol-card radius-8px">
                <div class="ol-card-body py-4 px-20px">
                    <form action="{{ route(get_current_user_role() . '.updater.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label" for="file">{{ get_phrase('Update your application') }}</label>
                            <input class="form-control ol-form-control" type="file" id="file" name="file">
                        </div>
                        <div class="fpb7 mb-2">
                            <button type="submit" class="btn mt-3 ol-btn-primary">{{ get_phrase('Upload') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ol-card radius-8px mt-4">
                <div class="ol-card-body py-4 px-20px">
                    <form action="{{ route('admin.setting.logo') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="fpb7 mb-3">
                            <label class="form-label ol-form-label" for="logo">{{ get_phrase('Update your application logo') }}</label>
                            <img src="{{ get_image(get_settings('logo')) }}" width="100px;" class="rounded mb-1" alt="">
                            <div class="upload-container">
                                <div class="drop-zone">
                                    <p>{{ get_phrase('Drag & Drop or Browse') }}</p>
                                    <input type="file" name="logo" class="file-input" hidden>
                                </div>
                                <ul class="file-list"></ul>
                            </div>
                        </div>
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label" for="favicon">{{ get_phrase('Update your application favicon') }}</label>
                            <img src="{{ get_image(get_settings('favicon')) }}" width="100px;" class="rounded mb-1" alt="">
                            <div class="upload-container">
                                <div class="drop-zone">
                                    <p>{{ get_phrase('Drag & Drop or Browse') }}</p>
                                    <input type="file" name="favicon" class="file-input" hidden>
                                </div>
                                <ul class="file-list"></ul>
                            </div>
                        </div>
                        <div class="fpb7 mb-2">
                            <button type="submit" class="btn mt-3 ol-btn-primary">{{ get_phrase('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
