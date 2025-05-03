<?php

namespace App\Helper;

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Route;

//use App\Modules\Auth\Models\ModuleApp;

use App\Modules\Auth\Models\ProfileForm;
use App\Modules\Support\Models\Office;
//use App\Modules\Auth\Models\FormUser;

use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Keygen;
use Carbon\Carbon;

//use Config;

class Utils
{
    /* public static function Date_Extension($date)
     {
         $dt = explode('/', $date);
         $ext = 'Brasília - DF, ';

         $ext .= $dt[0];
         $mes = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

         $ext .= ' de ' . $mes[(int) $dt[1]] . ' de ';
         $ext .= $dt[2];

         return $ext;
     }
*/
    public static function getVersion()
    {
        return '11.34';
    }

    public static function msg($status, $action)
    {
        if ($status) {
            if ($action = 'update') {
                session()->flash('success', 'Registro foi atualizada com sucesso!');
            } else {
                session()->flash('success', 'Registro criado com sucesso!');
            }
        } else {
            if ($action = 'update') {
                session()->flash('error', 'Não foi possível atualizar. Por favor, tente novamente!');
            } else {
                session()->flash('error', 'Não foi possível criar a registro. Por favor, tente novamente!!');
            }
        }
    }

    public static function getProfileUserForm($profileId, $formId)
    {
        $rs = ProfileForm::where('form_id', $formId)->where('profile_id', $profileId)->first();
        $_return = 0;
        if ($rs) {
            $_return = $rs->id;
        }
        return $_return;
    }

    public static function getTempFolder()
    {
        return  storage_path('app/upload');
    }

    public static function getExtensionFile($_file)
    {
        //dd($_file);
        \Log::info($_file);
        $_len = strlen($_file);
        $_file = substr($_file, $_len - 7, 7);

        $arr = explode('.', $_file);
        $count = count($arr);
        return $arr[$count - 1];
    }

    public static function getKey($qtd = 3)
    {
        return Keygen::numeric($qtd)->generate();
    }

    public static function btnAll($save, $back, $url, $urlDelete = '', $id = 0)
    {
        $btn = '<div class="row mb-2 justify-content-xl-center">';
        if ($urlDelete != '') {
            $btn .= '<div class="col-md-3">';
            $btn .= '<a href=" ' . route($urlDelete, $id) . '" class="btn btn-danger"><i class="fas fa-trash"></i> Delete </a>';
            $btn .= '</div>';
        }
        $btn .= '<a href="/' . $url . '" class="btn btn-warning"><i class="fas fa-step-backward"></i>' . $back . '</a>';
        $btn .= '&nbsp;<button class="btn btn-primary " type="submit"> <i class="fas fa-check"></i> &nbsp; ' . $save . '</button>';
        $btn .= '</div>';

        return $btn;
    }

    public static function diffInDays($start, $end)
    {
        $date = Carbon::parse($start)->format('Y-m-d');
        $startDate = Carbon::parse($date);

        $date = Carbon::parse($end)->format('Y-m-d');
        $endDate = Carbon::parse($date);

        // $endDate = Carbon::now()->format('Y-m-d');
        $days = $startDate->diffInDays($endDate);

        return $days;
    }

    public static function pathFileMission($year, $month, $id, $count = 0, $office, $extension = '')
    {
        $dirUpload = '/mnt/file/';
        $file = 'mission_' . $id;

        if ($count != 0) {
            $file .= '_' . $count;
        }

        $return['pathFile'] = $dirUpload . $year . '/' . $office . '/mission/' . $month . '/';
        $return['nameFile'] = $file . '.' . $extension;
        $return['ExtFile'] = $extension;

        return $return;
    }

    public static function pathFileRegistryIN($year, $id, $count = 0, $extension = '', $month = '', $office)
    {
        $dirUpload = '/mnt/file/';

        if (trim($extension) == '') {
            $extension = 'pdf';
        }

        $file = 'reg_in_' . $id;

        if ($count != 0) {
            $file .= '_' . $count;
        }

        return ['pathFile' => $dirUpload .= $year . '/' . $office . '/registry/in/' . $month . '/',
            'nameFile' => $file . '.' . $extension];
    }

