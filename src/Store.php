<?php

    class Store
    {
        //Retailer is store name
        private $retailer;
        private $address;
        private $phone;
        private $id;

        function __construct($retailer, $address, $phone, $id = null)
        {
            $this->retailer = $retailer;
            $this->address = $address;
            $this->phone = $phone;
            $this->id = $id;
        }

        //Retailer setter and getter
        function setRetailer($new_retailer)
        {
            $this->retailer = $new_retailer;
        }

        function getRetailer()
        {
            return $this->retailer;
        }

        //Address setter and getter
        function setAddress($new_address)
        {
            $this->address = $new_address;
        }

        function getAddress()
        {
            return $this->address;
        }

        //Phone setter and getter
        function setPhone($new_phone)
        {
            $this->phone = $new_phone;
        }

        function getPhone()
        {
            return $this->phone;
        }

        //ID getter
        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (retailer, address, phone) VALUES ('{$this->getRetailer()}', '{$this->getAddress()}', '{$this->getPhone()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_retailer, $new_address, $new_phone)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET retailer = '{$new_retailer}', address = '{$new_address}', phone = '{$new_phone}' WHERE id = {$this->getId()};");
            $this->setRetailer($new_retailer);
            $this->setAddress($new_address);
            $this->setPhone($new_phone);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM availability WHERE store_id = {$this->getId()};");
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO availability (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        }

        function getBrands()
        {
            $found_brands = $GLOBALS['DB']->query(
            "SELECT brands.* FROM
            stores JOIN availability ON (stores.id = availability.store_id)
                   JOIN brands ON (availability.brand_id = brands.id)
            WHERE stores.id = {$this->getId()};");

            $brands = array();
            foreach ($found_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        //Static functions
        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($returned_stores as $store) {
                $retailer = $store['retailer'];
                $address = $store['address'];
                $phone = $store['phone'];
                $id = $store['id'];
                $new_store = new Store($retailer, $address, $phone, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }
    }
?>
