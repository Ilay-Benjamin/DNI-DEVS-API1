<?php
class UserController extends BaseController
{

    public function action( string $actionName ) {
        try {
            switch ($actionName) {
                case 'list': $this->execute('executeListAction'); break;
                case 'find': $this->execute('executeFindAction'); break;
                case 'append': $this->execute('executeAppendAction'); break;
                case 'delete': $this->execute('executeDeleteAction'); break;
                case 'update': $this->execute('executeUpdateAction'); break;
                default: throw new Exception('The action "'.$actionName.'" does not exist.');
            }
        } catch (Exception $e) {
            $this->sendOutput(OutputBuilder::notFoundOutput($e->getMessage()));
        }
    }
    private function executeListAction( $query, $userModel ) {
        if ( isset($query['limit']) )
            $intLimit = $query['limit'];
        return $userModel->getUsers($intLimit);
    }
    private function executeFindAction( $query, $userModel ) {
        $field = '';
        if ( isset($query['id']) && !isset($query['email']) ) {
            $field = 'id';
        }
        else if ( isset($query['email']) && !isset($query['id']) ) {
            $field = 'email';
        }
        $data = $query[$field];
        return $userModel->findUser($data, $field);
    }
    private function executeAppendAction( $query, $userModel ) {
        if ( isset($query['phoneNumber']) && isset($query['email']) && isset($query['fullname']) )
            $user = new User($query['phoneNumber'], $query['email'], $query['fullname']);
        return $userModel->appendUser($user);
    }
    private function executeDeleteAction( $query, $userModel ) {
        if ( isset($query['id']) )
            $id = $query['id'];
        return $userModel->deleteUser($id);
    }
    private function executeUpdateAction( $query, $userModel ) {
        $userTableFields = ['id', 'phoneNumber', 'email', 'fullname'];
        if ( isset($query['id']) && (isset($query['phoneNumber']) || isset($query['email']) || isset($query['fullname'])) ) {
            $changes = [];
            $id = $query['id'];
            foreach ($userTableFields as $field) {
                if (isset($query[$field]))
                    $changes[$field] = $query[$field];
            }
        }    
         return $userModel->updateUser($changes, $id);
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