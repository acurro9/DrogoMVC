<?php

namespace Model;
use Exception;

/**
 * Clase Newsletter para gestionar suscripciones al boletín de noticias.
 *
 * Esta clase maneja las operaciones CRUD para las suscripciones al newsletter,
 * incluyendo la creación de suscripciones, validación de datos de entrada,
 * y consultas especializadas como conteo y paginación.
 */

class Newsletter extends ActiveRecord {

    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected static $tabla = 'newsletter';

    
    /**
     * @var array Columnas de la base de datos utilizadas por la clase.
     */
    protected static $columnasDB = ['email'];

    /**
     * @var string Email del suscriptor.
     */
    public $email;

    /**
     * @var string ID de la suscripción, generado automáticamente.
     */
    public $id;

      /**
     * Constructor de la clase Newsletter.
     *
     * @param array $args Argumentos para inicializar una suscripción al newsletter.
     */

    public function __construct($args = []) {
        $this->id = $args['id'] ?? md5(uniqid(rand(), true));
        $this->email= $args['email'] ?? null;
    }

     /**
     * Crea una nueva suscripción al newsletter en la base de datos.
     *
     * @return bool Retorna true si la suscripción es creada con éxito, false en caso contrario.
     */
    public function crear(){
        try{
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            // Para meterle la id
            $query = "INSERT INTO " . static::$tabla . " (";
            $query .= join(', ', array_keys($atributos));
            $query .= ") VALUES ('";
            $query .= join("', '", array_values($atributos));
            $query .= "')";

            // Resultado de la consulta
            $resultado = self::$db->query($query);

            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

    /**
     * Valida el correo electrónico proporcionado para la suscripción.
     *
     * @return array Retorna un array de errores si los hay.
     */
    public function validar(){
        if(!$this->email) {
            self::$errores[] = "Debes indicar un correo electrónico";
        }
        return self::$errores;
    }
     
    /**
     * Cuenta el total de suscripciones al newsletter registradas en la base de datos.
     *
     * @return int Retorna el número total de suscripciones al newsletter.
     */
     public static function contarNewsletter() {
        try{
            $query = "SELECT COUNT(*) as total FROM newsletter";
            $resultado = self::$db->query($query);
            $fila = $resultado->fetch();
            return $fila['total'];
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
        
    }

     /**
     * Obtiene un conjunto de suscripciones al newsletter por página.
     *
     * @param int $limit Número de suscripciones por página.
     * @param int $offset Número de suscripciones a saltar.
     * @return array Retorna un array de objetos Newsletter.
     */
    public static function obtenerNewsletterPorPagina($limit, $offset) {
        try{
            $query = "SELECT * FROM newsletter LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        } 
    }

    /**
     * Encuentra una suscripción al newsletter por su email.
     *
     * @param string $id Email del suscriptor a buscar.
     * @return Newsletter|null Retorna un objeto Newsletter si se encuentra, null en caso contrario.
     */

    public static function find($id) {
        if (!$id) {
            return null; 
        }
    
        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE email = '{$id}'"; 
            $resultado = self::consultarSQL($query);
    
            if ($resultado === false) {
                return null;
            }
    
            return array_shift($resultado);
        } catch (Exception $e) {
            error_log('Excepción capturada en find: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Elimina una suscripción al newsletter de la base de datos por su email.
     *
     * @return bool Retorna true si la suscripción es eliminada con éxito, false en caso contrario.
     */

    public function eliminar(){
        $idValue = $this->id;
        $query = "DELETE FROM " . static::$tabla . " WHERE email = '$this->email';";
        $resultado = self::$db->query($query);

        return $resultado;
    }
}