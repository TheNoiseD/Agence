<?php

namespace App\Repositories;

use App\Models\CaoUser;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    protected CaoUser $user;
    public function __construct(CaoUser $user)
    {
        $this->user = $user;
    }

    public function allConsultors()
    {
        return $this->user->join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
            ->where('permissao_sistema.co_sistema', 1)
            ->where('permissao_sistema.in_ativo', 'S')
            ->whereIn('permissao_sistema.co_tipo_usuario', [0, 1, 2])
            ->get();
    }

    public function getReceitas($users = [])
    {
       return DB::table('cao_fatura as cf')
           ->join('cao_os as co', 'cf.co_os', '=', 'co.co_os')
           ->join('cao_salario as cs', 'co.co_usuario', '=', 'cs.co_usuario')
           ->join('cao_usuario as usr', 'co.co_usuario', '=', 'usr.co_usuario')
           ->selectRaw("
        usr.no_usuario,
        DATE_FORMAT(cf.data_emissao, '%Y-%m') AS periodo,
        ROUND(SUM(cf.valor - (cf.valor * cf.total_imp_inc / 100)), 2) AS receta_liquida,
        cs.brut_salario AS costo_fijo,
        ROUND(SUM((cf.valor - (cf.valor * cf.total_imp_inc / 100)) * (cf.comissao_cn / 100)), 2) AS comision,
        ROUND(SUM(cf.valor - (cf.valor * cf.total_imp_inc / 100))-(cs.brut_salario + SUM((cf.valor - (cf.valor * cf.total_imp_inc / 100)) * (cf.comissao_cn / 100))), 2) AS lucro"
           )
           ->whereIn('usr.co_usuario', $users)
           ->groupBy('usr.no_usuario')  // Incluir usr.no_usuario en la cláusula GROUP BY
           ->groupBy('periodo')
           ->groupBy('costo_fijo')
           ->get();

    }

}
