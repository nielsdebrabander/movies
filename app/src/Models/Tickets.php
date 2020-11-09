<?php

    class Tickets {

        private string $title;
        private string $company;
        private string $date;
        private string $short;
        private ?string $long;
        private ?string $desired;
        private string $priority;
        private string $mail;
        private ?string $filePath;

        public function __construct (string $title, string $company, string $date, string $short, ?string $long, ?string $desired, string $priority, string $mail, ?string $filePath) {
            $this->title = $title;
            $this->company = $company;
            $this->date = $date;
            $this->short = $short;
            $this->long = $long;
            $this->desired = $desired;
            $this->priority = $priority;
            $this->mail = $mail;

            $parts = explode('/', $filePath);
            $fileName = end($parts);

            $this->filePath = $fileName;
        }

        public function getTitle (): string {
            return $this->title;
        }

        public function getCompany (): string {
            return $this->company;
        }

        public function getDate (): string {
            return $this->date;
        }

        public function getShort (): string {
            return $this->short;
        }

        public function setLong (?string $long): void {
            $this->long = $long;
        }

        public function getDesired (): ?string {
            return $this->desired;
        }

        public function getPriority (): string {
            return $this->priority;
        }

        public function getMail (): string {
            return $this->mail;
        }

        public function getFilePath (): string {
            return $this->filePath;
        }

        public function setTitle (string $title): void {
            $this->title = $title;
        }

        public function setCompany (string $company): void {
            $this->company = $company;
        }

        public function setDate (string $date): void {
            $this->date = $date;
        }

        public function setShort (string $short): void {
            $this->short = $short;
        }

        public function getLong (): ?string {
            return $this->long;
        }

        public function setDesired (?string $desired): void {
            $this->desired = $desired;
        }

        public function setPriority (string $priority): void {
            $this->priority = $priority;
        }

        public function setMail (string $mail): void {
            $this->mail = $mail;
        }

        public function setFilePath (?string $filePath): void {
            $this->filePath = $filePath;
        }
    }

?>
