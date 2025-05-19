<div class="p-3"></div>

<div id="filter-section">
    <!-- Category -->
    <div class="row align-items-center mb-18px">
        <div class="col-sm-3">
            <label for="category" class="form-label">{{ get_phrase('Category') }}</label>
        </div>
        <div class="col-sm-9">
            <select class="form-control px-14px ol-form-control ol-niceSelect ol-modal-niceSelect" name="category" id="category">
                <option value="all">{{ get_phrase('Select Category') }}</option>
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row align-items-center mb-18px">
        <div class="col-sm-3">
            <label for="status" class="form-label">{{ get_phrase('Status') }}</label>
        </div>
        <div class="col-sm-9">
            <select class="form-control px-14px ol-form-control ol-niceSelect ol-modal-niceSelect" name="status" id="status">
                <option value="all"> {{ get_phrase('Select status') }} </option>
                <option value="in_progress"> {{ get_phrase('In Progress') }} </option>
                <option value="not_started"> {{ get_phrase('Not Started') }} </option>
                <option value="completed"> {{ get_phrase('Completed') }} </option>
            </select>
        </div>
    </div>

    @if (auth()->user()->role_id == 1)
        <!-- Status -->
        <div class="row align-items-center mb-18px">
            <div class="col-sm-3">
                <label for="status" class="form-label">{{ get_phrase('Client') }}</label>
            </div>
            <div class="col-sm-9">
                <select class="form-control px-14px ol-form-control ol-niceSelect ol-modal-niceSelect" name="client" id="client">
                    <option value="all">{{ get_phrase('Select client') }}</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    @if (auth()->user()->role_id == 1)
        <!-- Instructor -->
        <div class="mb-18px row align-items-center">
            <div class="col-sm-3">
                <label for="staff" class="form-label">{{ get_phrase('Staff') }}</label>
            </div>
            <div class="col-sm-9">
                <select class="form-control px-14px ol-form-control ol-niceSelect ol-modal-niceSelect" name="staff" id="staff">
                    <option value="all">{{ get_phrase('Select staff') }}</option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id }}"> {{ $staff->name }} </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <!-- Price -->
    <div class="row align-items-center mb-18px mt-30px">
        <div class="col-sm-3">
            <label for="budget" class="form-label">{{ get_phrase('Budget') }}</label>
        </div>
        <div class="col-sm-9">
            <div class="me-17px">
                <div id="budget-slider"></div>
            </div>
            <div class="accordion-item-range me-2">
                <div class="accordion-range-value d-flex align-items-center justify-content-between mt-3">
                    <div class="d-flex align-items-center">
                        <input type="text" class="value" disabled id="min-price" name="minPrice">
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="text" class="value" disabled id="max-price" name="maxPrice">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Apply Button -->
    <div class="fpb7 mb-2">
        <button type="button" onclick="applyFilter('table-filter')" class="ms-auto btn ol-btn-outline-secondary">{{ get_phrase('Apply') }}</button>
    </div>
</div>

<script>
    "use strict";

    if ($("#ajaxOffcanvas select.ol-modal-niceSelect").length > 0) {
        $("#ajaxOffcanvas select.ol-modal-niceSelect").niceSelect({
            dropdownParent: $('#ajaxOffcanvas')
        });
    }
</script>
@include('projects.budget_range')
