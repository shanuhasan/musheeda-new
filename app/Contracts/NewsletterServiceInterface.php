<?php

namespace App\Contracts;

interface NewsletterServiceInterface
{
    /**
     * Subscribe a user to the newsletter.
     * 
     * @param string $email
     * @param array $data Additional data (source, ip, etc.)
     * @return bool
     */
    public function subscribe(string $email, array $data = []): bool;

    /**
     * Unsubscribe a user from the newsletter.
     * 
     * @param string $email
     * @return bool
     */
    public function unsubscribe(string $email): bool;

    /**
     * Verify a subscription using a token.
     * 
     * @param string $token
     * @return bool
     */
    public function verify(string $token): bool;

    /**
     * Unsubscribe a user using a token.
     * 
     * @param string $token
     * @return bool
     */
    public function unsubscribeByToken(string $token): bool;
}
