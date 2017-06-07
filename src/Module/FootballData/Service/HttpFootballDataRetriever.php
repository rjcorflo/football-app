<?php

namespace RJ\PronosticApp\Module\FootballData\Service;

use GuzzleHttp\Client;
use RJ\PronosticApp\Module\FootballData\Model\Competition;
use RJ\PronosticApp\Module\FootballData\Model\CompetitionCollection;
use Tebru\Gson\Gson;
use Tebru\PhpType\TypeToken;

/**
 * Get data from football-data.org via REST WS.
 *
 * @package RJ\PronosticApp\Module\FootballData\Service
 */
class HttpFootballDataRetriever implements FootballDataRetriever
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * HttpFootballDataRetriever constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function getLeagueTable($identifier, $matchday = "")
    {
        $leagueTable = $this->client->get("competitions/{$identifier}/leagueTable/?matchday={$matchday}")->getBody();
        return json_decode($leagueTable);
    }

    /**
     * @inheritdoc
     */
    public function getLeagues($year = "")
    {
        $leagues = $this->client->get("competitions/?season={$year}")->getBody();

        $gson = Gson::builder()->build();

        error_log(print_r(json_decode($leagues, true), true));

        $fooObject = $gson->fromJson($leagues, 'array<\RJ\PronosticApp\Module\FootballData\Model\Competition>');

        return $fooObject;
    }

    /**
     * @inheritdoc
     */
    public function getLeagueTeams($identifier)
    {
        $leagueTeams = $this->client->get("competitions/{$identifier}/teams")->getBody();
        return json_decode($leagueTeams);
    }

    /**
     * @inheritdoc
     */
    public function getLeagueFixtures($identifier, $matchday = "", $timeFrame = "")
    {
        $leagueFixtures = $this->client
            ->get("competitions/{$identifier}/fixtures/?matchday={$matchday}&timeFrame={$timeFrame}")
            ->getBody();
        return json_decode($leagueFixtures);
    }

    /**
     * @inheritdoc
     */
    public function getFixture($identifier, $head = "")
    {
        $fixture = $this->client->get("fixtures/{$identifier}/?head2head={$head}")->getBody();
        return json_decode($fixture);
    }

    /**
     * @inheritdoc
     */
    public function getFixturesOfSet($leagueCode = "", $timeFrame = "")
    {
        $fixtures = $this->client->get("fixtures/?leagueCode={$leagueCode}&timeFrame={$timeFrame}")->getBody();
        return json_decode($fixtures);
    }

    /**
     * @inheritdoc
     */
    public function getTeamFixtures($identifier, $season = "", $timeFrame = "", $venue = "")
    {
        $teamFixtures = $this->client
            ->get("teams/{$identifier}/fixtures/?season={$season}&timeFrame={$timeFrame}&venue={$venue}")
            ->getBody();
        return json_decode($teamFixtures);
    }

    /**
     * @inheritdoc
     */
    public function getTeam($identifier)
    {
        $team = $this->client->get("teams/{$identifier}")->getBody();
        return json_decode($team);
    }

    /**
     * @inheritdoc
     */
    public function getTeamPlayers($identifier)
    {
        $players = $this->client->get("teams/{$identifier}/players")->getBody();
        return json_decode($players);
    }
}
