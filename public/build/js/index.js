let icono =document.getElementById('hand');
let navMenu=document.querySelectorAll('nav');
let isImage1=true;
//Muestra u oculta el menú y cambia la imagen, se utiliza en el media query
icono.addEventListener('click', ()=>{
    icono.src=isImage1?"../assets/logoimg/open-box.svg":"../assets/logoimg/paquete.png";
    
    isImage1=!isImage1;
    navMenu.forEach(nav => {
        nav.style.display = isImage1 ? "none" : "block";
    });
    
})
//Muestra u oculta el menú, se utiliza en el media query
window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
        navMenu.forEach(nav => {
            nav.style.display = "block";
        });
    }
});
//Confirmaciones al eliminar, bloquear y desbloquear cuentas
function confirmEliminado() {
    return window.confirm( '¿Seguro que quiere borrarlo?' );
}
function confirmBloq() {
    return window.confirm( '¿Seguro que quiere bloquearlo?' );
}
function confirmDisbloq() {
    return window.confirm( '¿Seguro que quiere desbloquearlo?' );
}







