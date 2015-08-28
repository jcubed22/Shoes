<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
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
        





    }
?>
