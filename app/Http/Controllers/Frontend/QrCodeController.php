<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $qrCode = QrCode::size(200)->generate(route('filament.app.auth.login'));

        return view('qrcodes.login')->with('qrcode', $qrCode);
    }
}
