<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('/Service');

        if (!File::exists($servicePath)) {
            File::makeDirectory($servicePath, 0755, true);
        }

        $serviceName = str_replace('\\', '/', $name);
        $serviceNamespace = str_replace('/', '\\', dirname($name));
        $className = basename($name);

        $path = $servicePath . '/' . $serviceName . '.php';
        $directory = dirname($path);

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $namespace = 'App\\Service';
        if ($serviceNamespace !== '.') {
            $namespace .= '\\' . $serviceNamespace;
        }

        // 서비스 클래스 템플릿 생성
        $stub = <<<EOT
<?php

namespace {$namespace};

class {$className}
{
    public function __construct()
    {
        //
    }
}
EOT;

        // 파일 작성
        File::put($path, $stub);

        $this->info('Service class created successfully: ' . $name);
    }
}
