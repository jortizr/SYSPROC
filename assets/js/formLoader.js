document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const updateForm = document.getElementById('updateForm');

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

    if (updateForm) {
        updateForm.addEventListener('submit', function() {
            // Ocultar el botón de "Cargar"
            const submitBtn = document.getElementById('submitBtnUpdate');
            const loadingBtn = document.getElementById('loadingBtnUpdate');

            if (submitBtn && loadingBtn) {
                submitBtn.style.display = 'none';
                loadingBtn.style.display = 'inline-block';
            }
        });
    }
});
