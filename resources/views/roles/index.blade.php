@extends('layouts.admin')
@push('title', get_phrase('Roles & Permission'))
@section('content')
    <div class="position-relative">
        <div class="row justify-content-center" id="table-body">
            <div class="col-xl-8">
                <div class="ol-card">
                    <div class="ol-card-body p-3 mb-10 position-relative" id="filters-container">
                        <div class="ol-card radius-8px print-d-none">
                            <div class="ol-card-body px-2">
                                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                                    <div class="top-bar d-flex align-items-center w-100 flex-wrap">
                                        <div class="input-group dt-custom-search">
                                            <span class="input-group-text">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.733496 7.66665C0.733496 11.4885 3.84493 14.6 7.66683 14.6C11.4887 14.6 14.6002 11.4885 14.6002 7.66665C14.6002 3.84475 11.4887 0.733313 7.66683 0.733313C3.84493 0.733313 0.733496 3.84475 0.733496 7.66665ZM1.9335 7.66665C1.9335 4.50847 4.50213 1.93331 7.66683 1.93331C10.8315 1.93331 13.4002 4.50847 13.4002 7.66665C13.4002 10.8248 10.8315 13.4 7.66683 13.4C4.50213 13.4 1.9335 10.8248 1.9335 7.66665Z" fill="#99A1B7" stroke="#99A1B7" stroke-width="0.2" />
                                                    <path d="M14.2426 15.0907C14.3623 15.2105 14.5149 15.2667 14.6666 15.2667C14.8184 15.2667 14.9709 15.2105 15.0907 15.0907C15.3231 14.8583 15.3231 14.475 15.0907 14.2426L12.7774 11.9293C12.545 11.6969 12.1617 11.6969 11.9293 11.9293C11.6969 12.1617 11.6969 12.545 11.9293 12.7774L14.2426 15.0907Z" fill="#99A1B7" stroke="#99A1B7" stroke-width="0.2" />
                                                </svg>
                                            </span>
                                            <input type="text" class="form-control" id="custom-search-box" name="customSearch" placeholder="Search">
                                        </div>
                                        <div class="custom-dropdown" id="export-btn1">
                                            <button class="dropdown-header btn ol-btn-light btn-squire" data-bs-toggle="tooltip" title="{{ get_phrase('Export') }}">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.994 7.86602C16.8049 7.39018 16.3515 7.08268 15.8398 7.08268H14.0957V3.3335C14.0957 2.64433 13.5348 2.0835 12.8457 2.0835H7.84566C7.15649 2.0835 6.59566 2.64433 6.59566 3.3335V7.0835H4.99308C4.48141 7.0835 4.02807 7.391 3.83891 7.86683C3.64974 8.34266 3.76814 8.87683 4.13981 9.22766L9.36808 14.1676C9.66225 14.4451 10.039 14.5835 10.4156 14.5835C10.7923 14.5835 11.169 14.4443 11.4632 14.1676L16.6907 9.22766C17.0648 8.87599 17.1824 8.34185 16.994 7.86602ZM16.1198 8.62097L10.8915 13.561C10.6265 13.8127 10.2081 13.8127 9.94222 13.561L4.71313 8.62097C4.52647 8.4443 4.5907 8.23348 4.61487 8.17348C4.6382 8.11265 4.73639 7.91602 4.99389 7.91602H7.01314C7.12397 7.91602 7.22981 7.87185 7.30814 7.79435C7.38648 7.71685 7.42981 7.61018 7.42981 7.49935V3.33268C7.42981 3.10268 7.61731 2.91602 7.84647 2.91602H12.8465C13.0756 2.91602 13.2631 3.10268 13.2631 3.33268V7.49935C13.2631 7.61018 13.3073 7.71602 13.3848 7.79435C13.4623 7.87269 13.569 7.91602 13.6798 7.91602H15.8407C16.0982 7.91602 16.1966 8.11348 16.2199 8.17348C16.2432 8.23432 16.3065 8.44514 16.1198 8.62097ZM16.6665 17.5002C16.6665 17.7302 16.4798 17.9168 16.2498 17.9168H4.58313C4.35313 17.9168 4.16646 17.7302 4.16646 17.5002C4.16646 17.2702 4.35313 17.0835 4.58313 17.0835H16.2498C16.4798 17.0835 16.6665 17.2702 16.6665 17.5002Z" fill="#98A1B7"/>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-list dropdown-export">
                                                <li class="mb-1">
                                                    <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.server-side-datatable', 'Role-list')"><i class="fi-rr-file-pdf"></i>
                                                        {{ get_phrase('PDF') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i class="fi-rr-print"></i>
                                                        {{ get_phrase('Print') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table server-side-datatable" id="role_list">
                                <thead>
                                    <tr class="context-menu-header">
                                        <th scope="col" class="d-flex align-items-center">
                                            <span>#</span>
                                        </th>
                                        <th scope="col">{{ get_phrase('Role') }}</th>
                                        <th scope="col" class="d-flex justify-content-center">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $query = App\Models\Role::query();
                                        $currentUserRole = get_current_user_role();
                                    @endphp
                                    @foreach ($query->limit(10)->get() as $key => $role)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <p class="row-number fs-12px">{{ ++$key }}</p>
                                                    <input type="hidden" class="datatable-row-id" value="{{ $role->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                {{ ucfirst($role->title) ?: '-' }}
                                            </td>
                                            <td>
                                                @php
                                                    $permissionRoute = route($currentUserRole . '.role.permission', ['role' => $role->id]);
                                                @endphp
                                                @if (has_permission('role.permission'))
                                                    <div class="text-center">
                                                        <a class="fs-12px btn ol-btn-outline-secondary m-auto" onclick="modal('{{ get_phrase('User Permissions') }}', '{{ $permissionRoute }}', 'modal-xl')"><i class="fi-rr-checkbox me-2"></i> {{ get_phrase('Permissions') }}</a>
                                                    </div>
                                                @else
                                                    <li><span class="dropdown-item text-muted fs-12px">{{ get_phrase('No actions available') }}</span></li>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-none d-lg-block custom-datatable-row-selector">
                            <div class="page-length-select fs-12px margin--40px d-flex align-items-center position-absolute">
                                <label for="page-length-select" class="pe-2">{{ get_phrase('Showing') }}:</label>
                                <select id="page-length-select" class="form-select ol-from-control fs-12px w-auto ol-niceSelect">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <label for="page-length-select" class="ps-2 w-100"> {{get_phrase('of')}} {{ count($roles) }}</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";
        server_side_datatable('["id","title","options"]', "{{ route(get_current_user_role() . '.roles') }}", '{{ $query->count() }}');
    </script>
@endpush
