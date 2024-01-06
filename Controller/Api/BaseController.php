<?php
class BaseController
{
    /** 
     * __call magic method. 
     */
    public function __call( $name, $arguments ) {
        $this->sendOutput(OutputBuilder::notFoundOutput());
    }
    /** 
     * Get URI elements. 
     *  
     * @return array 
     */
    protected function getUriSegments() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        return $uri;
    }
    /** 
     * Get querystring params. 
     *  
     * @return array 
     */
    protected function getQueryStringParams() {
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }
    /** 
     * Send API output. 
     * 
     * @param mixed $data 
     * @param string $httpHeader 
     */
    protected function sendOutput( Output $output ) {
        header_remove('Set-Cookie');
        if ( is_array($output->getHttpHeaders()) && count($output->getHttpHeaders()) ) {
            foreach ( $output->getHttpHeaders() as $httpHeader ) {
                header($httpHeader);
            }
        }
        echo $output->getData();
        exit;
    }
}