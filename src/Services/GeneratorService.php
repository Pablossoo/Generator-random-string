<?php

namespace App\Services;


use App\Repository\CodeRepository;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GeneratorService implements GenerateInterface
{
    /**
     * @var RequestStack
     */
    private $request;

    /**
     * @var CodeRepository
     */
    private $codeRepostiroy;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * GeneratorService constructor.
     * @param RequestStack $request
     * @param CodeRepository $codeRepostiroy
     * @param SessionInterface $session
     */
    public function __construct(RequestStack $request, CodeRepository $codeRepostiroy, SessionInterface $session)
    {
        $this->request = $request;
        $this->codeRepostiroy = $codeRepostiroy;
        $this->session = $session;
    }


    /**
     * @return array
     * Method divide request on array and remove \n/whitespace. Return failed codes, or empty array if  remove success
     */
    public function bathRemove(): array
    {
        $request = $this->request->getMasterRequest();
        $codesFromDatabase = $this->codeRepostiroy->findAll();
        $codesToRemoveArray = explode(',', preg_replace( "/\r|\n/", "",trim($request->get('codes'))));

        return array_diff($codesToRemoveArray, $codesFromDatabase);
    }


    public function generate()
    {
        // TODO: Implement generate() method.
    }
}