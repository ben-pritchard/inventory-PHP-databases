<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Item.php";
    require_once "src/Collection.php";

    $server = 'mysql:host=localhost;dbname=inventory_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ItemTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Item::deleteAll();
            Collection::deleteAll();
        }

        function testGetCollectionId()
        {
            // Arrange
            $collection_name = "Basketball cards";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $test_collection_id = $test_collection->getId();
            $item_name = "MJ Rookie Card";
            $test_item = new Item($item_name, $test_collection_id);
            $test_item->save();


            // Act
            $result = $test_item->getCollectionId();

            // Assert
            $this->assertEquals(true, is_numeric($result));

        }

        function testSave()
        {
            // Arrange
            $collection_name = "Star Wars cards";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $test_collection_id = $test_collection->getId();

            $name = "Darth Vader Black Border Premier";
            $test_item = new Item($name, $test_collection_id);

            // Act
            $test_item->save();

            // Assert
            $result = Item::getAll();
            $this->assertEquals($test_item, $result[0]);
        }

        function testDelete()
        {
            // Arrange
            $collection_name = "Star Wars cards";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $test_collection_id = $test_collection->getId();

            $name = "Darth Vader Black Border Premier";
            $test_item = new Item($name, $test_collection_id);
            $test_item->save();

            // Act
            $test_item->delete();
            $collection_items = $test_collection->getItems();

            // Assert
            $this->assertEquals([], $collection_items);
        }

        function  testDeleteAll()
        {
            //Arrange
            $collection_name = "Cool stuff";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $test_collection_id = $test_collection->getId();

            $name = "Hello Kitty";
            $name2 = "Pokemon";
            $test_item = new Item($name, $test_collection_id);
            $test_item->save();
            $test_item2 = new Item($name2, $test_collection_id);
            $test_item2->save();

            //Act
            Item::deleteAll();
            $result = Item::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function testFind()
        {
            //Arrange
            $collection_name = "Rad stuff";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $test_collection_id = $test_collection->getId();

            $name = "Hello Kitty";
            $name2 = "Pokemon";
            $test_item = new Item($name, $test_collection_id);
            $test_item->save();
            $test_item2 = new Item($name2, $test_collection_id);
            $test_item2->save();

            //Act
            $result = Item::find($test_item2->getId());

            //Assert
            $this->assertEquals($test_item2, $result);
        }

    }


 ?>
