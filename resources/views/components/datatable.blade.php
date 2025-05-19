<link rel="stylesheet" href="{{ asset('assets/datatable/dataTables.bootstrap5.css') }}">
<script src="{{ asset('assets/datatable/dataTables.js') }}"></script>
<script src="{{ asset('assets/datatable/dataTables.bootstrap5.js') }}"></script>




<div id="nodata-content-block" class="d-none">
    <div class="no-data py-5">
        <img class="max-w-150px" src="{{ asset('assets/images/no-data.png') }}" alt="No Data">
        <h3 class="py-3">{{ get_phrase('No Result Found') }}</h3>
        <p class="pb-4">{{ get_phrase('If there is no data, add new records or clear the applied filters.') }}</p>
    </div>
</div>
<script>
    "use strict";


    function getTableNoDataFoundContent(dataExists, returnHtml = false) {
        const filterResetExists = $('#filter-reset').length > 0;
        const filterResetHidden = $('#filter-reset').hasClass('d-none');
        const searchBoxEmpty = $('#custom-search-box').val() === '';

        // Determine if data truly exists
        if (
            (!filterResetExists || (filterResetExists && filterResetHidden)) &&
            searchBoxEmpty &&
            dataExists == 0
        ) {
            dataExists = 0;
        } else {
            dataExists = 1;
        }

        const noDataContentBlock = document.getElementById('nodata-content-block');
        if (!noDataContentBlock) {
            console.error('No data content block not found');
            return '';
        }

        const noDataElement = noDataContentBlock.querySelector('.no-data');
        if (!noDataElement) {
            console.error('No ".no-data" element inside #nodata-content-block');
            return '';
        }

        // Remove existing action button
        const existingAction = noDataElement.querySelector('a');
        if (existingAction) {
            existingAction.remove();
        }

        let notFoundAction = '';

        if (dataExists > 0 && (!filterResetHidden || $('#custom-search-box').val() !== '')) {
            notFoundAction = `
            <a href="#" class="btn ol-btn-light border d-flex align-items-center" onclick="clearFilter()">
                <span class="fi-rr-cross-small d-block d-flex cg-10px lh-1-5-before"></span>
                {{ get_phrase('Clear Filter') }}
            </a>`;
        } else {
            const originalElement = document.querySelector('.enable-no-data-action');
            if (originalElement) {
                const attrs = Array.from(originalElement.attributes)
                    .filter(attr => attr.name.startsWith('on') || attr.name === 'href')
                    .map(attr => `${attr.name}="${attr.value}"`)
                    .join(' ');

                notFoundAction = `
                <a class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px" ${attrs}>
                    <span class="fi-rr-plus d-block d-flex cg-10px lh-1-5-before"></span>
                    {{ get_phrase('Add New') }}
                </a>`;
            }
        }

        // Add new action
        if (notFoundAction) {
            noDataElement.insertAdjacentHTML('beforeend', notFoundAction);
        }


        // Return or replace HTML
        if (returnHtml) {
            return noDataContentBlock.innerHTML;
        } else {
            setTimeout(function() {
                const serverSideNoDataCell = document.querySelector('.server-side-datatable td .no-data');
                if (serverSideNoDataCell) {
                    serverSideNoDataCell.innerHTML = noDataContentBlock.innerHTML;
                }
            }, 1);
        }
    }


    new DataTable('#basic-datatable', {
        orderCellsTop: true,
        ordering: false
    });

    // server side data table rendering
    var tableInstance;

    function server_side_datatable(columnsParam, url, totalRow = 0) {

        contextMenuInitialize();
        const noData = getTableNoDataFoundContent(totalRow, true);


        let columnsArray = Array.isArray(columnsParam) ? columnsParam : JSON.parse(columnsParam);
        if (!Array.isArray(columnsArray)) {
            console.error("{{ get_phrase('The columns parameter should be an array or a JSON-encoded array') }}.");
            return;
        }
        let columns = columnsArray.map(columnKey => {
            return {
                data: columnKey
            };
        });


        var table = new DataTable('.server-side-datatable', {
            deferLoading: totalRow,
            processing: true,
            serverSide: true,
            info: true,
            layout: {
                bottomStart: 'pageLength',
                topStart: null
            },
            ajax: {
                url: url,
                type: 'GET',
                data: function(d) {
                    $('#filters-container :input').each(function() {
                        var name = $(this).attr('name');
                        var value = $(this).val();
                        if (name) {
                            d[name] = value || null;
                        }
                    });
                },
                beforeSend: function() {},
                complete: function() {

                    contextMenuInitialize();
                    initiatePlugins();
                    initiate_floating_actions(
                        storedFloatingActionsParams.rootElement,
                        storedFloatingActionsParams.deleteRoute,
                        storedFloatingActionsParams.pdfRoute,
                        storedFloatingActionsParams.csvRoute,
                        storedFloatingActionsParams.printRoute,
                    );

                    if (typeof applyFilterToGraphs === 'function') {
                        applyFilterToGraphs();
                    }
                }
            },
            columns: columns,
            orderCellsTop: true,
            ordering: false,
            pageLength: 10,
            paging: true,
            language: {
                emptyTable: noData,
                zeroRecords: noData,
            }
        });

        tableInstance = table;

        table.on('xhr', function(e, settings, json) {
            if (json.filter_count > 0) {
                $('#filter-count-display').text(json.filter_count).removeClass('d-none');
                $('#filter-reset').removeClass('d-none');
            }
        });

        function decodeHtmlEntities(str) {
            var textarea = document.createElement('textarea');
            textarea.innerHTML = str;
            return textarea.value;
        }

        let typingTimer;
        let typingDelay = 500; // Adjust delay time in milliseconds
        $('#custom-search-box').on('keyup', function(e) {
            clearTimeout(typingTimer); // Clear previous timer
            typingTimer = setTimeout(() => {
                let name = $(this).attr('name');
                let value = $(this).val();
                let existingInput = $('#table-filter').find(`input[name="${name}"]`);

                if (existingInput.length) {
                    existingInput.val(value);
                } else {
                    let rowHtml =
                        `<input type="text" id="${name}" name="${name}" value="${value}" readonly class="form-control">`;
                    $('#table-filter').append(rowHtml);
                }
                table.ajax.reload();
            }, typingDelay);
        });


        $('#page-length-select').on('change', function() {
            var newLength = $(this).val();
            table.page.len(newLength).draw();
        });

        // Track the table data updating/loading
        table.on('xhr.dt', function(e, settings, json, xhr) {
            getTableNoDataFoundContent(table.data().count());

            setTimeout(function() {
                if ($("#ajaxOffcanvas select.ol-modal-niceSelect").length > 0) {
                    $("#ajaxOffcanvas select.ol-modal-niceSelect").niceSelect({
                        dropdownParent: $('#ajaxOffcanvas')
                    });
                }
            }, 500);

            if (typeof initiateTimesheetTotalHours === 'function') {
                setTimeout(function() {
                    initiateTimesheetTotalHours();
                }, 200);
            }
        });
    }


    function reloadDataTable() {
        if (tableInstance) {
            $('[data-default-progress-value]').each(function() {
                $(this).val($(this).attr('data-default-progress-value'));
            });

            tableInstance.ajax.reload();
        } else if ($("#grid-list").length > 0) {
            grid_view();
        }
    }


    $(document).ready(function() {
        // Handle filter button click
        $('#filter').on('click', function() {
            reloadDataTable();
        });

        // Handle filter-reset button click
        $('#filter-reset').on('click', function() {
            clearFilter();
        });
    });

    function clearFilter() {
        $('#filters-container input:not([type=hidden], #max-price, #min-price, .dateTimeRangePicker, .dateTimePicker)').val('');
        $('#filters-container .dateRangePickerHiddenField').val('');

        // Reset select elements to 'all'
        $('#status, #client, #staff, #category, #task, #team, #size, #uploaded_by, #type, #user, #payment_method')
            .val('all');


        // Clear specific input fields
        $('#start_date, #end_date, #progress, #min-price').val('');

        // Hide filter-related elements
        $('#filter-count-display').text(0).addClass('d-none');
        $('#filter-reset').addClass('d-none');

        if ($('select.ol-select2:not(.inited)').length > 0) {
            var $select = $("select.ol-select2:not(.inited)").select2();
            $($select).each(function() {
                $(this).data('select2').$dropdown.addClass('select-drop');
            });
        }


        // Update niceSelect after filter
        if ($('select.ol-niceSelect').length > 0) {
            $('select.ol-niceSelect').each(function() {
                $(this).niceSelect('update');
            });
        }

        // Reload the DataTable
        setTimeout(() => {
            reloadDataTable();
        }, 300);
    }
</script>
