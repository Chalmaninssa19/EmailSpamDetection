@include('pages/header');

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Nouveau email</h4>
                    <form class="forms-sample" action="{{ route('sendMessage') }}" method="POST">
                    @csrf    
                        <div class="form-group">
                            <label for="exampleSelectGender">Destinataire</label>
                            <select class="form-control" id="exampleSelectGender" name="profile">
                            @foreach ($profile as $item)
                                <option value="{{ $item->getIdProfile() }}">{{ $item->getMail() }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Sujet</label>
                            <input type="text" class="form-control" id="exampleInputUsername1" name="sujet" onkeyup="handleKeyPress1(event)">
                            <div id="suggestions1"></div>
                        </div>
                       
                        <div class="form-group">
                            <label for="exampleTextarea1">Entrez votre texte : </label>
                            <textarea class="form-control" id="word" rows="4" name="text" onkeyup="handleKeyPress(event)"></textarea>
                            <div id="suggestions"></div>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Envoyer</button>
                        <button class="btn btn-light">Retour</button>
                    </form>
                    @if(isset($error))
                        <div class="alert alert-success" role="alert">
                            {{ $error; }}
                        </div>
                    @endif
               </div>
          </div>
     </div>
</div>
    <script>
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

@include('pages/footer');