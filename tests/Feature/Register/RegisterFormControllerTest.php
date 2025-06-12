<?php

namespace Tests\Feature\Register;

use Tests\TestCase;

class RegisterFormControllerTest extends TestCase
{
    public function test_register_form_display_successfully()
    {
        $response = $this->get('register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }
}
