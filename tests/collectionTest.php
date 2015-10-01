<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Collection.php";

    $server = 'mysql:host=localhost;dbname=inventory_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CollectionTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Collection::deleteAll();
            Item::deleteAll();
        }

        function testSave()
        {
            // Arrange
            $name = "Star Wars Cards";
            $test_collection = new Collection($name);

            // Act
            $test_collection->save();

            // Assert
            $result = Collection::getAll();
            $this->assertEquals($test_collection, $result[0]);
        }

        function test_getItems()
        {
            // Arrange
            $collection_name = "Star Wars Cards";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $collection_id = $test_collection->getId();
            $item_name = "Boba Fett";
            $test_item = new Item($item_name, $collection_id);
            $test_item->save();
            $item_name2 = "Slave 1";
            $test_item2 = new Item($item_name2, $collection_id);
            $test_item2->save();

            // Act
            $items = array();
            $collection_items = $test_collection->getItems();

            // Assert
            $this->assertEquals([$test_item, $test_item2], $collection_items);
        }

        function testDelete()
        {
            // Arrange
            $collection_name = "Star Wars Cards";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $collection_name2 = "Cool stuff";
            $test_collection2 = new Collection($collection_name2);
            $test_collection2->save();

            // Act
            $test_collection->delete();

            // Assert
            $this->assertEquals([$test_collection2], Collection::getAll());
        }

        function testDeleteAlsoDeletesAssociatedItems()
        {
            // Arrange
            $collection_name = "Star Wars Cards";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $collection_id = $test_collection->getId();
            $item_name = "Boba Fett";
            $test_item = new Item($item_name, $collection_id);
            $test_item->save();
            $item_name2 = "Slave 1";
            $test_item2 = new Item($item_name2, $collection_id);
            $test_item2->save();

            // Act
            $test_collection->delete();

            // Assert
            $this->assertEquals([], Item::getAll());
        }

        function testDeleteAssociatedItems()
        {
            $collection_name = "Star Wars Cards";
            $test_collection = new Collection($collection_name);
            $test_collection->save();
            $collection_id = $test_collection->getId();
            $item_name = "Boba Fett";
            $test_item = new Item($item_name, $collection_id);
            $test_item->save();
            $item_name2 = "Slave 1";
            $test_item2 = new Item($item_name2, $collection_id);
            $test_item2->save();

            // Act
            $test_collection->deleteAssociatedItems();

            // Assert
            $this->assertEquals([], Item::getAll());

        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Hello Kitty";
            $name2 = "Pokemon";
            $test_collection = new Collection($name);
            $test_collection->save();
            $test_collection2 = new Collection($name2);
            $test_collection2->save();

            //Act
            Collection::deleteAll();
            $result = Collection::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function testFind()
        {
            //Arrange
            $name = "Hello Kitty";
            $name2 = "Pokemon";
            $test_collection = new Collection($name);
            $test_collection->save();
            $test_collection2 = new Collection($name2);
            $test_collection2->save();

            //Act
            $result = Collection::find($test_collection2->getId());

            //Assert
            $this->assertEquals($test_collection2, $result);
        }
    }


 ?>
