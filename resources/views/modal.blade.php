<div class="placeholder-content d-none">
    <div class="d-flex justify-content-center align-items-center">
        <div class="spinner-border text-primary spinner-border-lg" role="status">
            <span class="visually-hidden">{{ get_phrase('Loading...') }}</span>
        </div>
    </div>
    <p class="py-4 text-center">{{ get_phrase('Loading please wait...') }}</p>
</div>

<!-- setup offcanvas -->
<div class="global offcanvas p-1 offcanvas-end" id="ajaxOffcanvas" data-bs-scroll="true" tabindex="-1" id="Id1" aria-labelledby="backdrop">
    <div class="offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="backdrop"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-2"></div>
</div>


<div class="modal fade" id="multiDelete" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content pt-2">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center">
                    <span class="icon-confirm">
                        <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.2812 20.2656C15.7989 20.2656 16.2188 19.8458 16.2188 19.3281V9.95312C16.2188 9.43544 15.7989 9.01562 15.2812 9.01562C14.7636 9.01562 14.3438 9.43544 14.3438 9.95312V19.3281C14.3438 19.8458 14.7636 20.2656 15.2812 20.2656Z" fill="#F8285A" />
                            <path d="M8.71875 20.2656C9.23644 20.2656 9.65625 19.8458 9.65625 19.3281V9.95312C9.65625 9.43544 9.23644 9.01562 8.71875 9.01562C8.20106 9.01562 7.78125 9.43544 7.78125 9.95312V19.3281C7.78125 19.8458 8.20106 20.2656 8.71875 20.2656Z" fill="#F8285A" />
                            <path d="M15.75 1.98438C16.2677 1.98438 16.6875 1.56456 16.6875 1.04688C16.6875 0.529187 16.2677 0.109375 15.75 0.109375H8.25C7.73231 0.109375 7.3125 0.529187 7.3125 1.04688C7.3125 1.56456 7.73231 1.98438 8.25 1.98438H15.75Z" fill="#F8285A" />
                            <path d="M1.6875 2.92188C1.16981 2.92188 0.75 3.34169 0.75 3.85938C0.75 4.37706 1.16981 4.79688 1.6875 4.79688H2.625V22.0469C2.625 24.1655 4.35 25.8906 6.46875 25.8906H17.5312C19.6499 25.8906 21.375 24.1656 21.375 22.0469V4.79688H22.3125C22.8302 4.79688 23.25 4.37706 23.25 3.85938C23.25 3.34169 22.8302 2.92188 22.3125 2.92188H20.4375H3.5625H1.6875ZM19.5 4.79688V22.0469C19.5 23.1344 18.6187 24.0156 17.5312 24.0156H6.46875C5.38125 24.0156 4.5 23.1344 4.5 22.0469V4.79688H19.5Z" fill="#F8285A" />
                        </svg>
                    </span>
                </div>
                <p class="title">{{ get_phrase('Are you sure') }}?</p>
                <p class="">{{ get_phrase('Do you really want to delete these records') }}?</p>
            </div>

            <div class="d-flex align-items-center justify-content-center mb-4">
                <button type="button" class="btn ol-btn-secondary fw-500 me-1" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                <a href="javascript:void(0)" class="confirm-btn btn ol-btn-danger fw-500 ms-1">{{ get_phrase('Confirm') }}</a>
            </div>
        </div>
    </div>
</div>



{{-- Multitiple select floating menu --}}
<div class="floating-menu d-none" id="floatingMenu">
    <span class="selection-count">
        <span class="text-muted selected-number"></span> {{get_phrase(' of ')}} <span class="text-muted total-number"></span> {{get_phrase('selected')}}
        <button class="unselect-all btn pb-2"><i class="fi-rr-cross text-12px"></i></button>
    </span>

    <div class="divider export-option"></div>
    <div class="dropdown dropdown-export export-option dropup-center">
        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fi-rr-down-to-line me-2"></i>
            {{ get_phrase('Export') }}
            <i class="fi-rr-angle-up ms-3 d-none d-sm-inline-block"></i>
        </button>

        <ul class="dropdown-menu">
            <li>
                <a href="#" target="_blank" class="dropdown-item btn-pdf">
                    <i class="fi-rr-file-pdf"></i>
                    <span>{{ get_phrase('PDF') }}</span>
                </a>
            </li>

            <li>
                <a href="#" target="_blank" class="dropdown-item btn-csv">
                    <i class="fi-rr-file-export"></i>
                    <span>{{ get_phrase('CSV') }}</span>
                </a>
            </li>

            <li>
                <a href="#" target="_blank" class="dropdown-item btn-print">
                    <i class="fi-rr-print"></i>
                    <span>{{ get_phrase('Print') }}</span>
                </a>
            </li>

        </ul>
    </div>

    <div class="divider delete-option"></div>
    <button class="btn btn-delete"> <i class="fi-rr-trash"></i> {{ get_phrase('Delete') }}</button>
