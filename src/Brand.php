<?php

    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
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

        //ID getter
        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM availability WHERE id = {$this->getId()};");
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO availability (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        }

        function getStores()
        {
            $found_stores = $GLOBALS['DB']->query(
            "SELECT stores.* FROM
            brands JOIN availability ON (brands.id = availability.brand_id)
                   JOIN stores ON (availability.store_id = stores.id)
            WHERE brands.id = {$this->getId()};");

            $stores = array();
            foreach ($found_stores as $store) {
                $retailer = $store['retailer'];
                $address = $store['address'];
                $phone = $store['phone'];
                $id = $store['id'];
                $new_store = new Store($retailer, $address, $phone, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        //Static functions
        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
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
            $GLOBALS['DB']->exec("DELETE FROM availability;");
        }
    }
?>
