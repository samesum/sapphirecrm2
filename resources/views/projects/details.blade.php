@extends('layouts.admin')

@section('content')
    @php
        $project_code = request()->route()->parameter('code');
        $project = App\Models\Project::where('code', $project_code)->first();
        $tab = request()->route()->parameter('tab') ?? 'dashboard';
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <nav class="navbar navbar-expand-lg project-details">
                        <ul class="nav nav-underline w-100">
                            @if (has_permission('project.details'))
                                <li class="nav-item">
                                    <a class="nav-link @if ($tab == 'dashboard') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'dashboard']) }}">{{ get_phrase('Dashboard') }}</a>
                                </li>
                            @endif
                            @if (has_permission('milestones', 'milestone.create', 'milestone.store', 'milestone.delete', 'milestone.edit', 'milestone.update', 'milestone.multi-delete', 'milestone.tasks'))
                                <li class="nav-item">
                                    <a class="nav-link @if ($tab == 'milestone') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'milestone']) }}">{{ get_phrase('Milestone') }}</a>
                                </li>
                            @endif
                            @if (has_permission('tasks', 'task.create', 'task.store', 'task.delete', 'task.edit', 'task.update', 'task.multi-delete', 'task.datatable'))
                                <li class="nav-item">
                                    <a class="nav-link @if ($tab == 'task') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'task']) }}">{{ get_phrase('Task') }}</a>
                                </li>
                            @endif
                            @if (has_permission('gantt.chart'))
                                <li class="nav-item">
                                    <a class="nav-link @if ($tab == 'gantt_chart') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'gantt_chart']) }}">{{ get_phrase('Gantt Chart') }}
                                    </a>
                                </li>
                            @endif
                            @if (has_permission('files', 'file.create', 'file.store', 'file.delete', 'file.edit', 'file.update', 'file.multi-delete', 'file.download'))
                                <li class="nav-item">
                                    <a class="nav-link @if ($tab == 'file') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'file']) }}">{{ get_phrase('File') }}</a>
                                </li>
                            @endif
                            @if (has_permission('meetings', 'meeting.create', 'meeting.store', 'meeting.delete', 'meeting.edit', 'meeting.update', 'meeting.multi-delete', 'meeting.join'))
                                <li class="nav-item">
                                    <a class="nav-link @if ($tab == 'meeting') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'meeting']) }}">{{ get_phrase('Meeting') }}</a>
                                </li>
                            @endif
                            @if (has_permission('invoice', 'invoice.create', 'invoice.store', 'invoice.delete', 'invoice.edit', 'invoice.update', 'invoice.multi-delete'))
                                <li class="nav-item">
                                    <a class="nav-link @if ($tab == 'invoice') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'invoice']) }}">{{ get_phrase('Invoice') }}
                                    </a>
                                </li>
                            @endif
                            @if (has_permission('timesheets'))
                                <li class="nav-item">
                                    <a class="nav-link @if ($tab == 'timesheet') active @endif" href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'timesheet']) }}">{{ get_phrase('Timesheet') }}
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item ms-auto">
                                <a class="nav-link" href="{{ route(get_current_user_role() . '.projects', ['layout' => get_settings('list_view_type') ?? 'list']) }}">
                                    <i class="fi-rr-arrow-alt-left"></i>
                                    {{ get_phrase('Back') }}
                                </a>
                            </li>
                        </ul>
                    </nav>

                    @include("projects.{$tab}.index")
                </div>
            </div>
        </div>
    </div>
@endsection
