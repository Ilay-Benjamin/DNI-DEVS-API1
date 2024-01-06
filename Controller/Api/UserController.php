<?php
class UserController extends BaseController
{

    public function listAction() { $this->action('executeListAction'); }
    public function findAction() { $this->action('executeFindAction'); }
    public function appendAction() { $this->action('executeAppendAction'); }
    
    private function executeListAction($query, $userModel) {
        if ( isset($query['limit']) )
            $intLimit = $query['limit'];
        return json_encode($userModel->getUsers($intLimit));
    }
    private function executeFindAction($query, $userModel) {
        if ( isset($query['id']) )
            $id = $query['id'];
        return json_encode($userModel->getUsers($id));
    }
    private function executeAppendAction($query, $userModel) {
        if ( isset($query['username']) && isset($query['password']) && isset($query['fullname']) && isset($query['bio']) )
            $user = new User($query['username'], $query['password'], $query['fullname'], $query['bio']);
            return json_encode($userModel->appendUser($user));
    }

    private function action($func) {
        $output = new Output();
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $query = $this->getQueryStringParams();
        if ( strtoupper($requestMethod) == 'GET' ) {
            try {
                $responseData = $this->$func($query, new UserModel());
            } catch ( Error $e ) {
                $output = OutputBuilder::internalServerErrorOutput($e->getMessage() . 'Something went wrong! Please contact support.');
            }
        } else {
            $output = OutputBuilder::unprocessableEntityOutput();
        }
        if ( !$output->getIsError() )
            $this->sendOutput(OutputBuilder::okOutput($responseData));
        else
            $this->sendOutput($output);
    }

}