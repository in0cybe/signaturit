<?php

namespace App\_Domain\BusinessLogic;

use App\Models\ModelFactory;

class ReceiveEmployees
{

  protected $endpointModel, $requestModel, $resourcesModel, $json;

  /**
   * Instance of models through the model factory
   */
  public function __construct()
  {
    $this->endpointModel = ModelFactory::createIntegraEndPointsModel(); // EndPoints
    $this->requestModel =  ModelFactory::createIntegraRequestModel(); // Request 
    $this->resourcesModel =  ModelFactory::createResourcesModel(); // Resources  
  }

  /**
   * Get and Process Pending Jobs (ordered)
   *
   * @param Json $json
   * @return BusinessResponse
   */
  public function startProcess($json)
  {
    /** loads the current job into the backlog stack */
    $this->generateNewRequest($json);

    /** Get Pending Jobs */
    // request_id = 13 (EMPLOYEES	EmployeeIntegration)
    $pendingJobs = $this->requestModel->getPendingRequests(13);

    /** Process Pending Jobs */
    return $this->employeeIntegration($pendingJobs);
  }

  /**
   * Generate a new request
   *
   * @return void
   */
  protected function generateNewRequest($json)
  {
    $endpoint = $this->endpointModel->getEndPoint('EMPLOYEES', 'EmployeeIntegration', null);
    $this->requestModel->saveRequest('save', null, $endpoint, 0, 0, 'STARTING EMPLOYEE INTEGRATION', 0, json_encode($json));
  }

  /**
   * Insert the employees that are in the backlog
   *
   * @param IntegraRequesModel $pendingJobs
   * @return BusinessResponse
   */
  protected function employeeIntegration($pendingJobs)
  {
    $currentEndpoint = null;
    foreach ($pendingJobs as $JobsIntegraRequest) {
      /** Send Pending Jobs */
      $currentEndpoint = $this->getEndpointFromRequest($JobsIntegraRequest);
      try {

        /** Send resources RH to DB */
        $response = $this->resourcesModel->insertResources($currentEndpoint);       
        
        if ($response->result === false) {
          # Rack the Job again in the stack of work
          $this->requestModel->saveRequest('update', null, $currentEndpoint, $JobsIntegraRequest->retry + 1, 99, "KO", 400, $currentEndpoint->body);
          $statusCode = 400;
        }else{
          $this->requestModel->saveRequest('update', null, $currentEndpoint, $JobsIntegraRequest->retry + 1, 1, "OK", 200, $currentEndpoint->body);
          $statusCode = 200;
        }
        log_message('info', 'EndPoint ID: '.$currentEndpoint->id .'StatusCode: '.$statusCode);
      } catch (\Exception $e) {
        log_message('error', 'Exception in employeeIntegration(): ' . $e->getMessage());
        return new BusinessResponse(false, ' employeeIntegration(): ' . $e->getMessage());
      }
    }
    /** End of the process */
    log_message('info', 'Info: Process Completed Successfully.');
    return new BusinessResponse(true, 'Info: Process Completed Successfully.');
  }

  /**
   * Get an endpoint from a request
   *
   * @param IntegraRequestModel $request
   * @return IntegraEndPointsModel $endpoint
   */
  protected function getEndpointFromRequest($request)
  {
    $endpoint = $this->endpointModel->getEndPoint('EMPLOYEES', 'EmployeeIntegration', null);
    $endpoint->body = $request->json;
    $endpoint->request_id = $request->request_id;
    return $endpoint;
  }
}
