<?php

test('the application redirects to login when unauthenticated', function () {
    $response = $this->get('/');

    $response->assertStatus(302);
});
