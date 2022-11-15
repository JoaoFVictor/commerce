<?php

namespace App\Actions\Usuario;

use App\Models\Usuario;
use App\Models\UsuarioToken;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AutenticarUsuarioAction
{
    public function execute(Request $request)
    {
        if ($this->contemMuitasTentativas($request)) {
            $this->eventoBloqueio($request);

            return $this->enviarMensagemBloqueio($request);
        }

        $usuario = Usuario::where('email', $request->input('email'))->first();
        if ($this->autenticar($request, $usuario)) {
            return $this->enviarSucessoLogin($request, $usuario);
        }

        $this->incrementarTentativaLogin($request);

        return $this->enviarErroLogin();
    }

    private function enviarSucessoLogin(Request $request, Usuario $usuario): JsonResponse
    {
        $this->limparTentativasLogin($request);

        $token = $this->tratarToken($usuario);

        return response()->json(['token' => $token]);
    }

    private function autenticar(Request $request, Usuario $usuario): bool
    {
        if (Hash::check($request->senha, $usuario->senha)) {
            return true;
        }

        return false;
    }

    private function tratarToken(Usuario $usuario): string
    {
        $usuarioToken = UsuarioToken::where('name', $usuario->getKey())->first();
        if ($usuarioToken) {
            $usuarioToken->delete();
        }

        return $usuario->createToken($usuario->getKey())->plainTextToken;
    }

    private function enviarErroLogin(): ValidationException
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    private function eventoBloqueio(Request $request): void
    {
        event(new Lockout($request));
    }

    private function limparTentativasLogin(Request $request): void
    {
        $this->limite()->clear($this->chaveRequisicao($request));
    }

    private function enviarMensagemBloqueio(Request $request)
    {
        $segundos = $this->limite()->availableIn(
            $this->chaveRequisicao($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.throttle', [
                'seconds' => $segundos,
                'minutes' => ceil($segundos / 60),
            ])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    private function incrementarTentativaLogin(Request $request): void
    {
        $this->limite()->hit(
            $this->chaveRequisicao($request),
            $this->decadenciaPorMinuto() * 60
        );
    }

    private function contemMuitasTentativas(Request $request): bool
    {
        return $this->limite()->tooManyAttempts(
            $this->chaveRequisicao($request),
            $this->requisicaoMaxima()
        );
    }

    private function chaveRequisicao(Request $request): string
    {
        return Str::lower($request->input($this->username())).'|'.$request->ip();
    }

    private function limite(): RateLimiter
    {
        return app(RateLimiter::class);
    }

    private function requisicaoMaxima(): int
    {
        return property_exists($this, 'requisicaoMaxima') ? $this->requisicaoMaxima : 5;
    }

    private function decadenciaPorMinuto(): int
    {
        return property_exists($this, 'decadenciaPorMinuto') ? $this->decadenciaPorMinuto : 1;
    }

    private function username(): string
    {
        return 'email';
    }
}
