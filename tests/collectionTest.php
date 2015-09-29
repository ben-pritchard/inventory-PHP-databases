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
    }


 ?>
