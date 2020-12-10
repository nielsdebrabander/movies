<?php

    class AuthController {

        protected \Doctrine\DBAL\Connection $db;
        protected \Twig\Environment $twig;

        private string $email;
        private string $password;

        public function __construct () {
            // Bootstrap Twig
            $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
            $this->twig = new \Twig\Environment($loader);

            // Database connection
            require_once __DIR__ . '/../../config/database.php';
            $connectionParams = [
                'host' => DB_HOST,
                'dbname' => DB_NAME,
                'user' => DB_USER_NAME,
                'password' => DB_PASS,
                'driver' => 'pdo_mysql',
                'charset' => 'utf8mb4'
            ];

            try {
                $this->db = $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
                $result = $connection->connect();
            }
            catch (\Doctrine\DBAL\Exception $exception) {
                $connection = null;
                echo $exception;
            }

            // Get the post data
            $this->email = isset($_POST['email']) ? $_POST['email'] : '';
            $this->password = isset($_POST['password']) ? $_POST['password'] : '';
        }

        public function showLogin () {
            try {
                echo $this->twig->render('/pages/login.twig', [
                    'formAction' => '/login',
                    'email' => isset($_COOKIE['mail']) ? $_COOKIE['mail'] : ''
                ]);
            }
            catch (\Twig\Error\LoaderError $e) {
                echo $e;
            }
            catch (\Twig\Error\RuntimeError $e) {
                echo $e;
            }
            catch (\Twig\Error\SyntaxError $e) {
                echo $e;
            }
        }

        public function login () {

            /*
             *  Form check
             */
            if (isset($_POST['moduleAction'])) {
                $ok = true;

                if ($this->email === '') {
                    $ok = false;
                }

                if ($this->password === '') {
                    $ok = false;
                }

                /*
                 *  If everything is ok,perform a login
                 *  Else show the login form with persistence.
                 */
                if ($ok) {
                    try {
                        /*
                         *  Check if the mail address exists in the user table.
                         */
                        $stmtUsr = $this->db->prepare('SELECT * FROM users WHERE email = ?');
                        $stmtUsr->execute([$this->email]);
                        $userMailCheck = $stmtUsr->fetchAllAssociative();

                        if (count($userMailCheck) > 0) {
                            if (count($userMailCheck) === 1) {

                                /*
                                 *  If the correct user is found, verify the passwords.
                                 */
                                $userPassDb = $userMailCheck[0]['password'];
                                if (password_verify($this->password, $userPassDb)) {
                                    /*
                                     *  If the passwords match, store some info in the session.
                                     */
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['user'] = $userMailCheck;

                                    /*
                                     *  Check if this is the first login
                                     */
                                    $stmt = $this->db->prepare('SELECT first_login FROM users WHERE id = ?');
                                    $stmt->execute([$_SESSION['user'][0]['id']]);
                                    $first_login = $stmt->fetchOne();
                                    var_dump($first_login);

                                    $zone = new DateTimeZone('Europe/Brussels');
                                    $todayObj = new DateTime('now', $zone);
                                    $today = $todayObj->format('Y-m-d H:i:s');
                                    if ($first_login === null) {
                                        $stmt = $this->db->prepare('UPDATE users SET first_login = ?, last_login = ? WHERE id = ?');
                                        $stmt->execute([$today, $today, $_SESSION['user'][0]['id']]);
                                    }
                                    else {
                                        $stmt = $this->db->prepare('UPDATE users SET last_login = ? WHERE id = ?');
                                        $stmt->execute([$today, $_SESSION['user'][0]['id']]);
                                    }

                                    /*
                                     *  Check if the mail address needs to be remembered
                                     */
                                    if (isset($_POST['remember'])) {
                                        if (!isset($_COOKIE['mail'])) {
                                            setcookie('mail', $this->email, time() + 24*60*60*7*4*6);
                                        }
                                        else {
                                            setcookie('mail', $this->email, time() - 24*60*60*7*4*6);
                                            setcookie('mail', $this->email, time() + 24*60*60*7*4*6);
                                        }
                                    }

                                    /*
                                     *  If everything is saved to the session, redirect.
                                     */
                                    header('location: /dashboard/companies');
                                    exit();
                                }
                                else {
                                    try {
                                        echo $this->twig->render('/pages/login.twig', [
                                            'formAction' => '/login',
                                            'email' => $this->email,
                                            'message' => 'There might something wrong with your e-mailadress and/or password'
                                        ]);
                                    }
                                    catch (\Twig\Error\LoaderError $e) {
                                    }
                                    catch (\Twig\Error\RuntimeError $e) {
                                    }
                                    catch (\Twig\Error\SyntaxError $e) {
                                    }
                                }
                            }
                            else {
                                try {
                                    echo $this->twig->render('/pages/login.twig', [
                                        'formAction' => '/login',
                                        'email' => $this->email,
                                        'message' => 'Something went wrong with the database',
                                    ]);
                                }
                                catch (\Twig\Error\LoaderError $e) {
                                }
                                catch (\Twig\Error\RuntimeError $e) {
                                }
                                catch (\Twig\Error\SyntaxError $e) {
                                }
                            }
                        }
                        else {
                            try {
                                echo $this->twig->render('/pages/login.twig', [
                                    'formAction' => '/login',
                                    'email' => $this->email,
                                    'message' => 'There might something wrong with your e-mailadress and/or password',
                                ]);
                            }
                            catch (\Twig\Error\LoaderError $e) {
                            }
                            catch (\Twig\Error\RuntimeError $e) {
                            }
                            catch (\Twig\Error\SyntaxError $e) {
                            }
                        }
                    }
                    catch (\Doctrine\DBAL\Exception $e) {
                        echo $e;
                    }
                    catch (\Doctrine\DBAL\Driver\Exception $e) {
                        echo $e;
                    }
                    catch (Exception $e) {
                    }
                }
                else {
                    try {
                        echo $this->twig->render('/pages/login.twig', [
                            'formAction' => '/login',
                            'email' => $this->email,
                            'message' => 'There might something wrong with your e-mailadress and/or password'
                        ]);
                    }
                    catch (\Twig\Error\LoaderError $e) {
                    }
                    catch (\Twig\Error\RuntimeError $e) {
                    }
                    catch (\Twig\Error\SyntaxError $e) {
                    }
                }
            }
        }

        public function logout () {
            /*
             *  Stop the current session
             */
            session_start();
            $_SESSION = [];
            session_destroy();

            /*
             *  Redirect
             */
            header('Location: /login');
            exit();
        }
    }

?>
