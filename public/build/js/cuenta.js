//Se oculta o se muestra en el areaPersonal.php
document.addEventListener('DOMContentLoaded', function () {
    const accountDiv = document.querySelector('.userOpt.account');
    const lockIcon = accountDiv.querySelector('.lock_icon');
    const miCuentaSection = document.querySelector('.miCuenta');
    let isImage1 = true;

    accountDiv.addEventListener('click', () => {
        isImage1 = !isImage1; // cambio de togglestate
        lockIcon.src = isImage1 ? "./assets/icons/lock.svg" : "./assets/icons/lock-open.svg";

        miCuentaSection.classList.toggle('hidden');
    });

    const mostrarButton = document.querySelector('.mostrar');
    const tablaDatos = document.querySelector('.tabla_datos');
    
    mostrarButton.addEventListener('click', () => {
        tablaDatos.classList.toggle('hid');
    });

    //Confirmación al eliminar la cuenta
    /**
     * @return window.confirm
     */
    document.getElementById('deleteAccount').addEventListener('click', function(e){
        return window.confirm( '¿Seguro que quiere borrar la cuenta?' );
    });

});
