@include('pages/header');

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            @if($error != null)
                <div class="alert alert-success" role="alert">
                    {{ $error; }}
                </div>
            @endif
                <h4 class="card-title">Object : {{ $emailEnvoi->getSujet() }}</h4>
                
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                        A {{ $emailEnvoi->getProfileDestinataire()->getNom().' '.$emailEnvoi->getProfileDestinataire()->getPrenom() }}
                    </h4>
                    <p>{{ $emailEnvoi->getText() }}</p>
                  </div>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('pages/footer');