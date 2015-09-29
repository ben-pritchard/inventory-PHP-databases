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
        }
        
        function test_save()
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

        function  test_deleteAll()
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
    }


 ?>