    public static function pathFileSign($id, $extension)
    {
        $dirUpload = '/mnt/file/';

        $file = 'sign_' . $id;

        return ['url' => $dirUpload .= 'sign', 'file_name' => $file . '.' . $extension];
    }

    public static function pathFileRegistryOUT($year, $id, $count = 0, $extension = '', $month = '', $office)
    {
        $dirUpload = '/mnt/file/';

        if (trim($extension) == '') {
            $extension = 'pdf';
        }

        $file = 'reg_out_' . $id;

        if ($count != 0) {
            $file .= '_' . $count;
        }

        return ['pathFile' => $dirUpload .= $year . '/' . $office . '/registry/out/' . $month . '/',
            'nameFile' => $file . '.' . $extension];
    }

    public static function downloadFile($path, $name, $type = null)
    {
        $url = $path . $name;

        header('Content-type: application/pdf');

        header('Content-Disposition: inline; filename="' . $name . '"');

        header('Content-Transfer-Encoding: binary');

        header('Content-Length: ' . filesize($url));

        header('Accept-Ranges: bytes');

        @readfile($url);
    }

    public static function disk($disk = 'mnt')
    {
        return Storage::disk($disk)->path('');
        //Config::set('filesystems.disks.mnt.root', $url);
    }

    /*
        public static function setFormCount($idForm)
        {
            $rs = FormUser::where('user_id', static::getIdUser())->where('form_id', $idForm)->first();
            $rs->qtd_access = $rs->qtd_access +1;
            $rs->save();
        }
    */

    public static function StringtoTime($value)
    {
        return date('H:i:s', strtotime($value));
    }

    public static function cboMinutes()
    {
        $arr = ['' => '', '00' => '00', '15' => '15', '30' => '30', '45' => '45'];

        return $arr;
    }

    public static function cboQtdPersons($total = 36)
    {
        $arr = ['' => ''];

        for ($i = 0; $i < $total; $i++) {
            $arr["$i"] = $i;
        }

        return $arr;
    }

    public static function cboHours()
    {
        $arr = ['' => '', '08' => '08', '09' => '09', '10' => '10',
            '11' => '11', '12' => '12', '13' => '13', '14' => '14',
            '15' => '15', '16' => '16', '17' => '17'];

        return $arr;
    }

    public static function cboMonths()
    {
        $arr = ['' => '', '1' => '01', '2' => '02', '3' => '03', '04' => '04', '5' => '05', '6' => '06', '7' => '07', '8' => '08'];

        return $arr;
    }

    public static function getNameUser()
    {
        return Auth::user()->name;
    }

    public static function getLoginUser()
    {
        return Auth::user()->login;
    }

    public static function getIsAdminContact()
    {
        return Auth::user()->is_admin_contact;
    }

    public static function getIsHR()
    {
        return Auth::user()->is_hr;
    }

    public static function getUserLanguage()
    {
        return Auth::user()->languages->code;
    }

    public static function send2Mail($params)
    //$subject, $msg, $to, $file = '', $enableBCC = false, $emailCOZ = "")
    {
        $from = $params['from'] ?? 'applim@ilo.org';
        $fromName = $params['fromName'] ?? 'APPLIM';
        $to = $params['to'] ?? '';
        $cc = $params['cc'] ?? '';
        $bc = $params['bc'] ?? '';
        $subject = $params['subject'] ?? '';
        $body = $params['body'] ?? '';
        $file = $params['file'] ?? '';
        $img = $params['img'] ?? '';

        $phpmail = new PHPMailer();
        $phpmail->CharSet = 'UTF-8';

        $phpmail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        $phpmail->IsSMTP(); // envia por SMTP
        $phpmail->Host = 'foxs.bsb.ilo.org'; // SMTP servers
        $phpmail->SMTPAuth = false; // Caso o servidor SMTP precise de autenticaç
        $phpmail->IsHTML(true);

        $phpmail->From = $from;
        $phpmail->FromName = $fromName;  //env('MAIL_FROM_NAME', '');

        $mailTo = explode(';', $to);
        $mailCC = explode(';', $cc);
        $mailBC = explode(';', $bc);
        //dd($mailTo);
        foreach ($mailTo as $obj) {
            $phpmail->AddAddress($obj);
        }
        foreach ($mailBC as $bc) {
            $phpmail->addBCC($bc);
        }
        foreach ($mailCC as $cc) {
            $phpmail->addCC($cc);
        }

        $phpmail->Subject = $subject;

        if (strlen($file)) {
            $phpmail->AddAttachment($file);
        }
        if ($img != '') {
            $phpmail->AddEmbeddedImage(public_path('img/circle_green.png'), 'circle_green', 'circle_green.png', 'base64', 'image/png');
            $phpmail->AddEmbeddedImage(public_path('img/circle_yellow.png'), 'circle_yellow', 'circle_yellow.png', 'base64', 'image/png');
            $phpmail->AddEmbeddedImage(public_path('img/circle_red.png'), 'circle_red', 'circle_red.png', 'base64', 'image/png');
        }
        $phpmail->Body = $body;

        $send = $phpmail->Send();
        /*try {
            if (!$phpmail->Send()) {
                echo 'Mailer Error: ' . $phpmail->ErrorInfo;
                dd($phpmail->ErrorInfo);
            } else {
                echo 'Message has been sent';
            }
        } catch(Exception $e) {
            print_r($e);
            dd($e);
        }*/

        if ($send) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }

