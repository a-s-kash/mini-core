<?php
/*
* SQLite3 Class
* based on the code of miquelcamps
* @see http://7devs.com/code/view.php?id=67
*/

namespace core\db;

class DataBaseSQLite implements DataBase{

    /** @var \SQLite3  */
    private $sqlite;

    /** @var int  */
    private $mode;

    /**
     * ActiveQuerySQLite constructor.
     * @param $filename
     * @param int $mode
     */
    public function __construct(string $filename, int $mode = 1)
    {
        $this->mode = $mode;
        $this->sqlite = new \SQLite3($filename);
    }

    public function __destruct()
    {
        @$this->sqlite->close();
    }

    public function clean(string $str): string
    {
        return $this->sqlite->escapeString($str);
    }

    public function query(string $query)
    {
        $res = $this->sqlite->query($query);
        if ( !$res ){
            new \Exception($this->sqlite->lastErrorMsg());
        }
        return $res;
    }

    /**
     * @param $query
     * @return array
     * @throws \Exception
     */
    public function queryRow(string $query)
    {
        $res = $this->query($query);
        $row = $res->fetchArray($this->mode);
        return $row;
    }

    public function queryOne(string $query, $entireRow = true): array
    {
        return $this->sqlite->querySingle($query, $entireRow);
    }

    public function queryAll(string $query)
    {
        $rows = array();
        if( $res = $this->query($query) ){
            while($row = $res->fetchArray($this->mode)){
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
     * @return int
     */
    public function getLastInsertId(): int
    {
        return $this->sqlite->lastInsertRowID();
    }
}
