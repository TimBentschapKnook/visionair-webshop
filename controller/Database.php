<?php


namespace app\controller;
use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;
    private $query;
    /**
     * @var false
     */
    private bool $error;
    private int $count;
    private ?array $results = null;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance(): ?Database
    {
        if (!isset(self::$instance))
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($sql, $params = array()): Database
    {
        $this->error = false;

        if ($this->query = $this->pdo->prepare($sql))
        {
            $x = 1;

            if (count($params))
            {
                foreach ($params as $param)
                {
                    $this->query->bindValue($x, $param);
                    $x++;
                }
            }

            if ($this->query->execute())
            {
                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
            } else {
                $this->error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array())
    {
        if (count($where) === 3)
        {
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators))
            {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error())
                {
                    return $this;
                }
            }
        }
        return false;
    }

    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function insert($table, $fields = array())
    {
        $keys = array_keys($fields);
        $values = null;
        $x = 1;

        foreach ($fields as $field)
        {
            $values .= '?';
            if ($x < count($fields))
            {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

        if (!$this->query($sql, $fields)->error())
        {
            return true;
        }
        return false;
    }

    public function result(): ?array
    {
        return $this->results;
    }

    public function first() {
        $data = $this->result();
        return $data[0];
    }

    public function count(): int
    {
        return $this->count;
    }

    public function error(): bool
    {
        return $this->error;
    }
}