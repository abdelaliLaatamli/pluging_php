<?php 

namespace Pipline\Interfaces ;

interface IProsses {

    public function convert( callable $e ):IProsses;
    public function clean(   callable $e ):IProsses;
    public function analyze( callable $e ):IProsses;
    public function prosses( ): IConsume;

}