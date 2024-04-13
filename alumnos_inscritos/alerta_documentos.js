// Espera a que el DOM se cargue completamente
document.addEventListener("DOMContentLoaded", function () {
    // Realiza una solicitud AJAX para verificar si hay documentos con verificación igual a 2
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "verificacion_documentos.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response === "tiene_documento_mal") {
                alert("Tienes un documento mal. Por favor, verifica tus documentos.");
            }
        }
    };
    xhr.send();
});