    public static function getTokenFile()
    {
        // $email = \Utils::getEmailUser();

        return sha1(mt_rand(10000, 99999) . time() . 'Organização Internacional do Trabalho');
    }

    public static function statusActiveInactive($status_id)
    {
        if ($status_id) {
            return 'Active';
        } else {
            return 'Inactive';
        }
    }

    public static function TrueFalse($value)
    {
        $_return = null;

        if ($value == 1) {
            $_return = 'True';
        }
        if ($value == 0) {
            $_return = 'False';
        }

        return $_return;
    }

    public static function IsAdmin($is_admin)
    {
        if ($is_admin == 1) {
            return 'True';
        } else {
            return 'False';
        }
    }

    public static function IsActive($is_active)
    {
        if ($is_active == 1) {
            return 'True';
        } else {
            return 'False';
        }
    }

    public static function publicForm($public)
    {
        if ($public == 1) {
            return 'True';
        } else {
            return 'False';
        }
    }

    public static function getIdUser()
    {
        return Auth::user()->id;
    }

    public static function isAudit()
    {
        return Auth::user()->is_audit;
    }

    public static function getEmailUser()
    {
        return Auth::user()->email;
    }

    public static function getUserOfficeCode()
    {
        $office = Office::find(Auth::user()->office_id);

        return $office->code;
    }

    public static function getUserOfficeName()
    {
        $office = Office::find(Auth::user()->office_id);

        return $office->name;
    }

    public static function getUserOfficeUrlDefault()
    {
        $url = null;
        if (!is_null(Auth::user()->office_id)) {
            $office = Office::find(Auth::user()->office_id);
            $url = $office->url_default;
        }

        return $url;
    }

    public static function getUserOfficeId()
    {
        return Auth::user()->office_id;
    }

    public static function getIsAdmin()
    {
        $result = false;
        // dd(Auth::user());
        if (Auth::user()->is_admin != null) {
            $result = Auth::user()->is_admin;
        }

        return $result;
    }

    public static function getIsAdminRegistry()
    {
        $result = false;
        if (Auth::user()->is_registry_admin != null) {
            $result = Auth::user()->is_registry_admin;
        }

        return $result;
    }

    public static function checkConfidentialRegistry($confidential_id)
    {
        $_return = false;
        if ($confidential_id != null) {
            if (Auth::user()->is_registry_confidential) {
                if (is_null(Auth::user()->confidential_id)) {
                    $_return = true;
                } else {
                    if (Auth::user()->confidential_id == $confidential_id) {
                        $_return = true;
                    }
                }
            }
        } else {
            $_return = true;
        }

        //  dd($confidential_id);
        return $_return;
    }

