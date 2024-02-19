<?php

namespace Tests\Feature\app\Services;

use App\Services\SqsService;
use Tests\TestCase;

class SqsServiceTest extends TestCase
{
    protected SqsService $sqsService;
    protected function setUp(): void
    {
        parent::setUp();

        $this->sqsService = new SqsService();
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $csvData  = [
            [
                'John Doe',
                '11111111111',
                'johndoe@kanastra.com.br',
                '1000000.00',
                '2022-10-12',
                '1adb6ccf-ff16-467f-bea7-5f05d494280f',
            ],
        ];

        $response = $this->sqsService->send($csvData);

        $this->assertTrue($response);
    }
}
