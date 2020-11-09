<?php

    class Company {
        private ?int $id;
        private ?string $name;
        private ?string $address;
        private ?int $zip;
        private ?string $city;
        private ?string $activity;
        private ?string $vat;

        public function __construct (int $id, ?string $name, ?string $address, ?int $zip, ?string $city, ?string $activity, ?string $vat) {
            $this->id = $id;
            $this->name = $name;
            $this->address = $address;
            $this->zip = $zip;
            $this->city = $city;
            $this->activity = $activity;
            $this->vat = $vat;
        }

        public function getId (): ?int {
            return $this->id;
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

        public function setId (?int $id): void {
            $this->id = $id;
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

        function formatAddress (string $Country = 'BE'): string {
            //address array
            $address = explode(' ', $this->address);
            $street = '';
            $number = '';

            $format = '';

            foreach ($address as $part) {
                if ((int)$part === 0) {
                    $street .= $part;
                }
                else if ((int)$part !== 0) {
                    $number .= $part;
                }
            }

            if ($Country === 'BE') {
                $format .= $street . ' ' . $number;
            }
            else if ($Country === 'FR') {
                $format .= $number . ' ' . $street;
            }

            return $format;
        }
    }
    ?>
