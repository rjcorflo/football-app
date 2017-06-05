<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Exception\PasswordNotMatchException;
use RJ\PronosticApp\Model\Exception\Request\MissingParametersException;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\Exception\ValidationException;

/**
 * Class PrivateCommunityController.
 *
 * Expose private community data.
 *
 * @package RJ\PronosticApp\Controller
 */
class PrivateCommunityController extends BaseController
{
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
    ): ResponseInterface {
        $bodyData = $request->getParsedBody();

        $result = new MessageResult();

        try {
            if (!isset($bodyData['nombre_comunidad']) || !isset($bodyData['password_comunidad'])) {
                $exception = new MissingParametersException();
                $exception->addMessageWithCode(
                    ErrorCodes::MISSING_PARAMETERS,
                    'Los parámetros ["nombre_comunidad","password_comunidad"] son obligatorios'
                );

                throw $exception;
            }

            $communityName = $bodyData['nombre_comunidad'];
            $communityPass = $bodyData['password_comunidad'];

            /** @var CommunityRepositoryInterface $communityRepository */
            $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

            // Retrieve community
            $community = $communityRepository->findByName($communityName);

            if (!$community->isPrivate()) {
                $exception = new ValidationException('No pudo unirse a la comunidad');
                $exception->addMessageWithCode(
                    ErrorCodes::COMMUNITY_IS_NOT_PRIVATE,
                    'La comunidad no es privada'
                );
                throw $exception;
            }

            if (!password_verify($communityPass, $community->getPassword())) {
                $exception = new PasswordNotMatchException('No pudo unirse a la comunidad');
                $exception->addMessageWithCode(
                    ErrorCodes::INCORRECT_PASSWORD,
                    'Pasword incorrecta'
                );
                throw $exception;
            }

            // Proceed to add player as participant
            /** @var PlayerInterface $player */
            $player = $request->getAttribute('player');

            // Check player is not already member of community
            $this->validator->existenceValidator()
                ->checkIfPlayerIsAlreadyFromCommunity($player, $community)
                ->validate();

            /** @var ParticipantRepositoryInterface $participantRepo */
            $participantRepo = $this->entityManager->getRepository(ParticipantRepositoryInterface::class);

            $participant = $participantRepo->create();
            $participant->setPlayer($player);
            $participant->setCommunity($community);
            $participant->setCreationDate(new \DateTime());

            $participantRepo->store($participant);

            $result->setDescription(
                sprintf(
                    'El jugador %s se ha unido correctamente a la comunidad privada %s',
                    $player->getNickname(),
                    $community->getCommunityName()
                )
            );

            $resource = $this->resourceGenerator->createMessageResource($result);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }
}
