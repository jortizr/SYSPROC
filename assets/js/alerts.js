// alerts.js

document.addEventListener('DOMContentLoaded', function() {
    // Selecciona todas las alertas con la clase 'alert-dismissible'
    var alerts = document.querySelectorAll('.alert-dismissible');

    // Cierra automáticamente las alertas después de 5 segundos
    alerts.forEach(function(alert) {
        setTimeout(function() {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000); // 5 segundos
    });
});
