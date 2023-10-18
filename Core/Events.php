<?php

namespace test\CategoriesMedia\Core;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\DbMetaDataHandler;

/**
 * Class defines what module does on Shop events.
 */
class Events
{
    /**
     * Execute action on activate event
     */
    public static function onActivate()
    {
        self::addDatabaseStructure();
        self::updateViews();
        self::clearTmp();
    }

    /**
     * Execute action on deactivate event
     *
     * @return null
     */
    public static function onDeactivate()
    {
        self::clearTmp();
    }

    /**
     * Regenerates database view-tables.
     *
     * @return void
     */
    public static function updateViews()
    {
        $dbHandler = oxNew(DbMetaDataHandler::class);
        $dbHandler->updateViews();
    }

    /**
     * Clear tmp dir and smarty cache.
     *
     * @return void
     */
    public static function clearTmp()
    {
        $tmpDir = getShopBasePath() . "/tmp/";
        $smartyDir = $tmpDir . "smarty/";

        foreach (glob($tmpDir . "*.txt") as $fileName) {
            unlink($fileName);
        }
        foreach (glob($smartyDir . "*.php") as $fileName) {
            unlink($fileName);
        }
    }

    /**
     * Creating database structure changes.
     *
     * @return void
     */
    public static function addDatabaseStructure()
    {
        // '1.0.0' changes
        self::addColumnIfNotExists("oxmediaurls", 'OBJECTTYPE', "ALTER TABLE oxmediaurls ADD COLUMN OBJECTTYPE int(8) DEFAULT 0 NOT NULL;");
    }

    /**
     * Add a database table.
     *
     * @param string $tableName table to add
     * @param string $query     sql-query to add table
     *
     * @return boolean true or false
     */
    public static function addTableIfNotExists($tableName, $query)
    {
        if (!DatabaseProvider::getDb()->select("SHOW TABLES LIKE '{$tableName}'")->count()) {
            DatabaseProvider::getDb()->execute($query);
            return true;
        }
        return false;
    }

    /**
     * Add a column to a database table.
     *
     * @param string $tableName  table name
     * @param string $columnName column name
     * @param string $query      sql-query to add column to table
     *
     * @return boolean true or false
     */
    public static function addColumnIfNotExists($tableName, $columnName, $query)
    {
        if (!DatabaseProvider::getDb()->select("SHOW COLUMNS FROM {$tableName} LIKE '{$columnName}'")->count()) {
            DatabaseProvider::getDb()->execute($query);
            return true;
        }
        return false;
    }

    /**
     * Insert a database row to an existing table.
     *
     * @param string $tableName database table name
     * @param array  $keyValue  keys of rows to add for existance check
     * @param string $query     sql-query to insert data
     *
     * @return boolean true or false
     */
    public static function insertRowIfNotExists($tableName, $keyValue, $query)
    {
        $where = '';
        foreach ($keyValue as $key => $value) {
            $where .= " AND $key = '$value'";
        }

        if (!DatabaseProvider::getDb()->select("SELECT * FROM {$tableName} WHERE 1" . $where)->count()) {
            DatabaseProvider::getDb()->execute($query);
            return true;
        }
        return false;
    }
}
