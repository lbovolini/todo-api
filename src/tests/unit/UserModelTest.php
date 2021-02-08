<?php

declare(strict_types=1);

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\BaseResult;

use App\Models\UserModel;

/**
 * Should NOT touch Database
 */
class UserModelTest extends CIUnitTestCase {

    private string $userTable = 'users';

    private UserModel $userModel;
    private BaseConnection $mockDatabaseConnection;
    private BaseResult $resultMock;

    protected function setUp(): void {

        parent::setUp();

        $this->mockDatabaseConnection = $this->getMockBuilder(BaseConnection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userModel = new UserModel($this->mockDatabaseConnection);

        $this->resultMock = $this->getMockBuilder(BaseResult::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void {

        parent::tearDown();

        unset($this->mockDatabaseConnection);
        unset($this->userModel);    
        unset($this->resultMock);    
    }

    // findAndDelete method test cases

    /**
     * @test
     */
    public function shouldFindAndDeleteUserUsingValidId(): void {

        $userId = 1;
        $expectedNumberOfRowInFindResult = 1;
        $expectedTransactionStatus = true;

        // Query Result Mock behaviors
        $this->resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->exactly(2))
            ->method('query')
            ->will($this->returnValue($this->resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndDelete($userId);

        $this->assertTrue($isUserFound);
    }

    /**
     * @test
     */
    public function shouldNotFindAndDeleteUserUsingId(): void {

        $userId = 2;
        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = true;

        // Query Result Mock behaviors
        $this->resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndDelete($userId);

        $this->assertFalse($isUserFound);
    }

    /**
     * @test
     */
    public function shouldThrowRuntimeExceptionWhenFindAndDeleteTransactionFails(): void {

        $userId = 1;
        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = false;

        // Query Result Mock behaviors
        $this->resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Assertions
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Error executing delete query in {$this->userTable} table");

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndDelete($userId);
    }

    // findAndUpdate method test cases

    /**
     * @test
     */
    public function shouldFindAndUpdateUsingValidId(): void {

        $expectedNumberOfRowInFindResult = 1;
        $expectedTransactionStatus = true;

        $userData = [
            'id' => 1,
            'first_name' => 'Lucas',
            'last_name' => 'Bovolini',
            'email' => 'lbovolini94@gmail.com',
            'username' => 'lbovolini',
            'password' => 'pass11word',
            'birthday' => '1994/07/18'
        ];

        // Query Result Mock behaviors
        $this->resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->exactly(2))
            ->method('query')
            ->will($this->returnValue($this->resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndUpdate($userData);

        $this->assertTrue($isUserFound);
    }

    /**
     * @test
     */
    public function shouldNotFindAndUpdateUserUsingId(): void {

        $userId = 2;
        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = true;

        $userData = [
            'id' => 1,
            'first_name' => 'Lucas',
            'last_name' => 'Bovolini',
            'email' => 'lbovolini94@gmail.com',
            'username' => 'lbovolini',
            'password' => 'pass11word',
            'birthday' => '1994/07/18'
        ];

        // Query Result Mock behaviors
        $this->resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndUpdate($userData);

        $this->assertFalse($isUserFound);
    }

        /**
     * @test
     */
    public function shouldThrowRuntimeExceptionWhenFindAndUpdateTransactionFails(): void {

        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = false;

        $userData = [
            'id' => 1,
            'first_name' => 'Lucas',
            'last_name' => 'Bovolini',
            'email' => 'lbovolini94@gmail.com',
            'username' => 'lbovolini',
            'password' => 'pass11word',
            'birthday' => '1994/07/18'
        ];

        // Query Result Mock behaviors
        $this->resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Assertions
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Error executing update query in {$this->userTable} table");

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndUpdate($userData);
    }
}