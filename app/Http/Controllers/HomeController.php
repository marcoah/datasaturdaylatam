<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\HomeRouter;
use App\Services\ProfileRouter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Basico;
use App\Models\Capa;

class HomeController extends Controller
{
    private HomeRouter $homeRouter;
    private ProfileRouter $profileRouter;

    public function __construct(HomeRouter $homeRouter, ProfileRouter $profileRouter)
    {
        $this->middleware('auth');
        $this->homeRouter = $homeRouter;
        $this->profileRouter = $profileRouter;
    }

    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        // Delegate view-routing by role to the HomeRouter service
        return $this->homeRouter->homeViewFor($user);
    }

    public function profile()
    {
        /** @var User|null $user */
        $user = Auth::user();

        // Delegate view-routing by role to the HomeRouter service
        return $this->profileRouter->profileViewFor($user);
    }

    public function settings()
    {
        return view('dashboards.settings');
    }

    public function testMail(Request $request)
    {
        $destinatario = $request->destinatario;
        $preheader = "Correo de prueba desde " . ENV('APP_NAME', '');
        $asunto = $request->asunto;
        $mensaje = $request->mensaje;
        $etiqueta = 'Prueba';

        $header_img = '';
        $resultado = 'Resultado: ';

        try {
            Mail::to($destinatario)->send(new Basico($preheader, $header_img, $asunto, $mensaje, $etiqueta));
            $resultado = $resultado . "Envio a $destinatario: Correcto.";
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('message' => $e->getmessage()));
        };

        return redirect()->back()->with('success', $resultado);
    }

    public function mapa_interno()
    {
        $capas = Capa::All();
        return view('mapas.interno', compact('capas'));
    }

    public function search($search)
    {
        /*
        $search = urldecode($search);

        $razonsocial = Cliente::where('cliente_nombre', 'LIKE', '%' . $search . '%');
        $correo1 = Cliente::where('cliente_email1', 'LIKE', '%' . $search . '%');

        $resultado = Cliente::where('cliente_email2', 'LIKE', '%' . $search . '%')
            ->union($razonsocial)
            ->union($correo1)
            ->paginate(10);

        if (count($resultado) == 0) {
            return View('escritorio.busqueda')
                ->with('message', 'No hay resultados que mostrar')
                ->with('search', $search);
        } else {
            return View('escritorio.busqueda')
                ->with('resultados', $resultado)
                ->with('search', $search);
        }
        */
    }
}
