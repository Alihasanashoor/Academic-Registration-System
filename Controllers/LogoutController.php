<?php
require_once __DIR__ . '/LoginController.php';

class LogoutController
{
    public static function handle()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Logout'])) {

            $controller = new LoginController();
            $controller->Logout();

            // Logout ends with redirect + exit(), so no further code runs
        }
    }
}
