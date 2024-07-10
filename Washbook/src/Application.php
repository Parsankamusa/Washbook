<?php
namespace Simcify;

use Dotenv\Dotenv;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use DI\ContainerBuilder;
use function DI\create as dicreate;
use function DI\factory;
use function DI\get;

class Application {

    /**
     * Initialise the application
     * 
     * @return  void
     */
    public function __construct() {
        $this->_loadEnv();
        $this->_makeContainer();
    }
    
    /**
     * Destroy the application
     * 
     * @return void
     */
    public function __destruct() {
        container(PDO::class, 0);
    }

    /**
     * Load environment variables
     * 
     * @return  void
     */
    protected function _loadEnv() {
        // Load the environment variables
        $dotenv = \Dotenv\Dotenv::createUnsafeImmutable(str_replace("src/", "", dirname(__DIR__)));
        $dotenv->load();
    }

    /**
     * Load environment variables
     * 
     * @return  \DI\Container
     */
    protected static function _makeContainer() {
        $config = Config::cache();
        $dbConfig = $config['database'];
        // Create our new php-di container
        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->addDefinitions([
            'config' => $config,
            PDO::class => dicreate()->constructor(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']}",
                $dbConfig['username'],
                $dbConfig['password'],
                ['ATTR_DEFAULT_FETCH_MODE' => PDO::FETCH_OBJ]
            ),
            PHPMailer::class    => dicreate()->constructor(true),
            'Simcify\Mailer'    => factory(function($mail) {
                $mail->SMTPDebug = 0;
                if (env("SMTP_AUTH")) {
                    $mail->isSMTP();
                }
                $mail->Host = env('SMTP_HOST');
                $mail->SMTPAuth = env("SMTP_AUTH");
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('SMTP_PASSWORD');
                $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                $mail->Port = env('SMTP_PORT');
                return $mail;
            })->parameter('mail', get('PHPMailer\PHPMailer\PHPMailer')),
            Session::class      => dicreate()
        ]);
        
        Container::setInstance($builder->build());
    }

    /**
     * Handle incoming requests
     * 
     * @return  void
     */
    public function route() {
        /**
         * The default namespace for route-callbacks, so we don't have to specify it each time.
         * Can be overwritten by using the namespace config option on your routes.
         */
        Router::setDefaultNamespace('\Simcify\Controllers');
        // Load application routes
        require_once 'routes.php';
        // Start the application's routing
        Router::start();
    }
}
