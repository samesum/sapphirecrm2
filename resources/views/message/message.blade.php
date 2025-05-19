@extends('layouts.admin')
@push('title', get_phrase('Message'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="row g-4">
        <div class="col-xl-4 col-lg-5 col-md-4">
            <div class="message-sidebar-area">
                <div class="message-sidebar-header pb-0">
                    <div class="back-and-plus d-flex align-items-center justify-content-between flex-wrap">
                        <div class="back-title d-flex align-items-center">
                            <p class="title fs-16px">{{ get_phrase('Chat') }}</p>
                        </div>
                        @if (has_permission('message.thread.store'))
                            <a href="javascript:void(0)" onclick="modal('{{ get_phrase('Create a new thread') }}', '{{ route(get_current_user_role() . '.message.message_new') }}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px ms-auto">
                                <span class="fi-rr-plus"></span>
                                <span> {{ get_phrase('New Message') }} </span>
                            </a>
                        @endif
                        <button type="button" onclick="toggleUserList(this)" class="btn cg-10px btn-light d-md-none">
                            <span class="fi-rr-bars-staggered"></span>
                        </button>
                    </div>
                    <!-- Search -->
                    <form action="" class="responsive-toggler mb-4 mt-3 d-none d-md-block">
                        <div class="message-sidebar-search">
                            <label for="message-sideSearch" class="form-label sideSearch-label">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.58464 18.7918C4.8763 18.7918 1.04297 14.9584 1.04297 10.2501C1.04297 5.54175 4.8763 1.70842 9.58464 1.70842C14.293 1.70842 18.1263 5.54175 18.1263 10.2501C18.1263 14.9584 14.293 18.7918 9.58464 18.7918ZM9.58464 2.95842C5.55964 2.95842 2.29297 6.23342 2.29297 10.2501C2.29297 14.2668 5.55964 17.5418 9.58464 17.5418C13.6096 17.5418 16.8763 14.2668 16.8763 10.2501C16.8763 6.23342 13.6096 2.95842 9.58464 2.95842Z" fill="#4B5675"></path>
                                    <path d="M18.3315 19.6249C18.1732 19.6249 18.0148 19.5666 17.8898 19.4416L15.1148 16.5499C14.8732 16.3082 14.8732 15.9082 15.1148 15.6665C15.3565 15.4249 15.7565 15.4249 15.9982 15.6665L18.7732 18.5582C19.0148 18.7999 19.0148 19.1999 18.7732 19.4416C18.6482 19.5666 18.4898 19.6249 18.3315 19.6249Z" fill="#4B5675"></path>
                                </svg>
                            </label>
                            <input type="search" class="form-control" id="message-sideSearch" placeholder="{{ get_phrase('Search by username') }}">
                            <button type="submit" hidden=""></button>
                        </div>
                    </form>
                </div>
                <!-- Messages -->
                <ul class="message-sidebar-messages responsive-toggler d-none d-md-block" id="message-user-list">
                    @include('message.message_left_side_bar')
                </ul>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7 col-md-8">
            @if ($thread_details)
                @include('message.message_body')
            @else
                @include('no_data')
            @endif
        </div>
    </div>
    <script>
        "use strict";

        function toggleUserList() {
            $('.responsive-toggler').toggleClass('d-none d-md-block');
        }


        // Get the search input and message list
        const searchInput = document.getElementById('message-sideSearch');
        const messageItems = document.querySelectorAll('.message-item');

        // Add a keyup event listener to the search input
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();

            // Loop through the message items
            messageItems.forEach(function(item) {
                const name = item.querySelector('.name').textContent.toLowerCase();

                // Check if the name includes the filter text
                if (name.includes(filter)) {
                    item.style.display = ''; // Show the item
                } else {
                    item.style.display = 'none'; // Hide the item
                }
            });
        });
    </script>
@endsection
