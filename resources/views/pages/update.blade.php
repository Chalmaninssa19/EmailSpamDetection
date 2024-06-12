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

                <h4 class="card-title">Mise a jour</h4>
                @if($nbNewDatas < 10)
                <div class="card-body">
                    <p>Mise a jour non disponible</p>
                </div>
                @else 
                <div class="card-body">
                    <div class="template-demo">
                        <a href="{{ route('update') }}">
                            <button type="button" class="btn btn-gradient-primary btn-fw">Mettre a jour</button>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('pages/footer');