<?php

namespace Tests\Feature;

use App\DTOs\User\StoreUserDto;
use App\Models\User;
use App\Repository\User\UserRepositoryInterface;
use App\Service\UserService;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    protected UserService $userService;
    protected MockInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // UserRepositoryInterface 모킹
        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);

        // UserService 인스턴스 생성 (모킹된 레포지토리 주입)
        $this->userService = new UserService($this->userRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_store_user_creates_and_returns_user()
    {
        // 테스트 데이터 준비
        $userDto = new StoreUserDto(
            name: 'TEST',
            email: 'test@test.com',
            password: '123456',
        );

        $expectedUser = new User([
            'id' => 1,
            'name' => 'TEST',
            'email' => 'test@test.com'
        ]);

        // 모킹된 레포지토리의 동작 정의
        $this->userRepository->shouldReceive('create')
            ->once()
            ->with($userDto)
            ->andReturn($expectedUser);

        // 메소드 실행
        $result = $this->userService->storeUser($userDto);

        // 결과 검증
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('TEST', $result->name);
        $this->assertEquals('test@test.com', $result->email);
    }
}
