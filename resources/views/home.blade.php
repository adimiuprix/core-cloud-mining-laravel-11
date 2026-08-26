<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
</head>
<body>
    <form action="{{ url('authorize') }}" method="post">
        @csrf
        <input type="text" id="username" minlength="10" maxlength="100" pattern="[a-zA-Z0-9_-]+" name="username" placeholder="Enter Your Address" />
        <button class="but-hover" id="go_enter" onclick="return validateFormLogin()">Start mining</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function validateFormLogin() {
            const len = $("#username").val().length;
            const msg = {
                empty: "Harap di isi...",
                short: "Wallet salah, masukkan dengan alamat address crypto!",
                long: "Alamat kepanjangan!",
                success: "Tunggu ya, lagi di proses...."
            };

            if (!len) return $("#result").text(msg.empty), false;
            if (len < 10) return $("#result").html(msg.short), false;
            if (len > 100) return $("#result").html(msg.long), false;
            
            return $("#result").text(msg.success), true;
        }
    </script>
</body>
</html>
