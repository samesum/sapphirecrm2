
<form action="{{ route(get_current_user_role() . '.project.category.store') }}" method="post" id="ajaxCategoryForm" onsubmit="handleAjaxFormSubmission('ajaxCategoryForm'); return false;">
    @csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="name">{{ get_phrase('Name') }}</label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{ get_phrase('e.g.Jon Due') }}" required>
    </div>
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="parent">{{ get_phrase('Parent Category') }}</label>
        <select class="form-select ol-modal-select2 ol-select2 ol-form-control" name="parent" id="parent">
            <option value="">{{get_phrase('Select parent category')}}</option>
            @foreach ($categories as $parent)
                <option value="{{ $parent->id }}"> {{ $parent->name }} </option>
            @endforeach
        </select>
    </div>

    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
        <select class="form-control ol-form-control ol-niceSelect ol-modal-niceSelect" name="status" id="status" required>
            <option value="0"> {{ get_phrase('De Active') }} </option>
            <option value="1"> {{ get_phrase('Active') }} </option>
        </select>
    </div> 
    <div class="fpb7 mb-2">
        <button type="button" class="btn ol-btn-primary" onclick="handleAjaxFormSubmission('ajaxCategoryForm')"> {{ get_phrase('Save') }} </button>
    </div>

</form>
<script>
    "use strict";

    $(".ol-modal-select2").select2({
        dropdownParent: $('#ajaxOffcanvas')
    });
    $(".ol-modal-niceSelect").niceSelect({
        dropdownParent: $('#ajaxOffcanvas')
    });
</script>
