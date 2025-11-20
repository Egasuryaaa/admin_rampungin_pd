<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * Check if request is AJAX
     * 
     * @return bool
     */
    protected function isAjax(): bool
    {
        return $this->request->isAJAX();
    }

    /**
     * Return JSON response
     * 
     * @param array $data
     * @param int $statusCode
     * @return ResponseInterface
     */
    protected function respondWithJson(array $data, int $statusCode = 200): ResponseInterface
    {
        return $this->response
            ->setStatusCode($statusCode)
            ->setContentType('application/json')
            ->setJSON($data);
    }

    /**
     * Return success JSON response
     * 
     * @param string $message
     * @param mixed $data
     * @return ResponseInterface
     */
    protected function respondSuccess(string $message, $data = null): ResponseInterface
    {
        $response = [
            'status' => 'success',
            'pesan' => $message
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return $this->respondWithJson($response);
    }

    /**
     * Return error JSON response
     * 
     * @param string $message
     * @param int $statusCode
     * @return ResponseInterface
     */
    protected function respondError(string $message, int $statusCode = 400): ResponseInterface
    {
        return $this->respondWithJson([
            'status' => 'error',
            'pesan' => $message
        ], $statusCode);
    }
}
