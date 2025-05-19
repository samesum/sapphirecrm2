
@if(has_permission('gantt.chart'))
@php
    $project_id = project_id_by_code(request()->route()->parameter('code'));
    $project = App\Models\Project::where('id', $project_id)->first();
@endphp

@push('title', get_phrase('Gantt Chart').' - '.$project->title)
@php
    $tasks = App\Models\Task::where('project_id', project_id_by_code(request()->route()->parameter('code')))->get();
@endphp
<div id="chart_div" class="mt-3 print-table">
</div>
<a href="#" class="btn ol-btn-primary" onclick="window.print()">{{get_phrase('Print')}}</a>

<div id="empty_chart" class="d-none">
    <div class="d-flex justify-content-center flex-column align-items-center p-5">
        <img src="{{ asset('assets/images/task-not-found.png') }}" class="mt-5 mb-3" alt="No tasks available"
            width="200px">
        <p class="pb-5">{{ get_phrase('No Task Available') }}</p>
    </div>
</div>

@push('js')
    <script type="text/javascript">
        "use strict";

        google.charts.load('current', {
            packages: ['gantt']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var tasks = @json($tasks); // Pass PHP tasks data to JS

            // Handle empty tasks
            if (tasks.length === 0) {
                var html = document.getElementById('empty_chart').innerHTML;
                document.getElementById('chart_div').innerHTML = html;
                return;
            }

            var data = new google.visualization.DataTable();

            // Define Gantt chart columns
            data.addColumn('string', 'Task ID');
            data.addColumn('string', 'Task Name');
            data.addColumn('string', 'Resource');
            data.addColumn('date', 'Start Date');
            data.addColumn('date', 'End Date');
            data.addColumn('number', 'Duration');
            data.addColumn('number', 'Percent Complete');
            data.addColumn('string', 'Dependencies');

            // Populate Gantt chart rows
            data.addRows([
                @foreach ($tasks as $task)
                    [
                        'Task{{ $task->id }}', // Task ID
                        '{{ addslashes($task->title) }}', // Task Name
                        null, // Resource
                        new Date({{ $task->start_date * 1000 }}), // Convert UNIX timestamp to JavaScript Date
                        new Date({{ $task->end_date * 1000 }}),  // End Date
                        null, // Duration
                        {{ $task->progress ?? 0 }}, // Progress
                        null, // Dependencies
                    ],
                @endforeach
            ]);

            // Chart options
            var options = {
                height: 500,
                backgroundColor: '#f0f4f8',
                gantt: {
                    trackHeight: 60,
                    barHeight: 40,
                    palette: [{
                            color: '#42a5f5',
                            dark: '#1e88e5',
                            light: '#bbdefb'
                        },
                        {
                            color: '#ef5350',
                            dark: '#e53935',
                            light: '#ffcdd2'
                        }
                    ],
                    criticalPathEnabled: true,
                    criticalPathStyle: {
                        stroke: '#ff7043',
                        strokeWidth: 6
                    },
                    arrow: {
                        angle: 45,
                        width: 2,
                        color: '#ff5722',
                        radius: 0
                    },
                    labelStyle: {
                        fontName: 'Arial',
                        fontSize: 13,
                        color: '#333'
                    }
                },
                hAxis: {
                    textStyle: {
                        color: '#333',
                        fontName: 'Arial',
                        fontSize: 12
                    }
                },
                vAxis: {
                    textStyle: {
                        color: '#333',
                        fontName: 'Arial',
                        fontSize: 12
                    }
                },
                tooltip: {
                    isHtml: true
                }
            };

            // Render Gantt chart
            var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

            // Add event listener to modify lines
            google.visualization.events.addListener(chart, 'ready', function() {
                // Make lines dashed
                document.querySelectorAll('line').forEach(function(line) {
                    if (line.getAttribute('stroke') === '#e0e0e0') { // Match color
                        line.setAttribute('stroke-dasharray', '5,5'); // Dashed style
                    }
                });
            });

            chart.draw(data, options);
        }
    </script>

@endpush
@endif
