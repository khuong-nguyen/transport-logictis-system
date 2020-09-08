<?php
namespace App\Repositories\Eloquent;

use App\Repositories\BookingContainerDetailRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class EloquentBookingContainerDetailRepository extends EloquentBaseRepository implements BookingContainerDetailRepository
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function serverPaginationFilteringFor(Request $request) : LengthAwarePaginator
    {
        $query = $this->allWithBuilder();

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        return $query->paginate($request->get('per_page', 10));
    }

    public function getWithContainerByBookingId($id)
    {
        return $this->model->query()->with('container')->where('booking_id',$id)->get();
    }

    public function saveBooking($request) {
        DB::beginTransaction();
        try {
            $result = [];
//            $userId = Auth::user()->id;
            foreach ($request->containerbookingdetail as $data) {
                if ($data['id']) {
                    $oldContainer = $this->find($data['id']);
//                    $data['updated_by'] = $userId;
                    $this->update($oldContainer, $data);
                } else {
                    $filter = collect([$data])->whereNotNull('container_no')
                                                ->values()->pop();
                    if ($filter) {
                        
                        $record = $this->create($filter);
                        $data['id'] = $record->id;
                        $result[] = $data;
                    }
                }
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function fullSearch($bookingId, $driverNo = '', $containerTruckNo = '')
    {
        try {
                return $this->model->where('booking_id', $bookingId)->with(['container', 'schedules' => function($q) use ($driverNo, $containerTruckNo) {
                                                                            }])->get();
                return [];
        } catch (\Exception $e) {
            return false;
        }
    }

    public function isDuplicateContainerNoInBooking($booking_id, $container_no, $id = null){
        
        $isDuplicateContainerInBooking = true;
        
        if(empty($container_no)){
            return false;
        }
        
        if(empty($id)){
            $bookingContainerDetailCount = $this->model->where('booking_id', $booking_id)
                                                        ->where('container_no',$container_no)
                                                        ->count();
        }else{
            $bookingContainerDetailCount = $this->model->where('booking_id', $booking_id)
                                                        ->where('container_no',$container_no)
                                                        ->where('id','<>',$id)
                                                        ->count();
        }
        
        if($bookingContainerDetailCount == 0){
            $isDuplicateContainerInBooking = false;
        }
        return $isDuplicateContainerInBooking;
    }
    
    public function checkDuplicateBookingContainerDetail(array $bookingContainerDetails = []){
        $result = [
            "isDuplicated" => true,
            "errorMessage" => ""
        ];
        
        $groupedContainerNos = [];
        $errorMessage = "";
        
        foreach($bookingContainerDetails as $bookingContainerDetail){
            $groupedContainerNos[$bookingContainerDetail['container_no']][] = $bookingContainerDetail;
        }
        foreach($groupedContainerNos as $container_no => $groupedContainerNo){
            if(count($groupedContainerNo) > 1 && !empty($container_no)){
                $errorMessage = $errorMessage . $container_no . ",";
            }
        }
        if(!empty($errorMessage)){
            $errorMessage = substr($errorMessage, 0, strlen($errorMessage) - 1);
            $errorMessage = "Container No (" . $errorMessage . ") has been duplicated in booking";
            $result = [
                "isDuplicated" => true,
                "errorMessage" => $errorMessage
            ];
        }else{
            $result = [
                "isDuplicated" => false,
                "errorMessage" => ""
            ];
        }
        
        
        return $result;
    }
}
