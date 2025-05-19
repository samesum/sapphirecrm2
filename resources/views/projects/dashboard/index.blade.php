@php
    $project_id = project_id_by_code(request()->route()->parameter('code'));
    $timesheets = App\Models\Timesheet::where('project_id', $project_id)->get();
    $total_milestone = App\Models\Milestone::where('project_id', $project_id)->count();
    $total_meeting = App\Models\Meeting::where('project_id', $project_id)->count();
    $project = App\Models\Project::where('id', $project_id)->first();

    $tasks = App\Models\Task::where('project_id', $project_id);
    $total_tasks = $tasks->count();

    $project_client = App\Models\User::where('id', $project->client_id)->firstOrNew();
@endphp

@push('title', get_phrase('Dashboard').' - '. $project->title)

<div class="project-dashboard">
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="row">
                    <div class="col-sm-6">
                        <div id="donut"></div>
                    </div>
                    <div class="col-sm-6">
                        <div id="bar-chart"></div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6 col-xl-3">
                        <div class="dashboard-card-1">

                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.1" width="32" height="32" rx="16" fill="#5B93FF" />
                                <path d="M18.8498 8.6575C18.5423 8.35 18.0098 8.56 18.0098 8.9875V11.605C18.0098 12.7 18.9398 13.6075 20.0723 13.6075C20.7848 13.615 21.7748 13.615 22.6223 13.615C23.0498 13.615 23.2748 13.1125 22.9748 12.8125C21.8948 11.725 19.9598 9.7675 18.8498 8.6575Z" fill="#5B93FF" />
                                <path d="M22.375 14.6425H20.2075C18.43 14.6425 16.9825 13.195 16.9825 11.4175V9.25C16.9825 8.8375 16.645 8.5 16.2325 8.5H13.0525C10.7425 8.5 8.875 10 8.875 12.6775V19.3225C8.875 22 10.7425 23.5 13.0525 23.5H18.9475C21.2575 23.5 23.125 22 23.125 19.3225V15.3925C23.125 14.98 22.7875 14.6425 22.375 14.6425ZM15.625 20.3125H12.625C12.3175 20.3125 12.0625 20.0575 12.0625 19.75C12.0625 19.4425 12.3175 19.1875 12.625 19.1875H15.625C15.9325 19.1875 16.1875 19.4425 16.1875 19.75C16.1875 20.0575 15.9325 20.3125 15.625 20.3125ZM17.125 17.3125H12.625C12.3175 17.3125 12.0625 17.0575 12.0625 16.75C12.0625 16.4425 12.3175 16.1875 12.625 16.1875H17.125C17.4325 16.1875 17.6875 16.4425 17.6875 16.75C17.6875 17.0575 17.4325 17.3125 17.125 17.3125Z" fill="#5B93FF" />
                            </svg>

                            <div>
                                <p> {{ get_phrase('Total task') }} </p>
                                <h4> {{ $total_tasks }}+ </h4>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="dashboard-card-1">

                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.1" width="32" height="32" rx="16" fill="#FF8F6B" />
                                <path d="M13.75 8.5C11.785 8.5 10.1875 10.0975 10.1875 12.0625C10.1875 13.99 11.695 15.55 13.66 15.6175C13.72 15.61 13.78 15.61 13.825 15.6175C13.84 15.6175 13.8475 15.6175 13.8625 15.6175C13.87 15.6175 13.87 15.6175 13.8775 15.6175C15.7975 15.55 17.305 13.99 17.3125 12.0625C17.3125 10.0975 15.715 8.5 13.75 8.5Z" fill="#FF8F6B" />
                                <path d="M17.5607 17.6125C15.4682 16.2175 12.0557 16.2175 9.9482 17.6125C8.9957 18.25 8.4707 19.1125 8.4707 20.035C8.4707 20.9575 8.9957 21.8125 9.9407 22.4425C10.9907 23.1475 12.3707 23.5 13.7507 23.5C15.1307 23.5 16.5107 23.1475 17.5607 22.4425C18.5057 21.805 19.0307 20.95 19.0307 20.02C19.0232 19.0975 18.5057 18.2425 17.5607 17.6125Z" fill="#FF8F6B" />
                                <path d="M21.992 12.505C22.112 13.96 21.077 15.235 19.6445 15.4075C19.637 15.4075 19.637 15.4075 19.6295 15.4075H19.607C19.562 15.4075 19.517 15.4075 19.4795 15.4225C18.752 15.46 18.0845 15.2275 17.582 14.8C18.3545 14.11 18.797 13.075 18.707 11.95C18.6545 11.3425 18.4445 10.7875 18.1295 10.315C18.4145 10.1725 18.7445 10.0825 19.082 10.0525C20.552 9.925 21.8645 11.02 21.992 12.505Z" fill="#FF8F6B" />
                                <path d="M23.4922 19.4425C23.4322 20.17 22.9672 20.8 22.1872 21.2275C21.4372 21.64 20.4922 21.835 19.5547 21.8125C20.0947 21.325 20.4097 20.7175 20.4697 20.0725C20.5447 19.1425 20.1022 18.25 19.2172 17.5375C18.7147 17.14 18.1297 16.825 17.4922 16.5925C19.1497 16.1125 21.2347 16.435 22.5172 17.47C23.2072 18.025 23.5597 18.7225 23.4922 19.4425Z" fill="#FF8F6B" />
                            </svg>
                            <div>
                                <p> {{ get_phrase('Team Members') }} </p>
                                <h4> {{ count(json_decode($project->staffs, true) ?? []) }}+ </h4>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="dashboard-card-1">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.2" width="32" height="32" rx="16" fill="#FFD66B" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M19.6977 12.25C19.7216 12.1968 19.7328 12.1389 19.7304 12.0807H19.75C19.6661 10.0794 18.0137 8.5 16.0037 8.5C13.9937 8.5 12.3413 10.0794 12.2574 12.0807C12.2475 12.1367 12.2475 12.194 12.2574 12.25L12.1988 12.25C11.2377 12.25 10.2103 12.8845 9.91198 14.5901L9.32868 19.2361C8.85143 22.6472 10.608 23.5 12.9014 23.5H19.1189C21.4057 23.5 23.1092 22.2652 22.6849 19.2361L22.1083 14.5901C21.757 12.9322 20.7627 12.25 19.8148 12.25L19.6977 12.25ZM18.6199 12.25C18.599 12.196 18.588 12.1386 18.5872 12.0807C18.5872 10.6426 17.4174 9.47679 15.9743 9.47679C14.5312 9.47679 13.3614 10.6426 13.3614 12.0807C13.3713 12.1367 13.3713 12.194 13.3614 12.25H18.6199ZM13.823 16.1114C13.4569 16.1114 13.1602 15.806 13.1602 15.4292C13.1602 15.0524 13.4569 14.747 13.823 14.747C14.1891 14.747 14.4858 15.0524 14.4858 15.4292C14.4858 15.806 14.1891 16.1114 13.823 16.1114ZM17.502 15.4292C17.502 15.806 17.7987 16.1114 18.1648 16.1114C18.5309 16.1114 18.8276 15.806 18.8276 15.4292C18.8276 15.0524 18.5309 14.747 18.1648 14.747C17.7987 14.747 17.502 15.0524 17.502 15.4292Z"
                                    fill="#FFC327" />
                            </svg>
                            <div>
                                <p> {{ get_phrase('Total Milestones') }} </p>
                                <h4> {{ $total_milestone }}+ </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="dashboard-card-1">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.1" width="32" height="32" rx="16" fill="#605BFF" />
                                <path
                                    d="M22.8173 12.235C22.1798 11.53 21.1148 11.1775 19.5698 11.1775H19.3898V11.1475C19.3898 9.8875 19.3898 8.3275 16.5698 8.3275H15.4298C12.6098 8.3275 12.6098 9.895 12.6098 11.1475V11.185H12.4298C10.8773 11.185 9.81978 11.5375 9.18228 12.2425C8.43978 13.0675 8.46228 14.1775 8.53728 14.935L8.54478 14.9875L8.59724 15.5383C8.6115 15.6881 8.69223 15.8234 8.81829 15.9056C9.00007 16.024 9.26513 16.1935 9.42978 16.285C9.53478 16.3525 9.64728 16.4125 9.75978 16.4725C11.0423 17.1775 12.4523 17.65 13.8848 17.8825C13.9523 18.5875 14.2598 19.4125 15.9023 19.4125C17.5448 19.4125 17.8673 18.595 17.9198 17.8675C19.4498 17.62 20.9273 17.0875 22.2623 16.3075C22.3073 16.285 22.3373 16.2625 22.3748 16.24C22.6568 16.0806 22.9487 15.8862 23.218 15.6935C23.3313 15.6124 23.4035 15.4862 23.4189 15.3477L23.4248 15.295L23.4623 14.9425C23.4698 14.8975 23.4698 14.86 23.4773 14.8075C23.5373 14.05 23.5223 13.015 22.8173 12.235ZM16.8173 17.3725C16.8173 18.1675 16.8173 18.2875 15.8948 18.2875C14.9723 18.2875 14.9723 18.145 14.9723 17.38V16.435H16.8173V17.3725ZM13.6823 11.1775V11.1475C13.6823 9.8725 13.6823 9.4 15.4298 9.4H16.5698C18.3173 9.4 18.3173 9.88 18.3173 11.1475V11.185H13.6823V11.1775Z"
                                    fill="#605BFF" />
                                <path d="M22.4541 17.3962C22.8084 17.2294 23.2152 17.5104 23.1798 17.9004L22.9309 20.6425C22.7734 22.1425 22.1584 23.6725 18.8584 23.6725H13.1434C9.84336 23.6725 9.22836 22.1425 9.07086 20.65L8.83515 18.0572C8.80011 17.6717 9.19785 17.3912 9.55114 17.5493C10.4131 17.935 11.7865 18.5216 12.6914 18.7696C12.8552 18.8145 12.9888 18.9329 13.0649 19.0848C13.5325 20.0187 14.508 20.515 15.9034 20.515C17.285 20.515 18.2722 19.9996 18.7417 19.0625C18.8179 18.9105 18.9513 18.7922 19.1151 18.747C20.0786 18.4812 21.548 17.8225 22.4541 17.3962Z" fill="#605BFF" />
                            </svg>

                            <div>
                                <p> {{ get_phrase('Total Meeting') }} </p>
                                <h4> {{ $total_meeting }}+ </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">

            <div class="dashboard-card">
                <div class="upcoming-meetings">

                    <div class="meeting-user">
                        <img src="{{ $project_client->photo ? get_image($project_client->photo) : get_image('assets/global/images/default.jpg') }}" alt="">
                        <div>
                            <h5>{{ $project_client->name }}</h5>
                            <p>{{ $project_client->email }}</p>
                        </div>
                    </div>

                    <h5 class="text-14px fw-600 my-2">{{get_phrase('Upcoming Meeting')}}</h5>

                    @php
                        $current_user_role = get_current_user_role();
                        $query = App\Models\Meeting::query();
                        $query->where('project_id', project_id_by_code($project_code));
                        $query->where('status', 'upcoming');
                    @endphp

                    @foreach ($query->limit(10)->get() as $key => $meeting)
                        <div class="meeting-list">
                            <div class="info">
                                <h5>{{ $meeting->title }}</h5>
                                <p>{{ $meeting->agenda }}</p>
                                <small>{{ date('d M Y H:i', strtotime($meeting->timestamp_meeting)) }}</small>
                            </div>
                            <div class="join">
                                @php
                                    $meeting_info = json_decode($meeting->joining_data);
                                @endphp

                                @if ($meeting->meeting_type == 'online')
                                    @if (auth()->user()->role_id == 2)
                                        <a href="{{ $meeting_info?->join_url }}" class="btn btn-primary btn-sm">{{ get_phrase('Join Meeting') }}</a>
                                    @else
                                        <a href="{{ $meeting_info?->start_url }}" class="btn btn-primary btn-sm">{{ get_phrase('Start Meeting') }}</a>
                                    @endif
                                @else
                                    <a href="#" class="btn ol-btn-light view-btn">{{ get_phrase('Offline Meeting') }}</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mt-3">
        <div class="col-lg-6">
            <div class="dashboard-table">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="text-14px"> {{ get_phrase('Tasks') }} </h4>
                    <a href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'task']) }}" class="btn btn-see-all"> {{ get_phrase('See All') }} <i class="fi-rr-angle-small-right"></i></a>
                </div>
                <table class="table mt-2">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ get_phrase('Title') }}</th>
                            <th scope="col">{{ get_phrase('From') }}</th>
                            <th scope="col">{{ get_phrase('To') }}</th>
                            <th scope="col">{{ get_phrase('Progress') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks->limit(10)->get() as $key => $task)
                            @php
                                if ($key == 5) {
                                    continue;
                                }
                            @endphp
                            <tr>
                                <th scope="row"> {{ $key + 1 }} </th>
                                <td>
                                    <span class="cursor-pointer ellipsis-line-1 mx-120px" data-bs-toggle="tooltip" title="{{$task?->title}}">{{ $task?->title }}</span>
                                </td>
                                <td>
                                    {{ date('d M Y', $task->start_date) }}
                                </td>
                                <td>
                                    {{ date('d M Y', $task->start_date) }}
                                </td>
                                <td>
                                    @php $progress = $task->progress; @endphp
                                    <div class="dAdmin_profile d-flex gap-2 align-items-center min-w-200px">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%; " aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="fs-12px">{{ $progress }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="dashboard-card dashboard-table">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="text-14px"> {{ get_phrase('Timesheet') }} </h4>
                    <a href="{{ route(get_current_user_role() . '.project.details', [$project_code, 'timesheet']) }}" class="btn btn-see-all"> {{ get_phrase('See All') }} <i class="fi-rr-angle-small-right"></i></a>
                </div>
                <table class="table mt-2">
                    <thead>
                        <tr class="fs-14px">
                            <th scope="col"> {{ get_phrase('Staff') }} </th>
                            <th scope="col" class="text-center"> {{ get_phrase('Task') }} </th>
                            <th scope="col" class="text-center"> {{ get_phrase('Hours') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($timesheets as $time)
                            @php
                                $team_member = App\Models\User::where('id', $time->staff)->first();
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $team_member->photo ? get_image($team_member->photo) : get_image('assets/global/images/default.jpg') }}" class="rounded-circle" width="30px" height="30px" alt="">
                                        <div class="ps-2">
                                            <h6 class="text-dark text-14px d-block"> {{ $team_member->name }} </h6>
                                            <span class="text-12px"> {{ $team_member->email }} </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $team_id = '"' . $team_member->id . '"';
                                        echo App\Models\Task::where('project_id', $project_id)
                                            ->where('team', 'like', '%' . $team_id . '%')
                                            ->count();
                                    @endphp
                                </td>
                                <td class="text-center">
                                    @php
                                        if ($time->timestamp_start && $time->timestamp_end) {
                                            $hours = round((strtotime($time->timestamp_end) - strtotime($time->timestamp_start)) / 3600, 2);
                                            echo $hours . ' ' . removeScripts(get_phrase('hours'));
                                        } else {
                                            echo removeScripts(get_phrase('0 hour'));
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    "use strict";
    
    document.addEventListener('DOMContentLoaded', function() {

        let dataArr = @json($project_status).map(function(status) {

            return {
                x: status.title,
                y: status.amount
            };
        });

        var barOptions = {
            chart: {
                type: 'bar',
                height: 300,
                borderRadius: 5,
                fontFamily: 'Inter',
            },

            series: [{
                name: '{{ get_phrase('Total Task In This Project') }}',
                data: dataArr
            }],


            title: {
                text: '{{ get_phrase('Project Task Bar') }}',
                align: 'left'
            }
        };

        var barChart = new ApexCharts(document.querySelector("#bar-chart"), barOptions);
        barChart.render();
    });

    document.addEventListener('DOMContentLoaded', function() {

        let dataArr = @json($project_status).map(function(status) {
            return {
                label: status.title,
                value: status.amount
            };
        });

        const labels = dataArr.map(item => item.label);
        const values = dataArr.map(item => item.value);

        var donutOptions = {
            chart: {
                type: 'donut',
                height: 400,
                fontFamily: 'Inter',
            },
            series: values,
            labels: labels,
            title: {
                text: 'Projects Overview',
                align: 'left'
            },
            colors: [
                '#212534',
                '#4e97ff',
                '#4de78e'
            ],
            dataLabels: {
                enabled: false
            },
            responsive: [{
                options: {
                    chart: {
                        height: 288,
                    }
                }
            }]
        };

        var donutChart = new ApexCharts(document.querySelector("#donut"), donutOptions);
        donutChart.render();
    });
</script>
