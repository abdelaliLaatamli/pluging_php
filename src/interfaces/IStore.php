<?php

namespace Pipline\Interfaces ;


interface IStore {

    public function loadData( mixed $data ): IProsses;

}