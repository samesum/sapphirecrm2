@extends('layouts.admin')
@push('title', get_phrase('Dashboard'))
@section('content')
    <div class="admin-dashboard">
        <div class="row mt-4">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-card mb-3">

                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.1" width="32" height="32" rx="16" fill="#605BFF" />
                                <path
                                    d="M22.8173 12.235C22.1798 11.53 21.1148 11.1775 19.5698 11.1775H19.3898V11.1475C19.3898 9.88751 19.3898 8.32751 16.5698 8.32751H15.4298C12.6098 8.32751 12.6098 9.89501 12.6098 11.1475V11.185H12.4298C10.8773 11.185 9.81978 11.5375 9.18228 12.2425C8.43978 13.0675 8.46228 14.1775 8.53728 14.935L8.54478 14.9875L8.59724 15.5383C8.6115 15.6881 8.69223 15.8235 8.81829 15.9056C9.00007 16.024 9.26513 16.1935 9.42978 16.285C9.53478 16.3525 9.64728 16.4125 9.75978 16.4725C11.0423 17.1775 12.4523 17.65 13.8848 17.8825C13.9523 18.5875 14.2598 19.4125 15.9023 19.4125C17.5448 19.4125 17.8673 18.595 17.9198 17.8675C19.4498 17.62 20.9273 17.0875 22.2623 16.3075C22.3073 16.285 22.3373 16.2625 22.3748 16.24C22.6568 16.0806 22.9487 15.8862 23.218 15.6935C23.3313 15.6124 23.4035 15.4863 23.4189 15.3478L23.4248 15.295L23.4623 14.9425C23.4698 14.8975 23.4698 14.86 23.4773 14.8075C23.5373 14.05 23.5223 13.015 22.8173 12.235ZM16.8173 17.3725C16.8173 18.1675 16.8173 18.2875 15.8948 18.2875C14.9723 18.2875 14.9723 18.145 14.9723 17.38V16.435H16.8173V17.3725ZM13.6823 11.1775V11.1475C13.6823 9.87251 13.6823 9.40001 15.4298 9.40001H16.5698C18.3173 9.40001 18.3173 9.88001 18.3173 11.1475V11.185H13.6823V11.1775Z"
                                    fill="#605BFF" />
                                <path d="M22.4541 17.3962C22.8084 17.2295 23.2152 17.5104 23.1798 17.9004L22.9309 20.6425C22.7734 22.1425 22.1584 23.6725 18.8584 23.6725H13.1434C9.84336 23.6725 9.22836 22.1425 9.07086 20.65L8.83515 18.0572C8.80011 17.6717 9.19785 17.3913 9.55114 17.5493C10.4131 17.935 11.7865 18.5216 12.6914 18.7696C12.8552 18.8145 12.9888 18.9329 13.0649 19.0848C13.5325 20.0187 14.508 20.515 15.9034 20.515C17.285 20.515 18.2722 19.9996 18.7417 19.0625C18.8179 18.9105 18.9513 18.7922 19.1151 18.747C20.0786 18.4812 21.548 17.8225 22.4541 17.3962Z" fill="#605BFF" />
                            </svg>

                            <h3> {{ count($active_projects) }}+ </h3>
                            <p class="text-muted"> {{ get_phrase('Active Projects') }} </p>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="dashboard-card mb-3">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.2" width="32" height="32" rx="16" fill="#FFD66B" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M19.6977 12.25C19.7216 12.1968 19.7328 12.1389 19.7304 12.0807H19.75C19.6661 10.0794 18.0137 8.5 16.0037 8.5C13.9937 8.5 12.3413 10.0794 12.2574 12.0807C12.2475 12.1367 12.2475 12.194 12.2574 12.25L12.1988 12.25C11.2377 12.25 10.2103 12.8845 9.91198 14.5901L9.32868 19.2361C8.85143 22.6472 10.608 23.5 12.9014 23.5H19.1189C21.4057 23.5 23.1092 22.2652 22.6849 19.2361L22.1083 14.5901C21.757 12.9322 20.7627 12.25 19.8148 12.25L19.6977 12.25ZM18.6199 12.25C18.599 12.196 18.588 12.1386 18.5872 12.0807C18.5872 10.6426 17.4174 9.47679 15.9743 9.47679C14.5312 9.47679 13.3614 10.6426 13.3614 12.0807C13.3713 12.1367 13.3713 12.194 13.3614 12.25H18.6199ZM13.8227 16.1114C13.4567 16.1114 13.1599 15.806 13.1599 15.4292C13.1599 15.0524 13.4567 14.747 13.8227 14.747C14.1888 14.747 14.4856 15.0524 14.4856 15.4292C14.4856 15.806 14.1888 16.1114 13.8227 16.1114ZM17.5015 15.4292C17.5015 15.806 17.7983 16.1114 18.1644 16.1114C18.5304 16.1114 18.8272 15.806 18.8272 15.4292C18.8272 15.0524 18.5304 14.747 18.1644 14.747C17.7983 14.747 17.5015 15.0524 17.5015 15.4292Z"
                                    fill="#FFC327" />
                            </svg>
                            <h3> {{ count($resent_projects) }}+ </h3>
                            <p class="text-muted"> {{ get_phrase('Total Projects') }} </p>

                        </div>
                    </div>
                </div>
                <div class="ol-card">
                    <div class="ol-card-body p-2">
                        <div id="donut" class="dashboard-donut"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="ol-card">
                    <div class="ol-card-body p-2 pt-3">
                        <div id="bar-chart"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="ol-card">
                    <div class="ol-card-body p-3">
                        <div class="dashboard-table table-responsive">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h4 class="text-14px"> {{ get_phrase('Projects') }} </h4>
                                <a href="{{ route(get_current_user_role() . '.projects', ['layout' => get_settings('list_view_type') ?? 'list']) }}" class="btn btn-see-all"> {{ get_phrase('See All') }} <i class="fi-rr-angle-small-right"></i></a>
                            </div>
                            <table class="table mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Title') }}</th>
                                        <th scope="col">{{ get_phrase('Client') }}</th>
                                        <th scope="col">{{ get_phrase('Status') }}</th>
                                        <th scope="col">{{ get_phrase('Progress') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resent_projects as $key => $recent)
                                        @php
                                            if ($key == 5) {
                                                continue;
                                            }
                                        @endphp
                                        <tr>
                                            <th scope="row"> {{ $key + 1 }} </th>
                                            <td>
                                                <a href="{{ route(get_current_user_role() . '.project.details', $recent->code) }}" title="{{$recent->title}}" data-bs-toggle="tooltip" class="ellipsis-line-1 mx-120px">{{ $recent->title }}</a>
                                            </td>
                                            <td> {{ $recent->user?->name }} </td>
                                            <td>
                                                @php
                                                    $task = $recent->status;
                                                    $statusLabel = '';
                                                    if ($task == 'in_progress') {
                                                        $statusLabel = '<span class="in_progress">' . removeScripts(get_phrase('In Progress')) . '</span>';
                                                    } elseif ($task == 'not_started') {
                                                        $statusLabel = '<span class="not_started">' . removeScripts(get_phrase('Not Started')) . '</span>';
                                                    } elseif ($task == 'completed') {
                                                        $statusLabel = '<span class="completed">' . removeScripts(get_phrase('Completed')) . '</span>';
                                                    }
                                                    echo $statusLabel;
                                                @endphp
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-start gap-2 min-w-100px">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $recent->progress }}%; " aria-valuenow="{{ $recent->progress }}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <span class="fs-12px">{{ $recent->progress }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="ol-card">
                    <div class="ol-card-body p-3">
                        <div class="dashboard-table table-responsive">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="text-14px"> {{ get_phrase('Tasks') }} </h4>
                            </div>
                            <table class="table mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Title') }}</th>
                                        <th scope="col">{{ get_phrase('Start Data') }}</th>
                                        <th scope="col">{{ get_phrase('Status') }}</th>
                                        <th scope="col">{{ get_phrase('Progress') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($resent_tasks as $key => $recent)
                                        @php
                                            if ($key == 5) {
                                                continue;
                                            }
                                        @endphp
                                        <tr>
                                            <th scope="row"> {{ $key + 1 }} </th>
                                            <td> {{ $recent->title }} <p>{{ $recent->user?->name }}</p>
                                            </td>
                                            <td> {{ date('d M Y h:i A', $recent->start_date) }} </td>
                                            <td>
                                                @php
                                                    $task = $recent->status;
                                                    $statusLabel = '';
                                                    if ($task == 'in_progress') {
                                                        $statusLabel = '<span class="in_progress">' . removeScripts(get_phrase('In Progress')) . '</span>';
                                                    } elseif ($task == 'not_started') {
                                                        $statusLabel = '<span class="not_started">' . removeScripts(get_phrase('Not Started')) . '</span>';
                                                    } elseif ($task == 'completed') {
                                                        $statusLabel = '<span class="completed">' . removeScripts(get_phrase('Completed')) . '</span>';
                                                    }
                                                    echo $statusLabel;
                                                @endphp
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-start gap-2 min-w-100px">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $recent->progress }}%; " aria-valuenow="{{ $recent->progress }}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <span class="fs-12px">{{ $recent->progress }}%</span>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

        document.addEventListener('DOMContentLoaded', function() {

            let dataArr = @json($total_payments).map(function(status) {

                return {
                    x: status.title,
                    y: status.amount
                };
            });

            var barOptions = {
                chart: {
                    type: 'bar',
                    height: 460,
                    borderRadius: 5,
                    fontFamily: 'Inter',
                },

                series: [{
                    name: '{{ get_phrase('Total Revenue In This Month') }}',
                    data: dataArr
                }],


                title: {
                    text: '{{ get_phrase('Total payment in this year') }}',
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
                    height: 200,
                    fontFamily: 'Inter',
                },
                series: values,
                labels: labels,
                title: {
                    text: 'Projects',
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
                            height: 200,
                        },
                    }
                }]
            };

            var donutChart = new ApexCharts(document.querySelector("#donut"), donutOptions);
            donutChart.render();
        });
    </script>
@endpush
