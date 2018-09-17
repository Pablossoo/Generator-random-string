<?php

namespace App\Services;


use App\Entity\Code;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\DuplicateKeyException;


class GeneratorService implements GenerateInterface
{

    private CONST SUCCESS = 'SUCCESS';
    private CONST DANGER = 'DANGER';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * GeneratorService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param string $codes
     * @return array
     * Method divide request on array and remove \n/whitespace.
     * STAUTS = SUCCESS/FAILED
     * return Status or empty array
     */
    public function bathRemove(string $codes = null): array
    {
        $codesFromDatabase = $this->entityManager->getRepository(Code::class)->getAllValueAsArray();

        $codesToRemoveArray = array_filter(explode(',', preg_replace('/\s+/', '', $codes)));

        if (!empty($codesToRemoveArray)) {
            foreach ($codesToRemoveArray as $item) {
                $codesToRemove = $this->entityManager->getRepository(Code::class)->findOneBy(['uniqueCode' => $item]);
                if ($codesToRemove != null) {
                    $this->entityManager->remove($codesToRemove);
                }
            }

            // check if all passed post values exist in database, if not return difference codes as array
            if (empty(array_filter(array_diff($codesToRemoveArray, array_column($codesFromDatabase, 'uniqueCode'))))) {
                $this->entityManager->flush();
                return ['status' => static::SUCCESS];
            } else {
                return ['status' => static::DANGER, 'value' => array_filter(array_diff($codesToRemoveArray, array_column($codesFromDatabase, 'uniqueCode')))];
            }
        }

        return [];
    }


    public function generate(): void
    {
        $duplicates = [];
        for ($i = 0; $i < 10; $i++) {
            $entity = new Code();
            $entity->setDate(new \DateTime());
            try {
                $entity->setUniqueCode('dd');
            } catch (\Exception $e) {
            }

            $duplicates[] = $entity->getUniqueCode();
            $this->entityManager->persist($entity);
        }

        if (count(array_unique($duplicates)) === count($duplicates)) {
            $this->entityManager->flush();
        } else {
            throw new \Exception("Arrays has duplicate value!");
        }
    }
}