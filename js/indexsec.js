document.addEventListener('DOMContentLoaded', function() {
    // Récupération des secteurs d'activité dès le chargement de la page
    fetch('secteuractiviter.php')
        .then(response => response.json())
        .then(data => {
            const secteuractiviteSelect = document.getElementById('secteuractivite');
            data.forEach(secteur => {
                const option = document.createElement('option');
                option.value = secteur;
                option.textContent = secteur;
                secteuractiviteSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erreur:', error);
        });

    // Gestion de l'envoi du formulaire
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const secteuractivite = document.getElementById('secteuractivite').value;

        fetch(`rechercher.php?secteuractivite=${secteuractivite}`)
            .then(response => response.json())
            .then(data => {
                const resultsDiv = document.getElementById('results');
                resultsDiv.innerHTML = '';

                if (data.length === 0) {
                    resultsDiv.innerHTML = '<p>Aucun résultat trouvé.</p>';
                } else {
                    data.forEach(entreprise => {
                        const entrepriseDiv = document.createElement('div');
                        entrepriseDiv.classList.add('entreprise', 'border', 'p-3', 'mb-3');
                        entrepriseDiv.innerHTML = `
                        <h2>${entreprise.Nom}</h2>
                        <p>Email: ${entreprise.Email}</p>
                        <button onclick="window.location.href='cnt.html?email=${encodeURIComponent(entreprise.Email)}'">Envoyer Email</button>`;
                        resultsDiv.appendChild(entrepriseDiv);
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    });
});