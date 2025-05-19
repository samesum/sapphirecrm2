@extends('layouts.admin')
@push('title', get_phrase('Offline payments'))

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
@endpush

@section('content')
    <div class="position-relative">
        <div class="row" id="table-body">
            <div class="col-12">
                <div class="ol-card">

                    <div class="ol-card-body p-3 position-relative" id="filters-container">
                        <div id="table-filter" class="d-none"></div>
                        <div class="ol-card radius-8px print-d-none">
                            <div class="ol-card-body px-2">
                                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-lg-nowrap">
                                    <div class="top-bar flex-wrap d-flex align-items-center w-100">
                                        <div class="input-group dt-custom-search">
                                            <span class="input-group-text">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.733496 7.66665C0.733496 11.4885 3.84493 14.6 7.66683 14.6C11.4887 14.6 14.6002 11.4885 14.6002 7.66665C14.6002 3.84475 11.4887 0.733313 7.66683 0.733313C3.84493 0.733313 0.733496 3.84475 0.733496 7.66665ZM1.9335 7.66665C1.9335 4.50847 4.50213 1.93331 7.66683 1.93331C10.8315 1.93331 13.4002 4.50847 13.4002 7.66665C13.4002 10.8248 10.8315 13.4 7.66683 13.4C4.50213 13.4 1.9335 10.8248 1.9335 7.66665Z" fill="#99A1B7" stroke="#99A1B7" stroke-width="0.2" />
                                                    <path d="M14.2426 15.0907C14.3623 15.2105 14.5149 15.2667 14.6666 15.2667C14.8184 15.2667 14.9709 15.2105 15.0907 15.0907C15.3231 14.8583 15.3231 14.475 15.0907 14.2426L12.7774 11.9293C12.545 11.6969 12.1617 11.6969 11.9293 11.9293C11.6969 12.1617 11.6969 12.545 11.9293 12.7774L14.2426 15.0907Z" fill="#99A1B7" stroke="#99A1B7" stroke-width="0.2" />
                                                </svg>
                                            </span>
                                            <input type="text" class="form-control" name="customSearch" id="custom-search-box" placeholder="Search">
                                        </div>
                                        <div class="custom-dropdown" id="export-btn1">
                                            <button class="dropdown-header btn ol-btn-light btn-squire" data-bs-toggle="tooltip" title="{{ get_phrase('Export') }}">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.994 7.86602C16.8049 7.39018 16.3515 7.08268 15.8398 7.08268H14.0957V3.3335C14.0957 2.64433 13.5348 2.0835 12.8457 2.0835H7.84566C7.15649 2.0835 6.59566 2.64433 6.59566 3.3335V7.0835H4.99308C4.48141 7.0835 4.02807 7.391 3.83891 7.86683C3.64974 8.34266 3.76814 8.87683 4.13981 9.22766L9.36808 14.1676C9.66225 14.4451 10.039 14.5835 10.4156 14.5835C10.7923 14.5835 11.169 14.4443 11.4632 14.1676L16.6907 9.22766C17.0648 8.87599 17.1824 8.34185 16.994 7.86602ZM16.1198 8.62097L10.8915 13.561C10.6265 13.8127 10.2081 13.8127 9.94222 13.561L4.71313 8.62097C4.52647 8.4443 4.5907 8.23348 4.61487 8.17348C4.6382 8.11265 4.73639 7.91602 4.99389 7.91602H7.01314C7.12397 7.91602 7.22981 7.87185 7.30814 7.79435C7.38648 7.71685 7.42981 7.61018 7.42981 7.49935V3.33268C7.42981 3.10268 7.61731 2.91602 7.84647 2.91602H12.8465C13.0756 2.91602 13.2631 3.10268 13.2631 3.33268V7.49935C13.2631 7.61018 13.3073 7.71602 13.3848 7.79435C13.4623 7.87269 13.569 7.91602 13.6798 7.91602H15.8407C16.0982 7.91602 16.1966 8.11348 16.2199 8.17348C16.2432 8.23432 16.3065 8.44514 16.1198 8.62097ZM16.6665 17.5002C16.6665 17.7302 16.4798 17.9168 16.2498 17.9168H4.58313C4.35313 17.9168 4.16646 17.7302 4.16646 17.5002C4.16646 17.2702 4.35313 17.0835 4.58313 17.0835H16.2498C16.4798 17.0835 16.6665 17.2702 16.6665 17.5002Z" fill="#98A1B7"/>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-list dropdown-export">
                                                <li class="mb-1">
                                                    <a class="dropdown-item export-btn" href="javascript:void(0)" onclick="exportFile('{{ route(get_current_user_role() . '.offline-report.export-file', ['file' => 'pdf']) }}')"><i class="fi-rr-file-pdf"></i>
                                                        {{ get_phrase('PDF') }}</a>
                                                </li>
                                                <li class="mb-1">
                                                    <a class="dropdown-item export-btn" href="javascript:void(0)" onclick="exportFile('{{ route(get_current_user_role() . '.offline-report.export-file', ['file' => 'csv']) }}')">

                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M13.8988 4.68501L10.2739 1.10011C10.2091 1.03603 10.1212 1 10.0295 1H5.96971C3.78081 1 2.00003 2.76151 2.00003 4.92671V9.84474C2.00003 10.0335 2.00128 11.1745 2.34567 11.1154C2.80714 11.1154 2.69132 10.0335 2.69132 9.84474V4.92671C2.69132 3.13849 4.162 1.68367 5.96974 1.68367H9.68389V3.13003C9.68389 4.30449 10.6501 5.26 11.8376 5.26H13.3087V11.0741C13.3087 12.8619 11.8377 14.3164 10.0295 14.3164H5.96971C4.16197 14.3164 2.69129 12.8619 2.69129 11.0741C2.69129 10.8853 2.6811 9.75342 2.34567 9.75342C2.00003 9.75342 2 10.8853 2 11.0741C2 13.2388 3.78081 15 5.96968 15H10.0295C12.2189 15 14 13.2388 14 11.0741V4.92671C14 4.83605 13.9636 4.7491 13.8988 4.68501ZM10.3752 3.13V2.16707L12.8113 4.57633H11.8376C11.0312 4.57633 10.3752 3.92753 10.3752 3.13Z"
                                                                fill="#020202" />
                                                            <path
                                                                d="M6.58284 9.02809C6.58284 9.12016 6.56009 9.21981 6.51466 9.32697C6.46919 9.43422 6.39772 9.53941 6.30025 9.64266C6.20272 9.74594 6.07825 9.82975 5.92675 9.89419C5.77522 9.95866 5.59869 9.99088 5.39713 9.99088C5.24428 9.99088 5.10531 9.97638 4.98016 9.94747C4.85497 9.91853 4.74134 9.8735 4.63925 9.81234C4.53713 9.75119 4.44328 9.67063 4.35766 9.57066C4.28125 9.47994 4.21603 9.37831 4.16203 9.26584C4.108 9.15338 4.0675 9.03341 4.0405 8.90581C4.01347 8.77825 4 8.64278 4 8.49941C4 8.26659 4.03391 8.05816 4.10178 7.874C4.16959 7.68984 4.26678 7.53237 4.39325 7.4015C4.51972 7.27062 4.66794 7.171 4.83791 7.10259C5.00784 7.03422 5.18897 7 5.38134 7C5.61581 7 5.82466 7.04669 6.00778 7.14006C6.19088 7.23344 6.33119 7.34888 6.42872 7.48628C6.52619 7.62372 6.57497 7.75362 6.57497 7.87594C6.57497 7.943 6.55125 8.00222 6.50381 8.05353C6.45638 8.10481 6.39906 8.13047 6.33191 8.13047C6.25681 8.13047 6.2005 8.11272 6.16294 8.07719C6.12537 8.04169 6.08353 7.98053 6.03744 7.89372C5.96103 7.75037 5.87109 7.64316 5.76769 7.57216C5.66425 7.50113 5.53678 7.46562 5.38531 7.46562C5.14422 7.46562 4.95219 7.55706 4.80925 7.73984C4.66628 7.92269 4.59484 8.18244 4.59484 8.51912C4.59484 8.74403 4.62647 8.93116 4.68972 9.08041C4.75294 9.22969 4.84253 9.34119 4.95847 9.41481C5.07437 9.48847 5.21009 9.52528 5.36556 9.52528C5.53419 9.52528 5.67681 9.48356 5.79341 9.4C5.91 9.3165 5.99794 9.19384 6.05722 9.03209C6.08222 8.95584 6.11322 8.89366 6.15009 8.84562C6.18697 8.79766 6.24625 8.77363 6.32794 8.77363C6.39775 8.77363 6.45769 8.79797 6.50775 8.84663C6.55778 8.89528 6.58284 8.95581 6.58284 9.02809Z"
                                                                fill="#4d5675" stroke="#4d5675" stroke-width="0.2" stroke-miterlimit="10" />
                                                            <path
                                                                d="M9.21088 9.0735C9.21088 9.24847 9.16579 9.40562 9.07557 9.54503C8.98529 9.68447 8.85322 9.79359 8.67932 9.8725C8.50541 9.95141 8.29919 9.99087 8.06079 9.99087C7.77491 9.99087 7.5391 9.93694 7.35332 9.82909C7.22157 9.75153 7.1145 9.64794 7.03219 9.51837C6.94985 9.38884 6.90869 9.26287 6.90869 9.14056C6.90869 9.06956 6.93338 9.00872 6.98279 8.95806C7.03219 8.90747 7.0951 8.88209 7.1715 8.88209C7.23341 8.88209 7.28579 8.90184 7.3286 8.94131C7.37141 8.98078 7.40797 9.03931 7.43829 9.11687C7.47516 9.20897 7.51503 9.28591 7.55785 9.34772C7.60066 9.40956 7.66091 9.4605 7.73866 9.50062C7.81638 9.54075 7.9185 9.56081 8.04497 9.56081C8.21888 9.56081 8.36016 9.52037 8.46888 9.43947C8.5776 9.35859 8.63191 9.25769 8.63191 9.13666C8.63191 9.04066 8.60257 8.96275 8.54397 8.90287C8.48532 8.84306 8.40957 8.79734 8.31675 8.76575C8.22385 8.73419 8.09966 8.70066 7.94422 8.66512C7.73604 8.61647 7.56185 8.55959 7.42154 8.49447C7.28122 8.42937 7.16988 8.34059 7.08757 8.22816C7.00522 8.11569 6.96407 7.97597 6.96407 7.80891C6.96407 7.64978 7.00754 7.50841 7.09447 7.38475C7.18144 7.26112 7.30722 7.16609 7.47194 7.09966C7.6366 7.03325 7.83025 7.00003 8.05291 7.00003C8.23075 7.00003 8.38457 7.02206 8.51432 7.06612C8.64407 7.11022 8.75182 7.16872 8.83744 7.24172C8.92307 7.31472 8.98563 7.39134 9.02519 7.47156C9.06475 7.55178 9.08444 7.63006 9.08444 7.70634C9.08444 7.77603 9.05978 7.83884 9.01035 7.89472C8.96097 7.95066 8.89932 7.97859 8.8256 7.97859C8.75841 7.97859 8.70732 7.96181 8.67247 7.92828C8.6375 7.89475 8.59966 7.83984 8.55882 7.76356C8.50607 7.65444 8.44285 7.56925 8.36913 7.50809C8.29535 7.44691 8.17675 7.41631 8.01341 7.41631C7.86188 7.41631 7.73972 7.44953 7.64685 7.51594C7.55397 7.58237 7.50754 7.66228 7.50754 7.75566C7.50754 7.81356 7.52335 7.8635 7.55497 7.90559C7.5866 7.94772 7.63007 7.98387 7.68541 8.01412C7.74075 8.04437 7.79672 8.06806 7.85338 8.08512C7.91 8.10222 8.00357 8.12725 8.134 8.16006C8.29735 8.19825 8.44522 8.24031 8.57766 8.28634C8.71004 8.33241 8.82266 8.38828 8.91557 8.45403C9.00847 8.51978 9.08091 8.603 9.13297 8.70359C9.18488 8.80419 9.21088 8.9275 9.21088 9.0735Z"
                                                                fill="#4d5675" stroke="#4d5675" stroke-width="0.2" stroke-miterlimit="10" />
                                                            <path
                                                                d="M10.0404 7.38472L10.6965 9.32406L11.3545 7.37094C11.3888 7.26834 11.4145 7.197 11.4316 7.15687C11.4487 7.11675 11.477 7.08062 11.5166 7.04834C11.5561 7.01612 11.6101 7.00003 11.6786 7.00003C11.7287 7.00003 11.7751 7.01253 11.818 7.0375C11.8608 7.0625 11.8943 7.09569 11.9188 7.13712C11.9431 7.17856 11.9553 7.22031 11.9553 7.26241C11.9553 7.29134 11.9514 7.32259 11.9435 7.35612C11.9355 7.38966 11.9257 7.42253 11.9138 7.45475C11.902 7.487 11.8901 7.52022 11.8782 7.55437L11.1767 9.44437C11.1517 9.51672 11.1266 9.58544 11.1016 9.65056C11.0766 9.71566 11.0476 9.77287 11.0147 9.82219C10.9817 9.8715 10.9379 9.91194 10.8833 9.94353C10.8286 9.97509 10.7617 9.99087 10.6827 9.99087C10.6037 9.99087 10.5368 9.97541 10.4821 9.94453C10.4274 9.91366 10.3833 9.87284 10.3497 9.82222C10.3161 9.77159 10.2868 9.71403 10.2618 9.64959C10.2367 9.58516 10.2117 9.51678 10.1867 9.44444L9.49705 7.57019C9.48517 7.536 9.47298 7.50247 9.46048 7.46956C9.44795 7.43669 9.43742 7.40119 9.42886 7.36303C9.4203 7.32487 9.41602 7.29269 9.41602 7.26634C9.41602 7.19928 9.44298 7.13809 9.49705 7.08287C9.55108 7.02762 9.61889 7.00003 9.70061 7.00003C9.8007 7.00003 9.87155 7.03062 9.91305 7.09178C9.95455 7.15294 9.99689 7.25056 10.0404 7.38472Z"
                                                                fill="#4d5675" stroke="#4d5675" stroke-width="0.2" stroke-miterlimit="10" />
                                                        </svg>
                                                        <span>{{ get_phrase('CSV') }}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item export-btn" href="javascript:void(0)" onclick="exportFile('{{ route(get_current_user_role() . '.offline-report.export-file', ['file' => 'print']) }}')"><i class="fi-rr-print"></i>
                                                        {{ get_phrase('Print') }}</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="custom-dropdown filter-dropdown btn-group" id="export-btn">
                                            <button class="dropdown-header btn ol-btn-light dropdown-toggle-split btn-squire" data-bs-toggle="dropdown" title="{{ get_phrase('Filter') }}">
                                                <svg data-bs-toggle="tooltip" title="{{get_phrase('Filter')}}" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.417 2.0835H4.58366C3.66449 2.0835 2.91699 2.831 2.91699 3.75016V5.63099C2.91699 6.07599 3.09038 6.49432 3.40538 6.80932L7.67285 11.0768C7.82952 11.2343 7.91699 11.4435 7.91699 11.666V14.9993C7.91699 15.1302 7.97862 15.2543 8.08362 15.3327L11.417 17.8327C11.4903 17.8877 11.5778 17.916 11.667 17.916C11.7303 17.916 11.7945 17.9018 11.8537 17.8718C11.9945 17.801 12.0837 17.6568 12.0837 17.4993V11.666C12.0837 11.4435 12.1703 11.2343 12.3278 11.0768L16.5953 6.80932C16.9103 6.49432 17.0837 6.07599 17.0837 5.63099V3.75016C17.0837 2.831 16.3362 2.0835 15.417 2.0835ZM16.2503 5.63099C16.2503 5.85349 16.1637 6.06265 16.0062 6.22015L11.7387 10.4877C11.4237 10.8027 11.2503 11.221 11.2503 11.666V16.666L8.75033 14.791V11.6668C8.75033 11.2218 8.57694 10.8035 8.26194 10.4885L3.99447 6.22099C3.8378 6.06349 3.75033 5.85433 3.75033 5.63183V3.75016C3.75033 3.29016 4.12366 2.91683 4.58366 2.91683H15.417C15.877 2.91683 16.2503 3.29016 16.2503 3.75016V5.63099Z" fill="#98A1B7"/>
                                                </svg>
                                                <span class="filter-count-display d-none" id="filter-count-display"></span>
                                            </button>

                                            <a href="javascript:void(0)" class="border-0 filter-reset d-none d-flex align-items-center" id="filter-reset" data-bs-toggle="tooltip" title="{{get_phrase('Clear Filter')}}">
                                                <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7 6.99927L1.00141 1.00068" stroke="#99A1B7" stroke-width="1.3" stroke-linecap="round" />
                                                    <path d="M1 6.99936L6.99859 1.00077" stroke="#99A1B7" stroke-width="1.3" stroke-linecap="round" />
                                                </svg>

                                                <span>|</span>
                                            </a>

                                            <!-- Dropdown Menu -->
                                            <div class="dropdown-list custom-dropdown-280px px-14px" id="filter-section">
                                                <!-- Category -->
                                                <div class="mb-3">
                                                    <label for="user" class="form-label">{{ get_phrase('User') }}</label>
                                                    <select class="form-control px-14px ol-form-control ol-select2" name="user" id="user">
                                                        <option value="all">{{ get_phrase('Select user') }}</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">{{ get_phrase('Status') }}</label>
                                                    <select class="form-control ol-form-control ol-select2" name="status" id="status">
                                                        <option value="all">{{ get_phrase('Select all status') }}</option>
                                                        <option value="1">{{ get_phrase('Accepted') }}</option>
                                                        <option value="2">{{ get_phrase('Suspended') }}</option>
                                                        <option value="0">{{ get_phrase('Pending') }}</option>
                                                    </select>
                                                </div>
                                                <!-- Date Filter -->
                                                <div class="mb-3">
                                                    <label class="form-label ol-form-label" for="daterangepicker">{{ get_phrase('Date range') }}</label>
                                                    <br>
                                                    <input class="form-control ol-form-control dateTimeRangePicker w-100" type="text" id="daterangepicker" name="date_range" required>
                                                </div>

                                                <!-- Amount Filter -->
                                                <div class="mb-3">
                                                    <label for="budget" class="form-label">{{ get_phrase('Budget') }}</label>
                                                    <div class="accordion-item-range">
                                                        <div id="budget-slider"></div>
                                                        <div class="accordion-range-value d-flex align-items-center mt-4">
                                                            <div class="d-flex align-items-center">
                                                                <label for="min-price" class="me-2"> {{ get_phrase('From') }} </label>
                                                                <input type="text" class="value minPrice" disabled id="min-price" name="minPrice">
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <label for="max-price" class="mx-2"> {{ get_phrase('To') }} </label>
                                                                <input type="text" class="value" disabled id="max-price" name="maxPrice">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Apply Button -->
                                                <button type="button" id="filter" onclick="applyFilter('table-filter')" class="btn btn-apply px-14px w-100 mt-2">{{ get_phrase('Apply') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTable -->
                    <div class="ol-card">
                        <div class="ol-card-body px-3">
                            <div class="table-responsive">
                                <table class="table server-side-datatable mt-0" id="table_list">
                                    <thead>
                                        <tr class="context-menu-header">
                                            <th scope="col" class="d-flex align-items-center">
                                                <span> # </span>
                                            </th>
                                            <th scope="col">{{ get_phrase('User') }}</th>
                                            <th scope="col">{{ get_phrase('Item') }}</th>
                                            <th scope="col">{{ get_phrase('Total') }}</th>
                                            <th scope="col">{{ get_phrase('Issue date') }}</th>
                                            <th scope="col">{{ get_phrase('Payment info') }}</th>
                                            <th scope="col">{{ get_phrase('Status') }}</th>
                                            <th scope="col" class="d-flex justify-content-center">{{ get_phrase('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $current_user_role = get_current_user_role();

                                            $query = App\Models\OfflinePayment::query();


                                            $total_offline_payment = $query->count();
                                        @endphp
                                        @foreach ($query->limit(10)->get() as $key => $payment)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                                                        <p class="row-number fs-12px">{{ ++$key }}</p>
                                                        <input type="hidden" class="datatable-row-id" value="{{ $payment->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    @php $user = get_user_info($payment->user_id); @endphp
                                                    <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                        <div>
                                                            <h4 class="title fs-14px">{{ $user->name }}</h4>
                                                            <p class="sub-title text-12px">{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($payment->item_type === 'invoice')
                                                        @php
                                                            $invoices = App\Models\Invoice::whereIn('id', json_decode($payment->items, true))->get();
                                                            $invoiceLinks = '';
                                                        @endphp

                                                        @foreach ($invoices as $invoice)
                                                            <p class="sub-title text-12px">{{ $invoice?->title }}</p>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ currency($payment->total_amount) }}
                                                </td>
                                                <td>
                                                    <div class="sub-title2 text-12px">
                                                        <p>{{ date('d-M-y', strtotime($payment->created_at)) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @php $ext = pathinfo($payment->doc, PATHINFO_EXTENSION); @endphp
                                                        @if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'webp')
                                                            <a class="download-btn" onclick="showImage('{{asset($payment->doc)}}')" href="#">
                                                                <i class="fi-rr-eye"></i>
                                                            </a>
                                                        @endif

                                                        <a class="download-btn ms-2" href="{{ route('admin.offline.payment.doc', $payment->id) }}">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M4.92958 5.39042L4.92958 5.39041L4.92862 5.3905C3.61385 5.5146 2.6542 5.93651 2.02459 6.70783C1.39588 7.47804 1.10332 8.58816 1.10332 10.0736V10.1603C1.10332 11.8027 1.45436 12.987 2.22713 13.7598C2.99991 14.5326 4.18424 14.8836 5.82665 14.8836H10.1733C11.8157 14.8836 13 14.5326 13.7728 13.7615C14.5456 12.9904 14.8967 11.8094 14.8967 10.1736V10.0869C14.8967 8.59144 14.5991 7.4745 13.9602 6.70257C13.3204 5.92962 12.3457 5.5112 11.0111 5.39715C10.7022 5.36786 10.4461 5.59636 10.4169 5.89543C10.3874 6.19756 10.6157 6.46083 10.9151 6.49005L10.9158 6.4901C11.9763 6.57958 12.6917 6.86862 13.1444 7.43161C13.5984 7.99634 13.7967 8.84694 13.7967 10.0803V10.1669C13.7967 11.5202 13.5567 12.4212 12.9921 12.9858C12.4275 13.5504 11.5265 13.7903 10.1733 13.7903H5.82665C4.47345 13.7903 3.57245 13.5504 3.00784 12.9858C2.44324 12.4212 2.20332 11.5202 2.20332 10.1669V10.0803C2.20332 8.85356 2.39823 8.00609 2.84423 7.44127C3.28876 6.8783 3.99097 6.58615 5.03125 6.49007L5.03139 6.49006C5.33896 6.46076 5.5591 6.18959 5.52975 5.88876C5.50032 5.58704 5.22199 5.36849 4.92958 5.39042Z"
                                                                    fill="#6D718C" stroke="#6D718C" stroke-width="0.1" />
                                                                <path d="M7.45 9.92028C7.45 10.2212 7.69905 10.4703 8 10.4703C8.30051 10.4703 8.55 10.2283 8.55 9.92028V1.33362C8.55 1.03267 8.30095 0.783618 8 0.783618C7.69905 0.783618 7.45 1.03267 7.45 1.33362V9.92028Z" fill="#6D718C" stroke="#6D718C" stroke-width="0.1" />
                                                                <path d="M7.61153 11.0556C7.7214 11.1655 7.86101 11.2169 8.00022 11.2169C8.13943 11.2169 8.27904 11.1655 8.38891 11.0556L10.6222 8.8223C10.8351 8.60944 10.8351 8.25778 10.6222 8.04492C10.4094 7.83206 10.0577 7.83206 9.84487 8.04492L8.00022 9.88957L6.15558 8.04492C5.94272 7.83206 5.59106 7.83206 5.3782 8.04492C5.16534 8.25778 5.16534 8.60944 5.3782 8.8223L7.61153 11.0556Z" fill="#6D718C" stroke="#6D718C" stroke-width="0.1" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($payment->status == 0)
                                                        <span class="pending">{{ get_phrase('Pending') }}</span>
                                                    @elseif ($payment->status == 1)
                                                        <span class="accepted">{{ get_phrase('Accepted') }}</span>
                                                    @elseif ($payment->status == 2)
                                                        <span class="suspended">{{ get_phrase('Suspended') }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ get_phrase('Unknown') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $downloadRoute = route($current_user_role . '.offline.payment.doc', $payment->id);
                                                        $acceptRoute = route($current_user_role . '.offline.payment.accept', $payment->id);
                                                        $declineRoute = route($current_user_role . '.offline.payment.decline', $payment->id);
                                                        $options = 0;
                                                    @endphp


                                                    <div class="dropdown disable-right-click ol-icon-dropdown">
                                                        <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="fi-rr-menu-dots-vertical"></span>
                                                        </button>
                                                        <ul class="dropdown-menu contextMenuContainer">
                                                            @if (has_permission('offline.payment.doc'))
                                                                @php ++$options @endphp
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ $downloadRoute }}">{{ get_phrase('Download') }}</a>
                                                                </li>
                                                            @endif
                                                            @if (has_permission('offline.payment.accept'))
                                                                @php ++$options @endphp
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ $acceptRoute }}">{{ get_phrase('Accept') }}</a>
                                                                </li>
                                                            @endif

                                                            @if (has_permission('offline.payment.decline'))
                                                                @php ++$options @endphp
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="confirmModal('{{ $declineRoute }}')">{{ get_phrase('Decline') }}</a>
                                                                </li>
                                                            @endif

                                                            @if ($options == 0)
                                                                <li><span class="dropdown-item text-muted fs-12px">{{ get_phrase('No actions available') }}</span></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-lg-block custom-datatable-row-selector">
                        <div class="page-length-select fs-12px margin--40px d-flex align-items-center position-absolute">
                            <label for="page-length-select" class="pe-2">{{ get_phrase('Showing') }}:</label>
                            <select id="page-length-select" class="form-select fs-12px w-auto ol-niceSelect">
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label for="page-length-select" class="ps-2 w-100"> {{ get_phrase('of') }} {{ $total_offline_payment }}</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/nouislider.min.js') }}"></script>

    <script>
        'use strict';

        initiate_floating_actions(
            '#table_list', // table or any parent element
            "", // Delete route
            "{{ route(get_current_user_role() . '.offline-report.export-file', ['file' => 'pdf']) }}", // Export route pdf
            "{{ route(get_current_user_role() . '.offline-report.export-file', ['file' => 'csv']) }}", // Export route csv
            "{{ route(get_current_user_role() . '.offline-report.export-file', ['file' => 'print']) }}", // Export route for print copy
        );

        function showImage(imageLink){
            // load the spinner on every open
            let placeholder = $('.placeholder-content').html();
            $('#modal .modal-body').empty().html(placeholder);

            // set modal data
            $('#modal .modal-title').html('{{get_phrase('Payment document')}}');
            $('#modal .modal-dialog').addClass('modal-lg');
            $("#modal").modal('show');
            $('#modal .modal-body').empty().html('<img src="'+imageLink+'" width="100%">');
        }

        @php
            $max_value = \DB::table('offline_payments')->max(DB::raw('CAST(total_amount AS DECIMAL(10,2))'));
        @endphp

        var max = {{ isset($max_value) ? $max_value : 0 }};
        

        var slider = document.getElementById('budget-slider');

        var min = 0;

        noUiSlider.create(slider, {
            start: [min, max], // Initial range values
            connect: true,
            range: {
                'min': min,
                'max': max
            },
            tooltips: [true, true], // Show tooltips for both handles
            format: {
                to: function(value) {
                    return '{{ currency() }}' + value.toFixed(0);
                },
                from: function(value) {
                    return Number(value.replace('{{ currency() }}', ''));
                }
            }
        });

        slider.noUiSlider.on('update', function(values, handle) {
            document.getElementById('min-price').value = values[0];
            document.getElementById('max-price').value = values[1];
            document.getElementById('max-price').innerHTML = values[1];
            document.getElementById('min-price').innerHTML = values[0];

        });
    
        $(document).ready(function() {
            initiatePlugins();
        });
    
        server_side_datatable('["id","user_info","item_type","total_amount","date","download","status","options"]', "{{ route($current_user_role . '.offline.payments') }}", '{{ $total_offline_payment }}');
    </script>
@endpush
