
Feature:
    It tests the deploment frequency metric collected from github releases

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