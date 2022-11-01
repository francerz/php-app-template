<?php

namespace App\Models;

use Francerz\SqlBuilder\DatabaseManager;
use Francerz\SqlBuilder\Query;
use Francerz\WebappModelUtils\ModelParams;

/**
 *  Class.........: Usuario
 *  Database alias: default
 *  Table.........: usuarios
 *  Table alias...: u
 *  Primary key...: id_usuario
 */
class Usuario extends AbstractModel
{
    public $id_usuario;

    public static function getQuery(array $params = [])
    {
        $params = new ModelParams($params);

        $query = Query::selectFrom(['u' => 'usuarios']);

        if (isset($params['id_usuario'])) {
            $query->where('u.id_usuario', $params['id_usuario']);
        }

        // DO NOT REMOVE, checks if passed params are not used in code block.
        $params->checkUsed();
        return $query;
    }

    /**
     *  @return self[]
     */
    public static function getRows(array $params = [])
    {
        $db = DatabaseManager::connect('default');
        $query = static::getQuery($params);
        $result = $db->executeSelect($query);
        return $result->toArray(self::class);
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

    public static function insert(Usuario $data, $columns = null)
    {
        $db = DatabaseManager::connect('default');
        $query = Query::insertInto('usuarios', $data, $columns);
        $result = $db->executeInsert($query);
        $data->id_usuario = $result->getInsertedId();
        return $result;
    }

    public static function update(Usuario $data, $matching = null, $columns = null)
    {
        $db = DatabaseManager::connect('default');
        $query = Query::update('usuarios', $data, $matching, $columns);
        $result = $db->executeUpdate($query);
        return $result;
    }
}
