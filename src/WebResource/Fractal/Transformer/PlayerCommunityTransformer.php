<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\GeneralclassificationRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayclassificationRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\WebResource\Fractal\Resource\PlayerCommunityResource;

/**
 * Class PlayerCommunityTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class PlayerCommunityTransformer extends TransformerAbstract
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var ParticipantRepositoryInterface
     */
    private $participantRepo;

    /**
     * @var MatchdayRepositoryInterface
     */
    private $matchdayRepository;

    /**
     * @var MatchdayclassificationRepositoryInterface
     */
    private $matchdayClassRepo;

    /**
     * @var GeneralclassificationRepositoryInterface
     */
    private $generalClassRepo;

    /**
     * CommunityTransformer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->request = $this->container->get('request');
        $this->participantRepo = $this->container->get(ParticipantRepositoryInterface::class);
        $this->matchdayRepository = $this->container->get(MatchdayRepositoryInterface::class);
        $this->matchdayClassRepo = $this->container->get(MatchdayclassificationRepositoryInterface::class);
        $this->generalClassRepo = $this->container->get(GeneralclassificationRepositoryInterface::class);
    }

    /**
     * @param PlayerCommunityResource $playerCommunityResource
     * @return array
     */
    public function transform(PlayerCommunityResource $playerCommunityResource)
    {
        $community = $playerCommunityResource->getCommunity();

        $resource = [
            'id' => $community->getId(),
            'nombre' => $community->getCommunityName(),
            'password' => $community->getPassword(),
            'privada' => $community->isPrivate(),
            'id_imagen' => $community->getImage()->getId(),
            'url' => $community->getImage()->getUrl(),
            'fecha_creacion' => $community->getCreationDate()->format('d-m-Y'),
            'numero_jugadores' => $this->participantRepo->countPlayersFromCommunity($community),
            'puntos_ultima_jornada' => 0,
            'puesto_ultima_jornada' => 0,
            'puesto_general' => 0
        ];

        /** @var PlayerInterface $player */
        $player = $playerCommunityResource->getPlayer();
        $matchday = $this->matchdayRepository->getLastMatchday();
        $matchdayClassification = $this->matchdayClassRepo->findOneOrCreate($player, $community, $matchday);
        $general = $this->generalClassRepo->findOneOrCreate($player, $community, $matchday);

        if ($matchday->getId() != 0) {
            $resource['puntos_ultima_jornada'] = $matchdayClassification->getTotalPoints();
            $resource['puesto_ultima_jornada'] = $matchdayClassification->getPosition();
        }

        if ($general->getId() != 0) {
            $resource['puesto_general'] = $general->getPosition();
        }

        return $resource;
    }
}
