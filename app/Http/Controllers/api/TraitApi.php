<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Response;
use App\Http\Requests;

trait TraitApi{

    /**
     * Header Http Ok 
     * @var int
     */
    private $ok = Response::HTTP_OK;

    /** 
     * Header Http Created
     *  @var int
     */
    private $created = Response::HTTP_CREATED;

    /**
     * Header Http Not Found
     * @var int
     */
    private $not_found = Response::HTTP_OK;

    /**
     * Header Http prohibited
     * @var int
     */
    private $not_authorize = Response::HTTP_FORBIDDEN;

    /**
     * Response API Format
     * @param           $status[ok,created,error]
     * @param           $data 
     * @param string    $msg 
     */
    public function responseApi($status, $data, $msg)
    {
        switch($status){
            case'ok': 
                $response = $this->responseOk($data, $msg);
            break;
            case 'created' :
                $response = $this->responseCreated($data,$msg);
            break;
            case 'error' :
                $response = $this->responseError($msg);
            break;
            case 'unauthorized' :
                $response = $this->responseUnAuthorized($msg, $msg);
            break;
            case 'notfound' :
                $response = $this->responseUnAuthorized($msg, $msg);
            break;
            default:
                $response = $this->responseError("Error Response Handler");
            break;
        }
        return $response;
    }

      /**
     * Response Ok
     * @param $data
     * @param $msg
     *
     * @return \Illuminate\Http\Response
     */
    public function responseOk($data, $msg)
    {
        return response([
            'status'        => $this->ok,
            "success"       => true,
            "error"         => false,
            'response_time' => microtime(true) - LARAVEL_START,
            'messages'      =>  $msg,
            'data'          => $data
        ], $this->ok);
    }

    /**
     * Response Created
     * @param $data
     * @param $msg
     *
     * @return \Illuminate\Http\Response
     */
    public function responseCreated($data, $msg)
    {
        return response([
            'status'        => $this->created,
            "success"       => true,
            "error"         => false,
            'response_time' => microtime(true) - LARAVEL_START,
            'messages'      => $msg,
            'data'          => $data
        ], $this->created);
    }

    /**
     * Response Error
     * @param $msg
     *
     * @return \Illuminate\Http\Response
     */
    public function responseError($msg)
    {
        return response([
            'status'        => $this->ok,
            "success"       => false,
            "error"         => true,
            'response_time' => microtime(true) - LARAVEL_START,
            'messages'      => $msg,
            'data' => [
                'message'   =>  $msg,
            ]
        ], $this->not_found);
    }

    /**
     * Response Error
     * @param $msg
     *
     * @return \Illuminate\Http\Response
     */
    public function responseNotAuthorize($msg)
    {
        return response([
            'status'        => 403,
            "success"       => false,
            "error"         => true,
            'response_time' => microtime(true) - LARAVEL_START,
            'messages'      => $msg,
            'data' => [
                'message'   =>  $msg,
            ]
        ], $this->not_found);
    }

    /**
     * Response Error
     * @param $msg
     *
     * @return \Illuminate\Http\Response
     */
    public function responseUnAuthorized($msg)
    {
        return response([
            'status'        => 401,
            "success"       => false,
            "error"         => true,
            'response_time' => microtime(true) - LARAVEL_START,
            'messages'      => $msg,
            'data' => [
                'message'   =>  $msg,
            ]
        ], $this->not_found);
    }

    public function responseNotFound($msg)
    {
        return response([
            'status'        => 404,
            "success"       => false,
            "error"         => true,
            'response_time' => microtime(true) - LARAVEL_START,
            'messages'      => $msg,
            'data' => [
                'message'   =>  $msg,
            ]
        ], $this->not_found);
    }
}

