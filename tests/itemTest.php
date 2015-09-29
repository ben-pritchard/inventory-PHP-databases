<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Item.php";

    $server = 'mysql:host=localhost;dbname=inventory_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ItemTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Item::deleteAll();
        }

        function test_save()
        {
            // Arrange
            $name = "Darth Vader Black Border Premier";
            $test_Item = new Item($name);

            // Act
            $test_Item->save();

            // Assert
            $result = Item::getAll();
            $this->assertEquals($test_Item, $result[0]);
        }

        function  test_deleteAll()
        {
            //Arrange
            $name = "Hello Kitty";
            $name2 = "Pokemon";
            $test_Item = new Item($name);
            $test_Item->save();
            $test_Item2 = new Item($name2);
            $test_Item2->save();

            //Act
            Item::deleteAll();
            $result = Item::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function test_find()
        {
            //Arrange
            $name = "Hello Kitty";
            $name2 = "Pokemon";
            $test_Item = new Item($name);
            $test_Item->save();
            $test_Item2 = new Item($name2);
            $test_Item2->save();

            //Act
            $result = Item::find($test_Item2->getId());

            //Assert
            $this->assertEquals($test_Item2, $result);
        }
    }


 ?>
