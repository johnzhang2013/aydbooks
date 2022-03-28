<?php
namespace App\Service;

class AuthService{
	/**
	 * This service is used to user login/logout
	 */
	private static $_instance;

	private $auth_type = null;//admin or user
	private $auth_result = null;
	private $auth = null;

	//provent the object to be cloned
	private function __clone(){}
	private function __construct($auth_type = ''){
		$this->auth_type = $auth_type;
		$this->auth = auth($auth_type);

		$this->auth_result = [
			'status' => false,
			'code' => 200,
			'msg' => null,
			'data' => null
		];
	}
	//Singleton use
	public static function getInstance($auth_type = ''){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self($auth_type);
		}
		return self::$_instance;
	}

	########Business Methods For Controllers############
	/**
     * Log the user in to get the token structure.
     * @param array $credentials
     * @return mixed
     */
	public function login($credentials = []){
		if(!($this->checkAuthType($this->auth_type))){
			$this->auth_result['code'] = 400;
			$this->auth_result['msg'] = 'Please choose your login role.';
			return $this->auth_result;
        }

        $token = null;
        if(!($token = $this->auth->attempt($credentials))){
        	$this->auth_result['code'] = 401;
			$this->auth_result['msg'] = 'Your credentials are incorrect.';
			return $this->auth_result;
        }

        $this->auth_result['status'] = true;
        $this->auth_result['data'] = $this->generateTokenData($token);

        return $this->auth_result;
	}

	/**
     * Log the user out (Invalidate the token).
     * @return $mixed
     */
	public function logout(){
		if(!($this->checkAuthType($this->auth_type))){
			$this->auth_result['code'] = 400;
			$this->auth_result['msg'] = 'Please choose your login role.';
			return $this->auth_result;
        }

        $this->auth->logout();

        $this->auth_result['status'] = true;
        return $this->auth_result;
	}

	/**
     * Refresh a token.
     * @return $mixed
     */
    public function refresh(){
    	if(!($this->checkAuthType($this->auth_type))){
			$this->auth_result['code'] = 400;
			$this->auth_result['msg'] = 'Please choose your login role.';
			return $this->auth_result;
        }

        $token = $this->auth->refresh();

        $this->auth_result['status'] = true;
        $this->auth_result['data'] = $this->generateTokenData($token);
        return $this->auth_result;
    }

    /**
     * Get the current authenticate user(admin or user)
     * @return $mixed
     */
    public function user(){
        return $this->auth->user();
    }
    ########Business Methods For Controllers############

    /**
     * Make sure the auth_type is valid.
     * @return boolean
     */
	private function checkAuthType($auth_type = ''){
        if($auth_type == null || empty($auth_type)) return false;
        
    	$guards = config('auth.guards');

    	return array_key_exists($auth_type, $guards);
    }

    /**
     * Generate a token data for the client
     * @return array
     */
	private function generateTokenData($token = ''){
        $user = $this->auth->user();
        $user_name = $user->name;
		return [
            'user_name'=> $user_name,
			'user_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60
		];
	}
}
