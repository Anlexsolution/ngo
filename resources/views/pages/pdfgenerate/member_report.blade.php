<!DOCTYPE html>
<html>

<head>
    <title>Member Report</title>
    <style>
       body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        line-height: 1.4;
    }

    table {
        width: 100%;
        table-layout: fixed; /* Force equal cell widths */
        border-collapse: collapse;
        margin-bottom: 15px;
        word-wrap: break-word;
    }

    table th, table td {
        border: 1px solid #000;
        padding: 3px;
        text-align: left;
        vertical-align: top;
        font-size: 10px;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('assets/img/logo.png') }}" width="100" height="50">
    </div>
    <div class="company-info">
        <div>Sagama Road, Akkaraipattu</div>
        <div>Phone: 0123456789</div>
        <div>Date: {{ now()->format('Y-m-d H:i:s') }}</div>
    </div>
    <hr>
    <h3 class="header">Member Report Details</h3>
    <table>
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td> {{-- Serial number column --}}
                    @for ($i = 1; $i < count($headers); $i++)
                        {{-- Start from 1 to skip "#" --}}
                        <td>{!! strip_tags($row[$i] ?? '-') !!}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>

    </table>

</body>

</html>
