<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use AppBundle\Entity\User;

/**
 * @Route( "/user" )
 */
class UserController extends Controller{

    /**
     * @Route( "/", name="user_list", methods={ "GET" } )
     */
    public function list(){
        $em = $this->getDoctrine()->getRepository( User::class );
        $users = $em->findAll();
        $users = $this->get( 'jms_serializer' )->serialize( $users, 'json' );

        $response = new Response();
        $response->setContent( $users );
        $response->headers->set( 'Content-Type', 'application/json' );
        return $response;
    }

    /**
     * @Route( "/", name="user_add", methods={ "POST" } )
     */
    public function add( Request $request ){
        $data = $request->getContent();
        $serializer = $this->get( 'jms_serializer' );
       
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        try{
            $user = $serializer->deserialize( $data, User::class, 'json' );
        } catch (Exception $e ){
            $response->setStatusCode( Response::HTTP_CREATED );
            return $response;
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist( $user );
        $em->flush();

        $user = $serializer->serialize( $user, 'json' );
        $response->setStatusCode( Response::HTTP_CREATED );
        $response->setContent( $user );

        return $response;
    }

    /**
     * @Route( "/{id}", name="user_show", requirements={"id"="\d+"}, methods={ "GET" } )
     */
    public function show( $id ){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');

            $em = $this->getDoctrine()->getRepository( User::class );
            $user = $em->find( $id );

            if( !$user ){
                $response->setContent( json_encode( [] ) );
                $response->setStatusCode( Response::HTTP_NOT_FOUND );
                return $response;
            }

            $serializer = $this->get( 'jms_serializer' );
            $user = $serializer->serialize( $user, 'json' );

            $response->setContent( $user );
            $response->setStatusCode( Response::HTTP_OK );
            $response->headers->set('Content-Type', 'application/json');
            
            return $response;
        }

        /**
         * @Route( "/{id}", name="user_edit", requirements={"id"="\d+"}, methods={ "PATCH" } )
         */
        public function edit( Request $request, $id ){

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository( User::class )->find( $id );

            if( !$user ){
                $response->setContent( json_encode( [] ) );
                $response->setStatusCode( Response::HTTP_NOT_FOUND );
                return $response;
            }
            $user->setId( $id );

            $data = $request->getContent();
            $serializer = $this->get( 'jms_serializer' );
            $data = $serializer->deserialize( $data, User::class, 'json' );

            if( $data->getName() ){
                $user->setName( $data->getName() );
            }
            if( $data->getUsername() ){
                $user->setUsername( $data->getUsername() );
            }
            if( $data->getPassword() ){
                $user->setPassword( $data->getPassword() );
            }
            
            $em->flush();

            $user = $serializer->serialize( $user, 'json' );

            $response = new Response();
            $response->setContent( $user );
            $response->setStatusCode( Response::HTTP_OK );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        /**
         * @Route( "/{id}", name="user_delete", requirements={"id"="\d+"}, methods={ "DELETE" } )
         */
        public function delete( $id ){
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository( User::class )->find( $id );

            if( !$user ){
                $response->setContent( json_encode( [] ) );
                $response->setStatusCode( Response::HTTP_NOT_FOUND );
                return $response;
            }

            $em->remove( $user );
            $em->flush();
    
            $user = $serializer->serialize( $user, 'json' );

            $response = new Response();
            $response->setContent( $user );
            $response->setStatusCode( Response::HTTP_NO_CONTENT );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        /**
         * @Route( "/login", name="user_login", methods={ "POST" } )
         */

         public function login( Request $request ){
            $data = $request->getContent();
            $serializer = $this->get( 'jms_serializer' );
            $data = $serializer->deserialize( $data, User::class, 'json' );

            $user = array( 'username' => $data->getUsername(),
                           'password' => $data->getPassword(),
                        );

            $em = $this->getDoctrine()->getRepository( User::class );
            $users = $em->findBy($user);
            $response = new Response();

            if( $users ){
                $users = $serializer->serialize( $users[0], 'json');
                $response->setContent( $users );
                $response->setStatusCode( Response::HTTP_OK );
                return $response;
            }

            $response->setStatusCode( Response::HTTP_UNAUTHORIZED );
            return $response;
         }
    }