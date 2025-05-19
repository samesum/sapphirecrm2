<?php

use App\Models\Milestone;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

if (!function_exists('get_phrase')) {
    function get_phrase($phrase = '', $value_replace = array())
    {
        $active_lan    = session('language') ?? get_settings('language');
        $active_lan_id = DB::table('languages')->where('name', 'like', $active_lan)->value('id');
        $lan_phrase    = DB::table('language_phrases')->where('language_id', $active_lan_id)->where('phrase', $phrase)->first();

        if ($lan_phrase) {
            $translated = $lan_phrase->translated;
        } else {
            $translated  = $phrase;
            $english_lan = DB::table('languages')->where('name', 'like', 'english')->first();
            if (DB::table('language_phrases')->where('language_id', $english_lan->id)->where('phrase', $phrase)->count() == 0) {
                DB::table('language_phrases')->insert(['language_id' => $english_lan->id, 'phrase' => $phrase, 'translated' => $translated]);
            }
        }

        if (!is_array($value_replace)) {
            $value_replace = array($value_replace);
        }
        foreach ($value_replace as $replace) {
            $translated = preg_replace('/____/', $replace, $translated, 1); // Replace one placeholder at a time
        }

        return $translated;
    }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (!function_exists('random')) {
    function random($length_of_string, $lowercase = false)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        $randVal = substr(str_shuffle($str_result), 0, $length_of_string);
        if ($lowercase) {
            $randVal = strtolower($randVal);
        }
        return $randVal;
    }
}

if (!function_exists('currency')) {
    function currency($price = "")
    {
        $currency_position = DB::table('settings')->where('type', 'currency_position')->value('description');
        $symbol = DB::table('settings')->where('type', 'system_currency')->value('description');
        $symbol = DB::table('currencies')->where('code', $symbol)->value('symbol');
        $currency_position = 'left';
        if ($currency_position == 'left') {
            return $symbol . '' . $price;
        } else {
            return $price . '' . $symbol;
        }
    }
}

