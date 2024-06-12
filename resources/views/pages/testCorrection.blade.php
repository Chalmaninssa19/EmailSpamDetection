<!DOCTYPE html>
<html>
<head>
    <title>Correction orthographique</title>
    <style>
        /* Style pour les suggestions */
        #suggestions {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            width: auto; /* Définir la largeur de la liste déroulante sur 'auto' */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 9999; /* S'assurer que la liste déroulante est au-dessus de tout le contenu */
        }

        #suggestions div {
            padding: 5px 10px;
            margin: 0;
            cursor: pointer;
            transition: background-color 0.2s, border 0.2s;
        }

        #suggestions div:hover {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>Correction orthographique</h1>
    <form>
        <label for="word">Entrez un mot :</label>
        <input type="text" id="word" name="word" onkeyup="handleKeyPress(event)">
    </form>
    <div id="suggestions"></div>

    <script>

        /*function setSuggestionsWidth() {
                    const inputElement = document.getElementById('word');
                    const suggestionsElement = document.getElementById('suggestions');
                    suggestionsElement.style.width = inputElement.offsetWidth + 'px';
                }

        window.addEventListener('resize', setSuggestionsWidth); // Appeler la fonction lors du redimensionnement de la fenêtre
*/

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
</body>
</html>
