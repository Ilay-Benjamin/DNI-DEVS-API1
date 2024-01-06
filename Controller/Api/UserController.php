<?php
class UserController extends BaseController
{
    /** 
     * "/user/list" Endpoint - Get list of users 
     */
    public function listAction() {

        $output = new Output();
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $query = $this->getQueryStringParams();
        if ( strtoupper($requestMethod) == 'GET' ) {
            try {
                $userModel = new UserModel();
                if ( isset($query['limit']) ) {
                    $intLimit = $query['limit'];
                }
                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
            } catch ( Error $e ) {
                $output = OutputBuilder::internalServerErrorOutput($e->getMessage() . 'Something went wrong! Please contact support.');
            }
        } else {
            $output = OutputBuilder::unprocessableEntityOutput();
        }
        // send output 
        if ( !$output->getIsError() ) {
            $output = OutputBuilder::okOutput($responseData);
            $this->sendOutput($output);
        } else {
            $this->sendOutput($output);
        }
    }

    public function findAction() {
        $output = new Output();
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $query = $this->getQueryStringParams();
        if ( strtoupper($requestMethod) == 'GET' ) {
            try {
                $intId = 1;
                $userModel = new UserModel();
                if ( isset($query['id']) ) {
                    $intId = $query['id'];
                }
                $user = $userModel->findUser($intId);
                $responseData = json_encode($user);
            } catch ( Error $e ) {
                $output = OutputBuilder::internalServerErrorOutput($e->getMessage() . 'Something went wrong! Please contact support.');
            }
        } else {
            $output = OutputBuilder::unprocessableEntityOutput();
        }
        // send output 
        if ( !$output->getIsError() ) {
            $output = OutputBuilder::okOutput($responseData);
            $this->sendOutput($output);
        } else {
            $this->sendOutput($output);
        }
    }


    public function appendAction() {
        $output = new Output();
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $query = $this->getQueryStringParams();
        if ( strtoupper($requestMethod) == 'GET' ) {
            try {
                $stringUsername = "";
                $stringPassword = "";
                $stringBio = "";
                $stringFullname = "";
                $userModel = new UserModel();
                if ( isset($query['username']) && isset($query['password']) && isset($query['fullname']) && isset($query['bio']) ) {
                    $stringUsername = $query['username'];
                    $stringPassword = $query['password'];
                    $stringFullname = $query['fullname'];
                    $stringBio = $query['bio'];
                }
                $user = $userModel->appendUser($stringUsername, $stringPassword, $stringFullname, $stringBio);
                $responseData = json_encode($user);
            } catch ( Error $e ) {
                $output = OutputBuilder::internalServerErrorOutput($e->getMessage() . 'Something went wrong! Please contact support.');
            }
        } else {
            $output = OutputBuilder::unprocessableEntityOutput();
        }
        // send output 
        if ( !$output->getIsError() ) {
            $output = OutputBuilder::okOutput($responseData);
            $this->sendOutput($output);
        } else {
            $this->sendOutput($output);
        }
    }


}