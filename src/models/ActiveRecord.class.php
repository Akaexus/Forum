<?php

abstract class ActiveRecord
{
    public static $databaseTable;
    public static $idColumn;
    public static $columnNames;
    public $_new = false;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function getColumns()
    {
        $columns = static::$columnNames;
        unset($columns[array_search(static::$idColumn, $columns)]);
        return $columns;
    }

    public function getId()
    {
        $idColumn = static::$idColumn;
        return $this->$idColumn;
    }

    public function save()
    {
        $idColumn = static::$idColumn;
        $values = [];
        if ($this->_new) {
            $columnNames = static::$columnNames;
            unset($columnNames[array_search(static::$idColumn, $columnNames)]);

            $values = [];
            foreach ($columnNames as $column) {
                $values[$column] = $this->$column;
            }
            $id = DB::i()->insert(static::$databaseTable, $values);
            if ($id) {
                $this->id = $id;
            }
            return $id;
        } else {
            foreach (static::$columnNames as $column) {
                $values[] = $this->$column;
            }

            $query = 'update '.static::$databaseTable.' set ';
            $params = [];
            foreach (static::$columnNames as $column) {
                $params[] = "{$column}='{$this->$column}'";
            }
            $query .= implode(',', $params);
            $query .= ' where '.static::$idColumn.'='.$this->$idColumn;
            return DB::i()->query($query);
        }
    }

    public static function load($id)
    {
        $entity = DB::i()->select(
            [
                'select'=> implode(',', static::$columnNames),
                'from'=> static::$databaseTable,
                'where'=> [
                    [static::$idColumn.'=?', $id]
                ],
                'limit'=> 1
            ]
        );
        if (!$entity) {
            throw new Exception;
        } else {
            $entity = $entity[0];
        }
        $class = get_called_class();
        return new $class($entity);
    }

    public static function loadAll($where = null)
    {
        $query = [
            'select'=> '*',
            'from'=> static::$databaseTable
        ];
        if ($where) {
            $query['where'] = $where;
        }
        return array_map(
            function($e) {
                return new static($e);
            },
            DB::i()->select($query)
        );
    }

    public function delete()
    {
        $idColumn = static::$idColumn;
        DB::i()->query('delete from '.static::$databaseTable.' where '.$idColumn.'='.$this->$idColumn);
    }
}