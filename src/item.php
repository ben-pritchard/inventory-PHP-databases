<?php

class Item
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
        $GLOBALS['DB']->exec("INSERT INTO items (name) VALUES ('{$this->getName()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_items = $GLOBALS['DB']->query("SELECT * FROM items");
        $items_array = array();
        foreach($returned_items as $item) {
            $id = $item["id"];
            $name = $item["name"];
            $new_item = new Item($name, $id);
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
