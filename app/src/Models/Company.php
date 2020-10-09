<?php
    class Company {

        private string $name;
        private string $address;
        private string $zip;
        private string $city;
        private string $vat;
        private string $activity;
        private array $contacts;

        public function __construct(string $name, string $address, string $zip, string $city, string $vat, string $activity)
        {

            $this -> name = $name;
            $this -> address = $address;
            $this -> zip = $zip;
            $this -> city =$city;
            $this -> vat = $vat;
            $this -> activity =$activity;

        }
        public function getName(): string{
            return $this -> name;
        }
        public function getAddress():  string{
            return $this -> address;
        }
        public function getZip(): string{
            return $this -> zip;
        }
        public function getCity(): string{
            return $this -> city;
        }
        public function getVat(): string{
            return $this -> vat;
        }
        public function getActivity(): string{
            return $this -> activity;
        }


        public function getFullAddress (?string $country= ''): string{

            if ($country == 'FR'){
                return $this->address.','.$this->zip.','.$this->city;

            }
            else
            {
                return $this->address.','. $this->zip.','.$this->city;
            }
        }
    }