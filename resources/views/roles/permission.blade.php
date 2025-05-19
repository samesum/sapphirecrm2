<div class="row">
    <div class="col-sm-12">
        <div class="card border-0">
            <div class="card-body p-3">
                <div class="row role-list">
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Category Permissions') }}</h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    // Fetch all permissions related to "project"
                                    $project_category_permissions = App\Models\Permission::where('route', 'like', '%project.categor%')->get();
                                    $permission_array = App\Models\RolePermission::where('role_id', request()->query('role'))->pluck('permission_id')->toArray();                                    
                                @endphp

                                @foreach ($project_category_permissions as $category_permission)
                                @php
                                    if ($category_permission->route == 'staff.project.category.store' || $category_permission->route == 'project.category.multi-delete' || $category_permission->route == 'project.category.edit') {
                                        continue;
                                    }
                                @endphp
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $category_permission->id }}" class="form-check-input" onclick="create_permission('{{ $category_permission->id }}')" {{ in_array($category_permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $category_permission->id }}">{{ $category_permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Projects permissions') }}</h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    // Fetch all permissions related to "project"
                                    $permissions = App\Models\Permission::where('route', 'like', '%project%')->get();
                                    $permission_array = App\Models\RolePermission::where('role_id', request()->query('role'))->pluck('permission_id')->toArray();
                                @endphp

                                @foreach ($permissions as $permission)
                                @php
                                    if (strpos($permission->route, 'project.categor') !== false || $permission->route == 'project.store' || $permission->route == 'project.edit' || $permission->route == 'project.report' ||  $permission->route == 'project.multi-delete') {
                                        continue;
                                    }
                                @endphp
                              
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Milestone permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $milestone_permissions = App\Models\Permission::where('route', 'like', '%milestone%')->get();
                                @endphp

                                @foreach ($milestone_permissions as $milestone)
                                @php
                                    if ($milestone->route == 'milestone.store' || $milestone->route == 'milestone.multi-delete' || $milestone->route == 'milestone.edit') {
                                        continue;
                                    }
                                @endphp
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $milestone->id }}" class="form-check-input" onclick="create_permission('{{ $milestone->id }}')" {{ in_array($milestone->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $milestone->id }}">{{ $milestone->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Task permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $task_permissions = App\Models\Permission::where('route', 'like', '%task%')->get();
                                @endphp

                                @foreach ($task_permissions as $task)
                                @php
                                    if ($task->route == 'task.store' || $task->route == 'task.multi-delete' || $task->route == 'task.edit' || $task->route == 'milestone.tasks') {
                                        continue;
                                    }
                                @endphp
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $task->id }}" class="form-check-input" onclick="create_permission('{{ $task->id }}')" {{ in_array($task->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $task->id }}">{{ $task->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('File permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $file_permissions = App\Models\Permission::where('route', 'like', '%file%')->get();
                                @endphp

                                @foreach ($file_permissions as $file)
                                @php
                                    if ($file->route == 'file.store' || $file->route == 'report.offline.payment' || $file->route == 'file.multi-delete' || $file->route == 'file.edit' || $file->route == 'manage.profile' || $file->route == 'manage.profile.update') {
                                        continue;
                                    }
                                @endphp
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $file->id }}" class="form-check-input" onclick="create_permission('{{ $file->id }}')" {{ in_array($file->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $file->id }}">{{ $file->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Meeting permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $meeting_permissions = App\Models\Permission::where('route', 'like', '%meeting%')->get();
                                @endphp

                                @foreach ($meeting_permissions as $meeting)
                                @php
                                    if ($meeting->route == 'meeting.store' || $meeting->route == 'meeting.multi-delete' || $meeting->route == 'meeting.edit') {
                                        continue;
                                    }
                                @endphp
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $meeting->id }}" class="form-check-input" onclick="create_permission('{{ $meeting->id }}')" {{ in_array($meeting->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $meeting->id }}">{{ $meeting->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Invoice permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $invoice_permissions = App\Models\Permission::where('route', 'like', '%invoice%')->get();
                                @endphp

                                @foreach ($invoice_permissions as $invoice)
                                @php
                                    if ($invoice->route == 'invoice.store' || $invoice->route == 'invoice.multi-delete' || $invoice->route == 'invoice.edit') {
                                        continue;
                                    }
                                @endphp
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $invoice->id }}" class="form-check-input" onclick="create_permission('{{ $invoice->id }}')" {{ in_array($invoice->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $invoice->id }}">{{ $invoice->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Event permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $event_permissions = App\Models\Permission::where('route', 'like', '%event%')->get();
                                @endphp

                                @foreach ($event_permissions as $event)
                                @php
                                    if ($event->route == 'event.store' || $event->route == 'event.edit') {
                                        continue;
                                    }
                                @endphp
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $event->id }}" class="form-check-input" onclick="create_permission('{{ $event->id }}')" {{ in_array($event->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $event->id }}">{{ $event->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Time sheet permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $time_sheet_permissions = App\Models\Permission::where('route', 'like', '%timesheet%')->get();
                                @endphp

                                @foreach ($time_sheet_permissions as $time_sheet)
                                @php
                                    if ($time_sheet->route == 'timesheet.store' || $time_sheet->route == 'timesheet.edit' || $time_sheet->route == 'timesheet.multi-delete') {
                                        continue;
                                    }
                                @endphp
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $time_sheet->id }}" class="form-check-input" onclick="create_permission('{{ $time_sheet->id }}')" {{ in_array($time_sheet->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $time_sheet->id }}">{{ $time_sheet->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Message permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $permissions = App\Models\Permission::where('route', 'like', '%message%')->get();
                                @endphp

                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $permission->id }}" class="form-check-input" onclick="create_permission('{{ $permission->id }}')" {{ in_array($permission->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $permission->id }}">{{ $permission->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Report permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $report_permissions = App\Models\Permission::where('route', 'like', '%report%')->get();
                                @endphp

                                @foreach ($report_permissions as $report)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $report->id }}" class="form-check-input" onclick="create_permission('{{ $report->id }}')" {{ in_array($report->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $report->id }}">{{ $report->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 pt-3">
                        <div class="role-card p-3 ">
                            <h4> {{ get_phrase('Profile permissions') }} </h4>
                            <div class="d-flex flex-column gap-2 pt-3">
                                @php
                                    $profile_permissions = App\Models\Permission::where('route', 'like', '%manage.profile%')->get();
                                @endphp

                                @foreach ($profile_permissions as $profile)
                                    <div class="form-check">
                                        <input type="checkbox" id="client-{{ $profile->id }}" class="form-check-input" onclick="create_permission('{{ $profile->id }}')" {{ in_array($profile->id, $permission_array) ? 'checked' : '' }}>
                                        <label class="form-check-label text-capitalize sub-title fw-medium w-100" for="client-{{ $profile->id }}">{{ $profile->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";
    function create_permission(permission) {
        var url = '{{ route(get_current_user_role() . '.store.permissions') }}';
        var csrfToken = '{{ csrf_token() }}';
        var role_id = @json(request()->query('role'));

        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                role_id: role_id,
                permission: permission
            },
            success: function(response) {
                processServerResponse(response);
            }
        });
    }
</script>
