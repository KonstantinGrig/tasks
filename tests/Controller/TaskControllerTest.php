<?php


namespace App\Tests\Controller;


use PHPUnit\Framework\TestCase;

class TaskControllerTest extends TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'http://demo1.loc'
        ]);
    }

    public function testPostTask()
    {
        $response = $this->client->post('/task', [
            'json' => [
                'userName'    => "Jon",
                'email'     => 'jon@example.com'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostTaskErrorJson()
    {
        $response = $this->client->post('/task', [
            'body' => 'error Json'
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostTaskErrorValidation()
    {
        $response = $this->client->post('/task', [
            'json' => [
                'userName'    => "J on",
                'email'     => 'jon example.com'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $body = (string)$response->getBody();
        $this->assertContains("errors", $body);
        $this->assertContains("userName", $body);
        $this->assertContains("email", $body);
    }

}
