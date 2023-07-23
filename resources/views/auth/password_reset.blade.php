<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Change Password</title>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
          integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="hold-transition register-page" style="background-color: white">
<div class="register-box">
    <div class="register-logo">
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <h4 style="text-align: center">Enter New Password</h4>
            <p class="login-box-msg">Enter your new password</p>
            <form method="post" action="{{ route('user.change-password') }}">
              <form method="post" action="">
                @csrf
                Password
                <div class="input-group mb-3">
                    <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password">
                    @error('password')
                    @enderror
                </div>
                Re-Type Password
                <div class="input-group mb-3">
                    <input type="text" name="password_confirmation" class="form-control" placeholder="Re-Enter your password">
                </div>

                <div class="input-group mb-3">
                    <input type="hidden" name="token" value="{{ $request->token }}">
                </div>
                <div class="input-group mb-3">
                    <input type="hidden" name="email" value="{{ $request->email }}">
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->

    <!-- /.form-box -->
</div>

</body>
</html>
