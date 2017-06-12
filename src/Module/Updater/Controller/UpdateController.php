<?php

namespace RJ\PronosticApp\Module\Updater\Controller;

use Psr\Http\Message\ResponseInterface;
use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Entity\TeamInterface;
use RJ\PronosticApp\Model\Repository\CompetitionRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchRepositoryInterface;
use RJ\PronosticApp\Model\Repository\PhaseRepositoryInterface;
use RJ\PronosticApp\Model\Repository\TeamRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;

/**
 * Class UpdateController
 *
 * Create fixtures and updates.
 *
 * @package RJ\PronosticApp\Controller
 */
class UpdateController
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /**
     * FixturesController constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Fixtures for images.
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function updateAll(ResponseInterface $response): ResponseInterface
    {
        R::exec('DELETE FROM sqlite_sequence 
                  WHERE name IN ("image", "team", "competition", "phase", "matchday", "match")');

        R::wipe(MatchRepositoryInterface::ENTITY);
        R::wipe(MatchdayRepositoryInterface::ENTITY);
        R::wipe(CompetitionRepositoryInterface::ENTITY);
        R::wipe(PhaseRepositoryInterface::ENTITY);
        R::wipe(TeamRepositoryInterface::ENTITY);
        R::wipe(ImageRepositoryInterface::ENTITY);

        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        $this->updateCommunityImages($imageRepository);
        $this->updateCompetitionImages($imageRepository);
        $this->updateStadiumImages($imageRepository);
        $this->updateTeamImages($imageRepository);

        $this->updateTeams();

        $this->updateCompetitions();

        $this->updatePhases();

        $this->updateMatchdays();

        $this->updateMatches();

        $response->getBody()->write('{result: "OK"}');

        return $response;
    }

    /**
     * @param ImageRepositoryInterface $imageRepository
     */
    private function updateCommunityImages(ImageRepositoryInterface $imageRepository)
    {
        $images = [];

        for ($index = 1; $index < 17; $index++) {
            $image = $imageRepository->getByIdOrCreate($index);
            $image->setUrl("/images/community/{$index}.jpg");
            $image->setDescription("Comudidad {$index}");
            $images[] = $image;
        }

        $this->entityManager->transaction(function () use ($imageRepository, $images) {
            $imageRepository->storeMultiple($images);
        });
    }

    /**
     * @param ImageRepositoryInterface $imageRepository
     */
    private function updateCompetitionImages(ImageRepositoryInterface $imageRepository)
    {
        $dataList = [
            ['url' => "/images/competition/131306.jpg", 'description' => "Copa Confederaciones"]
        ];

        $images = [];

        foreach ($dataList as $data) {
            $image = $imageRepository->create();
            $image->setUrl($data['url']);
            $image->setDescription($data['description']);
            $images[] = $image;
        }

        $this->entityManager->transaction(function () use ($imageRepository, $images) {
            $imageRepository->storeMultiple($images);
        });
    }

    /**
     * @param ImageRepositoryInterface $imageRepository
     */
    private function updateStadiumImages(ImageRepositoryInterface $imageRepository)
    {
        $dataList = [
            ['url' => "/images/stadium/kazanarena.jpg", 'description' => "Kazán Arena"],
            ['url' => "/images/stadium/moscu.jpg", 'description' => "Moscú"],
            ['url' => "/images/stadium/san_petersburgo.jpg", 'description' => "San Petersburgo"],
            ['url' => "/images/stadium/sochi.jpg", 'description' => "Sochi"]
        ];

        $images = [];

        foreach ($dataList as $data) {
            $image = $imageRepository->create();
            $image->setUrl($data['url']);
            $image->setDescription($data['description']);
            $images[] = $image;
        }

        $this->entityManager->transaction(function () use ($imageRepository, $images) {
            $imageRepository->storeMultiple($images);
        });
    }

    /**
     * @param ImageRepositoryInterface $imageRepository
     */
    private function updateTeamImages(ImageRepositoryInterface $imageRepository)
    {
        $dataList = [
            ['url' => "/images/team/11.png", 'description' => "Camerún"],
            ['url' => "/images/team/379.png", 'description' => "México"],
            ['url' => "/images/team/771.png", 'description' => "Alemania"],
            ['url' => "/images/team/788.png", 'description' => "Portugal"],
            ['url' => "/images/team/791.png", 'description' => "Rusia"],
            ['url' => "/images/team/1435.png", 'description' => "Australia"],
            ['url' => "/images/team/1438.png", 'description' => "Nueva Zelanda"],
            ['url' => "/images/team/1652.png", 'description' => "Chile"],
        ];

        $images = [];

        foreach ($dataList as $data) {
            $image = $imageRepository->create();
            $image->setUrl($data['url']);
            $image->setDescription($data['description']);
            $images[] = $image;
        }

        $this->entityManager->transaction(function () use ($imageRepository, $images) {
            $imageRepository->storeMultiple($images);
        });
    }

    private function updateTeams()
    {
        $dataList = [
            [
                'name' => "Camerún",
                'alias' => "CAM",
                'color' => "#d41c25",
                'id_imagen' => 22
            ],
            [
                'name' => "México",
                'alias' => "MEX",
                'color' => "#397362",
                'id_imagen' => 23
            ],
            [
                'name' => "Alemania",
                'alias' => "ALE",
                'color' => "#88916d",
                'id_imagen' => 24
            ],
            [
                'name' => "Portugal",
                'alias' => "POR",
                'color' => "#a0ded7",
                'id_imagen' => 25
            ],
            [
                'name' => "Rusia",
                'alias' => "RUS",
                'color' => "#d41c25",
                'id_imagen' => 26
            ],
            [
                'name' => "Australia",
                'alias' => "AUS",
                'color' => "#b86314",
                'id_imagen' => 27
            ],
            [
                'name' => "Nueva Zelanda",
                'alias' => "ZEL",
                'color' => "#ffffff",
                'id_imagen' => 28
            ],
            [
                'name' => "Chile",
                'alias' => "CHI",
                'color' => "#0f3180",
                'id_imagen' => 29
            ]
        ];

        $teams = [];

        /** @var TeamRepositoryInterface $teamRepository */
        $teamRepository = $this->entityManager->getRepository(TeamRepositoryInterface::class);
        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        foreach ($dataList as $data) {
            /** @var TeamInterface $team */
            $team = $teamRepository->create();
            $team->setName($data['name']);
            $team->setAlias($data['alias']);
            $team->setColor($data['color']);
            $team->setStadium('');

            /** @var ImageInterface $image */
            $image = $imageRepository->getById($data['id_imagen']);
            $team->setImage($image);
            $teams[] = $team;
        }

        $this->entityManager->transaction(function () use ($teamRepository, $teams) {
            $teamRepository->storeMultiple($teams);
        });
    }

    private function updateCompetitions()
    {
        $dataList = [
            [
                'name' => "Copa Confederaciones 2017",
                'alias' => "CONFE2017",
                'id_imagen' => 17
            ]
        ];

        $competitions = [];

        /** @var CompetitionRepositoryInterface $competitionRepository */
        $competitionRepository = $this->entityManager->getRepository(CompetitionRepositoryInterface::class);
        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        foreach ($dataList as $data) {
            $competition = $competitionRepository->create();
            $competition->setName($data['name']);
            $competition->setAlias($data['alias']);

            /** @var ImageInterface $image */
            $image = $imageRepository->getById($data['id_imagen']);
            $competition->setImage($image);
            $competitions[] = $competition;
        }

        $this->entityManager->transaction(function () use ($competitionRepository, $competitions) {
            $competitionRepository->storeMultiple($competitions);
        });
    }

    private function updatePhases()
    {
        $dataList = [
            [
                'name' => "Jornada regular",
                'multiplier' => 1
            ],
            [
                'name' => "Octavos de final",
                'multiplier' => 1
            ],
            [
                'name' => "Cuartos de final",
                'multiplier' => 1
            ],
            [
                'name' => "Semifinal",
                'multiplier' => 2
            ],
            [
                'name' => "Final",
                'multiplier' => 3
            ]
        ];

        $beans = [];

        /** @var PhaseRepositoryInterface $beansRepository */
        $beansRepository = $this->entityManager->getRepository(PhaseRepositoryInterface::class);

        foreach ($dataList as $data) {
            $bean = $beansRepository->create();
            $bean->setName($data['name']);
            $bean->setMultiplierFactor($data['multiplier']);
            $beans[] = $bean;
        }

        $this->entityManager->transaction(function () use ($beansRepository, $beans) {
            $beansRepository->storeMultiple($beans);
        });
    }

    private function updateMatchdays()
    {
        $dataList = [
            [
                'id_competicion' => 1,
                'id_fase' => 1,
                'nombre' => 'Jornada 1',
                'alias' => 'J1'
            ],
            [
                'id_competicion' => 1,
                'id_fase' => 1,
                'nombre' => 'Jornada 2',
                'alias' => 'J2'
            ],
            [
                'id_competicion' => 1,
                'id_fase' => 1,
                'nombre' => 'Jornada 3',
                'alias' => 'J3'
            ],
            [
                'id_competicion' => 1,
                'id_fase' => 4,
                'nombre' => 'Jornada 4 - Semifinales',
                'alias' => 'SEMIS'
            ],
            [
                'id_competicion' => 1,
                'id_fase' => 5,
                'nombre' => 'Jornada 5 - Final y Tercer y cuarto',
                'alias' => 'FINAL'
            ]
        ];

        $beans = [];

        /** @var MatchdayRepositoryInterface $beansRepository */
        $beansRepository = $this->entityManager->getRepository(MatchdayRepositoryInterface::class);

        /** @var CompetitionRepositoryInterface $competitionRepository */
        $competitionRepository = $this->entityManager->getRepository(CompetitionRepositoryInterface::class);

        /** @var PhaseRepositoryInterface $phaseRepository */
        $phaseRepository = $this->entityManager->getRepository(PhaseRepositoryInterface::class);

        foreach ($dataList as $data) {
            $bean = $beansRepository->create();
            $bean->setCompetition($competitionRepository->getById($data['id_competicion']));
            $bean->setPhase($phaseRepository->getById($data['id_fase']));
            $bean->setName($data['nombre']);
            $bean->setAlias($data['alias']);
            $beans[] = $bean;
        }

        $this->entityManager->transaction(function () use ($beansRepository, $beans) {
            $beansRepository->storeMultiple($beans);
        });
    }

    private function updateMatches()
    {
        $dataList = [
            [
                'id_jornada' => 1,
                'fecha' => '2017-06-17 17:00',
                'tag' => 'Grupo A',
                'estadio' => 'San Petersburgo',
                'lugar' => 'San Petersburgo',
                'imagen' => 18,
                'local' => 5,
                'visitante' => 7
            ],
            [
                'id_jornada' => 1,
                'fecha' => '2017-06-18 17:00',
                'tag' => 'Grupo A',
                'estadio' => 'Kazán Arena',
                'lugar' => 'Kazán',
                'imagen' => 18,
                'local' => 4,
                'visitante' => 2
            ],
            [
                'id_jornada' => 1,
                'fecha' => '2017-06-18 20:00',
                'tag' => 'Grupo B',
                'estadio' => 'Estadio del Spartak',
                'lugar' => 'Moscú',
                'imagen' => 18,
                'local' => 1,
                'visitante' => 8
            ],
            [
                'id_jornada' => 1,
                'fecha' => '2017-06-19 17:00',
                'tag' => 'Grupo B',
                'estadio' => 'Estadio Fisht',
                'lugar' => 'Sochi',
                'imagen' => 18,
                'local' => 6,
                'visitante' => 3
            ],
            [
                'id_jornada' => 2,
                'fecha' => '2017-06-21 17:00',
                'tag' => 'Grupo A',
                'estadio' => 'Estadio del Spartak',
                'lugar' => 'Moscú',
                'imagen' => 18,
                'local' => 5,
                'visitante' => 4
            ],
            [
                'id_jornada' => 2,
                'fecha' => '2017-06-21 20:00',
                'tag' => 'Grupo A',
                'estadio' => 'Estadio Fisht',
                'lugar' => 'Sochi',
                'imagen' => 18,
                'local' => 2,
                'visitante' => 7
            ],
            [
                'id_jornada' => 2,
                'fecha' => '2017-06-22 17:00',
                'tag' => 'Grupo B',
                'estadio' => 'Estadio de San Petersburgo',
                'lugar' => 'San Petersburgo',
                'imagen' => 18,
                'local' => 1,
                'visitante' => 6
            ],
            [
                'id_jornada' => 2,
                'fecha' => '2017-06-22 20:00',
                'tag' => 'Grupo B',
                'estadio' => 'Kazán Arena',
                'lugar' => 'Kazán',
                'imagen' => 18,
                'local' => 3,
                'visitante' => 8
            ],
        ];

        $beans = [];

        /** @var MatchRepositoryInterface $beansRepository */
        $beansRepository = $this->entityManager->getRepository(MatchRepositoryInterface::class);

        /** @var TeamRepositoryInterface $teamRepository */
        $teamRepository = $this->entityManager->getRepository(TeamRepositoryInterface::class);

        /** @var MatchdayRepositoryInterface $matchdayRepository */
        $matchdayRepository = $this->entityManager->getRepository(MatchdayRepositoryInterface::class);

        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        foreach ($dataList as $data) {
            $bean = $beansRepository->create();
            $bean->setMatchday($matchdayRepository->getById($data['id_jornada']));
            $bean->setStartTime(\DateTime::createFromFormat('Y-m-d H:i', $data['fecha']));
            $bean->setState(MatchInterface::STATE_NOT_PLAYED);
            $bean->setTag($data['tag']);
            $bean->setStadium($data['estadio']);
            $bean->setCity($data['lugar']);
            $bean->setLocalTeam($teamRepository->getById($data['local']));
            $bean->setAwayTeam($teamRepository->getById($data['visitante']));
            $bean->setLocalGoals(-1);
            $bean->setAwayGoals(-1);
            $bean->setLastModifiedDate(new \DateTime());
            $bean->setImage($imageRepository->getById($data['imagen']));
            $beans[] = $bean;
        }

        $this->entityManager->transaction(function () use ($beansRepository, $beans) {
            $beansRepository->storeMultiple($beans);
        });
    }
}