    /* ============== objetivo formulario =============== */
    public static function cboOrdem($blank = false)
    {
        $arr = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'];

        if ($blank) {
            $arr = ['' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'];
        }

        return $arr;
    }

    public static function cboDebitCredit()
    {
        return ['D' => 'Debit', 'C' => 'Credit'];
    }

    public static function cboYesNo()
    {
        $_arr = ['0' => 'No', '1' => 'Si'];

        if (static::getUserLanguage() == 'en') {
            $_arr = ['0' => 'No', '1' => 'Yes'];
        }

        return $_arr;
    }

    public static function txtYesNo($var)
    {
        $_arr = ['0' => 'No', '1' => 'Si'];

        if (static::getUserLanguage() == 'en') {
            $_arr = ['0' => 'No', '1' => 'Yes'];
        }

        return $_arr[$var];
    }

    public static function cboLanguage()
    {
        return ['es' => 'Spanish', 'en' => 'English', 'pt' => 'Portugues'];
    }

    public static function cboChargeType()
    {
        return ['1' => 'Work', '2' => 'Person'];
    }

    public static function cboStatus()
    {
        return ['1' => trans('forms . active'), '2' => trans('forms . inactive')];
    }

    public static function doMessage($errors = [], $msg = [])
    {
        // dd($errors);
        $err = '';
        $_alert = '';

        if (count($errors) > 0) {
            foreach ($errors->all() as $e) {
                $err .= '<strong>' . $e . ' </strong>  <br>';
            }
        }

        if (count($msg) > 0) {
            foreach ($msg as $e) {
                $err .= '<strong>' . $e . ' </strong>  <br>';
            }
        }

        if ($err != '') {
            $_alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert"> ';
            $_alert .= $err ;
            $_alert .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }

        //dd($_alert);
        return $_alert;
    }

    public static function doMessage2($errors = [], $msg = [])
    {
        $err = '';
        $_alert = '';
        //  dd($errors);
        if (count($errors) > 0) {
            //foreach ($errors->all() as $e) {
            $err .= '<strong> Celda(s) obligatoria(s) en rojo </strong>  <br>';
            $err .= '<strong> Mandatory field(s) in red</strong>  <br>';
            // }
        }

        if (count($msg) > 0) {
            foreach ($msg as $e) {
                $err .= '<strong>' . $e . ' </strong>  <br>';
            }
        }

        if ($err != '') {
            $_alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert"> ';
            $_alert .= $err ;
            $_alert .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }

        //dd($_alert);
        return $_alert;
    }

    public static function cboCurrency()
    {
        return ['1' => 'Dolar', '2' => 'Local'];
    }

    public static function cboPaymentType()
    {
        return ['1' => 'Transfer', '2' => 'Billet'];
    }

    /* ============== fim =============== */

    public static function Message($string)
    {
        $json = json_decode(file_get_contents(public_path() . '/message.json'));

        return $json->$string;
    }

    public static function checkNull($value)
    {
        if ($value == '') {
            return null;
        } else {
            return $value;
        }
    }

    public static function checkNumero($value)
    {
        if ($value == '') {
            return 0;
        } else {
            return $value;
        }
    }

    public static function checkFK($value)
    {
        $_value = $value;

        if ($value == '') {
            $_value = null;
        }
        if ((int) $value == 0) {
            $_value = null;
        }

        return $_value;
    }

    public static function cboTypeForm()
    {
        return ['1' => 'Original', '2' => 'Copies'];
    }

    public static function cboTypeDate()
    {
        return ['1' => 'Registro', '2' => 'Emisión', '3' => 'Envio á ADM', '4' => 'Envio á FIN', '5' => 'Pago', '6' => 'Confirmación FIN', '7' => 'Borrado', '8' => 'Fecha de vencimiento'];
    }

    /*
    public static function DatetoMySQL($value) {
    if ($value == '') return NULL;

    if (strlen($value) < 10) return null;

    if (! strpos($value, '-')) {

    $date = explode(' / ', $value);

    if (sizeof($date) > 1) return $date[2] . '-' . $date[1] . '-' . $date[0];
    else {
    return $date;
    }
    }  else {
    return $value;
    }
    }*/

    public static function DatetoMySQL($value)
    {
        $_value = null;

        //if ($value == '')  {
        //    $_value = null;
        // }

        if (strlen($value) < 10) {
            $_value = null;
        }

        if ($value != null) {
            if (!strpos($value, '-')) {
                $_value = str_replace('/', '-', $value);

                $_value = date('Y-m-d', strtotime($_value));
            } else {
                $_value = $value;
            }
        }

        return $_value;
    }

    public static function FormatMoney($amount, $symbol = 'R$')
    {
        $value = '';
        if ($amount != null) {
            if ($amount != 0) {
                if ($symbol == 'R$') {
                    $value = $symbol . ' ' . number_format($amount, 2, ',', '.');
                } else {
                    $value = $symbol . ' ' . number_format($amount, 2, '.', ',');
                }
            }
        }

        // return $symbol.''. money_format(' % i', $amount);
        return $value;
    }

    public static function FormatMoney2($amount)
    {
        $value = '';
        if ($amount != null) {
            if ($amount != 0) {
                $value = number_format($amount, 2, '.', ',');
            }
        }

        // return $symbol.''. money_format(' % i', $amount);
        return $value;
    }

    public static function DatetoTimestamps($value)
    {
        return date('d/m/Y - H:i:s', strtotime($value));
    }

    public static function Truncate($string, $height = 15)
    {
        return current(explode('\n', wordwrap($string, $height, '...\n')));
    }

    public static function DateExtension($date)
    {
        $dt = explode('/', $date);

        $ext = 'Brasília - DF, ';

        $ext .= $dt[0];
        $mes = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        $ext .= ' de ' . $mes[(int) $dt[1]] . ' de ';
        $ext .= $dt[2];

        return $ext;
    }

    public static function DateExtensionES($date)
    {
        $dt = explode('/', $date);

        $ext = '';

        $ext .= $dt[0];
        $mes = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

        $ext .= ' de ' . $mes[(int) $dt[1]] . ' de ';
        $ext .= $dt[2];

        return $ext;
    }

    public static function DateExtensionHRES($date)
    {
        $dt = explode('/', $date);
        $dt[3] = substr($dt[2], 7, 5);
        $dt[2] = substr($dt[2], 0, 4);

        $ext = '';

        $ext .= $dt[0];
        $mes = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'novembre', 'decembre'];

        $ext .= ' de ' . $mes[(int) $dt[1]] . ' de ';
        $ext .= $dt[2];
        $ext .= ' a las ' . $dt[3] . ' horas';

        return $ext;
    }

