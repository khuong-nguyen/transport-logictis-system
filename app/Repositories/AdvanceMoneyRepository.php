<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AdvanceMoneyRepository extends BaseRepository
{

    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringFor(Request $request) :LengthAwarePaginator;
    
    public function advanceMoneyCode():string;
    
}