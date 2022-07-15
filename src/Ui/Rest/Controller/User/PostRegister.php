<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\User;

use App\Application\User\UseCase\RegisterUserUseCase;
use App\Domain\User\Exception\EmailAlreadyExistsException;
use App\Infrastructure\User\Form\Type\RegistrationFormType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;

class PostRegister extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private RegisterUserUseCase $useCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        RegisterUserUseCase $useCase
    ) {
        $this->formFactory = $formFactory;
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"POST"}, name="api.user.register", path="/api/register")
     * @OA\Post(
     *     path="/api/register",
     *     tags={"User"},
     *     description="register user",
     *     operationId="userRegister",
     *     summary="Register User",
     *     @OA\RequestBody(
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="firstName",
     *                     type="string",
     *                     example="name"
     *                 ),
     *                 @OA\Property(
     *                     property="lastName",
     *                     type="string",
     *                     example="lastname"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="user@email.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="password"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="userId",
     *                     type="string",
     *                     format="uuid",
     *                     description="Registered member identity",
     *                     example="00000000-0000-0000-0000-000000000000"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Registered member email",
     *                     example="email@gamil.com"
     *                  )
     *             )
     *         )
     *      ),
     *      @OA\Response(response="400", description="")
     * )
     */
    public function __invoke(Request $request): View
    {
//        $body = $request->getContent();
//        $data = json_decode($body, true);
        $data = $request->request->all();
        $form = $this->formFactory->createNamed('user', RegistrationFormType::class, null);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        try {
            $userId = $this->useCase->execute(
                $form->getData(),
            );

            return $this->view([
                    'userId' => (string)$userId,
                ],
                Response::HTTP_OK
            );
        } catch (EmailAlreadyExistsException $ex) {
            $form->get('email')->addError(
                new FormError($ex->getMessage())
            );
        }

        return $this->view($form, Response::HTTP_BAD_REQUEST);
    }
}
