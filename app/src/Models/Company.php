<?php
    class Company {
        private string $name;
        private string $address;
        private int $zip;
        private string $city;
        private string $activity;
        private string $vat;

        // constructor
        public function __construct (string $name, string $address, int $zip, string $city, string $activity, string $vat) {
            $this->name = $name;
            $this->address = $address;
            $this->zip = $zip;
            $this->city = $city;
            $this->activity = $activity;
            $this->vat = $vat;
        }
        public function setName (string $name): void {
            $this->name = $name;
        }

        public function setAddress (string $address): void {
            $this->address = $address;
        }

        public function setZip (int $zip): void {
            $this->zip = $zip;
        }

        public function setCity (string $city): void {
            $this->city = $city;
        }

        public function setActivity (string $activity): void {
            $this->activity = $activity;
        }

        public function setVat (string $vat): void {
            $this->vat = $vat;
        }

        public function getName (): string {
            return $this->name;
        }

        public function getAddress (): string {
            return $this->address;
        }

        public function getZip (): int {
            return $this->zip;
        }

        public function getCity (): string {
            return $this->city;
        }

        public function getActivity (): string {
            return $this->activity;
        }

        public function getVat (): string {
            return $this->vat;
        }

        function formatAddress (string $Country = 'BE'): string {
            $address = explode(' ', $this->address);
            $streetFormat = '';
            $numberFormat = '';
            $format = '';

            foreach ($address as $addressPart) {
                if ((int)$addressPart === 0) {
                    $streetFormat .= $addressPart;
                }
                else if ((int)$addressPart !== 0) {
                    $numberFormat .= $addressPart;
                }
            }

            if ($Country === 'BE') {
                $format .= $streetFormat . ' ' . $numberFormat;
            }
            else if ($Country === 'FR') {
                $format .= $numberFormat . ' ' . $streetFormat;
            }

            return $format;
        }

    }
