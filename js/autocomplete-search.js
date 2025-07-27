document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('Telefono');
    const searchForm = document.getElementById('searchform_telefonico_frontal');
    
    if (searchInput && searchForm && typeof datosDelFormulario !== 'undefined') {
        let suggestionsContainer = document.createElement('div');
        suggestionsContainer.id = 'suggestions-container';
        searchForm.parentNode.insertBefore(suggestionsContainer, searchForm.nextSibling);

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            suggestionsContainer.innerHTML = '';

            if (query.length < 2) { // No mostrar sugerencias si la búsqueda es muy corta
                return;
            }

            const suggestions = Object.keys(datosDelFormulario.mapaPrefijos).filter(function(provincia) {
                return provincia.toLowerCase().includes(query.toLowerCase());
            });

            if (suggestions.length > 0) {
                let suggestionsList = document.createElement('ul');
                suggestions.forEach(function(provincia) {
                    let listItem = document.createElement('li');
                    listItem.textContent = provincia;
                    listItem.addEventListener('click', function() {
                        searchInput.value = datosDelFormulario.mapaPrefijos[provincia];
                        suggestionsContainer.innerHTML = '';
                        searchInput.focus();
                    });
                    suggestionsList.appendChild(listItem);
                });
                suggestionsContainer.appendChild(suggestionsList);
            }
        });

        // Ocultar sugerencias si se hace clic fuera del formulario
        document.addEventListener('click', function(event) {
            if (!searchForm.contains(event.target)) {
                suggestionsContainer.innerHTML = '';
            }
        });
    }
});
