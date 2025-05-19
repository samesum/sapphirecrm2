<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{get_phrase('Task List')}}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin: 0;
            color: #333;
        }

        p {
            margin: 5px 0;
            color: #666;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        img {
            object-fit: cover;
            border-radius: 5px;
        }
    </style>

</head>

<body>

    <div class="header">
        <h2>{{get_phrase('Project Task')}}</h2>
        
    </div>

    <table class="table">
        <thead>
            <tr class="context-menu-header">
                <th scope="col">#</th>
                <th scope="col">{{ get_phrase('Title') }}</th>
                <th scope="col">{{ get_phrase('Status') }}</th>
                <th scope="col">{{ get_phrase('Progress') }}</th>
                <th scope="col">{{ get_phrase('Team Member') }}</th>
                <th scope="col">{{ get_phrase('Start Date') }}</th>
                <th scope="col">{{ get_phrase('End Date') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $key => $item)    
            <tr>
                <td> {{$key+1}} </td>
                <td> {{$item->title}} </td>
                <td> {{ucwords(str_replace('_', '', $item->status))}} </td>
                <td> {{$item->progress}}%</td>
                <td> 
                    @foreach (json_decode($item->team) as $user)
                        {{App\Models\User::where('id', $user)->first()?->name}}
                    @endforeach
                </td>
                <td> {{date('d M Y h:i A', $item->start_date)}} </td>
                <td> {{date('d M Y h:i A', $item->end_date)}} </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{get_phrase('Generated on')}}: {{ now()->format('H:i A d M Y') }}
    </div>

</body>

</html>
