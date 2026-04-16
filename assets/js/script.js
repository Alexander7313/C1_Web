// Scripts generales para el sistema de control de visitantes

document.addEventListener('DOMContentLoaded', function() {
    console.log('VisitorControl cargado correctamente.');

    // Auto-cierre de alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Validación de DNI (solo números por ejemplo)
    const dniInput = document.getElementById('dni_input');
    if (dniInput) {
        dniInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
});
