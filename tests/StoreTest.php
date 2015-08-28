<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
            $GLOBALS['DB']->exec("DELETE FROM availability;");
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

        function test_save()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $id = null;
            $test_store = new Store($retailer, $address, $phone, $id);

            //Act
            $test_store->save();
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $id = null;
            $test_store = new Store($retailer, $address, $phone, $id);

            $retailer2 = "Macys";
            $address2 = "400 SW 6th Avenue";
            $phone2 = "888-888-8888";
            $test_store2 = new Store($retailer2, $address2, $phone2, $id);

            //Act
            $test_store->save();
            $test_store2->save();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        /* I didn't want to spend a ton of time figuring out a more elegant way to test the update functionality for all three.  I ran the test three times, changing the assertion every time, and they all passed. But I also discovered that if you have multiple assertEquals statements, they all have to evaluate to true for the test to pass.  Is this a kosher way to go about this, or is there a better one? */
        function test_update()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $id = null;
            $test_store = new Store($retailer, $address, $phone, $id);
            $test_store->save();

            $new_retailer = "Macys";
            $new_address = "400 SW 6th Avenue";
            $new_phone = "888-888-8888";

            //Act
            $test_store->update($new_retailer, $new_address, $new_phone);

            //Assert
            $this->assertEquals($new_retailer, $test_store->getRetailer());
            $this->assertEquals($new_address, $test_store->getAddress());
            $this->assertEquals($new_phone, $test_store->getPhone());
        }

        function test_find()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $id = null;
            $test_store = new Store($retailer, $address, $phone, $id);
            $test_store->save();

            $retailer2 = "Macys";
            $address2 = "400 SW 6th Avenue";
            $phone2 = "888-888-8888";
            $test_store2 = new Store($retailer2, $address2, $phone2, $id);
            $test_store2->save();

            //Act
            $result = Store::find($test_store2->getId());

            //Assert
            $this->assertEquals($test_store2, $result);
        }

        function test_delete()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $id = null;
            $test_store = new Store($retailer, $address, $phone, $id);
            $test_store->save();

            $retailer2 = "Macys";
            $address2 = "400 SW 6th Avenue";
            $phone2 = "888-888-8888";
            $test_store2 = new Store($retailer2, $address2, $phone2, $id);
            $test_store2->save();

            //Act
            $test_store->delete();
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store2, $result[0]);
        }

        function test_addBrand()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $id = null;
            $test_store = new Store($retailer, $address, $phone, $id);
            $test_store->save();

            $name = "Nike";
            $stock = 5;
            $test_brand = new Brand($name, $stock, $id);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);
            $result = $test_store->getBrands();

            //Assert
            $this->assertEquals($test_brand, $result[0]);
        }

        function test_getBrands()
        {
            //Arrange
            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $id = null;
            $test_store = new Store($retailer, $address, $phone, $id);
            $test_store->save();

            $name = "Nike";
            $stock = 5;
            $test_brand = new Brand($name, $stock, $id);
            $test_brand->save();

            $name2 = "Adidas";
            $stock2 = 8;
            $test_brand2 = new Brand($name2, $stock2, $id);
            $test_brand2->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);
            $result = $test_store->getBrands();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }


    }


?>
