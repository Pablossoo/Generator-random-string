<?php

namespace App\Services;


use App\Repository\CodeRepository;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GeneratorService implements GenerateInterface
{

    /**
     * @var CodeRepository
     */
    private $codeRepository;


    /**
     * GeneratorService constructor.
     * @param CodeRepository $codeRepository
     */
    public function __construct(CodeRepository $codeRepository)
    {
        $this->codeRepository = $codeRepository;

    }


    /**
     * @param string $codes
     * @return array
     * Method divide request on array and remove \n/whitespace. Return failed codes, or empty array if  remove success
     */
    public function bathRemove(string $codes = null): array
    {
        $codesFromDatabase = $this->codeRepository->findAll();
        $codesToRemoveArray = explode(',', preg_replace("/\r|\n/", "", $codes));

        return array_diff($codesToRemoveArray, $codesFromDatabase);
    }


    public function generate()
    {
        // TODO: Implement generate() method.
    }
}