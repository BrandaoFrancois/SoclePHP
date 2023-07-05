<?php
/*
 *
 * The manager of user session.
 * Care: The class doesn't test the values passed ! Test them before !
 *
 */

define ('USERMANAGER_NO_ERROR', 0);
define ('USERMANAGER_ERROR_', 1);
define ('USERMANAGER_ERROR_LOGIN_ALREADY_USED', 2);

class UserManager {
     
    private static $user = null;

    public static function init() {
        if (isset($_SESSION[SESSION_KEY_USERMANAGER])) {
            self::$user = User::FromArray($_SESSION[SESSION_KEY_USERMANAGER]);
        }
    }
     
    public static function isConnected() {
        return self::$user != null;
    }
     
    public static function getUserInformation() {
        return self::$user;
    }

    public static function login(&$email, &$password) {
        $db = Db::getAdapter(DATABASE_USERMANAGER);
        $encryptedPassword = self::encryptPassword($password);
        $user = User::getFromLoginAndPassword($db, $email, $encryptedPassword);
        if ($user === null) {
            return false;
        }
        self::$user = $user;
        $_SESSION[SESSION_KEY_USERMANAGER] = $user->toArray();
        return true;
    }

    public static function logout() {
        if (isset($_SESSION[SESSION_KEY_USERMANAGER])) {
            unset($_SESSION[SESSION_KEY_USERMANAGER]);
        }
        self::$user = null;
    }

    public static function register(&$user, &$password) {
        $db = Db::getAdapter(DATABASE_USERMANAGER);
        // Test if the login is already used
        if (User::isLoginInDB($user->login)) {
            return USERMANAGER_ERROR_LOGIN_ALREADY_USED;
        }
         
        // Encrypt the password
        $encryptedPassword = self::encryptPassword($password);
         
        // Register
        return $user->create($db, $encryptedPassword) ? USERMANAGER_NO_ERROR : USERMANAGER_ERROR;
    }

    public static function generatePasswordRecoveryKey(&$login) {
        $generatedRecoveryKey = self::generateRecoveryKey();

        // Get timestamp
        $timestamp = new DateTimeImmutable()->getTimestamp();

        if (User::updateRecoveryKey($login, $generatedRecoveryKey, $timestamp)) {
            return false;
        }
        return $generatedRecoveryKey;
    }

    public static function updatePasswordFromPassword(&$login, &$oldPassword, &$newPassword) {
        $db = Db::getAdapter(DATABASE_USERMANAGER);

        // Encrypt the passwords
        $oldPasswordEncrypted = self::encryptPassword(oldPassword);
        $newPasswordEncrypted = self::encryptPassword(newPassword);

        $user = User::getFromLoginAndPassword($login, $oldPasswordEncrypted);
        if ($user === null) {
            return false;
        }
        return $user->updatePassword($db, $newPasswordEncrypted);
    }

    public static function updatePasswordFromRecoveryKey(&$login, &$recoveryKey, &$newPassword) {
        $db = Db::getAdapter(DATABASE_USERMANAGER);

        // Get timestamp
        $timestamp = new DateTimeImmutable()->getTimestamp();
        
        $user = User::getFromLoginAndRecoveryKey($login, $recoveryKey, $timestamp);
        if ($user === null) {
            return false;
        }

        // Encrypt the password
        $newPasswordEncrypted = self::encryptPassword(newPassword);

        return $user->updatePassword($db, $newPasswordEncrypted);
    }

    private static function encryptPassword(&$password) {
        $passwordPeppered = hash_hmac('sha256', $password, SECURITY_PEPPER);
        if (IS_ARGON2_AVAILABLE === 1) {
            return password_hash($passwordPeppered, PASSWORD_ARGON2ID);
        } else {
            return password_hash($passwordPeppered, PASSWORD_DEFAULT);
        }
    }

    private static function generateRecoveryKey() {
        return rand()&0xFFFF;
    }
}
?>
