<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\BaseResult;

use App\Models\UserModel;

/**
 * Should NOT touch Database
 */
class UserModelTest extends CIUnitTestCase {

    private $mockDatabaseConnection;
    private $userModel;
    private $userTable = 'users';

    public function __construct() {
        parent::__construct();

        $this->mockDatabaseConnection = $this->getMockBuilder(BaseConnection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->userModel = new UserModel($this->mockDatabaseConnection);
    }

    // findAndDelete method test cases

    /**
     * @test
     */
    public function shouldFindAndDeleteUserUsingValidId() {

        $userId = 1;
        $expectedNumberOfRowInFindResult = 1;
        $expectedTransactionStatus = true;

        // Query Result Mock
        $resultMock = $this->getMockBuilder(BaseResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Query Result Mock behaviors
        $resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->exactly(2))
            ->method('query')
            ->will($this->returnValue($resultMock));

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
    public function shouldNotFindAndDeleteUserUsingId() {

        $userId = 2;
        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = true;

        // Query Result Mock
        $resultMock = $this->getMockBuilder(BaseResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Query Result Mock behaviors
        $resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($resultMock));

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
    public function shouldThrowRuntimeExceptionWhenFindAndDeleteTransactionFails() {

        $userId = 1;
        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = false;

        // Query Result Mock
        $resultMock = $this->getMockBuilder(BaseResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Query Result Mock behaviors
        $resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($resultMock));

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
    public function shouldFindAndUpdateUsingValidId() {

        $expectedNumberOfRowInFindResult = 1;
        $expectedTransactionStatus = true;

        $userData = new StdClass();
        $userData->id = 1;
        $userData->first_name = 'Lucas';
        $userData->last_name = 'Bovolini';
        $userData->email = 'lbovolini94@gmail.com';
        $userData->username = 'lbovolini';
        $userData->password = 'pass11word';
        $userData->birthday = '1994/07/18';

        // Query Result Mock
        $resultMock = $this->getMockBuilder(BaseResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Query Result Mock behaviors
        $resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->exactly(2))
            ->method('query')
            ->will($this->returnValue($resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndUpdate($userData->id, $userData);

        $this->assertTrue($isUserFound);
    }

    /**
     * @test
     */
    public function shouldNotFindAndUpdateUserUsingId() {

        $userId = 2;
        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = true;

        $userData = new StdClass();
        $userData->id = 1;
        $userData->first_name = 'Lucas';
        $userData->last_name = 'Bovolini';
        $userData->email = 'lbovolini94@gmail.com';
        $userData->username = 'lbovolini';
        $userData->password = 'pass11word';
        $userData->birthday = '1994/07/18';

        // Query Result Mock
        $resultMock = $this->getMockBuilder(BaseResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Query Result Mock behaviors
        $resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndUpdate($userId, $userData);

        $this->assertFalse($isUserFound);
    }

        /**
     * @test
     */
    public function shouldThrowRuntimeExceptionWhenFindAndUpdateTransactionFails() {

        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = false;

        $userData = new StdClass();
        $userData->id = 1;
        $userData->first_name = 'Lucas';
        $userData->last_name = 'Bovolini';
        $userData->email = 'lbovolini94@gmail.com';
        $userData->username = 'lbovolini';
        $userData->password = 'pass11word';
        $userData->birthday = '1994/07/18';

        // Query Result Mock
        $resultMock = $this->getMockBuilder(BaseResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Query Result Mock behaviors
        $resultMock->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($resultMock));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Assertions
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Error executing update query in {$this->userTable} table");

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndUpdate($userData->id, $userData);
    }
}