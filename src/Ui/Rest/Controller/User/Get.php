<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\User;

use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Infrastructure\User\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;

class Get extends AbstractFOSRestController
{
    /**
     * @Route(methods={"GET"}, name="api.user.get", path="/api/user/{user}")
     * @OA\Get(
     *     path="/api/user/{user}",
     *     tags={"User"},
     *     operationId="userGet",
     *     summary="Get user by id",
     *     @OA\PathParameter(
     *          name="user",
     *          in="query",
     *          @OA\Schema(type="string", example="45d04bcc-610a-4f95-a2ba-e681ffdbbd77")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User details",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *              )
     *         )
     *      ),
     *      @OA\Response(response="404", description="User not found")
     * )
     */
    public function __invoke(User $user): View
    {
        return $this->view($user);
    }
}
