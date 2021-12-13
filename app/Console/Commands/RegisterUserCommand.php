<?php

namespace App\Console\Commands;

use App\Models\LoginDetails;
use App\Models\Logins;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class RegisterUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user into database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tb_id = $this->ask("Trucksbook ID");
        $password = $this->ask("Mot de Passe");


        $login = Logins::where('joueurs_tb_id', $tb_id)->first();

        if(!$login)
        {
            $lastID = Logins::orderBy('idlogin', 'desc')->first()->idlogin;
            $idlogin = $lastID + 1;

            $login = new Logins;
            $login->idlogin = $lastID + 1;
            $login->joueurs_tb_id = $tb_id;
            $login->password = Hash::make($password);
            $login->save();
            $login->refresh();

            $lastID = LoginDetails::orderBy('iddetail', 'desc')->first()->iddetail;

            $logindet = new LoginDetails;
            $logindet->iddetail = $lastID + 1;
            $logindet->logins_idlogin = $idlogin;
            $logindet->firstname_rp = null;
            $logindet->lastname_rp = null;
            $logindet->pseudo_discord = null;
            $logindet->histoire_rp = null;
            $logindet->save();
            $logindet->refresh();

            $this->info('User '. $tb_id . ' created! Password: '. $password);

            $lastID = UserToken::orderBy('idtoken', 'desc')->first()->idtoken;

            $userToken = new UserToken;
            $userToken->idtoken = $lastID + 1;
            $userToken->logins_idlogin = $idlogin;
            $userToken->token = $this->gen_uuid();
            $userToken->save();
            $userToken->refresh();

            $this->info('Token created! Token='. $userToken->token);

            return 0;
        }

        return 0;

    }

    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
