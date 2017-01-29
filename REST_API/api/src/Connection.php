<?php
class Connection
{
    private $mysqli;
    private $result;

    public function __construct(mysqli $mysqli) 
    {
        if ($mysqli->connect_error) {
            die('connection error: '.$mysqli->connect_error);
        }
        if (!$mysqli->set_charset('utf8')) {
            die(sprintf("UTF-8 loading error: %s\n",$mysqli->connect_error));
        }
        $this->mysqli = $mysqli;
    }
    
    public function query($sql) 
    {
        $result = $this->mysqli->query($sql);
        if (!$result) {
            die(sprintf(
                    'SQL: %s, błąd: %s', 
                    $sql, 
                    $this->mysqli->error)
                );
        }
        $this->result = $result;
    }
    
    public function getResult() 
    {
        return $this->result;
    }

    public function getInsertId() 
    {
        return $this->mysqli->insert_id;
    }

    public function getAffectedRows() 
    {
        return $this->mysqli->affected_rows;
    }
}