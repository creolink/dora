<?php

declare(strict_types=1);

namespace App\Tests\Behat\Domains\DeploymentFrequency\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class FrequencyByReleaseContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    private string $requestPayload;
    private array $requestHeaders;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given the :arg1 request header contains :arg2
     */
    public function theRequestHeaderContains($name, $value)
    {
        $this->requestHeaders[$name] = $value;
    }

    /**
     * @Given the request body is:
     */
    public function theRequestBodyIs(PyStringNode $string)
    {
        $this->requestPayload = $string->getRaw();
    }

    /**
     * @When I request :path using HTTP :method with the given json payload
     * @When I send a :method request to :path with the given json payload
     * @When I send a :method request to :path with the given json :payload:
     */
    public function iRequestUsingHttpPostWithGivenBody(string $path, string $method, ?string $payload = null)
    {
        $body = $this->requestPayload;

        if (null !== $payload) {
            $body = $payload;
        }

        $this->response = $this->kernel->handle(
            Request::create($path, $method, json_decode($body, true))
        );
    }

    /**
     * @When I request :path using HTTP :method
     * @When I send a :method request to :path
     */
    public function iRequestUsingHttpPost(string $path, string $method)
    {
        $this->response = $this->kernel->handle(
            Request::create($path, $method)
        );
    }

    /**
     * @Then the response code is :code
     */
    public function theResponseCodeIs(int $code)
    {
        Assert::assertEquals($code, $this->response->getStatusCode());
    }

    /**
     *  @Then the response is equal to:
     */
    public function theResponseIsEqualTo(PyStringNode $payload)
    {
        Assert::assertEquals(
            json_decode($payload->getRaw()),
            json_decode($this->response->getContent())
        );
    }
}
