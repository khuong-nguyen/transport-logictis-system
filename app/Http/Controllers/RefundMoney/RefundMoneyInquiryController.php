<?php

namespace App\Http\Controllers\AdvanceMoney;

use App\Http\Controllers\Controller;
use App\Repositories\AdvanceMoneyRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdvanceMoneyInquiryController extends Controller
{
    /**
     * @var AdvanceMoneyRepository
     */
    private $advanceMoneyRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/advance_money';

    /**
     * Create a new controller instance.
     * @param AdvanceMoneyRepository $advanceMoneyRepository
     *
     * @return void
     */
    public function __construct(
        AdvanceMoneyRepository $advanceMoneyRepository
    )
    {
        $this->advanceMoneyRepository = $advanceMoneyRepository;
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $params = '';
            $search = $request->get('search');
            if($search != null)
            {
                if (isset($search['columns'])) {
                    $params = http_build_query($search['columns']);
                }
                $data = $this->advanceMoneyRepository->inquirySearch($request);
            }
            else
            {
                $data = $this->advanceMoneyRepository->serverPaginationFilteringFor($request);
            }

            return datatables()->of($data->items())
                ->with([
                    "recordsTotal"    => $data->total(),
                    "recordsFiltered" => $data->total(),
                ])
                ->addColumn('action', function($row) use ($params) {
                    $url = '/advance_money/registration/'.$row->id.'?'.$params;
                    return '<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a>
                        <button class="delete btn btn-danger btn-sm" data-remote="'. $url.'">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('advance_money.advance_money_inquiry');
    }
}
