<?php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 *
 */
class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordHasher = $passwordHasher;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
       // dump($data->getPassword());
        //dump($data->getPassword());
        /* if ( */
        /*     $data instanceof User && ( */
        /*         ($context['collection_operation_name'] ?? null) === 'post' || */
        /*         ($context['graphql_operation_name'] ?? null) === 'create' */
        /*     ) */
        /* ) { */
        if($data->getPlainPassword()){
            $data->setPassword(
                $this->_passwordHasher->hashPassword(
                    $data,
                
                    $data->getPlainPassword()
                )
            );
                    
            $data->eraseCredentials();
            //dd($data);
        }
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
       // dd($data->getPassword());
    
    //}
    
    
    }


    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}