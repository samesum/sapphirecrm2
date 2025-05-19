<div class="messenger-area">
    <div class="messenger-header d-flex align-items-center justify-content-between">
        @if ($thread_details->user)
            <div class="user-wrap d-flex align-items-center">
                <div class="profile">
                    <img src="{{ $thread_details->user?->photo ? get_image($thread_details->user?->photo) : get_image('assets/global/images/default.jpg') }}" alt="">
                </div>
                <div class="name-status">
                    <h6 class="name">{{ $thread_details->user?->name }}</h6>
                    <!-- for offline just remove active class  -->
                    <p class="status active">
                        <span class="now">{{ get_phrase('Active') }}</span>
                        <span class="was">{{ get_phrase('Offline') }}</span>
                    </p>
                </div>
            </div>
        @endif
        <div class="messenger-call-search d-flex align-items-center">

        </div>
    </div>
    <ul class="messenger-body" id="scrollAbleContent">
        @php
            $my_data = auth()->user();
        @endphp
        @if ($thread_details->messages->isEmpty())
            <div class="no-message card-centered-section">
                <div class="card-middle-banner">
                    <img src="{{ get_image('assets/images/icons/no-message.svg') }}" alt="">
                </div>
            </div>
        @else
            @foreach ($thread_details->messages as $message)
                @if ($message->sender_id == $my_data->id)
                    <li>
                        <div class="single-message recipient-user">
                            <div class="user-wrap d-flex align-items-center">
                                <div class="profile">
                                    <img data-bs-toggle="tooltip" title="{{ $my_data?->name }}" src="{{ $my_data?->photo ? get_image($my_data->photo) : get_image('assets/global/images/default.jpg') }}" alt="">
                                </div>
                            </div>
                            <div class="info">
                                <p class="message">{{ $message->message }}</p>
                                <p class="time">{{ timeAgo($message->created_at) }}</p>
                            </div>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="single-message">
                            <div class="user-wrap d-flex align-items-center">
                                <div class="profile">
                                    <img data-bs-toggle="tooltip" title="{{ $thread_details->user?->name }}" src="{{ $thread_details->user?->photo ? get_image($thread_details->user->photo) : get_image('assets/global/images/default.jpg') }}" alt="">
                                </div>
                            </div>
                            <div class="info">
                                <p class="message">{{ $message->message }}</p>
                                <p class="time">{{ timeAgo($message->created_at) }}</p>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        @endif

    </ul>
    <div class="messenger-footer">
        @if (has_permission('message.store'))
            <form action="{{ route(get_current_user_role() . '.message.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="sender_id" value="{{ $my_data->id }}">
                <input type="hidden" name="receiver_id" value="{{ $thread_details->user?->id }}">
                <input type="hidden" name="thread_id" value="{{ $thread_details->id }}">

                <div class="messenger-footer-inner d-flex align-items-center">
                    <input type="search" name="message" class="form-control form-control-message" placeholder="Type your message here...">

                    <button type="submit" class="btn ol-btn-primary d-flex align-items-center cg-10px">
                        <span>
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.785 5.79323L14.5675 3.19906C18.06 2.0349 19.9575 3.94156 18.8025 7.43406L16.2083 15.2166C14.4667 20.4507 11.6067 20.4507 9.865 15.2166L9.095 12.9066L6.785 12.1366C1.55083 10.3949 1.55083 7.54406 6.785 5.79323Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9.26562 12.5125L12.5473 9.22168" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span>{{ get_phrase('Sent') }}</span>
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
    "use strict";

    let divElement = document.getElementById('scrollAbleContent');
    // Scroll to the bottom of the div
    divElement.scrollTop = divElement.scrollHeight;
</script>
