<?php

class Collection
//when we declare a class it is singular!
{
    private $name;
    private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
         $this->name = $new_name;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($new_id)
    {
        $this->id = $new_id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO collections (name) VALUES ('{$this->getName()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_collections = $GLOBALS['DB']->query("SELECT * FROM collections");
        $collections_array = array();
        foreach($returned_collections as $collection) {
            $id = $collection["id"];
            $name = $collection["name"];
            $new_collection = new Collection($name, $id);
            array_push($collections_array, $new_collection);
        }
        return $collections_array;
    }


}


 ?>
