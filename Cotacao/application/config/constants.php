<?php
defined('BASEPATH') or exit('No direct script access allowed');


define('NOME_SISTEMA', "COTAÇÃO");
 
define('CPATH', "C:/xampp/htdocs/_portal/");

define('iPATH', "https://" . $_SERVER['HTTP_HOST'] . "/_portal/");
define('anexoPATH', "https://" . $_SERVER['HTTP_HOST'] . "/_portal/anexos");
define('anexoPATHExterno', "https://" . $_SERVER['HTTP_HOST'] . "/_portal/anexos_externos/");
define('anexoPATHMudasSementes', "https://" . $_SERVER['HTTP_HOST'] . "/_portal/anexos/anexo_mudas_sementes");
define('iPATHGif', "https://" . $_SERVER['HTTP_HOST'] . "/_portal/imagens/gif/");
define('iPATHIcones', "https://" . $_SERVER['HTTP_HOST'] . "/_portal/icones/");


define('DIAS_VALIDADE_PRECO', 90);


// define('AVISO_TESTE', "<B class='red' style='font-size:20px; color: red'>FASE DE TESTE</B>");
define('AVISO_TESTE', "");


define('SITE', 'https://www.portalsema.ba.gov.br/');
define('SITE_LOGIN', 'https://www.portalsema.ba.gov.br/_portal/Intranet/usuario');



define('MOTIVO_COTACAO', "[
                                {
                                    label: 'Cotação para compras através de Edital de Chamada Pública/Dispensa (Caixa Escolar/FAED) e Registro de Preços (Apenas para Mercados Institucionais)',
                                    value: 'Cotação para compras através de Edital de Chamada Pública/Dispensa (Caixa Escolar/FAED) e Registro de Preços (Apenas para Mercados Institucionais)'
                                },
                                {
                                    label: 'Consulta SEM intenção de compras (todos)',
                                    value: 'Consulta SEM intenção de compras (todos)'
                                },
                                {
                                    label: 'Consulta COM intenção de compras (Apenas para Mercados Convencionais)',
                                    value: 'Consulta COM intenção de compras (Apenas para Mercados Convencionais)'
                                }
                            ]");





/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       https://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       https://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       https://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
