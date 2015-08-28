<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
            $GLOBALS['DB']->exec("DELETE FROM availability;");
        }

        //Tests both brand name setter and getter
        function test_setName()
        {
            //Arrange
            $name = "Nike";
            $stock = 3;
            $test_brand = new Brand($name, $stock);
            $new_name = "Adidas";

            //Act
            $test_brand->setName($new_name);
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        //Tests both stock setter and getter
        function test_setStock()
        {
            //Arrange
            $name = "Nike";
            $stock = 4;
            $test_brand = new Brand($name, $stock);
            $new_stock = 2;

            //Act
            $test_brand->setStock($new_stock);
            $result = $test_brand->getStock();

            //Assert
            $this->assertEquals($new_stock, $result);
        }

        //Tests getId method
        function test_getId()
        {
            //Arrange
            $name = "Nike";
            $stock = 4;
            $id = 3;
            $test_brand = new Brand($name, $stock, $id);

            //Act
            $result = $test_brand->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Nike";
            $stock = 5;
            $id = null;
            $test_brand = new Brand($name, $stock, $id);

            //Act
            $test_brand->save();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals($test_brand, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Nike";
            $stock = 4;
            $id = null;
            $test_brand = new Brand($name, $stock, $id);

            $name2 = "Adidas";
            $stock2 = 20;
            $test_brand2 = new Brand($name2, $stock2, $id);

            //Act
            $test_brand->save();
            $test_brand2->save();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_update()
        {
            //Arrange
            $name = "Nike";
            $stock = 5;
            $id = null;
            $test_brand = new Brand($name, $stock, $id);
            $test_brand->save();

            $new_name = "Adidas";
            $new_stock = 8;
            //Act
            $test_brand->update($new_name, $new_stock);

            //Assert
            $this->assertEquals($new_name, $test_brand->getName());
            $this->assertEquals($new_stock, $test_brand->getStock());
        }

        function test_find()
        {
            //Arrange
            $name = "Nike";
            $stock = 5;
            $id = null;
            $testbrande = new Brand($name, $stock, $id);
            $testbrande->save();

            $name2 = "Adidas";
            $stock2 = 8;
            $test_brand2 = new Brand($name2, $stock2, $id);
            $test_brand2->save();

            //Act
            $result = Brand::find($test_brand2->getId());

            //Assert
            $this->assertEquals($test_brand2, $result);
        }

        function test_delete()
        {
            //Arrange
            $name = "Nike";
            $stock = 5;
            $id = null;
            $test_brand = new Brand($name, $stock, $id);
            $test_brand->save();

            $name2 = "Adidas";
            $stock2 = 8;
            $test_brand2 = new Brand($name2, $stock2, $id);
            $test_brand2->save();

            //Act
            $test_brand->delete();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals($test_brand2, $result[0]);
        }

        function test_addStore()
        {
            //Arrange
            $name = "Nike";
            $stock = 5;
            $id = null;
            $test_brand = new Brand($name, $stock, $id);
            $test_brand->save();

            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $test_store = new Store($retailer, $address, $phone, $id);
            $test_store->save();

            //Act
            $test_brand->addStore($test_store);
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals($test_store, $result[0]);
        }

        function test_getStores()
        {
            //Arrange
            $name = "Nike";
            $stock = 5;
            $id = null;
            $test_brand = new Brand($name, $stock, $id);
            $test_brand->save();

            $retailer = "Nordstrom";
            $address = "1234 SW Main Street";
            $phone = "123-456-7890";
            $test_store = new Store($retailer, $address, $phone, $id);
            $test_store->save();

            $retailer2 = "Macys";
            $address2 = "400 SW 6th Avenue";
            $phone2 = "888-888-8888";
            $test_store2 = new Store($retailer2, $address2, $phone2, $id);
            $test_store2->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }




    }
?>
