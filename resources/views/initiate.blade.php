<script type="text/javascript">
    "use strict";

    function initiatePlugins() {

        // Initialize Bootstrap tooltips
        bootstrapTooltipInitiated();

        // Initiated drop uploader
        initiateFileDropUploader();


        // Single Date Picker
        if ($('.datePicker:not(.inited)').length) {
            $('.datePicker:not(.inited)').each(function() {
                let $this = $(this);
                let existingDate = $this.val(); // Get the value from the input field

                $this.daterangepicker({
                    "singleDatePicker": true,
                    "startDate": existingDate ? moment(existingDate, 'YYYY-MM-DD') : moment().format('YYYY-MM-DD HH:mm:ss'),
                    "locale": {
                        format: 'YYYY-MM-DD' // Ensure format matches input value
                    }
                });

                $this.addClass('inited');
            });
        }


        // Date Range Picker
        if ($('.dateRangePicker:not(.inited)').length) {
            $('.dateRangePicker:not(.inited)').each(function() {
                let $this = $(this);
                let value = $this.val(); // Get the input value

                let startDate = moment();
                let endDate = moment();

                if (value && value.includes(' - ')) {
                    let dates = value.split(' - ');
                    let parsedStart = moment(dates[0], "YYYY-MM-DD HH:mm:ss");
                    let parsedEnd = moment(dates[1], "YYYY-MM-DD HH:mm:ss");

                    if (parsedStart.isValid()) startDate = parsedStart;
                    if (parsedEnd.isValid()) endDate = parsedEnd;
                }

                $this.daterangepicker({
                    timePicker: false,
                    startDate: startDate,
                    endDate: endDate,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $this.addClass('inited');
            });
        }


        // SINGLE DATE & TIME PICKER
        if ($('.dateTimePicker:not(.inited)').length) {
            $('.dateTimePicker:not(.inited)').each(function() {
                let $this = $(this);
                let existingDate = $this.val();
                let startDate = existingDate ? moment(existingDate, 'YYYY-MM-DD HH:mm:ss') : moment();

                let $hiddenInput = datePickerHiddenField($this);

                // Set initial values


                $this.daterangepicker({
                        timePicker: true,
                        singleDatePicker: true,
                        startDate: startDate,
                        locale: {
                            format: 'YYYY-MM-DD HH:mm:ss'
                        }
                    })
                    .on('apply.daterangepicker hide.daterangepicker', function(ev, picker) {
                        $this.val(picker.startDate.format('YYYY-MM-DD'));
                        $hiddenInput.val(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
                    });

                $this.val(startDate.format('YYYY-MM-DD'));
                $hiddenInput.val(startDate.format('YYYY-MM-DD HH:mm:ss'));

                $this.addClass('inited');
            });
        }

        // DATE & TIME RANGE PICKER
        if ($('.dateTimeRangePicker:not(.inited)').length) {
            $('.dateTimeRangePicker:not(.inited)').each(function() {
                let $this = $(this);
                let value = $this.val();
                let startDate = moment();
                let endDate = moment();

                if (value && value.includes('-')) {
                    let dates = value.split(' - ');
                    startDate = moment(dates[0].trim(), 'YYYY-MM-DD HH:mm:ss');
                    endDate = moment(dates[1].trim(), 'YYYY-MM-DD HH:mm:ss');
                }

                let $hiddenInput = datePickerHiddenField($this);



                $this.daterangepicker({
                        timePicker: true,
                        startDate: startDate.isValid() ? startDate : moment(),
                        endDate: endDate.isValid() ? endDate : moment(),
                        locale: {
                            format: 'YYYY-MM-DD HH:mm:ss'
                        }
                    })
                    .on('apply.daterangepicker hide.daterangepicker', function(ev, picker) {
                        $this.val(`${picker.startDate.format('YYYY-MM-DD')} - ${picker.endDate.format('YYYY-MM-DD')}`);
                        $hiddenInput.val(`${picker.startDate.format('YYYY-MM-DD HH:mm:ss')} - ${picker.endDate.format('YYYY-MM-DD HH:mm:ss')}`);
                    });

                // Set initial values
                $this.val(`${startDate.format('YYYY-MM-DD')} - ${endDate.format('YYYY-MM-DD')}`);
                $hiddenInput.val(`${startDate.format('YYYY-MM-DD HH:mm:ss')} - ${endDate.format('YYYY-MM-DD HH:mm:ss')}`);

                $this.addClass('inited');
            });
        }

        // SHARED: Create and insert hidden input
        function datePickerHiddenField($existingInput) {
            let $hiddenInput = $('<input type="hidden" class="dateRangePickerHiddenField">');

            if ($existingInput.attr('name')) {
                $hiddenInput.attr('name', $existingInput.attr('name'));
                $existingInput.removeAttr('name');
            }

            $hiddenInput.val($existingInput.val());
            $existingInput.after($hiddenInput);
            $existingInput.attr('autocomplete', 'off');

            return $hiddenInput;
        }




        if ($('select.ol-niceSelect:not(.inited)').length > 0) {
            $('select.ol-niceSelect:not(.inited)').each(function() {
                $(this).niceSelect({
                    closeOnSelect: false, // Keeps the dropdown open
                    allowClear: true, // Allows clearing selection (optional)
                    placeholder: "Select an option", // Placeholder text
                    width: 'resolve' // Adjust width to container
                });
                $(this).addClass('inited');
            });
        }

        if ($('select.ol-select2:not(.inited)').length > 0) {
            $('select.ol-select2:not(.inited)').each(function() {
                $(this).select2();
                $(this).data('select2').$dropdown.addClass('select-drop');
                $(this).addClass('inited');
            });
        }


        if ($('.accordion-range-value').length > 0) {
            $('.accordion-range-value').each(function() {
                $(this).find('input').each(function() {
                    if ($(this).val() != '') {
                        $(this).attr('data-default-progress-value', $(this).val());
                    }
                })
            });
        }


        // Check overflow and enable tooltip only if needed
        document.querySelectorAll('.ellipsis-line-1, .ellipsis-line-2, .ellipsis-line-3, .ellipsis-line-4').forEach(function(el) {
            const clampedHeight = el.offsetHeight;
            const elStyle = window.getComputedStyle(el);

            // Clone with same styles
            const clone = el.cloneNode(true);
            clone.style.visibility = 'hidden';
            clone.style.position = 'absolute';
            clone.style.top = '0';
            clone.style.left = '0';
            clone.style.height = 'auto';
            clone.style.display = 'block';
            clone.style.webkitLineClamp = 'unset';
            clone.style.webkitBoxOrient = 'unset';
            clone.style.overflow = 'visible';
            clone.style.whiteSpace = 'normal';
            clone.style.width = el.offsetWidth + 'px';
            clone.style.font = elStyle.font;

            document.body.appendChild(clone);
            const fullHeight = clone.offsetHeight;
            document.body.removeChild(clone);

            if (fullHeight > clampedHeight + 1) { // +1 to handle subpixel rounding
                new bootstrap.Tooltip(el);
            } else {
                el.removeAttribute('data-bs-original-title');
                el.removeAttribute('data-bs-toggle');
                el.removeAttribute('title');
            }
        });





    }


    $(function() {
        initiatePlugins();
    });
</script>
