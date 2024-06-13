<?php

namespace Helpers;

const API_ENDPOINT = "http://127.0.0.1:8000/api";

// Request Class
class Request {

    // Object parameters
    private $method;
    private $endPoint;
    private $data;

    // Other variables
    private $curl;
    public $response;

    public function __construct(string $method, string $endPoint, array $data) {
        $this->method = $method;
        $this->endPoint = $endPoint;
        $this->data = $data;
    }

    public function send() {
        $this->curl = curl_init(API_ENDPOINT . $this->endPoint);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($this->data));
        $response = curl_exec($this->curl);
        // var_dump($this->response);

        if (!$response) return null;
        $this->response = json_decode($response, true);
        
        return $this->response;
        return json_decode($response, true);
    }

    public function isSuccess() {
        if(!$this->response) return false;
        return $this->response['status'] === 'success';
    }

    public function isError() {
        return !$this->isSuccess();
    }

    public function getError() {
        return $this->response->message;
    }

}

// Save Submission Method
function saveSubmission($formId, $details) {
    $request = new Request('POST',  '/f/' . $formId, $details);
    $request->send();
    return $request->response;
}

// Check if the request expects JSON as response
function expectsJson() {
    $acceptHeader = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
    return strpos($acceptHeader, 'application/json') !== false;
}