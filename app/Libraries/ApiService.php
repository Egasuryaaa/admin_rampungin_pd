<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

/**
 * ApiService Library
 * 
 * Handles all HTTP requests to Node.js backend API
 * Automatically manages JWT authentication tokens
 */
class ApiService
{
    protected $client;
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        // Get base URL from environment
        $this->baseUrl = rtrim(getenv('NODE_API_URL'), '/');
        
        // Initialize CURL client
        $this->client = Services::curlrequest([
            'baseURI' => $this->baseUrl,
            'timeout' => 30,
        ]);

        // Get JWT token from session
        $session = session();
        $this->token = $session->get('jwt_token');
    }

    /**
     * Main request method
     * 
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @param string $endpoint API endpoint path
     * @param array $data Request data (body or query params)
     * @param array $files Files to upload (optional)
     * @return array Response data
     */
    public function request(string $method, string $endpoint, array $data = [], array $files = [])
    {
        try {
            // Prepare headers
            $headers = [
                'Accept' => 'application/json',
            ];

            // Add authorization header if token exists
            if ($this->token) {
                $headers['Authorization'] = 'Bearer ' . $this->token;
            }

            // Prepare request options
            $options = [
                'headers' => $headers,
                'http_errors' => false, // Don't throw exceptions on HTTP errors
            ];

            // Handle different request types
            $method = strtoupper($method);

            if (!empty($files)) {
                // Multipart form data (for file uploads)
                $multipart = [];
                
                foreach ($data as $key => $value) {
                    $multipart[] = [
                        'name' => $key,
                        'contents' => $value,
                    ];
                }

                foreach ($files as $key => $file) {
                    if (is_array($file)) {
                        // Multiple files
                        foreach ($file as $f) {
                            $multipart[] = [
                                'name' => $key,
                                'contents' => fopen($f->getTempName(), 'r'),
                                'filename' => $f->getClientName(),
                            ];
                        }
                    } else {
                        // Single file
                        $multipart[] = [
                            'name' => $key,
                            'contents' => fopen($file->getTempName(), 'r'),
                            'filename' => $file->getClientName(),
                        ];
                    }
                }

                $options['multipart'] = $multipart;
            } elseif ($method === 'GET') {
                // Query parameters for GET
                if (!empty($data)) {
                    $options['query'] = $data;
                }
            } else {
                // JSON body for POST, PUT, DELETE
                if (!empty($data)) {
                    $headers['Content-Type'] = 'application/json';
                    $options['headers'] = $headers;
                    $options['json'] = $data;
                }
            }

            // Make the request
            $response = $this->client->request($method, $endpoint, $options);

            // Get response body
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            $result = json_decode($body, true);

            // Handle empty or invalid JSON response
            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'status' => 'error',
                    'message' => 'Invalid JSON response from API',
                    'http_code' => $statusCode,
                ];
            }

            // Handle 401 Unauthorized (Token expired or invalid)
            if ($statusCode === 401) {
                // Clear session and redirect to login
                $session = session();
                $session->destroy();

                return [
                    'success' => false,
                    'status' => 'error',
                    'message' => 'Session expired. Please login again.',
                    'http_code' => 401,
                    'redirect' => '/auth/login',
                ];
            }

            // Check if request was successful
            $result['success'] = in_array($statusCode, [200, 201]);
            $result['http_code'] = $statusCode;

            return $result;

        } catch (\Exception $e) {
            // Handle exceptions
            log_message('error', 'ApiService Error: ' . $e->getMessage());

            return [
                'success' => false,
                'status' => 'error',
                'message' => 'API request failed: ' . $e->getMessage(),
                'http_code' => 500,
            ];
        }
    }

    /**
     * Convenience methods for common HTTP verbs
     */

    public function get(string $endpoint, array $params = [])
    {
        return $this->request('GET', $endpoint, $params);
    }

    public function post(string $endpoint, array $data = [], array $files = [])
    {
        return $this->request('POST', $endpoint, $data, $files);
    }

    public function put(string $endpoint, array $data = [], array $files = [])
    {
        return $this->request('PUT', $endpoint, $data, $files);
    }

    public function delete(string $endpoint, array $data = [])
    {
        return $this->request('DELETE', $endpoint, $data);
    }

    /**
     * Set custom JWT token (useful for login)
     */
    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get current base URL
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
