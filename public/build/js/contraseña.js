/*  Cambiar el type del input de password a text y viceversa
    @param id
 */

function mostrarContraseña(id){
    var tipo = document.getElementById(id);
    if(tipo.type == "password"){
        tipo.type = "text";
    }else{
        tipo.type = "password";
    }
}
/*Cambia el icono del botón para mostrar la contraseña
    @param id1
    @param id2
*/
function cambiarIcono(id1, id2){
    var tipo = document.getElementById(id1);
    var boton = document.getElementById(id2);
    if(tipo.type == "password"){
        boton.innerHTML='<img src="./assets/icons/bloq.svg" alt="">';
    }else{
        boton.innerHTML='<img src="./assets/icons/disbloq.svg" alt="">'
    }
}
//Llama a las dos funciones anteriores
function clickBoton(id1, id2){
    mostrarContraseña(id1);
    cambiarIcono(id1, id2);
}