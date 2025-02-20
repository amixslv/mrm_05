<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    @foreach ($events as $department => $departmentEvents)
        <h2>{{ $department }}</h2>
        @foreach ($departmentEvents as $event)
            <table class="min-w-full border-collapse border border-black">
                <thead>
                    <tr>
                        <th class="border border-black px-4 py-2 text-left">Name</th>
                        <th class="border border-black px-4 py-2 text-left">Start Date & Time</th>
                        <th class="border border-black px-4 py-2 text-left">End Date & Time</th>
                        <th class="border border-black px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->start_date_time }}</td>
                        <td>{{ $event->end_date_time }}</td>
                        <td>{{ $event->status }}</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="border border-black px-4 py-2">Resource Name</th>
                                        <th class="border border-black px-4 py-2">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event->resources as $resource)
                                        <tr>
                                            <td class="border border-black px-4 py-2">{{ $resource->name }}</td>
                                            <td class="border border-black px-4 py-2">{{ $resource->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @endforeach
</body>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</html>
