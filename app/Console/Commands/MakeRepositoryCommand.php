<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    protected $signature = 'make:repository {name : The name of the repository}';
    protected $description = 'Create a new repository class with interface';

    public function handle()
    {
        $name = $this->argument('name');
        $repositoryPath = app_path('Repository');

        // Repository 디렉토리가 없으면 생성
        if (!File::exists($repositoryPath)) {
            File::makeDirectory($repositoryPath, 0755, true);
        }

        // 네임스페이스를 고려한 경로 처리
        $repositoryName = str_replace('\\', '/', $name) . 'Repository';
        $repositoryNamespace = str_replace('/', '\\', dirname($name));
        $className = basename($repositoryName);

        $interfacePath = $repositoryPath . '/' . $repositoryName . 'Interface.php';
        $classPath = $repositoryPath . '/' . $repositoryName . '.php';

        $directory = dirname($interfacePath);

        // 디렉토리가 없으면 생성
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // 네임스페이스 처리
        $namespace = 'App\\Repository';
        if ($repositoryNamespace !== '.') {
            $namespace .= '\\' . $repositoryNamespace;
        }

        // 인터페이스 템플릿 생성
        $interfaceStub = <<<EOT
<?php

namespace {$namespace};

interface {$className}Interface
{
    //
}
EOT;

        // 클래스 템플릿 생성
        $classStub = <<<EOT
<?php

namespace {$namespace};

use App\\Repository\\BaseRepository;

class {$className} extends BaseRepository implements {$className}Interface
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
EOT;

        // 파일 작성
        File::put($interfacePath, $interfaceStub);
        File::put($classPath, $classStub);

        $this->info('Repository created successfully:');
        $this->info('- ' . $name . 'Interface');
        $this->info('- ' . $name);

        $this->addBindingToServiceProvider($namespace, $className);
    }

    protected function addBindingToServiceProvider($namespace, $className)
    {
        $providerPath = app_path('Providers/AppServiceProvider.php');

        if (File::exists($providerPath)) {
            $providerContent = File::get($providerPath);

            // 인터페이스와 클래스의 전체 네임스페이스 경로
            $interfaceClass = "{$namespace}\\{$className}Interface";
            $repositoryClass = "{$namespace}\\{$className}";

            // 이미 바인딩이 있는지 확인
            if (Str::contains($providerContent, $interfaceClass)) {
                $this->warn("Binding for {$className}Interface already exists in AppServiceProvider.");
                return;
            }

            // register 메소드 찾기
            $pattern = '/public\s+function\s+register\(\)[^{]*\{/';
            preg_match($pattern, $providerContent, $matches, PREG_OFFSET_CAPTURE);

            if (empty($matches)) {
                $this->error('Could not find register method in AppServiceProvider.');
                return;
            }

            // register 메소드 내부의 닫는 중괄호 위치 찾기
            $registerStart = $matches[0][1];
            $registerContentStart = $registerStart + strlen($matches[0][0]);

            // 중괄호 균형을 맞추어 register 메소드의 끝 찾기
            $braceCount = 1;
            $registerEnd = $registerContentStart;

            for ($i = $registerContentStart; $i < strlen($providerContent); $i++) {
                if ($providerContent[$i] === '{') {
                    $braceCount++;
                } elseif ($providerContent[$i] === '}') {
                    $braceCount--;
                    if ($braceCount === 0) {
                        $registerEnd = $i;
                        break;
                    }
                }
            }

            // 바인딩 코드 추가
            $bindingCode = "    \$this->app->bind({$className}Interface::class, {$className}::class);\n    ";

            // use 문 추가 여부 확인
            if (!Str::contains($providerContent, "use {$interfaceClass};")) {
                $useStatements = "use {$interfaceClass};\nuse {$repositoryClass};";

                // namespace 선언 후에 use 문 추가
                $namespacePos = strpos($providerContent, 'namespace App\Providers;');
                $namespaceEnd = strpos($providerContent, ';', $namespacePos) + 1;
                $afterNamespace = $namespaceEnd + 1;

                // use 문 삽입
                $providerContent = substr_replace($providerContent, "\n{$useStatements}", $afterNamespace, 0);

                // register 메소드 위치 재조정 (use 문이 추가되어 위치가 바뀌었기 때문)
                $registerStart += strlen("\n{$useStatements}");
                $registerEnd += strlen("\n{$useStatements}");
            }

            // register 메소드 닫는 중괄호 직전에 바인딩 코드 추가
            $newContent = substr_replace($providerContent, $bindingCode, $registerEnd, 0);

            // 파일 저장
            File::put($providerPath, $newContent);

            $this->info("Binding added to AppServiceProvider for {$className}Interface.");
        } else {
            $this->error('AppServiceProvider.php not found.');
        }
    }
}