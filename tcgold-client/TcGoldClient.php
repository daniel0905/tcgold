<?php
require 'Parcel.php';

/**
 * Class TcGoldClient
 */
class TcGoldClient
{
    private $email;
    private $password;
    private $baseUrl;

    /**
     * TcGoldClient constructor.
     */
    public function __construct($email, $password, $baseUrl)
    {
        $this->email = $email;
        $this->password = $password;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Call API
     *
     * @param $method
     * @param $url
     * @param false $data
     * @return bool|string
     */
    private function call($method, $url, $data = false)
    {
        $url = $this->baseUrl . $url;
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $this->email . ':' . $this->password);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    /**
     * Get single parcel
     *
     * @param $id
     * @return mixed
     */
    public function getSingleParcel($id)
    {
        $method = 'GET';
        $url = '/api/parcels/' . $id;
        $data = false;
        return json_decode($this->call($method, $url, $data));
    }

    /**
     * Get multiple parcel
     *
     * @param $idList
     * @return mixed
     */
    public function getMultipleParcel($idList)
    {
        // check $idList is array
        if (!is_array($idList)) {
            return null;
        }

        $method = 'GET';
        $url = '/api/parcels/';
        $data = $idList;
        return json_decode($this->call($method, $url, $data));
    }

    /**
     * Create parcel
     *
     * @param Parcel $parcel
     * @return mixed
     */
    public function createParcel(Parcel $parcel)
    {
        $method = 'POST';
        $url = '/api/parcels/';
        $data = $parcel->toJSON();
        return json_decode($this->call($method, $url, $data));
    }

    /**
     * Update parcel
     *
     * @param Parcel $parcel
     * @return mixed
     */
    public function updateParcel(Parcel $parcel, $id)
    {
        $method = 'PUT';
        $url = '/api/parcels/' . $id;
        $data = $parcel;
        return json_decode($this->call($method, $url, $data));
    }

    /**
     * Delete
     *
     * @param $id
     * @return mixed
     */
    public function deleteParcel($id)
    {
        $method = 'DELETE';
        $url = '/api/parcels/' . $id;
        $data = false;
        return json_decode($this->call($method, $url, $data));
    }
}