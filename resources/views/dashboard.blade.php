<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <div>
        <h4>Your balance</h4>
        <input type="hidden" id="getBalance" value="{{ $balance }}" />
        <span id="balance">{{ $balance }}</span>
    </div>

    <div>
        <button type="button" onclick="location.href='logout'">Logout</button>
    </div>

    <script src="https://code.jquery.com/jquery-4.0.0.js"></script>
    <script>
    $(() => {
        const initial = parseFloat($('#getBalance').val()) || 0;
        const ratePerMs = (parseFloat({{ $user_earning_rate }}) || 0) / 60000;
        const start = Date.now();
        
        $('#balance').text(initial.toFixed(8));

        const animate = () => {
            const balance = (initial + (Date.now() - start) * ratePerMs).toFixed(8);
            $('#balance').text() !== balance && $('#balance').text(balance);
            requestAnimationFrame(animate);
        };

        requestAnimationFrame(animate);
    });
    </script>
</body>
</html>
