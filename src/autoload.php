<?php
/**
 * Forp PSR-0 autoloader
 */
spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    if (0 != strpos($className, 'Forp')) {
        return false;
    }
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName = __DIR__ . DIRECTORY_SEPARATOR . $fileName . $className . '.php';
    if (is_file($fileName)) {
        require $fileName;
        return true;
    }

    return false;
});