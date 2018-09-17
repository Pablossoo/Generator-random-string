<?php

namespace App\Services;


use App\Entity\Code;
use Doctrine\ORM\EntityManagerInterface;


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


    public function generate()
    {

    }
}