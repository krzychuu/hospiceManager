<?php

namespace Hospice\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HospiceUserBundle extends Bundle
{
    public function getParent() 
    {
        return 'FOSUserBundle';
    }
}
