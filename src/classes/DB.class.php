<?php

class DB extends Singleton
{
    public $config;
    public $c;
    function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->config = $config;
        try {
            $this->c = new PDO($dsn, $config['user'], $config['pass']);
        } catch (Exception $e) {
            die('<h1>Problem z bazą danych!</h1>
            <p>Skontaktuj się z administratorem serwisu.</p>');
        }
    }

    function query($q)
    {
        return $this->c->query($q);
    }


    public function delete($data)
    {
        $where = $this->compileWhere($data['where']);
        $query = 'DELETE FROM '.$data['from'].' where '.$where['query'];
        $stmt = $this->c->prepare($query);
        $stmt->execute($where['data']);
        $stmt = null;
    }

    public function update($data)
    {
        $query = 'UPDATE '.$data['update'].' SET ';
        $params = [];
        $sets = [];
        foreach ($data['set'] as $key => $value) {
            $sets[] = "$key=?";
            $params = $value;
        }
        $query .= implode(',', $sets);
        if (array_key_exists('where', $data)) {
            $where = $this->compileWhere($data['where']);
            $query .= ' WHERE '.$where['query'];
            $params = array_merge($params, $where['data']);
        }
        $stmt = $this->c->prepare($query);
        $stmt->execute($params);
        $stmt = null;
    }

    public function select($data)
    {
        $params = [];
        $query = 'SELECT '.$data['select']
            .' FROM '.$data['from'];
        if (array_key_exists('where', $data)) {
            $where = $this->compileWhere($data['where']);
            $params = array_merge($params, $where['data']);
            $query .= ' WHERE '.$where['query'];
        }
        if (array_key_exists('group', $data)) {
            $query .= ' GROUP BY '.$data['group'];
        }
        if (array_key_exists('having', $data)) {
            $having = $this->compileWhere($data['having']);
            $params = array_merge($params, $having['data']);
            $query .= ' HAVING '.$having['query'];
        }
        if (array_key_exists('order', $data)) {
            $query .= ' ORDER BY '.$data['order'];
        }
        if (array_key_exists('limit', $data)) {
            $query .= ' LIMIT '.$data['limit'];
        }
        $stmt = $this->c->prepare($query);
        $stmt->execute($params);
        if ($stmt->rowCount()) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            return $rows;
        } else {
            $stmt = null;
            return [];
        }
    }


    public function compileWhere($whereClause)
    {
        if (!is_array($whereClause)) {
            return ['query'=> $whereClause, 'data'=> []];
        }
        $where = [
            'query' => '',
            'data' => [],
        ];

        $where['query'] = implode(
            ' AND ',
            array_map(
                function($condition) {
                    return $condition[0];
                },
                $whereClause
            )
        );

        foreach ($whereClause as $singleClause) {
            if (is_array($singleClause[1])) {
                $where['data'] = array_merge($where['data'], $singleClause[1]);
            } else {
                $where['data'][] = $singleClause[1];
            }
        }
        return $where;
    }

    public function insert($table, $values)
    {
        $query = 'INSERT INTO '.$table.' ('
            .implode(',', array_keys($values))
            .') VALUES('
            .implode(
                ', ',
                array_map(
                    function() {
                        return '?';
                    },
                    array_keys($values)
                )
            )
            .')';
        $stmt = $this->c->prepare($query);
        $stmt->execute(array_values($values));
        $stmt = null;
        return $this->c->lastInsertId();
    }

    // SINGLETON
    //
    static function i()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            include ROOT_PATH.'config.php';
            self::$instances[$class] = new static($CONF['DB']);
        }
        return static::$instances[$class];
    }
}