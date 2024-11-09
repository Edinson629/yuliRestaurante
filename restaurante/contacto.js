// Script para guardar el número de contacto
document.getElementById('phone-icon').addEventListener('click', function() {
    var phoneNumber = document.getElementById('phone-number').innerText;

    // Elimina todos los caracteres que no sean dígitos del número de teléfono
    phoneNumber = phoneNumber.replace(/\D/g, '');

    // Redirigir a contactos para guardar o llamar 
    window.location.href = 'tel:' + phoneNumber; 
});
