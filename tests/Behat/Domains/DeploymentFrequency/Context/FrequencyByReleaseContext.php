<?php

declare(strict_types=1);

namespace App\Tests\Behat\Domains\DeploymentFrequency\Context;

use App\Domains\DeploymentFrequency\Domain\ValueObjects\Author;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\DeploymentTime;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseId;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\ReleaseName;
use App\Domains\DeploymentFrequency\Domain\ValueObjects\RepositoryName;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domains\DeploymentFrequency\Domain\Deployment;

final class FrequencyByReleaseContext extends AbstractContext implements Context
{
    private ?Response $response;

    private string $requestPayload;
    private array $requestHeaders;

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

    /**
     * @Given There are stored Deployments with data:
     */
    public function thereAreStoredDeploymentsWithData(TableNode $table)
    {
        $rows = $table->getIterator();
        //$headers = array_shift($rows);

        foreach ($rows as $index => $row) {
            $deployment = Deployment::create(
                DeploymentTime::fromString($row['DeploymentTime']),
                RepositoryName::toString($row['RepositoryName']),
                Author::toString($row['Author']),
                ReleaseId::toString($row['ReleaseId']),
                ReleaseName::toString($row['ReleaseName'])
            );

            $this->deploymentRepository->save($deployment);
        }
    }
}
