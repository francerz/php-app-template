<?php

namespace App\Models;

use App\Utils\ModelParams;
use Francerz\SqlBuilder\DatabaseManager;
use Francerz\SqlBuilder\Query;

class Usuario extends AbstractModel
{
    /** @var int */
    public $id_usuario;
    /** @var string */
    public $usuario;

    public static function getQuery(array $params = [])
    {
        $params = new ModelParams($params, static::class);

        $query = Query::selectFrom(['u' => 'usuarios']);

        if (isset($params['id_usuario'])) {
            $query->where('u.id_usuario', $params['id_usuario']);
        }

        // DO NOT REMOVE, checks if passed params are not used in code block.
        $params->check();
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
        return reset($rows) ?: null;
    }

    public static function getLast(array $params = [])
    {
        $rows = static::getRows($params);
        return end($rows) ?: null;
    }

    public static function insert(Usuario $usuario)
    {
        $db = DatabaseManager::connect('myapp');
        $query = Query::insertInto('usuarios', $usuario);
        $result = $db->executeInsert($query);
        $usuario->id_usuario = $result->getFirstId();
        return $result;
    }

    public static function update(Usuario $usuario, $matching = null, $columns = null)
    {
        $matching = $matching ?? ['id_usuario'];
        $columns = $columns ?? [];

        $db = DatabaseManager::connect('myapp');
        $query = Query::update('usuarios', $usuario, $matching, $columns);
        $result = $db->executeUpdate($query);
        return $result;
    }

    public static function delete(Usuario $usuario)
    {
        $db = DatabaseManager::connect('myapp');
        $query = Query::deleteFrom('usuarios', $usuario);
        $result = $db->executeDelete($query);
        return $result;
    }
}
