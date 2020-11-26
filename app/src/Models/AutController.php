<?php

    class AutController {
        protected \Twig\Environment $twig;

        public function __construct(){
            $loader = new \Twig\Loader\FilesystemLoader( __DIR__ . '/../../' . 'resources/templates/');
            $twig = new \Twig\Environment($loader);
        }

        public function showLogin(){
            require_once 'login.php';
            try {
                echo $this->twig->render('/pages/login.twig', [

                ]);
            }
            catch (\Twig\Error\LoaderError $e) {
            }
            catch (\Twig\Error\RuntimeError $e) {
            }
            catch (\Twig\Error\SyntaxError $e) {
            }
            exit();
        }

        public function login(){
            require_once 'login.php';
            try {
                echo $this->twig->render('/pages/login.twig', [

                ]);
            }
            catch (\Twig\Error\LoaderError $e) {
            }
            catch (\Twig\Error\RuntimeError $e) {
            }
            catch (\Twig\Error\SyntaxError $e) {
            }
            exit();
        }
    }
    ?>



