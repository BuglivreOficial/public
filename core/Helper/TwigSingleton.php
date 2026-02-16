<?php
namespace Core\Helper;

/**
 * Código gerado por IA
 */
class TwigSingleton
{
    private static $instance;
    private $twigEnvironment;

    private function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('layout/');
        $this->twigEnvironment = new \Twig\Environment($loader, [
            'cache' => false, // Configure cache path
        ]);
    // Add custom extensions, filters, etc. here if needed
    }

    public static function getInstance(): TwigSingleton
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getEnvironment(): \Twig\Environment
    {
        return $this->twigEnvironment;
    }

    private function __clone()
    {
    }
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}