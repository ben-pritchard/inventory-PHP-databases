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

    function getItems()
    {
        $items = array();
        $db_items = $GLOBALS['DB']->query("SELECT * FROM items WHERE collection_id = ('{$this->getId()}')");
        foreach($db_items as $item) {
            $name = $item["name"];
            $collection_id = $item["collection_id"];
            $id = $item["id"];
            $found_item = new Item($name, $collection_id, $id);
            array_push($items, $found_item);
        }
        return $items;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO collections (name) VALUES ('{$this->getName()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM collections WHERE id = {$this->getId()}");
        $GLOBALS['DB']->exec("DELETE FROM items WHERE collection_id = {$this->getId()}");
    }

    function deleteAssociatedItems()
    {
        $GLOBALS['DB']->exec("DELETE FROM items WHERE collection_id = {$this->getId()}");
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

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM collections;");
    }

    static function find($found_id)
    {
        $found_collection = null;
        $collections = Collection::getAll();
        foreach($collections as $collection){
            $id = $collection->getId();
            if ($id == $found_id){
                $found_collection = $collection;
            }
        }
        return $found_collection;

    }


}


 ?>
