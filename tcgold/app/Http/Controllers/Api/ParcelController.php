<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParcelResource;
use App\Models\Parcel;
use App\Models\PricingModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ParcelController extends Controller
{

    /**
     * Store a newly created parcel in storage.
     *
     * @param Request $request
     * @return array
     */
    public function createParcel(Request $request)
    {
        $result = [];
        try {
            // create new parcel
            $parcel = new Parcel();

            // validate the parcel information
            $columnList = ['item_name', 'weight', 'volume', 'declared_value', 'chosen_model'];
            foreach ($columnList as $column) {
                $validate = $this->validateParcelInfo($column, $request->input($column));
                if ($validate['status'] != Response::HTTP_OK) {
                    return $validate;
                }
                $parcel->{$column} = $request->input($column);
            }

            // calculate quote
            $parcel = $this->calculateQuote($parcel);

            // save data
            $parcel->save();
            $result['status'] = Response::HTTP_CREATED;
            $result['message'] = 'Data is created successful';
            $result['data'] = new ParcelResource($parcel);
        } catch (\Throwable $throwable) {
            $result['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['message'] = 'Internal server error';
            $result['message'] = $throwable->getMessage();
        }
        return $result;
    }

    /**
     * Validate the parcel information
     *
     * @param $key
     * @param $value
     * @return array
     */
    private function validateParcelInfo($key, $value)
    {
        $result = ['status' => Response::HTTP_OK];
        // check empty
        if (empty($value)) {
            $result['status'] = Response::HTTP_BAD_REQUEST;
            $result['message'] = $key . ' is required';
            return $result;
        }

        // check numeric
        if ($key !== 'item_name' && !is_numeric($value)) {
            $result['status'] = Response::HTTP_BAD_REQUEST;
            $result['message'] = $key . ' should be numeric';
            return $result;
        }

        // check chosen_model allow value
        if ($key == 'chosen_model' && ($value < 1 || $value > 3)) {
            $result['status'] = Response::HTTP_BAD_REQUEST;
            $result['message'] = $key . ' should be 1 (by weight) or 2 (by volume) or 3 (by value)';
            return $result;
        }
        return $result;
    }

    /**
     * Calculate the quote of parcel
     *
     * @param Parcel $parcel
     * @return Parcel
     */
    private function calculateQuote(Parcel $parcel) {
        // get pricing model (always has the data)
        $pricingModel = PricingModel::whereDate('start_date', '<=', date('Y-m-d'))->orderBy('id', 'desc')->first();
        switch ($parcel->chosen_model) {
            case 1:
                $parcel->quote = ($parcel->weight * $pricingModel->by_weight);
                break;
            case 2:
                $parcel->quote = ($parcel->volume * $pricingModel->by_volume);
                break;
            case 3:
                $parcel->quote = ($parcel->declared_value * $pricingModel->by_value) / 100;
                break;
            default:
                $parcel->quote = 0;
                break;
        }
        $parcel->pricing_model_id = $pricingModel->id;
        return $parcel;
    }

    /**
     * Get the specified parcel.
     *
     * @param $id
     * @return array
     */
    public function getSingleParcel(Request $request, $id)
    {
        $result = [];
        try {
            // get parcel by id
            $parcel = Parcel::find($id);

            // check parcel exist
            if ($parcel) {
                $result['status'] = Response::HTTP_OK;
                $result['data'] = new ParcelResource($parcel);
            } else {
                $result['status'] = Response::HTTP_NOT_FOUND;
                $result['message'] = 'Data is not found';
            }
        } catch (\Throwable $throwable) {
            $result['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['message'] = 'Internal server error';
        }
        return $result;
    }

    /**
     * Display a listing of the parcel.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMultipleParcel(Request $request)
    {
        $result = [];
        // check the parameter(parcelIds) exist
        if (empty($request->get('parcelIds'))) {
            $result['status'] = Response::HTTP_NOT_FOUND;
            $result['message'] = 'Data is not found';
        } else {
            // convert parcelIds from string to array
            $idList = explode(",", $request->get('parcelIds'));
            try {
                // get parcel list
                $parcelList = Parcel::whereIn('id', $idList)->get();

                // check data exist
                if (count($parcelList) > 0) {
                    $result['status'] = Response::HTTP_OK;
                    $result['data'] = ParcelResource::collection($parcelList);
                } else {
                    $result['status'] = Response::HTTP_NOT_FOUND;
                    $result['message'] = 'Data is not found';
                }
            } catch (\Throwable $throwable) {
                $result['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
                $result['message'] = 'Internal server error';
            }
        }
        return $result;
    }

    /**
     * Update the specified parcel in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateParcel(Request $request, $id)
    {

        $result = [];
        try {
            // get parcel by id
            $parcel = Parcel::find($id);

            // get parcel exist
            if ($parcel) {
                // check the fields need update or not
                if (!empty($request->input('item_name'))) {
                    $parcel->item_name = $request->input('item_name');
                }
                if (!empty($request->input('weight'))) {
                    $parcel->weight = $request->input('weight');
                }
                if (!empty($request->input('volume'))) {
                    $parcel->volume = $request->input('volume');
                }
                if (!empty($request->input('declared_value'))) {
                    $parcel->declared_value = $request->input('declared_value');
                }
                if (!empty($request->input('chosen_model'))) {
                    $parcel->chosen_model = $request->input('chosen_model');
                }
                if (!empty($request->input('quote'))) {
                    $parcel->quote = $request->input('quote');
                }

                $parcel->save();
                $result['status'] = Response::HTTP_OK;
                $result['message'] = 'Update successful';
            } else {
                $result['status'] = Response::HTTP_NOT_FOUND;
                $result['message'] = 'Data is not found';
            }
        } catch (\Throwable $throwable) {
            $result['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['message'] = 'Internal server error';
        }
        return $result;
    }

    /**
     * Remove the specified parcel from storage.
     *
     * @param $id
     * @return array
     */
    public function deleteParcel($id)
    {
        $result = [];
        try {
            // get parcel by id
            $parcel = Parcel::find($id);

            // check parcel exist
            if ($parcel) {
                $parcel->delete();
                $result['status'] = Response::HTTP_OK;
                $result['message'] = 'Delete successful';
            } else {
                $result['status'] = Response::HTTP_NOT_FOUND;
                $result['message'] = 'Data is not found';
            }
        } catch (\Throwable $throwable) {
            $result['status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
            $result['message'] = 'Internal server error';
        }
        return $result;
    }
}
