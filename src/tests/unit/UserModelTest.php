<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\BaseResult;

use App\Models\UserModel;

/**
 * Should NOT touch Database
 */
class UserModelTest extends CIUnitTestCase {

    public $mockDatabaseConnection;
    private $userModel;

    public function __construct() {
        parent::__construct();

        $this->mockDatabaseConnection = $this->getMockBuilder(BaseConnection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->userModel = new UserModel($this->mockDatabaseConnection);
    }

    /**
     * @test
     */
    public function shouldFindAndDeleteUserUsingValidId() {

        $userId = 1;
        $expectedNumberOfRowInFindResult = 1;

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
            ->will($this->returnValue(true));

        // Should test ONLY this method
        $isUserFound = $this->userModel->findAndDelete($userId);

        $this->assertTrue($isUserFound);
    }
}