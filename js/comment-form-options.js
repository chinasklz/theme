document.addEventListener('DOMContentLoaded', function() {
    const moreOptionsButton = document.querySelector('.more_options_button');
    const additionalFields = document.querySelector('.additional-fields');

    if (moreOptionsButton && additionalFields) {
        moreOptionsButton.addEventListener('click', function() {
            const isHidden = additionalFields.style.display === 'none';
            additionalFields.style.display = isHidden ? 'block' : 'none';
            this.textContent = isHidden ? '- Ocultar opciones' : '+ Mostrar más opciones';
        });
    }
});
