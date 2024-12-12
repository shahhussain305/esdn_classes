<?php 
class SecurityPolicy {
    private $directives = [];

    public function addDirective(string $name, string $value): void {
        $this->directives[$name][] = $value;
    }

    public function buildHeader(): string {
        $header = "Content-Security-Policy: ";
        foreach ($this->directives as $name => $values) {
            $header .= $name . " " . implode(" ", $values) . "; ";
        }
        return rtrim($header, "; ");
    }

    public function apply(): void {
        header($this->buildHeader());
    }


    /**
     * Set a secure cookie.
     */
    public function setSecureCookie(
        string $name,
        string $value,
        int $expiry = 0,
        string $path = "/",
        string $domain = "",
        bool $httpOnly = true,
        bool $secure = true,
        string $sameSite = "Strict"
    ): void {
        $options = [
            'expires' => $expiry,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httponly' => $httpOnly,
            'samesite' => $sameSite
        ];
        setcookie($name, $value, $options);
    }

    /**
     * Initialize a secure session.
     */
    public function startSecureSession(): void {
        // Set session cookie parameters
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '', // Set domain if needed
            'secure' => true, // Transmit cookies over HTTPS only
            'httponly' => true, // Accessible only via HTTP(S), not JavaScript
            'samesite' => 'Strict' // Prevent CSRF
        ]);

        // Start the session
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Regenerate session ID to prevent fixation
        session_regenerate_id(true);
    }




}

// Usage
// $sp = new SecurityPolicy();
// $sp->addDirective('script-src', "'self'");
// $sp->addDirective('style-src', "'self' 'unsafe-inline'");
// $sp->addDirective('img-src', "'self' https://example.com");
// $sp->apply();

/*
Hybrid Approach
For applications with a mix of uniform and page-specific SecurityPolicy needs, you can combine the two:

Define a base SecurityPolicy in index.php or a global template.
Extend or override the CSP using a class or method for specific pages.

Example: 

        // index.php
            include 'SecurityPolicy.php';
            $sp = new SecurityPolicy();
            $sp->addDirective('default-src', "'self'");
            $sp->addDirective('script-src', "'self'");
            $sp->apply();

        // On a specific page
            $sp->addDirective('script-src', "'self' https://cdn.example.com");
            $sp->apply();

    // Set a secure cookie
        $security->setSecureCookie('user_session', 'random_session_token', time() + 3600, '/', '', true, true, 'Strict');

    // Start a secure session
        $security->startSecureSession();

*/