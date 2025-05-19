<form action="{{ route('temp.update', ['id' => $template->id]) }}" enctype="multipart/form-data" method="post"
    class="mt-4">
    @csrf
    <div class="fpb-7 mb-3">
        <label class="mb-2">{{ get_phrase('Template title') }}</label>
        <input name="setting_title" id="setting_title" class="form-control ol-form-control"
            value="{{ $template->setting_title }}" required>
    </div>
    <div class="fpb-7 mb-3">
        <label class="mb-2">{{ get_phrase('Template Sub title') }}</label>
        <input name="setting_sub_title" id="setting_sub_title" class="form-control ol-form-control"
            value="{{ $template->setting_sub_title }}" required>
    </div>
    @foreach (json_decode($template->subject) as $key => $item)
        <div class="fpb-7 mb-3">
            <label class="mb-2">{{ ucwords($key) . ' ' . get_phrase('Message Subject') }}</label>
            <input name="subject[{{ $key }}]" id="subject_{{ $key }}"
                class="form-control ol-form-control" value="{{ $item }}" required>
        </div>
    @endforeach
    <p class="mb-2">{{ get_phrase('Template contractor') }}</p>
    <p class="mb-2">
        @if ($template->type == 'forget-password')
            {{ __('[forget_password_link], [client_name], [site_email], [address], [footer_text]') }}
        @elseif($template->type == 'payment-conformation')
            {{ __('[client_name], [site_email], [address], [footer_text]') }}
        @endif
    </p>
    @foreach (json_decode($template->template) as $key => $item)
        <div class="fpb-7 mb-3">
            <label class="mb-2">{{ ucwords($key) . ' ' . get_phrase('Message Template') }}</label>
            <textarea name="template[{{ $key }}]" id="template_{{ $key }}" cols="30" rows="10"
                class="form-control email_template ol-form-control" required>{{$item}}</textarea>
        </div>
    @endforeach
    <button class="btn ol-btn-primary" type="submit"> {{ get_phrase('Update') }} </button>
</form>

<script>
    "use strict";
    
    $('.email_template').summernote({
        height: 600,
        minHeight: null,
        maxHeight: null,
        focus: true,
        toolbar: [
            ['color', ['color']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ]
    });
</script>
