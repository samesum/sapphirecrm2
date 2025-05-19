<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{get_phrase('Offline payment List')}}</title>

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
        <h2>{{get_phrase('Offline Reports')}}</h2>
    </div>

    <table class="table">
        <thead>
            <tr class="context-menu-header">
                <th scope="col">#</th>
                <th scope="col">{{ get_phrase('User Name') }}</th>
                <th scope="col">{{ get_phrase('Payment Type') }}</th>
                <th scope="col">{{ get_phrase('Amount') }}</th>
                <th scope="col">{{ get_phrase('Purpose') }}</th>
                <th scope="col">{{ get_phrase('Phone') }}</th>
                <th scope="col">{{ get_phrase('Bank No') }}</th>
                <th scope="col">{{ get_phrase('Status') }}</th>
                <th scope="col">{{ get_phrase('Date') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $key => $item)    
            <tr>
                <td> {{$key+1}} </td>
                <td> {{$item->user->name}} </td>
                <td> {{$item->item_type}} </td>
                <td> {{currency($item->total_amount)}} </td>
                <td> {{$item->invoice->title}} </td>
                <td> {{$item->phone_no}} </td>
                <td> {{$item->bank_no}} </td>
                <td> 
                    @php
                        $statuses = [
                            1 => get_phrase('Accepted'),
                            2 => get_phrase('Suspended'),
                            0 => get_phrase('Pending'),
                        ];
                    @endphp
                    {{$statuses[$item->status]}} </td>
                <td> {{date('d M Y h:i A', strtotime($item->created_at))}} </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{get_phrase('Generated on')}}: {{ now()->format('H:i A d M Y') }}
    </div>

</body>

</html>
