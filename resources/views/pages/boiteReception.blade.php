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
                <h4 class="card-title">Boite de reception</h4>
                <table class="table">
                    @csrf
                    <thead>
                        <tr>
                            <td>Photo</td>
                            <td>Source</td>
                            <td>Objet</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    
                    <tbody>
                    @foreach ($boiteReception as $item)
                        <tr>
                            <td><img src="{{ asset('image/pdp.jpg') }}" alt="photo" /></a></td>
                            <td>{{ $item->getProfileSource()->getNom().' '.$item->getProfileSource()->getPrenom() }}</td>
                            <td>{{ $item->getSujet() }}</td>
                            <td>{{ $item->getEtatLettre() }}</td>
                            <td><a href="{{ route('signaleSpam') }}?idEmailRecu={{ $item->getIdEmailRecu() }}">Signaler spam</a></td>
                            <td><a href="{{ route('signaleNoSpam') }}?idEmailRecu={{ $item->getIdEmailRecu() }}">Signaler non spam</a></td>
                            <td><a href="{{ route('detailsReception') }}?idEmailRecu={{ $item->getIdEmailRecu() }}">Voir details</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                          
                </table>
            </div>
        </div>
    </div>
</div>

@include('pages/footer');