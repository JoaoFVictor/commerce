<?php

return [
    'mail' => [
        'reset_password' => env('MENSAGEM_SUCESSO_RESETAR_SENHA', 'Senha resetada com sucesso!'),
        'verify' => env('MENSAGEM_SUCESSO_VERIFICAR_EMAIL', 'Seu email foi verificado com sucesso!'),
    ],

    'error' => [
        'server' => 'Algo de errado não está certo. Entre em contato com o suporte!',
    ],
];
