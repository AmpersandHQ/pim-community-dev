<?php

namespace Pim\Bundle\ApiBundle\tests\integration\Controller\Product;

use Akeneo\Test\Integration\Configuration;
use Pim\Bundle\CatalogBundle\Version;
use Symfony\Component\HttpFoundation\Response;

class PartialUpdateListProductIntegration extends AbstractProductTestCase
{

    protected $buffer = '';

    public function testPartialUpdateListWithTooLongLines()
    {
        $line = [
            'invalid_json_1'  => str_repeat('a', $this->getBufferSize() - 1),
            'invalid_json_2'  => str_repeat('a', $this->getBufferSize()),
            'invalid_json_3'  => '',
            'line_too_long_1' => '{"identifier":"foo"}' . str_repeat('a', $this->getBufferSize()),
            'line_too_long_2' => '{"identifier":"foo"}' . str_repeat(' ', $this->getBufferSize()),
            'line_too_long_3' => str_repeat('a', $this->getBufferSize() + 1),
            'line_too_long_4' => str_repeat('a', $this->getBufferSize() + 2),
            'line_too_long_5' => str_repeat('a', $this->getBufferSize() * 2),
            'line_too_long_6' => str_repeat('a', $this->getBufferSize() * 5),
            'invalid_json_4'  => str_repeat('a', $this->getBufferSize()),
        ];

        $data =
<<<JSON
${line['invalid_json_1']}
${line['invalid_json_2']}
${line['invalid_json_3']}
${line['line_too_long_1']}
${line['line_too_long_2']}
${line['line_too_long_3']}
${line['line_too_long_4']}
${line['line_too_long_5']}
${line['line_too_long_6']}
${line['invalid_json_4']}
JSON;

        $expectedContent =
<<<JSON
{"message":"Invalid json message received"}
{"message":"Invalid json message received"}
{"message":"Invalid json message received"}
{"message":"Line is too long."}
{"message":"Line is too long."}
{"message":"Line is too long."}
{"message":"Line is too long."}
{"message":"Line is too long."}
{"message":"Line is too long."}
{"message":"Invalid json message received"}

JSON;

        $content = $this->executeStreamRequest('PATCH', 'api/rest/v1/products', [], [], [], $data);

        $this->assertSame($expectedContent, $content);
    }

    public function testCreateAndUpdateSameProduct()
    {
        $data =
<<<JSON
    {"identifier": "my_code"}
    {"identifier": "my_code"}
JSON;

        $expectedContent =
<<<JSON
{"code":201}
{"code":204}

JSON;


        $content = $this->executeStreamRequest('PATCH', 'api/rest/v1/products', [], [], [], $data);

        $this->assertSame($expectedContent, $content);
    }

    protected function getBufferSize()
    {
        return $this->getParameter('api_buffer_size');
    }

    /**
     * Execute a request where the response is streamed by chunk.
     *
     * The whole content of the request and the whole content of the response
     * are loaded in memory.
     * Therefore, do not use this function on with an high volumetry in input or in ouput.
     *
     * @param string $method
     * @param string $uri
     * @param array  $parameters
     * @param array  $files
     * @param array  $server
     * @param null   $content
     * @param bool   $changeHistory
     *
     * @return string
     */
    public function executeStreamRequest($method, $uri, array $parameters = [], array $files = [], array $server = [], $content = null, $changeHistory = true)
    {
        $streamedResponse = '';

        ob_start(function($buffer) use (&$streamedResponse) {
            $streamedResponse .= $buffer;

            return '';
        });

        $client = $this->createAuthenticatedClient();
        $client->setServerParameter('CONTENT_TYPE', 'application/json-stream');
        $client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);

        ob_end_flush();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        return $streamedResponse;
    }

    /**
     * @return Configuration
     */
    protected function getConfiguration()
    {
        return new Configuration(
            [Configuration::getTechnicalCatalogPath()],
            true
        );
    }

}
