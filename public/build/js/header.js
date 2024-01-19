let displayX = document.getElementById("links");
let btn=document.getElementById("btn");
//Mustra u oculta el menú desplegable del usuario
btn.addEventListener('click', ()=>{
    if(displayX.classList.contains("oculto")){
        displayX.classList.remove("oculto");
        displayX.classList.add("visible");
    }else{
        displayX.classList.remove("visible");
        displayX.classList.add("oculto");
    }
})
//Confirmación al borrar la cuenta de usuario
window.addEventListener("load", () => {
    document.querySelector("#borrar").addEventListener("click", e => {
        let confirmacion = confirm("¿Seguro que quieres borrar la cuenta?\nTodos los datos serán borrados.")
        let pagina = document.getElementById("borrar")
        if(confirmacion){
            pagina.setAttribute('href', "borrar-cuenta.php")
        } else{
            pagina.setAttribute('href', "/")
        }
    });
});
