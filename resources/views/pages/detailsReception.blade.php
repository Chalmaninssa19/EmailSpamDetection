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
                <h4 class="card-title">{{ $emailRecu->getSujet() }}</h4>
                
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                        <img src="{{ asset('image/pdp.jpg') }}" alt="photo" width="50px" height="50px"/>{{ $emailRecu->getProfileSource()->getNom().' '.$emailRecu->getProfileSource()->getPrenom() }}
                    </h4>
                    <p>{{ $emailRecu->getText() }}</p>
                  </div>
                </div>
                </div>

                <div class="card-body">
                    <div class="template-demo">
                      <button type="button" class="btn btn-gradient-secondary btn-rounded btn-fw" onclick="afficherFormulaire()">Repondre</button>
                    </div>
                </div>

                <div class="card-body" id="formulaire" style="display:none;">
                    <form class="forms-sample" action="{{ route('repondreEmail') }}" method="POST">
                    @csrf    
                        <input type="hidden" name="idEmailRecu" value="{{ $emailRecu->getIdEmailRecu() }}"/>
                      <div class="form-group">
                        <label for="exampleTextarea1">Reponse</label>
                        <textarea class="form-control" id="word" rows="4" name="reponse" onkeyup="handleKeyPress(event)"></textarea>
                        <div id="suggestions"></div>
                      </div>
                      <button type="submit" class="btn btn-gradient-primary me-2">Envoyer</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
  function afficherFormulaire() {
    var formulaire = document.getElementById('formulaire');

    // Vérifie si le formulaire est déjà affiché ou caché
    if (formulaire.style.display === 'none') {
      formulaire.style.display = 'block'; // Affiche le formulaire
    } else {
      formulaire.style.display = 'none'; // Cache le formulaire
    }
  }
  let timeout;

  function handleKeyPress(event) {
      clearTimeout(timeout);

      const inputText = event.target.value;
      const words = inputText.split(/\s+/).filter(Boolean);
      const lastWord = words[words.length - 1];

      if (lastWord.trim() === '') {
          document.getElementById('suggestions').innerHTML = '';
          document.getElementById('suggestions').style.display = 'none'; // Masquer la div des suggestions
          return;
      }

      timeout = setTimeout(() => {
          getSuggestions(lastWord);
      }, 500);
  }

  function getSuggestions(inputWord) {
      fetch('{{ route("suggestions") }}?word=' + inputWord)
          .then(response => response.json())
          .then(data => {
              const suggestionsDiv = document.getElementById('suggestions');
              suggestionsDiv.innerHTML = '';
              suggestionsDiv.style.display = 'block'; // Afficher la div des suggestions

              data.forEach(word => {
                  const suggestion = document.createElement('div');
                  suggestion.textContent = word;
                  suggestion.addEventListener('click', function() {
                      updateInputValue(word);
                  });
                  suggestionsDiv.appendChild(suggestion);
              });
          });
  }

  function updateInputValue(word) {
      const inputElement = document.getElementById('word');
      const inputText = inputElement.value.trim();
      const words = inputText.split(/\s+/);
      words[words.length - 1] = word;
      inputElement.value = words.join(' ');
      document.getElementById('suggestions').innerHTML = '';
      document.getElementById('suggestions').style.display = 'none'; // Masquer la div des suggestions après le clic
  }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Placez ici le code JavaScript pour l'événement de clic du bouton
  });
</script>

@include('pages/footer');