    public static function valorPorExtenso($valor = 0, $tipoMoeda)
    {
        if ($tipoMoeda == 1) {
            $moedaSingular = 'Dolar';
            $moddaPlural = 'Dolares';
        } else {
            $moedaSingular = 'Real';
            $moddaPlural = 'Reais';
        }
        $singular = ['Centavo', $moedaSingular, 'Mil', 'Milhão', 'Bilhão', 'Trilhão', 'Quatrilhão'];
        $plural = ['Centavos', $moddaPlural, 'Mil', 'Milhões', 'Bilhões', 'Trilhões',
            'Quatrilhões'];

        $c = ['', 'Cem', 'Duzentos', 'Trezentos', 'Quatrocentos',
            'Quinhentos', 'Seiscentos', 'Setecentos', 'Oitocentos', 'Novecentos'];
        $d = ['', 'Dez', 'Vinte', 'Trinta', 'Quarenta', 'Cinquenta',
            'Sessenta', 'Setenta', 'Oitenta', 'Noventa'];
        $d10 = ['Dez', 'Onze', 'Doze', 'Treze', 'Quatorze', 'Quinze',
            'Dezesseis', 'Dezessete', 'Dezoito', 'Dezenove'];
        $u = ['', 'Um', 'Dois', 'Três', 'Quatro', 'Cinco', 'Seis',
            'Sete', 'Oito', 'Nove'];

        $z = 0;

        $valor = number_format($valor, 2, '.', '.');
        $inteiro = explode('.', $valor);
        for ($i = 0; $i < count($inteiro); $i++) {
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++) {
                $inteiro[$i] = '0' . $inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        $rt = '';
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? 'Cento' : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? '' : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : '';

            $r = $rc . (($rc && ($rd || $ru)) ? ' e ' : '') . $rd . (($rd &&
                $ru) ? ' e ' : '') . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? ' ' . ($valor > 1 ? $plural[$t] : $singular[$t]) : '';
            if ($valor == '000') {
                $z++;
            } elseif ($z > 0) {
                $z--;
            }

            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) {
                $r .= (($z > 1) ? ' de ' : '') . $plural[$t];
            }

            if ($r) {
                $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                    ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ', ' : ' e ') : ' ') . $r;
            }
        }

        return ($rt ? $rt : 'zero');
    }

    public static function FormatNumber($num, $type)
    {
        $amount = '';
        if ($type == 1) {
            $amount = number_format($num, 2, ',', '.');
        } else {
            $amount = number_format($num, 2, '.', ',');
        }

        return $amount;
    }

    public static function FormatAgency($num)
    {
        $age = '';
        if (strlen($num) != 0) {
            if (strlen($num) > 4) {
                $age = substr($num, 0, 4) . '-' . substr($num, 4, 1);
            } else {
                $age = substr($num, 0, 4);
            }
        }

        return $age;
    }

    public static function FormatAccount($num)
    {
        $cc = '';
        if (strlen($num) != 0) {
            $cc = substr($num, 0, strlen($num) - 1) . '-' . substr($num, strlen($num) - 1, 1);
        }

        return $cc;
    }

    public static function toFloat($str)
    {
        if (strstr($str, ',')) {
            $str = str_replace('.', '', $str);

            // replace dots (thousand seps) with blancs
            $str = str_replace(',', '.', $str);

            // replace ', ' with ' . '
        }

        if (preg_match("#([0-9\.]+)#", $str, $match)) {
            // search for number that may contain ' . '
            return floatval($match[0]);
        } else {
            return floatval($str);

            // take some last chances with floatval
        }
    }

    public static function convertNumber($str)
    {
        $str = str_replace('.', '', $str);
        $str = str_replace(',', '.', $str);

        if (strlen(trim($str)) == 0) {
            return null;
        } else {
            return $str;
        }
    }

    public static function Number($value, $decimal = '2')
    {
        return number_format($value, $decimal, '.', ',');
    }

    public static function LimparCampos($campo)
    {
        $campo = str_replace(' . ', '', $campo);
        $campo = str_replace('-', '', $campo);
        $campo = str_replace(' / ', '', $campo);

        return $campo;
    }

    public static function NumberToMySQL($valor)
    {
        if (strpos($valor, ', ')) {
            $valor = str_replace(' . ', '', $valor);
            $valor = str_replace(', ', ' . ', $valor);
        }

        return number_format(Utils::checkNumero($valor), 2, ' . ', '');
    }

    public static function DisplayTelefone($telefone)
    {
        $telefone = str_pad($telefone, 9, '0', STR_PAD_LEFT);

        return substr($telefone, 0, 5) . '-' . substr($telefone, -4);
    }

    public static function DisplayRuc($valor)
    {
        $numero = '';
        if (strlen($valor) == 14) {
            $numero = substr($valor, 0, 2) . '.' . substr($valor, 2, 3) . '.' . substr($valor, 5, 3) . '/' . substr($valor, 8, 4) . '-' . substr($valor, -2);
        }

        if (strlen($valor) == 11) {
            $numero = substr($valor, 0, 3) . '.' . substr($valor, 3, 3) . '.' . substr($valor, 6, 3) . '-' . substr($valor, -2);
        }

        return $numero;
    }

    public static function completarComZeros($string, $tamanho, $esquerda = 'esquerda')
    {
        if (strtolower($esquerda == 'esquerda')) {
            $var = str_pad($string, $tamanho, '0', STR_PAD_LEFT);
        } else {
            $var = str_pad($string, $tamanho, '0', STR_PAD_RIGHT);
        }

        return $var;
    }

    public static function DisplayCpf($cpf = '')
    {
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        return substr($cpf, 0, 3) . ' . ' . substr($cpf, 3, 3) . ' . ' . substr($cpf, 6, 3) . '-' . substr($cpf, -2);

        // 716.10545672
    }

    public static function DisplayCep($cd_cep)
    {
        $cd_cep = str_pad($cd_cep, 8, '0', STR_PAD_LEFT);

        return substr($cd_cep, 0, 5) . '-' . substr($cd_cep, -3);
    }

    public static function array_change_value_case($input, $case = CASE_LOWER)
    {
        $aRet = [];

        if (!is_array($input)) {
            return $aRet;
        }

        foreach ($input as $key => $value) {
            if (!is_array($value)) {
                //$aRet[$key] = array_change_value_case($value, $case);
                // continue;
                $aRet[$key] = ($case == CASE_UPPER ? strtoupper(strtr($value, 'áéíóúâêôãõàèìòùç', 'ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ')) : strtolower(strtr($value, 'ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ', 'áéíóúâêôãõàèìòùç')));
            }
        }

        return $aRet;
    }

    public static function array_change_value_case3(array $input, $case = CASE_LOWER)
    {
        switch ($case) {
            case CASE_LOWER:
                return array_map('strtolower', $input);

                break;

            case CASE_UPPER:
                return array_map('strtoupper', $input);

                break;

            default:
                trigger_error('case isnotvalid, CASE_LOWER or CASE_UPPERonly', E_USER_ERROR);

                return false;
        }
    }

    public static function FormatCPFCNPJ($campo, $formatado = true)
    {
        //retira formato
        $codigoLimpo = preg_replace("[''-./ t]", '', $campo);
        // pega o tamanho da string menos os digitos verificadores
        $tamanho = (strlen($codigoLimpo) - 2);
        //verifica se o tamanho do c�digo informado � v�lido
        if ($tamanho != 9 && $tamanho != 12) {
            return false;
        }

        if ($formatado) {
            // seleciona a m�scara para cpf ou cnpj
            $mascara = ($tamanho == 9) ? ' ###.###.###-##' : '##.###.###/####-##';

            $indice = -1;
            for ($i = 0; $i < strlen($mascara); $i++) {
                if ($mascara[$i] == '#') {
                    $mascara[$i] = $codigoLimpo[++$indice];
                }
            }
            //retorna o campo formatado
            $retorno = $mascara;
        } else {
            //se n�o quer formatado, retorna o campo limpo
            $retorno = $codigoLimpo;
        }

        return $retorno;
    }

    public static function Month_Name($id, $pt_br = true)
    {
        //dd($pt_br);
        $month_pt[1] = 'Janeiro';
        $month_pt[2] = 'Fevereiro';
        $month_pt[3] = 'Março';
        $month_pt[4] = 'Abril';
        $month_pt[5] = 'Maio';
        $month_pt[6] = 'Junho';
        $month_pt[7] = 'Julho';
        $month_pt[8] = 'Agosto';
        $month_pt[9] = 'Setembro';
        $month_pt[10] = 'Outubro';
        $month_pt[11] = 'Novembro';
        $month_pt[12] = 'Dezembro';

        $month_en[1] = 'January';
        $month_en[2] = 'February';
        $month_en[3] = 'March';
        $month_en[4] = 'April';
        $month_en[5] = 'May';
        $month_en[6] = 'June';
        $month_en[7] = 'July';
        $month_en[8] = 'August';
        $month_en[9] = 'September';
        $month_en[10] = 'October';
        $month_en[11] = 'November';
        $month_en[12] = 'December';

        $month_es[1] = 'Enero';
        $month_es[2] = 'Febrero';
        $month_es[3] = 'Marzo';
        $month_es[4] = 'Abril';
        $month_es[5] = 'Mayo';
        $month_es[6] = 'Junio';
        $month_es[7] = 'Julio';
        $month_es[8] = 'Agosto';
        $month_es[9] = 'Septiembre';
        $month_es[10] = 'Octubre';
        $month_es[11] = 'Noviembre';
        $month_es[12] = 'Diciembre';

        $month_nu['January'] = 1;
        $month_nu['February'] = 2;
        $month_nu['March'] = 3;
        $month_nu['April'] = 4;
        $month_nu['May'] = 5;
        $month_nu['June'] = 6;
        $month_nu['July'] = 7;
        $month_nu['August'] = 8;
        $month_nu['September'] = 9 ;
        $month_nu['October'] = 10;
        $month_nu['November'] = 11;
        $month_nu['December'] = 12 ;
        if ($id != null) {
            return $month_pt[$id];
        } else {
            return '';
        }
    }

    public static function MonthName($id, $language = '', $abr = false)
    {
        $month_pt[1] = 'Janeiro';
        $month_pt[2] = 'Fevereiro';
        $month_pt[3] = 'Março';
        $month_pt[4] = 'Abril';
        $month_pt[5] = 'Maio';
        $month_pt[6] = 'Junho';
        $month_pt[7] = 'Julho';
        $month_pt[8] = 'Agosto';
        $month_pt[9] = 'Setembro';
        $month_pt[10] = 'Outubro';
        $month_pt[11] = 'Novembro';
        $month_pt[12] = 'Dezembro';

        $month_en[1] = 'January';
        $month_en[2] = 'February';
        $month_en[3] = 'March';
        $month_en[4] = 'April';
        $month_en[5] = 'May';
        $month_en[6] = 'June';
        $month_en[7] = 'July';
        $month_en[8] = 'August';
        $month_en[9] = 'September';
        $month_en[10] = 'October';
        $month_en[11] = 'November';
        $month_en[12] = 'December';

        $abr_month[1] = 'Jan';
        $abr_month[2] = 'Feb';
        $abr_month[3] = 'Mar';
        $abr_month[4] = 'Apr';
        $abr_month[5] = 'May';
        $abr_month[6] = 'Jun';
        $abr_month[7] = 'Jul';
        $abr_month[8] = 'Aug';
        $abr_month[9] = 'Sep';
        $abr_month[10] = 'Oct';
        $abr_month[11] = 'Nov';
        $abr_month[12] = 'Dec';

        $month_es[1] = 'Enero';
        $month_es[2] = 'Febrero';
        $month_es[3] = 'Marzo';
        $month_es[4] = 'Abril';
        $month_es[5] = 'Mayo';
        $month_es[6] = 'Junio';
        $month_es[7] = 'Julio';
        $month_es[8] = 'Agosto';
        $month_es[9] = 'Septiembre';
        $month_es[10] = 'Octubre';
        $month_es[11] = 'Noviembre';
        $month_es[12] = 'Diciembre';
        $_id = (int) $id ;

        if ($language == 'en') {
            return $month_en[$_id];
        }

        if ($language == 'es') {
            return $month_es[$_id];
        }
        if ($language == 'pt') {
            return $month_pt[$_id];
        }
        if ($abr == true) {
            return $abr_month[$_id];
        }
    }

    public static function MonthNumber($value)
    {
        $month['January'] = 1;
        $month['February'] = 2;
        $month['March'] = 3;
        $month['April'] = 4;
        $month['May'] = 5;
        $month['June'] = 6;
        $month['July'] = 7;
        $month['August'] = 8;
        $month['September'] = 9 ;
        $month['October'] = 10;
        $month['November'] = 11;
        $month['December'] = 12 ;

        return $month[$value];
    }

    public static function Date_Extension($date)
    {
        $dt = explode('/', $date);
        $ext = 'Brasília - DF, ';

        $ext .= $dt[0];
        $mes = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        $ext .= ' de ' . $mes[(int) $dt[1]] . ' de ';
        $ext .= $dt[2];

        return $ext;
    }

    public static function removerAcento($string)
    {
        $comAcentos = ['à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú'];
        $semAcentos = ['a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U'];
        $nova_string = str_replace($comAcentos, $semAcentos, $string);
        //  $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç';
        // $to = 'AAAAEEIOOOUUCaaaaeeiooouuc';
        return $nova_string;
        // return strtr($str, $from, $to);
    }

    public static function uploadFile($file, $path, $name)
    {
        $extension = $file->getClientOriginalExtension();

        $uploadSuccess = $file->move($path, $name);

        return $uploadSuccess;
    }

    /******   date  **/
    public static function dateMonth2($date1, $date2)
    {
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        return (($year2 - $year1) * 12) + ($month2 - $month1);
    }

    public static function getMonth($date)
    {
        return date('m', strtotime($date));
    }

    public static function getYear($date)
    {
        return date('Y', strtotime($date));
    }

    public static function DateToView($value)
    {
        if ($value == '') {
            return '';
        } else {
            return date('d/m/Y', strtotime($value));
        }
    }

    public static function removeMaskCNPJ($cnpj)
    {
        $cnpj = str_replace('.', '', $cnpj);
        $cnpj = str_replace('-', '', $cnpj);
        $cnpj = str_replace('/', '', $cnpj);

        return $cnpj;
    }

    public static function removecoma($value)
    {
        return str_replace(',', '', $value);
        //$cnpj = str_replace('-', '', $cnpj);
        //$cnpj = str_replace('/', '', $cnpj);

        return $value;
    }
}
