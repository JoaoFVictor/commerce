<?php

namespace App\Rules;

use App\Models\Usuario;
use Illuminate\Contracts\Validation\Rule;

class CodigoDeBarrasUnicoParaUsuario implements Rule
{
    private ?array $produtos;

    private ?int $produto;

    private ?string $nomeProduto;

    public function __construct()
    {
        $this->produto = null;
        $this->produtos = null;
    }

    public function setProduto(?int $produto): CodigoDeBarrasUnicoParaUsuario
    {
        $this->produto = $produto;

        return $this;
    }

    public function setProdutos(?array $produtos): CodigoDeBarrasUnicoParaUsuario
    {
        $this->produtos = $produtos;

        return $this;
    }

    public function setNomeProduto($nomeProduto): CodigoDeBarrasUnicoParaUsuario
    {
        $this->nomeProduto = $nomeProduto;

        return $this;
    }

    public function passes($nomeCampo, $valor): bool
    {
        $usuarioLogado = auth('sanctum')->user();

        return ! ($this->falhaCodigoBarrasUnicoDoProduto($usuarioLogado, $valor) || $this->falhaCodigoBarrasUnicoDaListaProduto($usuarioLogado, $valor));
    }

    public function message(): string
    {
        return "Um produto possui um código de barras em uso. Produto: {$this->nomeProduto}";
    }

    private function falhaCodigoBarrasUnicoDoProduto(Usuario $usuarioLogado, $valor): bool
    {
        if ($this->produto) {
            $consultaCodigoEmUso = $usuarioLogado->produto()->where('codigo_barras', $valor);

            if ($this->produto) {
                $consultaCodigoEmUso->where('id', '!=', $this->produto);
            }

            return $consultaCodigoEmUso->exists();
        }

        return false;
    }

    private function falhaCodigoBarrasUnicoDaListaProduto(Usuario $usuarioLogado): bool
    {
        if ($this->produtos) {
            foreach ($this->produtos as $produto) {
                $consultaCodigoEmUso = $usuarioLogado->produto()->where('codigo_barras', $produto['codigo_barras'])->exists();
                if ($consultaCodigoEmUso) {
                    $this->nomeProduto = $produto['nome'];

                    return true;
                }
            }
        }

        return false;
    }
}
