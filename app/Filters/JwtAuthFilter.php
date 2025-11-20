<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use App\Models\JwtBlacklistModel;

class JwtAuthFilter implements FilterInterface
{
    /**
     * Check JWT token before request
     * 
     * @param array|null $arguments - Can pass role to check (e.g., ['client'] or ['tukang'])
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');
        
        // Get Authorization header - try multiple methods
        $authHeader = $request->getHeaderLine('Authorization');
        
        // Fallback: try to get from $_SERVER
        if (empty($authHeader)) {
            if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
                $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            } elseif (function_exists('apache_request_headers')) {
                $headers = apache_request_headers();
                $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
            }
        }
        
        if (empty($authHeader)) {
            // Log untuk debugging
            log_message('error', 'JWT Auth: No Authorization header found. Headers: ' . json_encode($request->getHeaders()));
            
            return $response->setStatusCode(401)
                           ->setJSON([
                               'status' => 'error',
                               'message' => 'Token tidak ditemukan. Silakan login terlebih dahulu.'
                           ]);
        }
        
        // Extract token from "Bearer <token>"
        $parts = explode(' ', $authHeader);
        if (count($parts) !== 2 || strtolower($parts[0]) !== 'bearer') {
            return $response->setStatusCode(401)
                           ->setJSON([
                               'status' => 'error',
                               'message' => 'Format token tidak valid. Gunakan: Bearer <token>'
                           ]);
        }
        
        $token = $parts[1];
        
        try {
            // Check if token is blacklisted (using hash for security)
            $blacklistModel = new JwtBlacklistModel();
            $tokenHash = hash('sha256', $token);
            $isBlacklisted = $blacklistModel->where('token_hash', $tokenHash)->first();
            
            if ($isBlacklisted) {
                return $response->setStatusCode(401)
                               ->setJSON([
                                   'status' => 'error',
                                   'message' => 'Token telah diblacklist. Silakan login kembali.'
                               ]);
            }
            
            // Decode and verify token
            $key = env('JWT_SECRET_KEY');
            if (empty($key)) {
                log_message('error', 'JWT_SECRET_KEY not configured in .env');
                return $response->setStatusCode(500)
                               ->setJSON([
                                   'status' => 'error',
                                   'message' => 'JWT configuration error'
                               ]);
            }
            
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            
            // Convert decoded object to array
            $userData = (array) $decoded;
            
            // Check if user data is valid
            if (empty($userData['id']) || empty($userData['role_id'])) {
                return $response->setStatusCode(401)
                               ->setJSON([
                                   'status' => 'error',
                                   'message' => 'Token tidak valid atau rusak'
                               ]);
            }
            
            // Check role if specified in arguments
            if (!empty($arguments)) {
                $requiredRole = is_array($arguments) ? $arguments[0] : $arguments;
                
                // Map role names to role IDs
                $roleMap = [
                    'admin' => 1,
                    'client' => 2,
                    'tukang' => 3
                ];
                
                $requiredRoleId = $roleMap[$requiredRole] ?? null;
                
                if ($requiredRoleId && $userData['role_id'] != $requiredRoleId) {
                    return $response->setStatusCode(403)
                                   ->setJSON([
                                       'status' => 'error',
                                       'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses resource ini.'
                                   ]);
                }
            }
            
            // Store user data in request for use in controllers
            $request->userData = $userData;
            $request->userId = $userData['id'];
            $request->userRoleId = $userData['role_id'];
            
            // Success - continue to controller
            return $request;
            
        } catch (ExpiredException $e) {
            return $response->setStatusCode(401)
                           ->setJSON([
                               'status' => 'error',
                               'message' => 'Token telah kadaluarsa. Silakan login kembali.'
                           ]);
        } catch (SignatureInvalidException $e) {
            return $response->setStatusCode(401)
                           ->setJSON([
                               'status' => 'error',
                               'message' => 'Token tidak valid. Signature tidak cocok.'
                           ]);
        } catch (\Exception $e) {
            log_message('error', 'JWT Auth Error: ' . $e->getMessage());
            return $response->setStatusCode(401)
                           ->setJSON([
                               'status' => 'error',
                               'message' => 'Token tidak valid: ' . $e->getMessage()
                           ]);
        }
    }

    /**
     * After controller execution
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after request
        return $response;
    }
}
