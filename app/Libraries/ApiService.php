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
                // Use native PHP cURL for file uploads (more reliable)
                $ch = curl_init($this->baseUrl . $endpoint);
                
                // Prepare multipart data
                $postFields = [];
                
                // Add regular data
                foreach ($data as $key => $value) {
                    $postFields[$key] = $value;
                }
                
                // Add files
                foreach ($files as $key => $file) {
                    if (is_array($file)) {
                        // Multiple files (not commonly used)
                        foreach ($file as $f) {
                            $postFields[$key] = new \CURLFile($f->getTempName(), $f->getClientMimeType(), $f->getClientName());
                        }
                    } else {
                        // Single file
                        $postFields[$key] = new \CURLFile($file->getTempName(), $file->getClientMimeType(), $file->getClientName());
                    }
                }
                
                // Set cURL options
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_POSTFIELDS => $postFields,
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Bearer ' . $this->token,
                        'Accept: application/json',
                    ],
                    CURLOPT_TIMEOUT => 30,
                ]);
                
                // Execute request
                $body = curl_exec($ch);
                $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $error = curl_error($ch);
                curl_close($ch);
                
                // Handle cURL errors
                if ($body === false) {
                    return [
                        'success' => false,
                        'status' => 'error',
                        'message' => 'cURL Error: ' . $error,
                        'http_code' => 500,
                    ];
                }
                
                $result = json_decode($body, true);
                
                // Handle empty or invalid JSON response
                if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                    return [
                        'success' => false,
                        'status' => 'error',
                        'message' => 'Invalid JSON response from API',
                        'http_code' => $statusCode,
                        'raw_response' => $body,
                    ];
                }
                
                // Handle 401 Unauthorized
                if ($statusCode === 401) {
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
                
                $result['success'] = in_array($statusCode, [200, 201]);
                $result['http_code'] = $statusCode;
                
                return $result;
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
