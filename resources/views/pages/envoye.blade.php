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

                <h4 class="card-title">Email envoye</h4>
                <div class="card-body">
                    <div class="template-demo">
                        <a href="{{ route('newMessage') }}">
                            <button type="button" class="btn btn-gradient-primary btn-fw">Nouveau email</button>
                        </a>
                    </div>
                </div>


                <table class="table">
                    @csrf
                    <thead>
                        <tr>
                            <td>Photo</td>
                            <td>Destinataire</td>
                            <td>Objet</td>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($emailEnvoye as $item)
                        <tr>
                            <td><img src="{{ asset('image/pdp.jpg') }}" alt="photo" /></a></td>
                            <td>{{ $item->getProfileDestinataire()->getNom().' '.$item->getProfileDestinataire()->getPrenom() }}</td>
                            <td>{{ $item->getSujet() }}</td>
                            <td><a href="{{ route('detailsEnvoi') }}?idEmailEnvoye={{ $item->getIdEmailEnvoye() }}">Voir details</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                          
                </table>
            </div>
        </div>
    </div>
</div>

@include('pages/footer');