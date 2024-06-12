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
                <h4 class="card-title">Mon profil</h4>
                
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                        <img src="{{ asset('image/pdp.jpg') }}" alt="photo" width="200px" height="200px"/>
                    </h4>
                    <p>Nom complet : {{ $profileConnected->getNom().' '.$profileConnected->getPrenom() }}</p>
                    <p>Email : {{ $profileConnected->getMail() }}</p>
                  </div>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('pages/footer');