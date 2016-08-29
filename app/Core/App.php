<?php
class App{
    /**
     * app start
     */
    public function start(){
        $route = SampleRoute::singleton();
        $route->exec();
    }
}