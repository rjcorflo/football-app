<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\General\ResponseGenerator;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

/**
 * Class PrivateCommunityController.
 *
 * Expose private community data.
 *
 * @package RJ\PronosticApp\Controller
 */
class PrivateCommunityController
{
    use ResponseGenerator;

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @var WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CommunityController constructor.
     * @param EntityManager $entityManager
     * @param WebResourceGeneratorInterface $resourceGenerator
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManager $entityManager,
        WebResourceGeneratorInterface $resourceGenerator,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->resourceGenerator = $resourceGenerator;
        $this->validator = $validator;
    }

    /**
     * Join to private community.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function join(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        $result = new MessageResult();

        try {
            if (!isset($bodyData['nombre_comunidad']) || !isset($bodyData['password_comunidad'])) {
                $response = $this->generateParameterNeededResponse(
                    $response,
                    'Los parámetros ["nombre_comunidad","password_comunidad"] son obligatorios'
                );

                return $response;
            }

            $communityName = $bodyData['nombre_comunidad'];
            $communityPass = $bodyData['password_comunidad'];

            /** @var CommunityRepositoryInterface $communityRepository */
            $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

            // Retrieve community
            $community = $communityRepository->findByName($communityName);

            // Checks that comunity exists, is private and passwords match
            if ($community === null) {
                $result->addMessageWithCode(
                    ErrorCodes::EXIST_COMMUNITY_NAME,
                    'No existe una comunidad con ese nombre'
                );

                throw new \Exception('No pudo unirse a la comunidad');
            }

            if (!$community->isPrivate()) {
                $result->addMessageWithCode(
                    ErrorCodes::DEFAULT,
                    'La comunidad no es privada'
                );
                throw new \Exception('No pudo unirse a la comunidad');
            }

            if (!password_verify($communityPass, $community->getPassword())) {
                $result->addMessageWithCode(
                    ErrorCodes::LOGIN_ERROR_INCORRECT_PASSWORD,
                    'Pasword incorrecta'
                );
                throw new \Exception('No pudo unirse a la comunidad');
            }

            // Proceed to add player as participant
            /** @var PlayerInterface $player */
            $player = $request->getAttribute('player');

            /** @var ParticipantRepositoryInterface $participantRepo */
            $participantRepo = $this->entityManager->getRepository(ParticipantRepositoryInterface::class);

            $participant = $participantRepo->create();
            $participant->setPlayer($player);
            $participant->setCommunity($community);
            $participant->setCreationDate(new \DateTime());

            $participantRepo->store($participant);
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }
}
