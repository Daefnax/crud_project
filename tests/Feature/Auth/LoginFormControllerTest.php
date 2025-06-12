<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LoginFormControllerTest extends TestCase
{
    public function test_login_form_displays_successfully()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

}
