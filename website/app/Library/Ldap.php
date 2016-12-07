<?php

/**
 * Created by PhpStorm.
 * User: Mosrur
 * Date: 11/30/2016
 * Time: 2:59 PM
 */

namespace App\library {

    use App\Http\Requests\Request;
    use Auth;
    use Cartalyst\Sentinel\Laravel\Facades\Activation;
    use Sentinel;
    use App\User;
    use App\Person;

    class Ldap
    {
        /**
         * Handle an incoming request.
         *
         * @param  username
         * @param  password
         * @return mixed
         */
        public function ldap_authenticate($credentials)
        {
            /* Server config */
            $host = env('LDAP_HOST');
            $port = env('LDAP_PORT');
            $addr = gethostbyname($host);
            $client = stream_socket_client("tcp://$addr:$port",$errno,$errorMessage);

            /* user credential */
            $username = $credentials['username'];
            $password = $credentials['password'];
            

            /* XML parsing for LDAP*/
            $xml = new \SimpleXMLElement('<ldap/>');
            $xml->addChild('user', $username);
            $xml->addChild('passwd',$password);
            $xml->addChild('operation','validate');

            $data = $xml->asXML( );
            fwrite($client, $data);
            $response = stream_get_contents($client);

            $result = str_replace($username, '', $response);

            if(strstr($result, 'success') !== false) {
                /* collect userid using username from person table */
                $person = Person::where('nmrbox_acct', $username)->first();
                if(!$person) {
                    return false;
                }
                $user = User::where('person_id', $person->id)->first();
                //$user = Sentinel::findById(1);

                if(!$user){
                    return false;
                }

                Sentinel::login($user);

                //Auth::loginUsingId($user->id);

                return true;
            }

            return false;

        }

        public function ldap_set_password($credentials)
        {
            /* Server config */
            $host = env('LDAP_HOST');
            $port = env('LDAP_PORT');
            $addr = gethostbyname($host);
            $client = stream_socket_client("tcp://$addr:$port",$errno,$errorMessage);

            /* user credential */
            $username = $credentials['username'];
            $password = $credentials['password'];

            /* XML parsing for LDAP*/
            $xml = new \SimpleXMLElement('<ldap/>');
            $xml->addChild('user', $username);
            $xml->addChild('passwd',$password);
            $xml->addChild('operation','set');

            $data = $xml->asXML( );
            fwrite($client, $data);
            $response = stream_get_contents($client);

            $result = str_replace($username, '', $response);
            echo '<pre>';
            print_r($result);
            echo '</pre>';


            if(strstr($result, 'success') !== false) {
                return true;
            }

            return false;
        }
    }
}