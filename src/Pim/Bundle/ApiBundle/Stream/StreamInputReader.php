<?php

namespace Pim\Bundle\ApiBundle\Stream;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Read the php input as a stream and handle each line as the content of the subrequest to an action.
 * Each line of the stream should represent the standard format of the entity to process.
 *
 * The response will be returned as a stream, each line corresponding to the response of each subrequest.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ProductUpdateStreamer
{

    /**
     */
    public function __construct()
    {

    }

    public function execute(Request $request)
    {
        $this->streamInputToFile($request);

        $response->setCallback(function() use ($request) {
            $streamContent = $request->getContent(true);

            $line = true;
            do {
                try {
                    $line = $this->readInputBuffer($streamContent);
                    if (false === $line) {
                        continue;
                    }
                    $data = $this->getDecodedContent($line);

                    if (!isset($data['identifier'])) {
                        throw new UnprocessableEntityHttpException('Identifier is missing');
                    }
                    $subRequest = new Request([], [], [], [], [], [], $line);
                    $subRequest->setRequestFormat('json');
                    $subRequest->attributes->add([
                        '_controller' => 'pim_api.controller.product:partialUpdateAction',
                        'code'        => $data['identifier'],
                    ]);

                    $subResponse = $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);

                    $this->uniqueValuesSet->reset();

                    if ('' !== $subResponse->getContent()) {
                        $response = ['identifier' => $data['identifier']] + json_decode($subResponse->getContent(), true);
                    } else {
                        $response = ['identifier' => $data['identifier'],  'code' => $subResponse->getStatusCode()];
                    }
                } catch (HttpException $e) {
                    $response = ['code' => $e->getStatusCode(), 'message' => $e->getMessage()];
                }

                $this->flushOutputBuffer($response);
            } while (false !== $line);

        });
    }

    /**
     * Get the JSON decoded content. If the content is not a valid JSON, it throws an error 400.
     *
     * @param string $content content of a request to decode
     *
     * @throws BadRequestHttpException
     *
     * @return array
     */
    protected function getDecodedContent($content)
    {
        $decodedContent = json_decode($content, true);

        if (null === $decodedContent) {
            throw new BadRequestHttpException('Invalid json message received');
        }

        return $decodedContent;
    }

    /**
     * Read a line from a stream.
     * If the line is too long fot the buffer, consume the rest of the line
     * and throws an error 400.
     *
     * @param $streamContent
     *
     * @throws BadRequestHttpException
     * @return string
     */
    protected function readInputBuffer($streamContent)
    {
        $buffer = stream_get_line($streamContent, $this->bufferSize + 1, PHP_EOL);
        $bufferSizeExceeded = strlen($buffer) > $this->bufferSize;

        while (strlen($buffer) > $this->bufferSize) {
            $buffer = stream_get_line($streamContent, $this->bufferSize + 1, PHP_EOL);
        }

        if ($bufferSizeExceeded) {
            throw new BadRequestHttpException("Line is too long.");
        }

        return $buffer;
    }

    /**
     * Copy the php input into a file.
     * It avoids to customize the max_input_time parameter in the php configuration
     * and allows more control over the uploaded stream data.
     *
     * @param $request
     *
     * @throws BadRequestHttpException
     *
     * @return string
     */
    protected function streamInputToFile(Request $request)
    {
        $streamInput = $request->getContent(true);

    }
}
