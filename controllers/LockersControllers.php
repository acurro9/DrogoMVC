<?php

namespace Controllers;
use MVC\Router;
use Model\Locker;

class LockersController{
    public function crear(){
        // Sanitizar los datos
      $atributos = $this->sanitizarAtributos();


      // Para meterle la id
      $query = "INSERT INTO " . static::$tabla . " (";
      $query .= join(', ', array_keys($atributos));
      $query .= ") VALUES (";
      $query .= join("', '", array_values($atributos));
      $query .= "')";


      // Resultado de la consulta
      $resultado = self::$db->query($query);

      return $resultado;
   }

   public function actualizar(){
        // Sanitización de datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->refLocker) . "'";
        $query .= " LIMIT 1";

        return self::$db->query($query);
   }

   public function eliminar(){
    Locker::eliminar();
   }

   public function verLockers(Router $router){
    $tipo = $_SESSION["tipo"] ?? null;
    $errores = [];
    $res = $_GET['res'] ?? null;

    // Obtener datos para la paginación
    $ppp = $_GET["producto"] ?? 5; // Productos por página
    $pagina = $_GET["pagina"] ?? 1;
    $totalLockers = Locker::contarLockers();

    $limit = $ppp;
    $offset = ($pagina - 1) * $ppp;
    $lockers = Locker::obtenerLockersPorPagina($limit, $offset);
    $totalPaginas = ceil($totalLockers / $ppp);

    // Renderizardo de la vista con los datos necesarios
    $router->render('lockers/locker', [
        'lockers' => $lockers,
        'totalPaginas' => $totalPaginas,
        'paginaActual' => $pagina,
        'ppp' => $ppp,
        'totalLockers' => $totalLockers
    ]);
   }
}