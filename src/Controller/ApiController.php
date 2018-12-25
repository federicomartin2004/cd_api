<?php
/**
 * ApiController.php
 *
 * API Controller
 *
 * @category   Controller
 * @package    api
 * @author     Federico
 */

namespace App\Controller;

use App\Entity\Products;
use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class ApiController
 *
 * @Route("/api")
 */
class ApiController extends FOSRestController
{
    // USER URI's

    /**
     * @Rest\Post("/login_check", name="user_login_check")
     *
     * @SWG\Response(
     *     response=200,
     *     description="User was logged in successfully"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="User was not logged in successfully"
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={
     *     }
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="body",
     *     type="string",
     *     description="The password",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function getLoginCheckAction() {}

    /**
     * @Rest\Post("/register", name="user_register")
     *
     * @SWG\Response(
     *     response=201,
     *     description="User was successfully registered"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="User was not successfully registered"
     * )
     *
     * @SWG\Parameter(
     *     name="_name",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_email",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="query",
     *     type="string",
     *     description="The password"
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $user = [];
        $message = "";

        try {
            $code = 200;
            $error = false;

            $name = $request->request->get('_name');
            $email = $request->request->get('_email');
            $username = $request->request->get('_username');
            $password = $request->request->get('_password');

            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setPlainPassword($password);
            $user->setPassword($encoder->encodePassword($user, $password));

            $em->persist($user);
            $em->flush();

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to register the user - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $user : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }

    
    
    // PRODUCTS URI's

    /**
     * @Rest\Post("/v1/products.{_format}", name="products_add", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="Product was added successfully"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error was occurred trying to add new Product"
     * )
     *
     * @SWG\Parameter(
     *     name="categoryId",
     *     in="body",
     *     type="integer",
     *     description="The category id",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="body",
     *     type="string",
     *     description="The product name",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="description",
     *     in="body",
     *     type="string",
     *     description="The product description",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="price",
     *     in="body",
     *     type="decimal",
     *     description="The product price",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="photo",
     *     in="body",
     *     type="string",
     *     description="The path to the photo of the product",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Products")
     */
    public function addProductsAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $products = [];
        $message = "";

        try {
            $code = 201;
            $error = false;
            $categoryId = $request->request->get("categoryId", null);
            $name = $request->request->get("name", null);
            $description = $request->request->get("description", null);
            $price = $request->request->get("price", null);
            $photo = $request->request->get("photo", null);
            $userId = $this->getUser()->getId();

            if (!is_null($categoryId) && !is_null($name) && !is_null($description) && !is_null($price) && !is_null($photo)) {
                $products = new Products;
                $products->setCategoryId($categoryId);
                $products->setUserId($userId);
                $products->setName($name);
                $products->setDescription($description);
                $products->setPrice($price);
                $products->setPhoto($photo);
                $products->setEnabled(true);
                $products->setCreatedAt(new \DateTime);
                $products->setUpdatedAt(new \DateTime);

                $em->persist($products);
                $em->flush();

            } else {
                $code = 500;
                $error = true;
                $message = "An error has occurred trying to add new product - Error: You must to provide all the required fields";
            }

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to add new product - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 201 ? $products : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }
    
    
    /**
     * @Rest\Get("/v1/products.{_format}", name="products_list", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Gets products filtered."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to get products filtered."
     * )
     *
     * @SWG\Parameter(
     *     name="categoryId",
     *     in="body",
     *     type="integer",
     *     description="The category id",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="body",
     *     type="string",
     *     description="The product name",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="priceFrom",
     *     in="body",
     *     type="decimal",
     *     description="The product price",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="priceTo",
     *     in="body",
     *     type="decimal",
     *     description="The product price",
     *     schema={}
     * )
     *
     *
     * @SWG\Tag(name="Products")
     */
    public function getFilteredProductsAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $products = [];
        $message = "";

        try {
            $code = 200;
            $error = false;
            
            $categoryId = $request->query->get("categoryId", null);
            $name = $request->query->get("name", null);
            $priceFrom = $request->query->get("priceFrom", null);
            $priceTo = $request->query->get("priceTo", null);
            
            $parameters = [];                
            $query = $qb->select('p')
                    ->from('App:Products','p')
                    ->where('p.enabled = 1');
            
            if($categoryId>0){
                $query->andWhere("p.categoryId = $categoryId");
            }
            
            if(!empty($name) && strlen($name)>2){
                $query->andWhere($qb->expr()->like('p.name', ':name'));
                $parameters['name']='%'.$name.'%';
            }
            
            if(!empty($priceFrom) && is_numeric($priceFrom)){
                $query->andWhere($qb->expr()->gte('p.price', ':from'));
                $parameters['from']=$priceFrom;
            }
            
            if(!empty($priceTo) && is_numeric($priceTo)){
                $query->andWhere($qb->expr()->lte('p.price', ':to'));
                $parameters['to']=$priceTo;
            }
            
            if(count($parameters)>0)$qb->setParameters($parameters);
            
            $products = $query->getQuery()->getResult();

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get Products - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'query' => $qb->getQuery()->getSql(),
            'params' => $qb->getQuery()->getParameters(),
            'data' => $code == 200 ? $products : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }
   
    /**
     * @Route("/v1/", name="api")
     */
    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }

}
