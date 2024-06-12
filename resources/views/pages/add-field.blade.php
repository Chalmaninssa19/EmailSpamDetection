<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('fontawesome-5/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/FOC/home.css') }}">
	<link rel="stylesheet" href="{{ asset('css/FOC/add-field.css') }}">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css">
	<title>HILALAO | CLIENT - TERRAIN</title>
</head>
<body>
@include('FOC/headerNotification');

	<section>
		<div class="container mt-5">
			<div class="row">
				<div class="col-md-6 image-place">
					<img src="{{ asset('imageDesign/add-terrain.png') }}" alt="Image terrain" srcset="">
				</div>
				<div class="col-md-6">
					<h1>Ajouter vos terrains dans la liste</h1>
					<p class="mt-4">
						Vous pouvez bien sûr ajouter votre terrain ainsi que d'autres informations nécessaires 
						afin que les utilisateurs puissent mieux voir les merveilles sur le terrain où ils jouent.
					</p>
				</div>
			</div><br>
			<div class="row justify-content-center fonction-list">
				<h1>Formulaire d'ajout de terrain</h1>
				<div class="col-md-12 contenu-terrain">
					<form action="{{ route('addField') }}" method="POST">
						@csrf
						<div class="row">
							<div class="col-md-6">
								<div class="row info-terrain">
									<div class="col-md-3">
										<label for="nom" class="control-label mt-2"><b>Nom</b></label>
									</div>
									<div class="col-md-7">
										<input class="form-content__input form-content__input--log form-control" type="text" aria-label=".form-control-lg" id="nom" name="nameField" placeholder="nom du terrain">
									</div>
								</div>
								<div class="row info-terrain">
									<div class="col-md-3">
										<label for="categories" class="control-label mt-2"><b>Catégories</b></label>
									</div>
									<div class="col-md-7">
										<select id="categories" class="form-control" name="category">
										@foreach ($category as $item)
											<option value="{{ $item->getIdcategory() }}">{{ $item->getCategory() }}</option>
										@endforeach
										</select>
									</div>
								</div>
								<div class="row info-terrain">
									<div class="col-md-3">
										<label for="surface" class="control-label mt-2"><b>Surface</b></label>
									</div>
									<div class="col-md-7">
										<select id="surface" class="form-control" name="surface">
										@foreach ($fieldType as $item)
											<option value="{{ $item->getIdFieldType() }}">{{ $item->getFieldType() }}</option>
										@endforeach
										</select>
									</div>
								</div>
								<div class="row info-terrain">
									<div class="col-md-3">
										<label for="infrastructure" class="cotrol-label mt-2"><b>Infrastructure</b></label>
									</div>
									<div class="col-md-9">
										<div class="radio">
										@foreach ($infrastructure as $item)
											<label class="label-for-radio">
												<input type="radio" name="infrastructure" id="" value="{{ $item->getIdInfrastructure() }}">
												{{ $item->getInfrastructure() }}
											</label>
										@endforeach
										</div>
									</div>
								</div>
								<div class="row info-terrain">
									<div class="col-md-3">
										<label for="eclairage" class="control-label mt-2"><b>Eclairage</b></label>
									</div>
									<div class="col-md-9">
										<div class="radio">
										@foreach ($light as $item)
											<label class="label-for-radio">
												<input type="radio" name="light" id="" value="{{ $item->getIdLight() }}">
												{{ $item->getLight() }}
											</label>
										@endforeach
										</div>
									</div>
								</div>
								<input type="hidden" id="latitude" name="latitude">
								<input type="hidden" id="longitude" name="longitude">
								<input type="hidden" id="adresseResult" name="adresseResult">
								<input class="btn btn-success" type="submit" value="Ajouter">
							</form>
						</div>
						<div class="col-md-6">
							@csrf
							<form action="{{ route('addField') }}" id="formMap" method="POST">
								<div class="row sig-map">
									<div class="col-md-3">
										<label for="adresse" class="control-label mt-2"><b>Adresse</b></label>
									</div>
									<div class="col-md-5">
										<input class="form-content__input form-content__input--log form-control" type="text" placeholder="adresse terrain" aria-label=".form-control-lg" id="adresse" name="adresse">
									</div>
									<div class="col-md-4">
										<input class="btn btn-warning valide-coord-map" type="submit" value="Rechercher">
									</div>
								</div>
								<div class="row sig-map">
									<div id="map"></div>
								</div>
								<div class="row sig-info">
									<div id="info"></div>
								</div>
							</form>
						</div>
						@isset($error)
							<div class="error">
								<p style="color: red">{{ $error }}</p>
							</div>
						@endisset
					</div>
				</div>

			</div>
		</div>
	</section>

    @include('FOC/scriptMap');

<script src="{{ asset('css/FOU/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>