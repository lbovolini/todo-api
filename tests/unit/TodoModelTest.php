<?php

declare(strict_types=1);

use App\Models\TodoModel;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\BaseResult;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Should NOT touch Database
 */
class TodoModelTest extends CIUnitTestCase {

    private string $todoTable = 'todos';

    private TodoModel $todoModel;
    private BaseConnection $mockDatabaseConnection;
    private BaseResult $mockResult;

    protected function setUp(): void {

        parent::setUp();

        $this->mockDatabaseConnection = $this->getMockBuilder(BaseConnection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->todoModel = new TodoModel($this->mockDatabaseConnection);

        $this->mockResult = $this->getMockBuilder(BaseResult::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void {

        parent::tearDown();

        unset($this->mockDatabaseConnection);
        unset($this->todoModel);
        unset($this->mockResult);
    }

    // findAndDelete method test cases

    /**
     * @test
     */
    public function shouldFindAndDeleteTodoUsingValidId(): void {

        $todoId = 1;
        $expectedNumberOfRowInFindResult = 1;
        $expectedTransactionStatus = true;

        // Query Result Mock behaviors
        $this->mockResult->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->exactly(2))
            ->method('query')
            ->will($this->returnValue($this->mockResult));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isTodoFound = $this->todoModel->findAndDelete($todoId);

        $this->assertTrue($isTodoFound);
    }

    /**
     * @test
     */
    public function shouldNotFindAndDeleteTodoUsingId(): void {

        $todoId = 2;
        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = true;

        // Query Result Mock behaviors
        $this->mockResult->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->mockResult));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isTodoFound = $this->todoModel->findAndDelete($todoId);

        $this->assertFalse($isTodoFound);
    }


    /**
     * @test
     */
    public function shouldThrowRuntimeExceptionWhenFindAndDeleteTransactionFails(): void {

        $todoId = 1;
        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = false;

        // Query Result Mock behaviors
        $this->mockResult->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->mockResult));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Assertions
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Error executing delete query in {$this->todoTable} table");

        // Should test ONLY this method
        $this->todoModel->findAndDelete($todoId);
    }

    // findAndUpdate method test cases

    /**
     * @test
     */
    public function shouldFindAndUpdateUsingValidId(): void {

        $expectedNumberOfRowInFindResult = 1;
        $expectedTransactionStatus = true;

        $todoData = [
            'id' => 1,
            'users_id' => 1
        ];

        // Query Result Mock behaviors
        $this->mockResult->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->exactly(2))
            ->method('query')
            ->will($this->returnValue($this->mockResult));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isTodoFound = $this->todoModel->findAndUpdate($todoData);

        $this->assertTrue($isTodoFound);
    }

    /**
     * @test
     */
    public function shouldNotFindAndUpdateUserUsingId(): void {

        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = true;

        $todoData = [
            'id' => 1,
            'users_id' => 1
        ];

        // Query Result Mock behaviors
        $this->mockResult->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->mockResult));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Should test ONLY this method
        $isTodoFound = $this->todoModel->findAndUpdate($todoData);

        $this->assertFalse($isTodoFound);
    }

    /**
     * @test
     */
    public function shouldThrowRuntimeExceptionWhenFindAndUpdateTransactionFails(): void {

        $expectedNumberOfRowInFindResult = 0;
        $expectedTransactionStatus = false;

        $todoData = [
            'id' => 1,
            'users_id' => 1
        ];

        // Query Result Mock behaviors
        $this->mockResult->expects($this->once())
            ->method('getNumRows')
            ->will($this->returnValue($expectedNumberOfRowInFindResult));

        // Database Connection Mock behaviors
        $this->mockDatabaseConnection->expects($this->once())
            ->method('query')
            ->will($this->returnValue($this->mockResult));

        $this->mockDatabaseConnection->expects($this->once())
            ->method('transStatus')
            ->will($this->returnValue($expectedTransactionStatus));

        // Assertions
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Error executing update query in {$this->todoTable} table");

        // Should test ONLY this method
        $this->todoModel->findAndUpdate($todoData);
    }
}