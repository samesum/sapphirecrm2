<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.file.update', $file->id) }}" method="post" enctype="multipart/form-data" id="ajaxFileForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $file->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" required value="{{ $file->title }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="file">{{ get_phrase('Type') }}</label>
                        <div class="upload-container">
                            <div class="drop-zone">
                                <p>{{get_phrase('Drag & Drop or Browse')}}</p>
                                <input type="file" name="file" class="file-input" hidden>
                            </div>
                            <ul class="file-list"></ul>
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxFileForm')" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
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