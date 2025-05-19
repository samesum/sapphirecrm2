<div class="ol-card mt-3">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.addon.store',['id'=>$addon->id]) }}" method="post" id="ajaxForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="install">
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="code">{{ get_phrase('Purchase Code') }}</label>
                        <input class="form-control ol-form-control" type="text" id="code" name="code" value="{{$addon->purchase_code}}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="file">{{ get_phrase('Zip File') }}</label>
                        <div class="upload-container">
                            <div class="drop-zone">
                                <p>{{get_phrase('Drag & Drop or Browse')}}</p>
                                <input type="file" name="file" class="file-input" hidden>
                            </div>
                            <ul class="file-list"></ul>
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn mt-3 ol-btn-primary">{{ get_phrase('Update') }}</button>
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