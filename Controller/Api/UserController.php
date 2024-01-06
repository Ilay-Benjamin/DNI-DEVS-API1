<?php
class UserController extends BaseController
{

    public function action( string $actionName ) {
        try {
            switch ($actionName) {
                case 'list': $this->execute('executeListAction'); break;
                case 'find': $this->execute('executeFindAction'); break;
                case 'append': $this->execute('executeAppendAction'); break;
                default: throw new Exception('The action "'.$actionName.'" does not exist.');
            }
        } catch (Exception $e) {
            $output = OutputBuilder::notFoundOutput($e->getMessage());
            $this->sendOutput($output);
        }
    }
    private function executeListAction( $query, $userModel ) {
        if ( isset($query['limit']) )
            $intLimit = $query['limit'];
        return $userModel->getUsers($intLimit);
    }
    private function executeFindAction( $query, $userModel ) {
        if ( isset($query['id']) )
            $id = $query['id'];
        return $userModel->findUser($id);
    }
    private function executeAppendAction( $query, $userModel ) {
        if ( isset($query['username']) && isset($query['password']) && isset($query['fullname']) && isset($query['bio']) )
            $user = new User($query['username'], $query['password'], $query['fullname'], $query['bio']);
        return $userModel->appendUser($user);
    }

    private function execute( $func ) {
        $output = new Output();
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $query = $this->getQueryStringParams();
        if ( strtoupper($requestMethod) == 'GET' ) {
            try {
                $responseData = json_encode($this->$func($query, new UserModel()));
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