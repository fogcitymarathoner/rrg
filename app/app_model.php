<?php
class AppModel extends Model {
    function db_connect()
    {

        $dataSource = ConnectionManager::getDataSource('default');

        $gaSql['user']       = $dataSource->config['login'];
        $gaSql['password']   = $dataSource->config['password'];
        $gaSql['db']         = $dataSource->config['database'];
        $gaSql['server']     = $dataSource->config['host'];


        $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
            die( 'Could not open connection to server' );

        mysql_select_db( $gaSql['db'], $gaSql['link'] ) or
            die( 'Could not select database '. $gaSql['db'] );
        return $gaSql;
    }
    function getLastQuery()
    {
        $dbo = $this->getDatasource();
        $logs = $dbo->_queriesLog;

        return end($logs);
    }
}