if (!function_exists('get_settings')) {
    function get_settings($type = "", $return_type = false)
    {
        $value = DB::table('settings')->where('type', $type);
        if ($value->count() > 0) {
            if ($return_type === true) {
                return json_decode($value->value('description'), true);
            } elseif ($return_type === "object") {
                return json_decode($value->value('description'));
            } else {
                return $value->value('description');
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('get_user_role')) {
    function get_user_role($id)
    {
        $role_id = User::where('id', $id)->value('role_id');
        $role    = Role::where('id', $role_id)->value('title');
        return $role;
    }
}

if (!function_exists('get_current_user_role')) {
    function get_current_user_role()
    {
        $role = Role::where('id', Auth::user()->role_id)->value('title');
        return $role;
    }
}

if (!function_exists('ellipsis')) {
    function ellipsis($long_string, $max_character = 30)
    {
        $long_string = strip_tags($long_string);
        $short_string = strlen($long_string) > $max_character ? mb_substr($long_string, 0, $max_character) . "..." : $long_string;
        return $short_string;
    }
}

if (!function_exists('has_permission')) {
    function has_permission($routes)
    {
        // Admins have all permissions
        if (get_current_user_role() == 'admin') {
            return true;
        }
        if (!$routes) {
            return false;
        }
        $permission_has = [];
        $routes = is_array($routes) ? $routes : [$routes];
        $role_id = Auth::user()->role_id;
        foreach ($routes as $route) {
            if (str_contains($route, '.edit')) {
                $route = str_replace('.edit', '.update', $route);
            }
            $permission_id = Permission::where('route', $route)->value('id');
            if ($permission_id) {
                $permission = RolePermission::where('role_id', $role_id)
                    ->where('permission_id', $permission_id)
                    ->exists();

                if ($permission) {
                    $permission_has[] = $route;
                }
            }
        }
        // Return true if any matching permission is found
        return !empty($permission_has);
    }
}

if (!function_exists('get_user')) {
    function get_user($id)
    {
        $user = User::where('id', $id)->first();
        return $user;
    }
}

if (!function_exists('get_user_info')) {
    function get_user_info($user_id = "")
    {
        $user_info = User::where('id', $user_id)->firstOrNew();
        return $user_info;
    }
}

if (!function_exists('convertBytes')) {
    function readFileSize($bytes, $decimalPlaces = 2) {
        if ($bytes >= 1024 * 1024 * 1024) {
            return number_format($bytes / (1024 * 1024 * 1024), $decimalPlaces) . " GB";
        } elseif ($bytes >= 1024 * 1024) {
            return number_format($bytes / (1024 * 1024), $decimalPlaces) . " MB";
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, $decimalPlaces) . " KB";
        } else {
            return $bytes . " B";
        }
    }
}


if (!function_exists('project_id_by_code')) {
    function project_id_by_code($code = "")
    {
        $project = Project::where('code', $code)->first();
        return $project?->id;
    }
}

if (!function_exists('get_image')) {
    function get_image($url = null, $optimized = false)
    {

        if ($url == null) {
            return asset('uploads/system/placeholder.png');
        }

        // If the value of URL is from an online URL
        if (str_contains($url, 'http://') && str_contains($url, 'https://')) {
            return $url;
        }

        $url_arr = explode('/', $url);
        // File name & Folder path
        $file_name = end($url_arr);
        $path      = str_replace($file_name, '', $url);

        //Optimized image url
        $optimized_image = $path . 'optimized/' . $file_name;

        if (!$optimized) {
            if (is_file(public_path($url)) && file_exists(public_path($url))) {
                return asset($url);
            } else {
                return asset($path . 'placeholder/placeholder.png');
            }
        } else {
            if (is_file(public_path($optimized_image)) && file_exists(public_path($optimized_image))) {
                return asset($optimized_image);
            } else {
                return asset($path . 'placeholder/placeholder.png');
            }
        }
    }
}

if (!function_exists('removeScripts')) {
    function removeScripts($text)
    {
        if (!$text) return;
        $trimConetnt = Purifier::clean($text);
        return $trimConetnt;

    }
}

if (!function_exists('timeAgo')) {
    function timeAgo($time_ago)
    {
        $time_ago     = strtotime($time_ago);
        $cur_time     = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds      = $time_elapsed;
        $minutes      = round($time_elapsed / 60);
        $hours        = round($time_elapsed / 3600);
        $days         = round($time_elapsed / 86400);
        $weeks        = round($time_elapsed / 604800);
        $months       = round($time_elapsed / 2600640);
        $years        = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60) {
            return "just now";
        }
        //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 minute ago";
            } else {
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 hour ago";
            } else {
                return "$hours hours ago";
            }
        }
        //Days
        else if ($days <= 7) {
            if ($days == 1) {
                return "Yesterday";
            } else {
                return "$days days ago";
            }
        }
        //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "1 week ago";
            } else {
                return "$weeks weeks ago";
            }
        }
        //Months
        else if ($months <= 12) {
            if ($months == 1) {
                return "1 month ago";
            } else {
                return "$months months ago";
            }
        }
        //Years
        else {
            if ($years == 1) {
                return "1 year ago";
            } else {
                return "$years years ago";
            }
        }
    }
}

if (!function_exists('get_task_progress')) {
    function get_task_progress($milestone_id = "")
    {
        $tasks = Milestone::where('id', $milestone_id)->value('tasks');
        if (count($tasks) > 0) {
            $total_progress = Task::whereIn('id', $tasks)->sum('progress');
            $count_tasks    = Task::whereIn('id', $tasks)->count();
            $avg            = $total_progress / $count_tasks;
            return $avg;
        }
        return 0;
    }
}

if (!function_exists('get_invoice_creator_id')) {
    function get_invoice_creator_id($invoice_id = "")
    {
        if ($invoice_id != '') {
            $invoice = DB::table('invoices')->where('id', $invoice_id)->get();
            foreach ($invoice as $value) {
                $creator = App\Models\User::where('id', $value->user_id)->firstOrNew();
            }
            return $creator;
        }
    }
}
    