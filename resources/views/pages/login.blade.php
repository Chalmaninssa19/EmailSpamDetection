<!DOCTYPE html>
<html lang="en">

<head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <title>email</title>
     <!-- plugins:css -->
     <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
     <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
     <!-- endinject -->
     <!-- Plugin css for this page -->
     <!-- End plugin css for this page -->
     <!-- inject:css -->
     <!-- endinject -->
     <!-- Layout styles -->
     <link rel="stylesheet" href="{{ asset('css/style.css') }}">
     <!-- End layout styles -->
     <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
</head>

<body>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Connecter-vous</h4>
                        <form class="forms-sample" action="{{ route('login') }}" method="POST">
                        @csrf    
                            <div class="form-group">
                                <label for="exampleInputUsername1">Email</label>
                                <input type="text" class="form-control" id="exampleInputUsername1" name="email" value="chalman@gmail.com">
                            </div>
                        
                            <div class="form-group">
                                <label for="exampleTextarea1">Mot de passe</label>
                                <input type="password" class="form-control" id="exampleInputUsername1" name="mdp" value="chalman">
                            </div>
                            @if(isset($error))
                                <div class="alert alert-success" role="alert">
                                    {{ $error; }}
                                </div>
                            @endif
                            <button type="submit" class="btn btn-gradient-primary me-2">Se connecter</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>