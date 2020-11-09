
<?php

    class Contact {
        private int $id;
        private int $company_id;
        private ?string $first_name;
        private ?string $last_name;
        private ?string $email;
        private ?string $phone;

        public function __construct (int $id, int $company_id, ?string $first_name, ?string $last_name, ?string $email, ?string $phone) {
            $this->id = $id;
            $this->company_id = $company_id;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->email = $email;
            $this->phone = $phone;
        }

        public function getId (): int {
            return $this->id;
        }

        public function getCompanyId (): int {
            return $this->company_id;
        }

        public function getFirstName (): ?string {
            return $this->first_name;
        }

        public function getLastName (): ?string {
            return $this->last_name;
        }
        public function getEmail (): ?string {
            return $this->email;
        }

        public function getPhone (): ?string {
            return $this->phone;
        }

        public function setId (int $id): void {
            $this->id = $id;
        }

        public function setCompanyId (int $company_id): void {
            $this->company_id = $company_id;
        }

        public function setFirstName (?string $first_name): void {
            $this->first_name = $first_name;
        }

        public function setLastName (?string $last_name): void {
            $this->last_name = $last_name;
        }

        public function setEmail (?string $email): void {
            $this->email = $email;
        }

        public function setPhone (?string $phone): void {
            $this->phone = $phone;
        }
    }

?>