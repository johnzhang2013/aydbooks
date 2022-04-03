<?php
namespace App\Service;
use App\Repositories\Member as MemberRepository;

class MemberService{
	private static $_instance;
    private $_result = null;
    private $mr_instance = null;

	//provent the object to be cloned
	private function __clone(){}
	private function __construct(){
        $this->_result = [
        	'status' => false,
        	'code' => 200,
        	'msg' => null,
        	'data' => null
        ];

        $this->mr_instance = MemberRepository::getInstance();
    }
	//Singleton use
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    ########Business Methods For Controllers############
    public function register($mdata = []){
        //more logic here
        //check if this user already exists
        $find_member = $this->mr_instance->loadMemberByEmail($mdata['email']);
        if($find_member != null){
            $this->_result['status'] = false;
            $this->_result['code'] = 400;
            $this->_result['msg'] = 'There has been a user with this email.';
        }else{
            $_member = $this->mr_instance->createMember($mdata);
            if($_member){                
                $this->_result['status'] = true;
                $this->_result['code'] = 200;
                $this->_result['msg'] = 'Congratuation! Welcome to join us!';
            }else{
                $this->_result['status'] = false;
                $this->_result['code'] = 401;
                $this->_result['msg'] = 'Some errors occured. Please try it later.';
            }
        }

        return $this->_result;
    }

    public function update($mdata = []){
        //more logic here
        MemberRepository::getInstance()->updateUser($mdata);
    }

    public function view($mid = 0){
        //more logic here
        MemberRepository::getInstance()->viewUser($mdata);
    }

    public function delete($mid = 0){
        //more logic here
        MemberRepository::getInstance()->deleteUser($mid);
    }

    public function list($filters = [], $paginate = []){
        //more logic here
        return MemberRepository::getInstance()->list($filters, $paginate);
    }
    
    public function listBorrowReturnRecords($filters = [], $paginate = []){
        return MemberRepository::getInstance()->listBorrowReturnRecords($filters, $paginate);
    }

    public function updateMemberAfterBorrowed($member = null){
        $this->mr_instance->updateMemberAfterBorrowed($member);
    }

    public function updateMemberAfterReturned($member = null){
        $this->mr_instance->updateMemberAfterReturned($member);
    }
    
    ########Business Methods For Controllers############
}
