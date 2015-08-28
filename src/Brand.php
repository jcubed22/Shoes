<?php

    class Brand
    {
        private $name;
        private $stock;
        private $id;

        function __construct($name, $stock, $id = null)
        {
            $this->name = $name;
            $this->stock = $stock;
            $this->id = $id;
        }

        //Brand name setter and getter
        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        //Stock setter and getter
        function setStock($new_stock)
        {
            $this->stock = $new_stock;
        }

        function getStock()
        {
            return $this->stock;
        }

        //ID getter
        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brands (name, stock) VALUES ('{$this->getName()}', '{$this->getStock()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name, $new_stock)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}', stock = '{$new_stock}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
            $this->setStock($new_stock);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        }

        //Static functions
        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $stock = $brand['stock'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $stock, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function find($search_id)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand) {
                $brand_id = $brand->getId();
                if ($brand_id == $search_id) {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }




    }
?>
