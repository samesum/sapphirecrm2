<script type="text/javascript">
    "use strict";

    const dropdownItems = document.querySelectorAll('.dropdown-menu, .select2-search, .select2-search__field');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    $(function() {
        $('a[href="#"]').on('click', function(event) {
            event.preventDefault();
        });
    });

    function redirectTo(url) {
        $(location).attr('href', url);
    }

    function actionTo(url, type = "get") {
        //Start prepare get url to post value
        var jsonFormate = '{}';
        if (type == 'post') {
            let pieces = url.split(/[\s?]+/);
            let lastString = pieces[pieces.length - 1];
            jsonFormate = '{"' + lastString.replace('=', '":"').replace("&", '","').replace("=", '":"').replace("&",
                '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&", '","').replace("=",
                '":"').replace("&", '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&",
                '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&", '","').replace("=",
                '":"').replace("&", '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&",
                '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&", '","') + '"}';
        }
        jsonFormate = JSON.parse(jsonFormate);
        //End prepare get url to post value
        $.ajax({
            type: type,
            url: url,
            data: jsonFormate,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                distributeServerResponse(response);
            }
        });
    }

    //Server response distribute
    function distributeServerResponse(response) {
        try {
            JSON.parse(response);
            var isValidJson = true;
        } catch (error) {
            var isValidJson = false;
        }
        if (isValidJson) {
            response = JSON.parse(response);
            //For reload after submission
            if (typeof response.reload != "undefined" && response.reload != 0) {
                location.reload();
            }

            //For redirect to another url
            if (typeof response.redirectTo != "undefined" && response.redirectTo != 0) {
                $(location).attr('href', response.redirectTo);
            }

            //for show a element
            if (typeof response.show != "undefined" && response.show != 0 && $(response.show).length) {
                $(response.show).css('display', 'inline-block');
            }
            //for hide a element
            if (typeof response.hide != "undefined" && response.hide != 0 && $(response.hide).length) {
                $(response.hide).hide();
            }
            //for fade in a element
            if (typeof response.fadeIn != "undefined" && response.fadeIn != 0 && $(response.fadeIn).length) {
                $(response.fadeIn).fadeIn();
            }
            //for fade out a element
            if (typeof response.fadeOut != "undefined" && response.fadeOut != 0 && $(response.fadeOut).length) {
                $(response.fadeOut).fadeOut();
            }

            //For adding a class
            if (typeof response.addClass != "undefined" && response.addClass != 0 && $(response.addClass.elem).length) {
                $(response.addClass.elem).addClass(response.addClass.content);
            }
            //For remove a class
            if (typeof response.removeClass != "undefined" && response.removeClass != 0 && $(response.removeClass.elem)
                .length) {
                $(response.removeClass.elem).removeClass(response.removeClass.content);
            }
            //For toggle a class
            if (typeof response.toggleClass != "undefined" && response.toggleClass != 0 && $(response.toggleClass.elem)
                .length) {
                $(response.toggleClass.elem).toggleClass(response.toggleClass.content);
            }

            //For showing error message
            if (typeof response.error != "undefined" && response.error != 0) {
                error(response.error);
            }
            //For showing warning message
            if (typeof response.warning != "undefined" && response.warning != 0) {
                warning(response.warning);
            }
            //For showing success message
            if (typeof response.success != "undefined" && response.success != 0) {
                success(response.success);
            }

            //For replace texts in a specific element
            if (typeof response.text != "undefined" && response.text != 0 && $(response.text.elem).length) {
                $(response.text.elem).text(response.text.content);
            }
            //For replace elements in a specific element
            if (typeof response.html != "undefined" && response.html != 0 && $(response.html.elem).length) {
                $(response.html.elem).html(response.html.content);
            }
            //For replace elements in a specific element
            if (typeof response.load != "undefined" && response.load != 0 && $(response.load.elem).length) {
                $(response.load.elem).html(response.load.content);
            }
            //For appending elements
            if (typeof response.append != "undefined" && response.append != 0 && $(response.append.elem).length) {
                $(response.append.elem).append(response.append.content);
            }
            //Fo prepending elements
            if (typeof response.prepend != "undefined" && response.prepend != 0 && $(response.prepend.elem).length) {
                $(response.prepend.elem).prepend(response.prepend.content);
            }
            //For appending elements after a element
            if (typeof response.after != "undefined" && response.after != 0 && $(response.after.elem).length) {
                $(response.after.elem).after(response.after.content);
            }

            // Update the browser URL and add a new entry to the history
            if (typeof response.pushState != "undefined" && response.pushState != 0) {
                history.pushState({}, response.pushState.title, response.pushState.url);
            }
            //For form validation Error
            if (typeof response.validationError != "undefined" && response.validationError != 0) {
                $('.form-validation-error-label').remove();
                let errorList = '<ul>';
                Object.keys(response.validationError).forEach(key => {
                    if ($("[name=" + key + "]").length > 0) {
                        $("[name=" + key + "]").after(
                            '<small class="text-danger text-12px form-validation-error-label">' + response
                            .validationError[key][0] + '</small>');
                    } else if ($("input[name='" + key + "[]']").length > 0) {
                        $("input[name='" + key + "[]']").after(
                            '<small class="text-danger text-12px form-validation-error-label">' +
                            response.validationError[key][0] + '</small>');
                    }

                    errorList = errorList + '<li>' + response.validationError[key][0] + '</li>';
                });
                errorList = errorList + '</ul>';

                error(errorList);
            }

            if (typeof response.script != "undefined" && response.script != 0) {
                response.script
            }
        }
    }

    function loadView(url, element, check_already_loaded) {
        if ($(element).text() == '' && check_already_loaded || !check_already_loaded) {
            $.ajax({
                url: url,
                success: function(response) {
                    $(element).html(response);
                }
            });
        }
    }

    function printDiv(divId) {
        var printContents = document.getElementById(divId).outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    function copy_text(e) {
        var copyText = document.getElementById("generatedAiText");
        console.log(copyText);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        $(e).html('<i class="far fa-copy"></i> Copied!')
    }


    function handleAjaxFormSubmission(ajaxFormId) {
        const form = document.getElementById(ajaxFormId);
        if (!form) return;

        // Check required fields
        let requiredFields = form.querySelectorAll("[required]");
        let isValid = true;

        for (let i = 0; i < requiredFields.length; i++) {
            let field = requiredFields[i];
            if (!field.value.trim()) {
                error('Please fill out the required field: ' + field.name);
                field.trigger('focus')
                isValid = false;
                break; // Proper usage
            }
        }

        if (!isValid) return;

        let formData = new FormData(form);
        let url = form.getAttribute("action");
        let method = form.getAttribute("method") || "POST";

        fetch(url, {
                method: method,
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }
            })
            .then(response => response.json())
            .then(data => {


                processServerResponse(data);

                if (window.location.pathname.includes("/admin/events")) {
                    location.reload();
                }
                if (window.location.pathname.includes("/client/events")) {
                    location.reload();
                }
                if (window.location.pathname.startsWith("/client/event/delete/")) {
                    location.reload();
                }

                if (typeof grid_view === "function") {
                    grid_view();
                }
                if (typeof reloadDataTable === "function") {
                    reloadDataTable();
                }

                if (!data.validationError) {
                    document.querySelectorAll(".offcanvas, .offcanvas-backdrop").forEach(el => {
                        el.style.display = "none";
                    });
                }
            })
            .catch(error => {
                console.error("AJAX Error:", error);
            });
    }



    function applyFilter(divId) {
        $('body').trigger('click');

        collectAndAppendInputs('filter-section', divId);
        reloadDataTable();
    }

    function collectAndAppendInputs(formId, targetDivId) {
        $('#' + targetDivId).empty(); // Clear existing content

        let inputs = {};

        // Collect all input, select, and textarea values dynamically
        $('#' + formId + ' :input').each(function() {
            let name = $(this).attr('name');
            let value = $(this).val();

            if (name) { // Ensure name exists to avoid undefined issues
                inputs[name] = value;
            }
        });

        // Append collected inputs as readonly fields
        $.each(inputs, function(name, value) {
            let rowHtml =
                `<input type="text" id="${name}" name="${name}" value="${value}" readonly class="form-control">`;
            $('#' + targetDivId).append(rowHtml);
        });
        document.querySelectorAll(".offcanvas, .offcanvas-backdrop").forEach(el => {
            el.style.display = "none";
        });

        if (typeof grid_view === "function") {
            grid_view();
        }
    }

    function exportFile(url, selectedIds = []) {
        let urlObj = new URL(url, window.location.origin);

        let segments = urlObj.pathname.split('/').filter(segment => segment);
        let firstParam = segments.length > 1 ? segments[segments.length - 2] : null;

        // Prepare parameters
        let params = new URLSearchParams();

        // Add filter form inputs
        $('#table-filter :input').each(function() {
            if (this.name) {
                params.append(this.name, $(this).val() || '');
            }
        });

        // Add selectedIds as single parameter with array-like string
        if (selectedIds.length > 0) {
            params.set('selectedIds', `[${selectedIds.join(',')}]`);
        }

        // Construct final URL (check if original already has ? or not)
        const queryString = params.toString();
        const finalUrl = url.includes('?') ? `${url}&${queryString}` : `${url}?${queryString}`;

        if (firstParam && firstParam.toLowerCase() === 'print') {
            let printWindow = window.open(finalUrl, '_blank');
            if (printWindow) {
                printWindow.trigger('focus')
                printWindow.onload = function() {
                    printWindow.print();
                };
            } else {
                alert("Popup blocked! Please allow popups for this site.");
            }
        } else {
            window.location.href = finalUrl;
        }
    }





    var storedFloatingActionsParams;
    function initiate_floating_actions(rootElement, deleteRoute = "", pdfRoute = "", csvRoute = "", printRoute = "") {

        let selectedIds = [];

        function toggleFloatingMenu() {
            const selectedCheckboxes = $(rootElement + ' .checkbox-item:checked');
            const allCheckboxes = $(rootElement + ' .checkbox-item');

            if (selectedCheckboxes.length > 0) {
                $('#floatingMenu').removeClass('d-none');

                // Update selectedIds globally
                selectedIds = $(rootElement + ' .table-checkbox:checked').map(function() {
                    return $(this).closest('tr').find('.datatable-row-id').val();
                }).get();

                $('#floatingMenu .selected-number').text(selectedCheckboxes.length);
                $('#floatingMenu .total-number').text(allCheckboxes.length);
            } else {
                $('#floatingMenu').addClass('d-none');
            }
        }

        // Unselect all when click and call to this function
        $(document).off('click').on('click', '#floatingMenu .unselect-all', function() {
            $(rootElement + ' .checkbox-item, ' + rootElement + ' #select-all')?.prop('checked', false);
            toggleFloatingMenu();
        });
        $(rootElement + ' .checkbox-item, ' + rootElement + ' #select-all')?.prop('checked', false);
        toggleFloatingMenu();
        // Unselect all when click and call to this function eded


        // Delegated checkbox logic
        $(rootElement + ' #select-all')?.off('change').on('change', function() {
            $(rootElement + ' .checkbox-item').prop('checked', this.checked);
            toggleFloatingMenu();
        });

        $(document).on('change', rootElement + ' .checkbox-item', function() {
            const total = $(rootElement + ' .checkbox-item').length;
            const checked = $(rootElement + ' .checkbox-item:checked').length;
            $(rootElement + ' #select-all')?.prop('checked', total == checked);
            toggleFloatingMenu();
        });

        // ✅ Bind each button ONCE
        if (deleteRoute) {
            $('#floatingMenu .delete-option').removeClass('d-none');
            $('#floatingMenu .btn-delete').removeClass('d-none').off('click').on('click.floatingAction', function() {
                confirmMultiDelete(deleteRoute, rootElement, selectedIds);
            });
        } else {
            $('#floatingMenu .delete-option').addClass('d-none');
            $('#floatingMenu .btn-delete').addClass('d-none');
        }

        if (pdfRoute) {
            $('#floatingMenu .btn-pdf').removeClass('d-none').off('click').on('click.floatingAction', function() {
                exportFile(pdfRoute, selectedIds);
            });
        }

        if (csvRoute) {
            $('#floatingMenu .btn-csv').removeClass('d-none').off('click').on('click.floatingAction', function() {
                exportFile(csvRoute, selectedIds);
            });
        }

        if (printRoute) {
            $('#floatingMenu .btn-print').removeClass('d-none').off('click').on('click.floatingAction', function() {
                exportFile(printRoute, selectedIds);
            });
        }

        if (!pdfRoute && !csvRoute && !printRoute) {
            $('#floatingMenu .export-option').addClass('d-none');
        } else {
            $('#floatingMenu .export-option').removeClass('d-none');
        }

        storedFloatingActionsParams = { rootElement, deleteRoute, pdfRoute, csvRoute, printRoute };
    }



    function confirmMultiDelete(url, rootElement, selectedIds = []) {
        // Show confirmation modal
        $("#multiDelete").modal('show');

        // Unbind previous clicks to avoid duplicate requests
        $('.confirm-btn').off('click').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    ids: selectedIds,
                    _token: $('meta[name="csrf-token"]').attr('content') // safer than inline blade
                },
                success: function(response) {
                    // Hide floatingMenu
                    $('#floatingMenu').addClass('d-none');

                    if (response.success) {
                        processServerResponse(response);
                        $("#multiDelete").modal('hide');
                        reloadDataTable();

                        if (typeof grid_view === 'function') {
                            grid_view();
                        }
                    }

                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    }
</script>
