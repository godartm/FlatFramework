<?php

namespace PrivateHeberg\Flat;


class Entity
{
    public $id;

    /**
     * @param $query
     * @param array ...$data
     *
     * @return $this|$this[]|null
     */
    public function get($query, ...$data)
    {
        $pdo = Controller::getMysql(0);
        $stmt = $pdo->prepare($query);
        $stmt->execute($data);
        echo $stmt->queryString;
        $data_list = array();

        while ($row = $stmt->fetchObject(get_class($this))) {
            $data_list[] = $row;
        }


        if (count($data_list) == 0) {
            return null;
        } else if (count($data_list) == 1) {
            return $data_list[0];
        } else {
            return $data_list;
        }
    }

    /**
     * @return int get ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id set ID
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}