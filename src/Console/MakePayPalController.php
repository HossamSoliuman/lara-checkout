<?php

namespace Hossam\LaraCheckout\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakePayPalController extends Command
{
    protected $signature = 'checkout:make-controller ';

    protected $description = 'Generate the PayPalController using the stub file.';

    public function handle(Filesystem $filesystem)
    {
        $stubPath = __DIR__ . '/../stubs/PayPalController.stub';
        $controllerPath = app_path("Http/Controllers/Checkout/PayPalController.php");

        $stubContent = $filesystem->get($stubPath);

        $filesystem->put($controllerPath, $stubContent);

        $this->info("Controller created at: {$controllerPath}");
    }
}
