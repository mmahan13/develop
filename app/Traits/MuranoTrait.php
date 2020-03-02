<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait MuranoTrait
{
    /**
     * @param array $con
     * @param string $sql
     * @param array $params
     * @return string|void
     */
    public static function executeExternalQueryNoFetch(array $con, $sql, array $params)
    {
        if ($con['driver'] == 'sqlsrv' || $con['driver'] == 'sqlsrv2') {
            $dns = "sqlsrv:server={$con['host']},{$con['port']};Database={$con['database']};ConnectionPooling=0";
            try {
                $connection = new \PDO($dns, $con['username'], $con['password']);
                $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                $prepareSql = $connection->prepare($sql);
                $connection->beginTransaction();
                $prepareSql->execute($params);
                $result = $prepareSql->rowCount();
                $connection->commit();
                $prepareSql->closeCursor();
                $connection = null;
                return [
                    'result' => $result,
                ];
            } catch (\Exception $e) {
                return (json_encode([
                    'outcome' => false,
                    'dns' => $dns,
                    'message' => $e->getMessage(),
                    'query' => $sql,
                    'params' => $params
                ]));
            }
        }
        return json_encode(['outcome' => false, 'message' => 'Can\'t find the correct driver']);
    }

    /**
     * @param atring $sql
     * @param array $params
     * @return string|void
     */
    public static function executeExternalQuery(array $con, string $sql, array $params)
    {
        // $dns = "sqlsrv:server=10.118.120.206,1433;Database=clients_portal;ConnectionPooling=0";
        $dns
            = "sqlsrv:server={$con['host']},{$con['port']};Database={$con['database']};ConnectionPooling=0";
        try {
            $connection = new \PDO($dns, 'client_portal_dev', 'clients_2016.dev');
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $sql = $connection->prepare($sql);
            $connection->beginTransaction();
            $sql->execute($params);
            $result = $sql->fetchAll();
            $connection->commit();
            $sql->closeCursor();
            $connection = null;
            return json_encode([
                'outcome' => true,
                'message' => $result,
                'query' => $sql,
                'params' => $params
            ]);
        } catch (\Exception $e) {
            return die(json_encode([
                'outcome' => false,
                'dns' => $dns,
                'message' => $e->getMessage(),
                'query' => $sql,
                'params' => $params
            ]));
        }
    }
    
     /**
     * @param array $con
     * @param string $sql
     * @param array $params
     * @return string|void
     */
    public static function executeExternalQueryWithoutParams(array $con, $sqlQuery, array $params = [])
    {
        if ($con['driver'] == 'sqlsrv' || $con['driver'] == 'sqlsrv2') {
            $dns = "sqlsrv:server={$con['host']},{$con['port']};Database={$con['database']};ConnectionPooling=0";
            try {
                $connection = new \PDO($dns, $con['username'], $con['password']);
                $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                
                $sql = $connection->prepare($sqlQuery);
                $connection->beginTransaction();
                $sql->execute($params);
                $result = $sql->fetchAll();
                $connection->commit();
                $sql->closeCursor();
                $connection = null;
                return [
                    'result' => $result,
                ];
            } catch (\Exception $e) {
                return (json_encode([
                    'outcome' => false,
                    'dns' => $dns,
                    'message' => $e->getMessage(),
                    'query' => $sql,
                    'params' => $params
                ]));
            }
        }
        return json_encode(['outcome' => false, 'message' => 'Can\'t find the correct driver']);
    }
}
