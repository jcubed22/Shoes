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

        function getAll()
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




        //Static functions
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE * FROM stores;");
        }

    }


?>
