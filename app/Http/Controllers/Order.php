<?php

namespace App\Http\Controllers;

use App\Business\Order\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

class Order extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RepositoryInterface $repository
     * @return \Illuminate\Http\Response
     */
    public function index(RepositoryInterface $repository)
    {
        $codes = [
            '0077-6495-AYUX',
            '0077-6491-ASLK',
            '0077-6490-VNCM',
            '0077-6478-DMAR',
            '0077-1456-TESV',
            '0077-0836-PEFL',
            '0077-0526-EBDW',
            '0077-0522-QAYC',
            '0077-0516-VBTW',
            '0077-0424-NSHE'
        ];
        $repository->find($codes);
        return response((string) $repository->render(), 201);
    }
}
