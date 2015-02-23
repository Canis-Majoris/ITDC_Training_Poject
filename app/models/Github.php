<?php/*
use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;
class Github{
	public static function gitLogin()
	{
		$provider='github';
		$provider = OAuth2::provider($provider, [
			'id' => '09696cd9626f7270e967',
			'secret' => 'a9d620646378642962aa13b5392cbae083745fff',
			]);
		if ( ! isset($_GET['code'])){
			return $provider->authorize();
		}
		else
		{
			try{
				$params = $provider->access($_GET['code']);
				$token = new Token_Access([
					'access_token' => $params->access_token
					]);
				$user = $provider->get_user_info($token);
				//dd($user);
				return Redirect::route('user-profile', $user['nickname']);
			}
			catch (OAuth2_Exception $e)
			{
				show_error('error: '.$e);
			}
		}
	}
}