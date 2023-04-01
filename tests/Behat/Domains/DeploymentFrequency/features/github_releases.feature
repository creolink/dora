
Feature:
    It tests the deploment frequency metric collected from github releases

    @initData
    Scenario: End-to-End test from collection up to metric calculation
        Given the "Content-Type" request header contains "application/json"
        And the request body is:
        """
        {
          "action": "released",
          "release": {
            "id": 96939175,
            "author": {
              "login": "creolink"
            },
            "tag_name": "v0.0.1",
            "name": "Release 0.0.1",
            "draft": false,
            "prerelease": false,
            "created_at": "2018-04-13T14:23:20Z",
            "published_at": "2023-03-26T15:45:23Z"
          },
          "repository": {
            "name": "microservices",
            "full_name": "creolink/microservices",
            "private": false
          }
        }
        """
        When I request "/payload" using HTTP POST with the given json payload
        Then the response code is 201
        When I send a GET request to "/metric/microservices?timeRangeDays=90"
        Then the response code is 200
        And the response is equal to:
        """
        {
          "repository":"microservices",
          "from":"01/01/2023",
          "to":"01/04/2023",
          "duration_in_days":90,
          "score":0.01
        }
        """

    @initData
    Scenario: Calculation of metric for stored deployments
        Given There are stored Deployments with data:
        |    DeploymentTime    | RepositoryName | Author | ReleaseId |  ReleaseName  |
        | 2023-02-28T15:45:23Z | microservices  | Bor    | 96939171  | Release 0.0.1 |
        | 2023-03-26T15:45:23Z | microservices  | Foo    | 96939175  | Release 0.0.2 |
        | 2023-03-27T16:45:23Z | microservices  | Bar    | 96939176  | Release 0.0.3 |
        | 2023-03-28T12:45:23Z | microservices  | Qux    | 96939177  | Release 0.0.4 |
        | 2023-03-29T10:45:23Z | microservices  | Fux    | 96939178  | Release 0.0.5 |
        | 2023-03-31T08:45:23Z | microservices  | Bax    | 96939179  | Release 0.0.6 |
        When I send a GET request to "/metric/microservices?timeRangeDays=10"
        Then the response code is 200
        And the response is equal to:
        """
        {
          "repository":"microservices",
          "from":"22/03/2023",
          "to":"01/04/2023",
          "duration_in_days":10,
          "score":0.5
        }
        """