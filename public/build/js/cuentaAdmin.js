//Muestra u oculta los submenús del areaPersonalAdmin
document.addEventListener("DOMContentLoaded", function () {
  //Parte de Usuarios
  const accountDiv = document.querySelector(".userOpt.account");
  const lockIcon = accountDiv.querySelector(".lock_icon");
  const miCuentaSection = document.querySelector(".miCuenta");
  let isImageU = true;

  accountDiv.addEventListener("click", () => {
    isImageU = !isImageU; // cambio de togglestate
    lockIcon.src = isImageU
      ? "../build/img/icons/lock.svg"
      : "../build/img/icons/lock-open.svg";
    lockIconL.src = "../build/img/icons/lock.svg";
    lockIconP.src = "../build/img/icons/lock.svg";
    miCuentaSection.classList.toggle("hidden");
    miPedidoSection.classList.add("hidden");
    miLockerSection.classList.add("hidden");
  });

  const mostrarButton = document.querySelector(".mostrar");
  const tablaDatos = document.querySelector(".tabla_datos");

  mostrarButton.addEventListener("click", () => {
    tablaDatos.classList.toggle("hid");
  });

  //Parte de Pedidos
  const pedidoDiv = document.querySelector(".userOpt.pedido");
  const lockIconP = pedidoDiv.querySelector(".lock_iconP");
  const miPedidoSection = document.querySelector(".miPedido");
  let isImageP = true;
  pedidoDiv.addEventListener("click", () => {
    isImageP = !isImageP; // cambio de togglestate
    lockIconP.src = isImageP
      ? "../build/img/icons/lock.svg"
      : "../build/img/icons/lock-open.svg";
    lockIcon.src = "../build/img/icons/lock.svg";
    lockIconL.src = "../build/img/icons/lock.svg";
    miPedidoSection.classList.toggle("hidden");
    miCuentaSection.classList.add("hidden");
    miLockerSection.classList.add("hidden");
  });

  //Parte de Lockers
  const lockerDiv = document.querySelector(".userOpt.locker");
  const lockIconL = lockerDiv.querySelector(".lock_iconL");
  const miLockerSection = document.querySelector(".miLocker");

  let isImageL = true;
  lockerDiv.addEventListener("click", () => {
    isImageL = !isImageL; // cambio de togglestate
    lockIconL.src = isImageL
      ? "../build/img/icons/lock.svg"
      : "../build/img/icons/lock-open.svg";
    lockIcon.src = "../build/img/icons/lock.svg";
    lockIconP.src = "../build/img/icons/lock.svg";
    miLockerSection.classList.toggle("hidden");
    miPedidoSection.classList.add("hidden");
    miCuentaSection.classList.add("hidden");
  });
});
