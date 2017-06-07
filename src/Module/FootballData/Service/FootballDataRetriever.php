<?php
/**
 * Created by IntelliJ IDEA.
 * User: RJ Corchero
 * Date: 07/06/2017
 * Time: 0:11
 */

namespace RJ\PronosticApp\Module\FootballData\Service;

/**
 * Methods to receive data.
 *
 * @package RJ\PronosticApp\Module\FootballData\Service
 */
interface FootballDataRetriever
{
    /**
     * Get competition/league
     *
     * @param $identifier
     * @param string $matchday
     * @return mixed
     */
    public function getLeagueTable($identifier, $matchday = '');

    /**
     * Get leagues.
     *
     * @param string $year
     * @return mixed
     */
    public function getLeagues($year = '');

    /**
     * Get teams by league.
     *
     * @param $identifier
     * @return mixed
     */
    public function getLeagueTeams($identifier);

    /**
     * Get league fixtures.
     *
     * @param $identifier
     * @param string $matchday
     * @param string $timeFrame
     * @return mixed
     */
    public function getLeagueFixtures($identifier, $matchday = '', $timeFrame = '');

    /**
     * Get fixtures for timeframe.
     *
     * @param string $leagueCode
     * @param string $timeFrame
     * @return mixed
     */
    public function getFixturesOfSet($leagueCode = '', $timeFrame = '');

    /**
     * Get fixtures for team.
     *
     * @param $identifier
     * @param string $season
     * @param string $timeFrame
     * @param string $venue
     * @return mixed
     */
    public function getTeamFixtures($identifier, $season = '', $timeFrame = '', $venue = '');

    /**
     * Get a team.
     *
     * @param $identifier
     * @return mixed
     */
    public function getTeam($identifier);

    /**
     * Get team players.
     *
     * @param $identifier
     * @return mixed
     */
    public function getTeamPlayers($identifier);
}
