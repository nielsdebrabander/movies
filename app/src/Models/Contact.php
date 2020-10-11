<?php

    class Contact {

        private string $name;
        private string $client;
        private string $email;
        private string $phone;

        public function __construct (string $name, string $client, string $email, string $phone) {
            $this->name = $name;
            $this->client = $client;
            $this->email = $email;
            $this->phone = $phone;
        }

        public function getName (): string {
            return $this->name;
        }
        public function getClient (): string {
            return $this->client;
        }
        public function getEmail (): string {
            return $this->email;
        }
        public function getPhone (): string {
            return $this->phone;
        }
        public function setName (?string $name): void {
            $this->name = $name;
        }
        public function setClient (?string $client): void {
            $this->client = $client;
        }
        public function setEmail (?string $email): void {
            $this->email = $email;
        }

        public function setPhone (?string $phone): void {
            $this->phone = $phone;
        }
    }