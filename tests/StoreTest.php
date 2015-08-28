<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
        }

        //Tests both retailer setter and getter
        function test_setName()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $test_store = new Store($retailer, $address, $phone);
            $new_retailer = "Macys";

            //Act
            $test_store->setRetailer($new_retailer);
            $result = $test_store->getRetailer();

            //Assert
            $this->assertEquals($new_retailer, $result);
        }

        //Tests both address setter and getter
        function test_setAddress()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $test_store = new Store($retailer, $address, $phone);
            $new_address = "4321 NE Elm Street";

            //Act
            $test_store->setAddress($new_address);
            $result = $test_store->getAddress();

            //Assert
            $this->assertEquals($new_address, $result);
        }

        //Tests both phone setter and getter
        function test_setPhone()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $test_store = new Store($retailer, $address, $phone);
            $new_phone = "971-806-6298";

            //Act
            $test_store->setPhone($new_phone);
            $result = $test_store->getPhone();

            //Assert
            $this->assertEquals($new_phone, $result);
        }

        //Tests getId method
        function test_getId()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $id = 3;
            $test_store = new Store($retailer, $address, $phone, $id);
            $new_phone = "971-806-6298";

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

    }


?>
