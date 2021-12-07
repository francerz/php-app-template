<?php

namespace App\Models;

use Francerz\SqlBuilder\DatabaseManager;
use Francerz\SqlBuilder\Query;

class Usuario extends AbstractModel
{
    /**
     * @var int
     */
    public $id_usuario;

    /**
     * @var string
     */
    public $usuario;

    public static function getQuery(array $params = [])
    {
        $query = Query::selectFrom(['u' => 'usuarios']);

        if (array_key_exists('id_usuario', $params)) {
            $query->where('u.id_usuario', $params['id_usuario']);
        }

        return $query;
    }

    /**
     * @param array $params
     * @return Usuario[]
     */
    public static function getRows(array $params = [])
    {
        $db = DatabaseManager::connect();
        $query = static::getQuery($params);
        $rows = $db->executeSelect($query);
        return $rows->toArray(static::class);
    }

    public static function getFirst(array $params = [])
    {
        $rows = static::getRows($params);
        return reset($rows);
    }

    public static function getLast(array $params = [])
    {
        $rows = static::getRows($params);
        return end($rows);
    }

    public static function insert(Usuario $usuario)
    {
        $db = DatabaseManager::connect('myapp');
        $query = Query::insertInto('usuarios', $usuario);
        $result = $db->executeInsert($query);
        $usuario->id_usuario = $result->getFirstId();
        return $result;
    }

    public static function update(Usuario $usuario)
    {
        $db = DatabaseManager::connect('myapp');
    }
}
