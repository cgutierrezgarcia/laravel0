<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    public function __invoke($name, $nickname = null)
    {
        //    if ($nickname) {
        //        return 'Bienvenido '. $name .'. tu apodo es '. $nickname;
        //    }
        //    return 'Bienvenido '. $name .'.';
        return $nickname
            ? 'Bienvenido '. ucfirst($name) .'. tu apodo es '. $nickname
            : 'Bienvenido '. ucfirst($name) .'.';
    }
}
