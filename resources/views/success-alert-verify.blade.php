<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Badge Alert</title>
    <style>
        /* Common styles for badge alert */
        .badge-alert {
            display: block;
            padding: 10px;
            margin: 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        /* Styles for success alert */
        .badge-success {
            background-color: #4CAF50;
            /* Green */
            color: white;
        }

        /* Styles for error alert */
        .badge-error {
            background-color: #F44336;
            /* Red */
            color: white;
        }

        /* Styles for info alert */
        .badge-info {
            background-color: #2196F3;
            /* Blue */
            color: white;
        }
    </style>
</head>

<body>
    @if($status == 'success')
    <span class="badge-alert badge-success">{{ $message }}</span>
    @elseif($status == 'error')
    <span class="badge-alert badge-error">{{ $message }}</span>
    @elseif($status == 'info')
    <span class="badge-alert badge-info">{{ $message }}</span>
    @endif
</body>

<script>
    setTimeout(function() {
        window.location.href = "/";
    }, 1000);
</script>

</html>