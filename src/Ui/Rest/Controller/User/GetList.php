<?php

declare(strict_types=1);

namespace App\Ui\Rest\Controller\User;

use App\Application\User\UseCase\GetUserListUseCase;
use App\Infrastructure\Core\Form\Search\Symfony\SearchFormFactoryInterface;
use App\Infrastructure\User\Form\Type\UserSearchType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;


class GetList extends AbstractFOSRestController
{
    private GetUserListUseCase $useCase;
    private SearchFormFactoryInterface $searchFormFactory;

    public function __construct(
        GetUserListUseCase $useCase,
        SearchFormFactoryInterface $searchFormFactory
    ) {
        $this->useCase = $useCase;
        $this->searchFormFactory = $searchFormFactory;
    }

    /**
     * @Route(methods={"GET"}, name="api.user.getList", path="/api/user")
     * @OA\Get(
     *     path="/api/user",
     *     tags={"User"},
     *     operationId="userGetList",
     *     summary="Get user list",
     *     @OA\Response(
     *         response="200",
     *         description="User details",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *              )
     *         )
     *      )
     * )
     */
    public function __invoke(Request $request): View
    {
        $form = $this->searchFormFactory->createAndHandle(
            UserSearchType::class,
            $request->request->all()
        );

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $result = $this->useCase->execute($form->getData());

        return $this->view($result, Response::HTTP_OK);
    }
}