</div>
{{-- Multitiple select floating menu ended --}}

<!-- normal modal -->
<div class="modal global fade ad-modal" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalLabel"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content pt-2">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center">
                    <span class="icon-confirm my-3">
                        <i class="fi-rr-exclamation text-danger"></i>
                    </span>
                </div>
                <p class="title mb-2">{{ get_phrase('Are you sure') }}?</p>
                <p class="mb-2">{{ get_phrase('Do you want to execute this action') }}?</p>
            </div>
            <div class="d-flex align-items-center justify-content-center mb-4">
                <button type="button" class="btn ol-btn-secondary fw-500 me-1" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                <a href="javascript:void(0)" class="confirm-btn btn ol-btn-danger fw-500 ms-1">{{ get_phrase('Confirm') }}</a>
            </div>
        </div>
    </div>
</div>

<script>
    "use strict";

    function confirmModal(url, elem = false, actionType = null, content = null) {
        const $modal = $("#confirmModal");
        const $confirmBtn = $modal.find('.confirm-btn');

        // Show modal
        $modal.modal('show');

        // Set modal content if provided
        if (content) {
            $modal.find('.modal-body').html(content);
        }

        // Clear previous click events
        $confirmBtn.off('click');

        if (!elem) {
            $confirmBtn.on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        $modal.modal('hide');

                        // Delay reload if needed
                        setTimeout(reloadDataTable, 1000);

                        // Handle response (you may want to check response.success etc.)
                        processServerResponse(response);

                        // Conditional reload based on path
                        const path = window.location.pathname;
                        const shouldReload = ['/admin/events', '/staff/events', '/admin/event/delete', '/staff/event/delete']
                            .some(substring => path.includes(substring));

                        if (shouldReload) {
                            setTimeout(() => location.reload(), 500);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alert("Something went wrong. Please try again.");
                    }
                });
            });
        } else {
            // If elem is provided, just update href and remove inline onclick
            $confirmBtn.attr('href', url).removeAttr('onclick');
        }
    }


    function rightCanvas(url, title, position = '', previousElement = '') {
        if (previousElement != '' && $('.global .offcanvas-body').find(previousElement).length > 0) {
            $('.global.offcanvas').offcanvas('show');
            $('.offcanvas').show();
            $('.offcanvas-backdrop').show();
            return;
        }

        let spinner = $('.placeholder-spinner').html();

        let offcanvasBody = $('.global .offcanvas-body').empty().append(spinner);
        let canvasPosition = position == 'right' ? 'offcanvas-end' : 'offcanvas-start';

        $('.global .offcanvas-title').text(title);
        $('.global.offcanvas').addClass(position == '' ? 'offcanvas-end' : canvasPosition);
        $('.global.offcanvas').offcanvas('show');

        $('.offcanvas').show();
        $('.offcanvas-backdrop').show();

        $.ajax({
            type: "get",
            url: url,
            success: function(response) {
                if (response) {
                    $('.global.offcanvas .offcanvas-body').empty().html(response);
                }
            }
        });
    }

    function multiDelete(selectedIds, model_name, url) {
        $("#multiDelete").modal('show');

        $('.confirm-btn').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    ids: selectedIds,
                    type: model_name,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        processServerResponse(response);
                        $("#multiDelete").modal('hide');
                        reloadDataTable();
                        grid_view();
                    }
                },
                error: function(xhr, error, thrown) {
                    console.log(xhr.responseText);
                }
            });
        });
    }

    function modal(title = '', url = '', size = 'modal-md') {

        // load the spinner on every open
        let placeholder = $('.placeholder-content').html();
        $('#modal .modal-body').empty().html(placeholder);

        // set modal data
        $('#modal .modal-title').html(title);
        $('#modal .modal-dialog').addClass(size);
        $("#modal").modal('show');

        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
                if (response) {
                    $('#modal .modal-body').empty().html(response);
                }
            }
        });
    }
</script>
