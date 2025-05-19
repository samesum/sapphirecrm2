<link rel="stylesheet" href="{{ asset('assets/css/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
@php
    if (request()->is(get_current_user_role() . '/client_report') || request()->is(get_current_user_role() . '/projects_report') || request()->is(get_current_user_role() . '/payment_history')) {
        $max_value = App\Models\Payment_history::sum('amount');
    } elseif (request()->is(get_current_user_role() . '/offline-payments')) {
        $max_value = App\Models\offlinePayment::max('total_amount');
    } else {
        $project_max_budget = App\Models\Project::query();

        if (auth()->user()->role_id == 2) {
            $project_max_budget->where('client_id', auth()->user()->id);
        } elseif (auth()->user()->role_id == 3) {
            $staff = [auth()->user()->id];
            $staff = json_encode($staff);
            $staff = str_replace('[', '', $staff);
            $staff = str_replace(']', '', $staff);
            $project_max_budget->where('staffs', 'like', '%' . $staff . '%');
        }
        
        $max_value = $project_max_budget->select(DB::raw('CAST(budget AS UNSIGNED) as numeric_budget'))->orderBy('numeric_budget', 'desc')->value('numeric_budget');
    }
@endphp


<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
<script>
    "use strict";

    var max = {{ isset($max_value) ? $max_value : 0 }};
    var slider = document.getElementById('budget-slider');

    var min = 0;

    noUiSlider.create(slider, {
        start: [min, max], // Initial range values
        connect: true,
        range: {
            'min': min,
            'max': max
        },
        tooltips: [true, true], // Show tooltips for both handles
        format: {
            to: function(value) {
                return '{{ currency() }}' + value.toFixed(0);
            },
            from: function(value) {
                return Number(value.replace('{{ currency() }}', ''));
            }
        }
    });

    slider.noUiSlider.on('update', function(values, handle) {
        document.getElementById('min-price').value = values[0];
        document.getElementById('max-price').value = values[1];
        document.getElementById('max-price').innerHTML = values[1];
        document.getElementById('min-price').innerHTML = values[0];

    });
</script>
