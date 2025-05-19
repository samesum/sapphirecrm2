<div class="ol-card">
    <div class="ol-card-body">
        <!-- Table -->
        <div class="table-responsive overflow-auto course_list" id="project_list">
            <table class="table eTable eTable-2" id="">
                <thead>
                    <th scope="col">{{ get_phrase('Tasks') }}</th>
                    <th scope="col">{{ get_phrase('Progress') }}</th>
                </thead>

                <tbody>
                    @foreach ($tasks as $task)
                        <tr data-id="{{ $task->id }}" class="context-menu">
                            <td>
                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                    <div class="dAdmin_profile_name">
                                        <h4 class="title fs-14px">{{ $task->title }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dAdmin_profile d-block align-items-center min-w-200px">
                                    <span class="p-2">{{ $task->progress }}%</span>
                                    <div class="progress progress-100-3 ms-2">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $task->progress }}%; "
                                            aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
