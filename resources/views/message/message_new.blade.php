<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role().'.message.thread.store') }}" method="post">
            @csrf
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Select User') }}</label>
                <select class="form-select ol-select2 from-control" data-toggle="select2" name="receiver_id" required>
                    @php
                        if(auth()->user()->role_id == 1){
                            $users = App\Models\User::get();
                        }else{
                            $users = App\Models\User::where('role_id', 1)->get();
                        }
                    @endphp
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="input-group d-flex justify-content-end">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Next') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    "use strict";
    
    $("select.ol-select2:not(.inited)").select2({
        dropdownParent: $('#modal')
    });
    $("select.ol-niceSelect:not(.inited)").niceSelect({
        dropdownParent: $('#modal')
    });
</script>
@include('script')
