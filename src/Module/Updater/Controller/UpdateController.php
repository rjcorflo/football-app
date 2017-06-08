<?php

namespace RJ\PronosticApp\Module\Updater\Controller;

use Psr\Http\Message\ResponseInterface;
use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\TeamInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
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
        R::wipe(TeamRepositoryInterface::ENTITY);
        R::wipe(ImageRepositoryInterface::ENTITY);

        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        $this->updateCommunityImages($imageRepository);
        $this->updateCompetitionImages($imageRepository);
        $this->updateStadiumImages($imageRepository);
        $this->updateTeamImages($imageRepository);

        $this->updateTeams();

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
}
