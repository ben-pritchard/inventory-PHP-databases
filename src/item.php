<?php

class Item
//when we declare a class it is singular!
{
    private $name;
    private $collection_id;
    private $id;

    function __construct($name, $collection_id, $id = null)
    {
        $this->name = $name;
        $this->collection_id = $collection_id;
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

    function getCollectionId()
    {
        return $this->collection_id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO items (name, collection_id) VALUES ('{$this->getName()}', {$this->getCollectionId()})");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM items WHERE id = {$this->getId()}");
    }

    static function getAll()
    {
        $returned_items = $GLOBALS['DB']->query("SELECT * FROM items");
        $items_array = array();
        foreach($returned_items as $item) {
            $id = $item["id"];
            $collection_id = $item["collection_id"];
            $name = $item["name"];
            $new_item = new Item($name, $collection_id, $id);
            array_push($items_array, $new_item);
        }
        return $items_array;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM items;");
    }

    static function find($found_id)
    {
        $found_item = null;
        $items = Item::getAll();
        foreach($items as $item){
            $id = $item->getId();
            if ($id == $found_id){
                $found_item = $item;
            }
        }
        return $found_item;

    }


}


 ?>
