<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Models\User as MemberModel;
use App\Models\BorrowReturnRecord as BRRModel;
class Member{
	private static $_instance;
	private function __clone(){}
	private function __construct(){}
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	#####################################################
	public function createMember($u_data = []){
		return $this->_createEntity('MemberModel', $u_data);
	}

	public function loadMemberBorrowedHistory($uid = 0){
		$member = $this->loadMember($uid);
		if($member == null) return null;

		return $member->borrow_return_records;
	}

	public function getOneRandomMember(){
		return MemberModel::inRandomOrder()->first();
	}

	public function loadMembers(){
		return MemberModel::all();
	}

	public function loadMember($uid = 0){
		return MemberModel::find($uid);
	}

    public function loadMemberByEmail($email = ''){
    	return MemberModel::Where('email', $email)->first();
    }

    public function list($filters = [], $paginate = []){
    	if(empty($filters)){
    		return MemberModel::paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}else{
    		return MemberModel::where($filters)->paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}
    }

    public function listBorrowReturnRecords($filters = [], $paginate = []){
    	if(empty($filters)){
    		return BRRModel::paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}else{
    		return BRRModel::where($filters)->paginate($paginate['limit'], ['*'], 'page', $paginate['offset']);
    	}
    }

    public function updateMemberAfterBorrowed(MemberModel $member = null){
    	$member->lendable_qty = $member->lendable_qty - 1;
    	$member->save();
    }

    public function updateMemberAfterReturned(MemberModel $member = null){
    	$member->lendable_qty = $member->lendable_qty + 1;
    	$member->save();
    }

    ######################################################
	private function _createEntity($entity_model = '', $entity_data = []){
		DB::beginTransaction();

		try{
			$entity = $this->_createEntityTransaction($entity_model, $entity_data);
			if($entity == null){//business logic error
				DB::rollBack();
			}else{
				DB::commit();
			}
			return $entity;
		}catch(\Exception $e){//DB exception
			DB::rollBack();
			return null;
		}
	}
	private function _createEntityTransaction($entity_model = '', $entity_data = []){
		switch(true){
			case $entity_model == 'MemberModel':
				$entity = new MemberModel();
			break;
			default:
				return null;
			break;
		}

		foreach($entity_data as $k => $v){
			$entity->$k = $v;
		}
		$res = $entity->save();

		return ($res == true) ? $entity : null;
	}
}
