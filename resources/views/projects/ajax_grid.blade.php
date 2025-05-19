@if (count($projects))
    @foreach ($projects as $project)
        <div class="col-sm-6 col-md-6 col-xl-4 col-xxl-3">
            <div class="grid-card context-menu hover-action-label" data-code="{{ $project->code }}">
                <!-- Task Info Section -->
                <div class="grid-title mt-0 ellipsis-line-2">
                    <span class="fs-12px fw-600">{{ $project->title }}</span>
                </div>

                <div class="d-flex mt-2 justify-content-between">
                    @if ($project->status == 'in_progress')
                        <span class="in_progress ">{{ get_phrase('In Progress') }}</span>
                    @elseif($project->status == 'not_started')
                        <span class="not_started">{{ get_phrase('Not Started') }}</span>
                    @elseif($project->status == 'completed')
                        <span class="completed">{{ get_phrase('Completed') }}</span>
                    @endif

                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{ route(get_current_user_role() . '.project.details', $project->code) }}" class="btn action-label">{{ get_phrase('Open Project') }}</a>
                        <div class="btn-group dropdown-menu-end ol-icon-dropdown ol-icon-dropdown-transparent" role="group">
                            <button type="button" class="btn action-label border-radius-right-6px" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fi-rr-menu-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu contextMenuContainer">
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'dashboard']) }}">{{ get_phrase('Dashboard') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'milestone']) }}">{{ get_phrase('Milestone') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'task']) }}">{{ get_phrase('Task') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'file']) }}">{{ get_phrase('File') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'meeting']) }}">{{ get_phrase('Meeting') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'invoice']) }}">{{ get_phrase('Invoice') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'timesheet']) }}">{{ get_phrase('Timesheet') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'gantt_chart']) }}">{{ get_phrase('Gantt Chart') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" onclick="rightCanvas('{{ route(get_current_user_role() . '.project.edit', $project->code) }}', 'Edit project')" href="#">{{ get_phrase('Edit') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" onclick="confirmModal('{{ route(get_current_user_role() . '.project.delete', $project->code) }}')" href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-16px">
                    <div class="d-flex flex-column align-items-start">
                        <span class="fs-10px fw-600 text-muted-1 mb-4px">{{ get_phrase('Client') }}</span>
                        <h6 class="fs-12px fw-600">{{ $project->user?->name }}</h6>
                    </div>
                    <div class="d-flex flex-column align-items-end">
                        <span class="fs-10px fw-600 text-muted-1 mb-4px code">{{ get_phrase('Code') }}</span>
                        <h6 class="fs-12px fw-600">{{ $project->code }}</h6>
                    </div>
                </div>



                <!-- Progress -->
                <div class="grid-progress grid-title mt-16px">
                    <div class="d-flex flex-column align-items-start">
                        <span class="fs-10px fw-600 text-muted-1 mb-4px">{{ get_phrase('Staff') }}</span>
                        <div class="d-flex align-items-center">
                            @foreach (json_decode($project->staffs, true) ?? [] as $key => $staff)
                                @php
                                    if ($key > 2) {
                                        break;
                                    }
                                @endphp
                                <img src="{{ get_image(App\models\User::where('id', $staff)->first()->photo) }}" alt="Attendee 1">
                            @endforeach
                            @if (count(json_decode($project->staffs, true) ?? []) > 3)
                                <span class="project-count">+{{ count(json_decode($project->staffs)) - 3 }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end">
                        <span class="fs-10px fw-600 text-muted-1 mb-4px">{{ get_phrase('Budget') }}</span>
                        <h6 class="fs-12px fw-600">{{ currency($project->budget) }}</h6>
                    </div>
                </div>

                <div class="mt-16px">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fs-10px fw-600 text-muted-1 mb-4px">{{ get_phrase('Progress') }}</span>
                        <span class="fs-12px">{{ $project->progress }}%</span>
                    </div>
                    <div class="bg-light rounded overflow-hidden h-8px">
                        <div class="bg-progress-primary" style="width: {{ $project->progress }}%; height: 100%; border-radius: 8px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-lg-12">
        <div id="table-data-not-found" class="my-4">
            <div class="no-data py-5">
                <img class="max-w-150px" src="{{ asset('assets/images/no-data.png') }}" alt="No Data">
                <h3 class="py-3">{{ get_phrase('No Result Found') }}</h3>
                <p class="pb-4">{{ get_phrase('If there is no data, add new records or clear the applied filters.') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center d-lpaginate">
        <div class="page-length-select fs-12px d-flex align-items-center mt-3 w-260">
            <label for="page-length-select" class="pe-2">{{ get_phrase('Showing') }}:</label>
            <select id="page-length-select" class="form-select fs-12px w-auto ol-niceSelect">
                <option value="10" {{ $page_item == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ $page_item == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ $page_item == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $page_item == 100 ? 'selected' : '' }}>100</option>
            </select>
            <label for="page-length-select" class="ps-2 w-100">
                {{ get_phrase('of') }}
                {{ $projects->total() }}
            </label>
        </div>
        <div class="lpaginate mt-4">
            {{ $projects->links() }}
        </div>
    </div>
</div>

@if (isset($filter_count))
    <script>
        "use strict";
        var filter_count_val = {{ $filter_count }};

        if (filter_count_val > 0) {
            $('#filter-count-display').text(filter_count_val).removeClass('d-none');
            $('#filter-reset').removeClass('d-none');
        }
    </script>
@endif
