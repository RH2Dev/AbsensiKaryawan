<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CEO implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here

        $session = session()->get();
        if($session['adminStatus'] != 1) {
            return redirect()->to('Admin');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}