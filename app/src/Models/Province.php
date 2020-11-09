<?php
    class Province {

        private string $name;
        private int $upperZip;
        private  int $lowerZip;


        public function __construct (string $name, int $lowerZip, int $upperZip) {
            $this->name = $name;
            $this->lowerZip = $lowerZip;
            $this->upperZip = $upperZip;
        }

        public function setName (string $name): void {
            $this->name = $name;
        }

        public function setLowerZip (int $lowerZip): void {
            $this->lowerZip = $lowerZip;
        }

        public function setUpperZip (int $upperZip): void {
            $this->upperZip = $upperZip;
        }

        public function getName (): string {
            return $this->name;
        }

        public function getLowerZip (): int {
            return $this->lowerZip;
        }

        public function getUpperZip (): int {
            return $this->upperZip;
        }
    }
