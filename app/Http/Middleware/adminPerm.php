<?php

namespace App\Http\Middleware;

use Closure;
use App\models\Tbl_admin_perm;
use App\models\Submenu;
use App\models\Menu;
use DB;
use Auth;
class adminPerm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $url = $request->path();
        $Submenu = strtok($url, "/");
        while ($Submenu != false) {
           $tmp = $Submenu;
           $Submenu = strtok("/");
        }
        $menu_id = DB::table('url')->where('urlName', $tmp)->first()->menu_id;
        
        $perm = DB::table('admin_perm')
                ->where('admin_id', Auth::user()->uid)
                ->where('submenu_id', $menu_id)
                ->first();
        $perm_view = $perm->perm_view;
        $perm_upd = $perm->perm_upd;
        $perm_del = $perm->perm_del;
        
        if($perm_view == 1 || $perm_upd == 1 || $perm_del == 1)
            return $next($request);
        return redirect('/sysinform');
        }
}
