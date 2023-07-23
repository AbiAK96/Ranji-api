<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
          integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="hold-transition login-page" style="background-color: white">
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <div class="login-logo">
                <a>
                    <img src="{{ asset('theme/dist/img/successful.png') }}" 
                    class="pb-2" alt="Logo" width="150px">    
                </a>
            </div>
            <h4 style="text-align: center">Verification Successful!</h1>
            <p style="text-align: center">Your email has been successfully verified.</p>
        </div>
    </div>

</div>
</body>
</html>
