<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Cliente
 *
 * @property int $id
 * @property string $nome
 * @property string|null $telefone
 * @property string|null $bairro
 * @property string|null $rua
 * @property string|null $numero
 * @property string|null $cpf
 * @property int $usuario_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Usuario|null $usuario
 * @method static \Database\Factories\ClienteFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereRua($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereUsuarioId($value)
 */
	class Cliente extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Estoque
 *
 * @property int $id
 * @property int $quantidade
 * @property int $produto_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Produto $produto
 * @method static \Database\Factories\EstoqueFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Estoque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estoque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estoque query()
 * @method static \Illuminate\Database\Eloquent\Builder|Estoque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estoque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estoque whereProdutoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estoque whereQuantidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estoque whereUpdatedAt($value)
 */
	class Estoque extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Imagem
 *
 * @property int $id
 * @property string $caminho
 * @property string $descricao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ImagemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagem whereCaminho($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagem whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagem whereUpdatedAt($value)
 */
	class Imagem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PersonalAccessToken
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property array|null $abilities
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $tokenable
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereTokenableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereTokenableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereUpdatedAt($value)
 */
	class PersonalAccessToken extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Produto
 *
 * @property int $id
 * @property string $codigo_barras
 * @property string $nome
 * @property string $marca
 * @property float|null $preco_custo
 * @property float|null $preco_venda
 * @property string|null $validade
 * @property int $usuario_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Estoque|null $estoque
 * @property-read \App\Models\Usuario $usuario
 * @method static \Database\Factories\ProdutoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Produto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Produto query()
 * @method static \Illuminate\Database\Eloquent\Builder|Produto whereCodigoBarras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto whereMarca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto wherePrecoCusto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto wherePrecoVenda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto whereUsuarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Produto whereValidade($value)
 */
	class Produto extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Usuario
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property bool $status
 * @property string|null $codigo_confirmacao
 * @property string $telefone
 * @property string|null $plano
 * @property int|null $imagem_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $email_verified_at
 * @property string|null $remember_token
 * @property string $password
 * @property-read \App\Models\Imagem|null $imagem
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Produto[] $produto
 * @property-read int|null $produto_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UsuarioFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newQuery()
 * @method static \Illuminate\Database\Query\Builder|Usuario onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereCodigoConfirmacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereImagemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario wherePlano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereSenha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Usuario withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Usuario withoutTrashed()
 */
	class Usuario extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\UsuarioToken
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property string|null $abilities
 * @property string|null $last_used_at
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereTokenableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereTokenableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsuarioToken whereUpdatedAt($value)
 */
	class UsuarioToken extends \Eloquent {}
}

