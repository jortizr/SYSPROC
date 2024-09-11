document.addEventListener('DOMContentLoaded', function() {
    console.log("formLoader.js cargado");
    const uploadForm = document.getElementById('uploadForm');

    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            // Ocultar el botón de "Cargar"
            const submitBtn = document.getElementById('submitBtn');
            const loadingBtn = document.getElementById('loadingBtn');

            if (submitBtn && loadingBtn) {
                submitBtn.style.display = 'none';
                loadingBtn.style.display = 'inline-block';
            }
        });
    }
});
