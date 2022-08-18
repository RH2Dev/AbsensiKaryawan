<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
class HRCEO implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session()->get();
        if($session['adminStatus'] == 2) {
            return redirect()->to('Admin');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}